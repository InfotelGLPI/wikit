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

include('../../../inc/includes.php');

global $CFG_GLPI;

if (Plugin::isPluginActive("wikit")) {
    if (Session::haveRight("config", UPDATE)) {
        Html::redirect("config.form.php");
    } else {
        Html::displayRightError();
    }
} else {
    Html::header(__('Setup'), '', "config", "plugins");
    echo "<div class='alert alert-important alert-warning d-flex'>";
    echo "<b>" . __('Please activate the plugin', 'wikit') . "</b></div>";
    Html::footer();
}
