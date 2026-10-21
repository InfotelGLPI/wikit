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


class PluginWikitLogin
{

    public static function displayWebChat()
    {
        $options = PluginWikitConfig::getWebChatOptions(true);
        if ($options === null) {
            return;
        }

        echo '<script type="text/javascript" src="' . htmlescape(PluginWikitConfig::VENDOR_SCRIPT_URL) . '"></script>';
        // Every config value is emitted as a JSON literal, never between hand-written quotes
        echo Html::scriptBlock('wrapWebchat(' . PluginWikitConfig::toJs($options) . ');');
    }
}
