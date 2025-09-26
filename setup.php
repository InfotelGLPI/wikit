<?php
/*
 -------------------------------------------------------------------------
 Wikit plugin for GLPI
 Copyright (C) 2021-2022 by the Wikit Development Team.

 -------------------------------------------------------------------------

 LICENSE

 This file is part of Wikit.

 Wikit is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 Wikit is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with Wikit. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */

global $CFG_GLPI;

use Glpi\Plugin\Hooks;

define('PLUGIN_WIKIT_VERSION', '2.0.0');

// Minimal GLPI version, inclusive
define("PLUGIN_WIKIT_MIN_GLPI", "11");
// Maximum GLPI version, exclusive
define("PLUGIN_WIKIT_MAX_GLPI", "12");

if (!defined("PLUGIN_WIKIT_DIR")) {
    define("PLUGIN_WIKIT_DIR", Plugin::getPhpDir("wikit"));
    define("PLUGIN_WIKIT_DIR_NOFULL", Plugin::getPhpDir("wikit", false));
    $root = $CFG_GLPI['root_doc'] . '/plugins/wikit';
    define("PLUGIN_WIKIT_WEBDIR", $root);
}

/**
 * Init hooks of the plugin.
 * REQUIRED
 *
 * @return void
 */
function plugin_init_wikit()
{
    global $PLUGIN_HOOKS;

    $PLUGIN_HOOKS['csrf_compliant']['wikit'] = true;

    $PLUGIN_HOOKS[Hooks::ADD_JAVASCRIPT]['wikit'] = [
        'js/wikit.js.php',
    ];

    $PLUGIN_HOOKS[Hooks::ADD_CSS]['wikit'] = [
        'css/wikit.css.php',
    ];

    if (Session::haveRight("config", UPDATE)) {
        $PLUGIN_HOOKS['config_page']['wikit'] = 'front/config.form.php';
    }

    $PLUGIN_HOOKS['display_login']['wikit'] = "plugin_wikit_display_login";
    
}


/**
 * Get the name and the version of the plugin
 * REQUIRED
 *
 * @return array
 */
function plugin_version_wikit()
{
    return [
        'name' => 'Wikit',
        'version' => PLUGIN_WIKIT_VERSION,
        'author' => '<a href="https://blogglpi.infotel.com">Infotel</a>',
        'license' => 'GPL v2+',
        'logo_url' => 'http://localhost/glpi10/plugins/wikit/wikit.png',
        'homepage' => 'https://blogglpi.infotel.com',
        'requirements' => [
            'glpi' => [
                'min' => PLUGIN_WIKIT_MIN_GLPI,
                'max' => PLUGIN_WIKIT_MAX_GLPI,
            ],
        ]
    ];
}
