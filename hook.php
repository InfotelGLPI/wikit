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
