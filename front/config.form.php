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


if (!isset($_GET["id"])) {
    $_GET["id"] = "1";
}

if (!isset($_POST["id"])) {
    $_POST["id"] = "1";
}

if (Plugin::isPluginActive("wikit")) {
    Session::checkRight("config", UPDATE);

    $config = new PluginWikitConfig();

    if (isset($_POST["update"])) {
        $config->update($_POST);
        Html::back();
    } else {
        Html::header(__('Setup', 'wikit'), '', "config", "pluginwikitmenu", "config");
        $config->display($_GET);
        Html::footer();
    }
} else {
    Html::header(__('Setup'), '', "config", "plugin");
    echo "<div class='alert alert-important alert-warning d-flex'>";
    echo "<b>" . __('Please activate the plugin', 'wikit') . "</b></div>";
    Html::footer();
}
