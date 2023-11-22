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
//use Glpi\Application\View\TemplateRenderer;

class PluginWikitConfig extends CommonDBTM
{

    public static $rightname = 'config';

    public static function getTypeName($nb = 0)
    {
        return __('Wikit plugin setup', 'wikit');
    }

    public function __construct()
    {
        global $DB;

        if ($DB->tableExists($this->getTable())) {
            $this->getFromDB(1);
        }
    }

    public static function canView()
    {
        return (Session::haveRight(self::$rightname, UPDATE));
    }


    public static function canCreate()
    {
        return (Session::haveRight(self::$rightname, CREATE));
    }

    public function showForm($ID, $options = [])
    {

        echo "<form name='form' method='post' action='" . Toolbox::getItemTypeFormURL('PluginWikitConfig') . "'>";

        echo "<div align='center'><table class='tab_cadre_fixe'>";
        echo "<tr><th colspan='4'>" . __('Setup', 'wikit') . "</th></tr>";
        echo "<tr class='tab_bg_1'>";

        echo "<tr class='tab_bg_1'>";
        echo "<td>" . __("Web Chat Token", 'wikit') . "</td>";
        echo "<td>";
        echo Html::input('webchattoken', ['value' => $this->fields['webchattoken'], 'size' => 100]);
        echo "</td>";
        echo "</tr>";


        echo "<tr><td class='tab_bg_2 center' colspan='6'>";
        echo Html::submit(_sx('button', 'Post'), ['name' => 'update_config', 'class' => 'btn btn-primary']);
        echo "</td></tr>";

        Html::closeForm();
    }
}

?>
