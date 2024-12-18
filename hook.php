<?php
/*
 -------------------------------------------------------------------------
 Ewikit plugin for GLPI
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

function plugin_wikit_install()
{
    global $DB;

    if (!$DB->tableExists("glpi_plugin_wikit_configs")) {
        $DB->runFile(PLUGIN_WIKIT_DIR . "/install/sql/empty-1.1.0.sql");

        if (!$DB->fieldExists("glpi_plugin_wikit_configs", "persona", false)) {
            $query = "ALTER TABLE `glpi_plugin_wikit_configs` ADD `persona` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Navy';";
            $DB->doQuery($query);
        }

        if (!$DB->fieldExists("glpi_plugin_wikit_configs", "icon_url", false)) {
            $query = "ALTER TABLE `glpi_plugin_wikit_configs` ADD `icon_url` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL;";
            $DB->doQuery($query);
        }
        $input['webchattoken'] = "";
        $input['description_text'] = __('A problem ? Ask me your question ??', 'wikit');
        $input['home_description_text'] = __('Welcome to the digital service center!', 'wikit');
        $input['close_text'] = __('Close the window', 'wikit');
        $input['open_newwindow_text'] = __('Open in new tab', 'wikit');
        $input['maximize_text'] = __('Enlarge window', 'wikit');
        $input['minimize_text'] = __('Shrink window', 'wikit');
        $input['persona'] = "Navy";
        $input['icon_url'] = "";
        $input['width'] = "50";
        $input['height'] = "50";
        $input['top'] = "93";
        $input['bottom'] = "7";
        $input['left'] = "97";
        $input['right'] = "3";

        $config = new PluginWikitConfig();
        $input['id'] = 1;
        $config->add($input);

    } elseif (!$DB->fieldExists("glpi_plugin_wikit_configs", "width")) {
        $DB->runFile(PLUGIN_WIKIT_DIR . "/install/sql/update-1.1.0.sql");
    }

    if (!$DB->fieldExists("glpi_plugin_wikit_configs", "persona", false)) {
        $query = "ALTER TABLE `glpi_plugin_wikit_configs` ADD `persona` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Navy';";
        $DB->doQuery($query);
    }

    if (!$DB->fieldExists("glpi_plugin_wikit_configs", "icon_url", false)) {
        $query = "ALTER TABLE `glpi_plugin_wikit_configs` ADD `icon_url` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL;";
        $DB->doQuery($query);
    }

    return true;
}


/**
 * Plugin uninstall process
 *
 * @return boolean
 */
function plugin_wikit_uninstall()
{
    global $DB;

    // Plugin tables deletion
    $tables = ["glpi_plugin_wikit_configs"];

    foreach ($tables as $table) {
        $DB->dropTable($table);
    }
}

function plugin_wikit_display_login()
{
    PluginWikitLogin::displayWebChat();
}
