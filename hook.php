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
        $DB->runFile(PLUGIN_STOCKVIEW_DIR . "/install/sql/empty-1.0.0.sql");
        $description_text = __('A problem ? Ask me your question ??', 'wikit');
        $home_description_text = __('Welcome to the digital service center!', 'wikit');
        $close_text = __('Close the window', 'wikit');
        $open_newwindow_text = __('Open in new tab', 'wikit');
        $maximize_text = __('Enlarge window', 'wikit');
        $minimize_text = __('Shrink window', 'wikit');
            
        $query = "INSERT INTO `glpi_plugin_wikit_configs` (`id`, `webchattoken`, `display_on_login`, 
                                         `home_description_text`, `description_text`, `close_text`, `open_newwindow_text`, `maximize_text`, `minimize_text`)
VALUES ('1', '', 0,'".$home_description_text."','".$description_text."','".$close_text."','".$open_newwindow_text."','".$maximize_text."','".$minimize_text."');";
        $DB->query($query);
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
    $tables = ["glpi_plugin_wikit_configss"];

    foreach ($tables as $table) {
        $DB->query("DROP TABLE IF EXISTS `$table`;");
    }
}

function plugin_wikit_display_login()
{
    PluginWikitLogin::displayWebChat();
}
