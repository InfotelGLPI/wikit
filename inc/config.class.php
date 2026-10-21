<?php
/*
 -------------------------------------------------------------------------
 Wikit plugin for GLPI
 Copyright (C) 2021-2022 by the Ewikit Development Team.

 -------------------------------------------------------------------------

 LICENSE

 This file is part of wikit.

 wikit is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 wikit is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with wikit. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */
class PluginWikitConfig extends CommonDBTM
{

    public static $rightname = 'config';

    public static function getTypeName($nb = 0)
    {
        return __('Wikit plugin setup', 'wikit');
    }

    public const VENDOR_SCRIPT_URL = 'https://webchat.wikit.ai/webchat-embed.js';

    /** Avatar used when no icon URL is configured */
    public const DEFAULT_ICON_URL = 'https://wikit-files-hpg.s3.eu-de.objectstorage.softlayer.net/1657139091885-Neo.png';

    private const DIMENSION_FIELDS = ['width', 'height', 'top', 'bottom', 'left', 'right'];

    public function prepareInputForUpdate($input)
    {
        // Only the single configuration row exists
        $input['id'] = 1;

        if (isset($input['icon_url']) && $input['icon_url'] !== ''
            && !Toolbox::isValidWebUrl($input['icon_url'])) {
            Session::addMessageAfterRedirect(__s('Invalid avatar URL', 'wikit'), false, ERROR);
            return false;
        }
        foreach (self::DIMENSION_FIELDS as $field) {
            if (isset($input[$field])) {
                $input[$field] = max(0, min(100, (int) $input[$field]));
            }
        }
        if (isset($input['display_on_login'])) {
            $input['display_on_login'] = (int) (bool) $input['display_on_login'];
        }

        return $input;
    }

    /**
     * Build the options given to the vendor wrapWebchat() function.
     * Every value is returned raw: the caller has to emit the whole array with json_encode()
     *
     * @param bool $on_login options for the unauthenticated login page
     *
     * @return array|null null when the widget must not be displayed
     */
    public static function getWebChatOptions(bool $on_login = false): ?array
    {
        $config = new self();
        if (!$config->getFromDB(1)) {
            return null;
        }
        if ($on_login && (int) $config->fields['display_on_login'] !== 1) {
            return null;
        }

        $user_login = 'anonymous';
        $firstname  = '';
        $realname   = '';
        if (!$on_login) {
            $user = new User();
            if ($user->getFromDB(Session::getLoginUserID())) {
                $user_login = $user->fields['name'] ?? 'anonymous';
                $firstname  = $user->fields['firstname'] ?? '';
                $realname   = $user->fields['realname'] ?? '';
            }
        }

        $description_text = $on_login
            ? ($config->fields['home_description_text'] ?: __('Welcome to the digital service center!', 'wikit'))
            : ($config->fields['description_text'] ?: __('A problem ? Ask me your question 😊', 'wikit'));

        $icon_url = $config->fields['icon_url'] ?? '';
        if ($icon_url === '' || !Toolbox::isValidWebUrl($icon_url)) {
            $icon_url = self::DEFAULT_ICON_URL;
        }
        $width  = (int) ($config->fields['width'] ?: 50);
        $height = (int) ($config->fields['height'] ?: 50);

        $options = [
            'color'             => '#243469',
            'webchatParams'     => [
                'userId'        => $user_login,
                'userIdType'    => 'login',
                'userFirstName' => $firstname,
                'userLastName'  => $realname,
                'webChatToken'  => $config->fields['webchattoken'],
                'originId'      => 'GLPI',
                'customParams'  => new stdClass(),
                'persona'       => $config->fields['persona'],
            ],
            'height'            => '80%',
            'width'             => '30%',
            'chatButtonIcon'    => [
                'url'          => $icon_url,
                'altText'      => 'Bob',
                'height'       => $height . 'px',
                'width'        => $width . 'px',
                'borderRadius' => '50%',
            ],
            'chatButtonTooltip' => [
                'text'            => $description_text,
                'backgroundColor' => '#005091',
                'textColor'       => '#FFFFFF',
                'visibility'      => 'hidden',
            ],
            'headerButtons'     => [
                'color'                   => '#fff',
                'closeIconDescription'    => $config->fields['close_text'] ?: __('Close the window', 'wikit'),
                'launchIconDescription'   => $config->fields['open_newwindow_text'] ?: __('Open in new tab', 'wikit'),
                'maximizeIconDescription' => $config->fields['maximize_text'] ?: __('Enlarge window', 'wikit'),
                'minimizeIconDescription' => $config->fields['minimize_text'] ?: __('Shrink window', 'wikit'),
            ],
            'opening'           => [
                'mode'     => 'close',
                'delay'    => null,
                'memorize' => true,
            ],
            'position'          => $on_login
                ? ['right' => '1rem', 'bottom' => '1rem']
                : ['left' => '1rem', 'top' => '1rem'],
        ];
        if ($on_login) {
            $options['chatButtonAnimation'] = [
                'delay'       => 300,
                'enabled'     => true,
                'openTooltip' => true,
            ];
        }

        return $options;
    }

