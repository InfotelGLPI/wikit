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

define('PLUGIN_WIKIT_VERSION', '1.0.0');

// Minimal GLPI version, inclusive
define("PLUGIN_WIKIT_MIN_GLPI", "10.0.0");
// Maximum GLPI version, exclusive
define("PLUGIN_WIKIT_MAX_GLPI", "10.0.99");

if (!defined("PLUGIN_WIKIT_DIR")) {
    define("PLUGIN_WIKIT_DIR", Plugin::getPhpDir("wikit"));
    define("PLUGIN_WIKIT_DIR_NOFULL", Plugin::getPhpDir("wikit", false));
    define("PLUGIN_WIKIT_WEBDIR", Plugin::getWebDir("wikit"));
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

    $PLUGIN_HOOKS['add_javascript']['wikit'] = [
        'js/connection.js.php',
    ];

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
        'name' => 'wikit',
        'version' => PLUGIN_WIKIT_VERSION,
        'author' => '<a href="https://blogglpi.infotel.com">Infotel</a>',
        'license' => 'GPL v2+',
        'homepage' => 'https://blogglpi.infotel.com',
        'requirements' => [
            'glpi' => [
                'min' => PLUGIN_WIKIT_MIN_GLPI,
                'max' => PLUGIN_WIKIT_MAX_GLPI,
            ],
        ]
    ];
}