    /**
     * Encode a value as a JavaScript literal, safe inside an inline <script> block
     *
     * @param mixed $value
     *
     * @return string
     */
    public static function toJs($value): string
    {
        return json_encode($value, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_THROW_ON_ERROR);
    }

    public static function canView(): bool
    {
        return (Session::haveRight(self::$rightname, UPDATE));
    }


    public static function canCreate(): bool
    {
        return (Session::haveRight(self::$rightname, CREATE));
    }

    public function showForm($ID, $options = [])
    {
        $this->getFromDB(1);

        echo "<form name='form' method='post' action='" . Toolbox::getItemTypeFormURL('PluginWikitConfig') . "'>";

        echo "<div class='center'><table class='tab_cadre_fixe'>";
        echo "<tr><th colspan='4'>" . __('Wikit plugin setup', 'wikit') . "</th></tr>";
        echo "<tr class='tab_bg_1'>";

        echo "<tr class='tab_bg_1'>";
        echo "<td>" . __("Web Chat Token", 'wikit') . "</td>";
        echo "<td>";
        echo Html::input('webchattoken', ['value' => $this->fields['webchattoken'], 'size' => 100]);
        echo "</td>";
        echo "<td colspan='2'></td>";
        echo "</tr>";

        echo "<tr class='tab_bg_1'>";
        echo "<td>" . __('Display on login', 'wikit') . "</td>";
        echo "<td>";
        Dropdown::showYesNo('display_on_login', is_numeric($this->getField('display_on_login')) ? $this->getField('display_on_login') : 1);
        echo "</td>";
        echo "</tr>";

        echo "<tr class='tab_bg_1'>";
        echo "<td>" . __("Home description text", 'wikit') . "</td>";
        echo "<td>";
        echo Html::input('home_description_text', ['value' => $this->fields['home_description_text'], 'size' => 100]);
        echo "</td>";
        echo "<td colspan='2'></td>";
        echo "</tr>";

        echo "<tr class='tab_bg_1'>";
        echo "<td>" . __("Description text", 'wikit') . "</td>";
        echo "<td>";
        echo Html::input('description_text', ['value' => $this->fields['description_text'], 'size' => 100]);
        echo "</td>";
        echo "<td colspan='2'></td>";
        echo "</tr>";

        echo "<tr class='tab_bg_1'>";
        echo "<td>" . __("Closing window text", 'wikit') . "</td>";
        echo "<td>";
        echo Html::input('close_text', ['value' => $this->fields['close_text'], 'size' => 100]);
        echo "</td>";
        echo "<td colspan='2'></td>";
        echo "</tr>";

        echo "<tr class='tab_bg_1'>";
        echo "<td>" . __("Open new window text", 'wikit') . "</td>";
        echo "<td>";
        echo Html::input('open_newwindow_text', ['value' => $this->fields['open_newwindow_text'], 'size' => 100]);
        echo "</td>";
        echo "<td colspan='2'></td>";
        echo "</tr>";

        echo "<tr class='tab_bg_1'>";
        echo "<td>" . __("Maximize window text", 'wikit') . "</td>";
        echo "<td>";
        echo Html::input('maximize_text', ['value' => $this->fields['maximize_text'], 'size' => 100]);
        echo "</td>";
        echo "<td colspan='2'></td>";
        echo "</tr>";

        echo "<tr class='tab_bg_1'>";
        echo "<td>" . __("Minimize window text", 'wikit') . "</td>";
        echo "<td>";
        echo Html::input('minimize_text', ['value' => $this->fields['minimize_text'], 'size' => 100]);
        echo "</td>";
        echo "<td colspan='2'></td>";
        echo "</tr>";

        echo "<tr class='tab_bg_1'>";
        echo "<td>" . __("Persona", 'wikit') . "</td>";
        echo "<td>";
        echo Html::input('persona', ['value' => $this->fields['persona'], 'size' => 100]);
        echo "</td>";
        echo "<td colspan='2'></td>";
        echo "</tr>";

        echo "<tr class='tab_bg_1'>";
        echo "<td>" . __("Avatar URL", 'wikit') . "</td>";
        echo "<td>";
        echo Html::input('icon_url', ['value' => $this->fields['icon_url'], 'size' => 100]);
        echo "</td>";
        echo "<td colspan='2'></td>";
        echo "</tr>";

        echo "<tr class='tab_bg_1'>";
        echo "<td>" . __("Width", 'wikit') . "</td>";
        echo "<td>";
        $optionNumber = [
            'value' => $this->fields['width'],
            'min'   => 25,
            'max'   => 100,
            'step'  => 25,
        ];
        Dropdown::showNumber('width', $optionNumber);
        echo " px";
        echo "</td>";
        echo "<td colspan='2'></td>";
        echo "</tr>";

        echo "<tr class='tab_bg_1'>";
        echo "<td>" . __("Height", 'wikit') . "</td>";
        echo "<td>";
        $optionNumber = [
            'value' => $this->fields['height'],
            'min'   => 25,
            'max'   => 100,
            'step'  => 25,
        ];
        Dropdown::showNumber('height', $optionNumber);
        echo " px";
        echo "</td>";
        echo "<td colspan='2'></td>";
        echo "</tr>";

        echo "<tr class='tab_bg_1'>";
        echo "<td>" . __("Top", 'wikit') . "</td>";
        echo "<td>";
        $optionNumber = [
            'value' => $this->fields['top'],
            'min'   => 1,
            'max'   => 100,
        ];
        Dropdown::showNumber('top', $optionNumber);
        echo " %";
        echo "</td>";
        echo "<td colspan='2'></td>";
        echo "</tr>";

        echo "<tr class='tab_bg_1'>";
        echo "<td>" . __("Bottom", 'wikit') . "</td>";
        echo "<td>";
        $optionNumber = [
            'value' => $this->fields['bottom'],
            'min'   => 1,
            'max'   => 100,
        ];
        Dropdown::showNumber('bottom', $optionNumber);
        echo " %";
        echo "</td>";
        echo "<td colspan='2'></td>";
        echo "</tr>";

        echo "<tr class='tab_bg_1'>";
        echo "<td>" . __("Left", 'wikit') . "</td>";
        echo "<td>";
        $optionNumber = [
            'value' => $this->fields['left'],
            'min'   => 1,
            'max'   => 100,
        ];
        Dropdown::showNumber('left', $optionNumber);
        echo " %";
        echo "</td>";
        echo "<td colspan='2'></td>";
        echo "</tr>";

        echo "<tr class='tab_bg_1'>";
        echo "<td>" . __("Right", 'wikit') . "</td>";
        echo "<td>";
        $optionNumber = [
            'value' => $this->fields['right'],
            'min'   => 1,
            'max'   => 100,
        ];
        Dropdown::showNumber('right', $optionNumber);
        echo " %";
        echo "</td>";
        echo "<td colspan='2'></td>";
        echo "</tr>";


        echo "<tr><td class='tab_bg_2 center' colspan='6'>";
        echo Html::submit(_sx('button', 'Post'), ['name' => 'update', 'class' => 'btn btn-primary']);
        echo "</td></tr>";

        Html::closeForm();
    }

    public static function getIcon()
    {
        return "ti ti-brand-hipchat";
    }
}
