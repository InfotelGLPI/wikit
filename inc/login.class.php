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

class PluginWikitLogin extends CommonDBTM
{

    static function displayWebChat()
    {
        // Wikit (to refactor in a lovely GLPI plugin)
        $userLogin = 'anonymous';
        $config = new PluginWikitConfig();
        $config->getFromDB(1);
        $webChatToken = $config->fields['webchattoken'];
        $description_text = __('Welcome to the digital service center!', 'wikit');
        $close_text = __('Close the window', 'wikit');
        $open_newwindow_text = __('Open in new tab', 'wikit');
        $maximize_text = __('Enlarge window', 'wikit');
        $minimize_text = __('Shrink window', 'wikit');

        echo '<script type="text/javascript" src="https://webchat.wikit.ai/webchat-embed.js"></script>';
        echo '<script type="text/javascript">
            wrapWebchat({
                color: "#243469",
                webchatParams: {
                    userId: "' . $userLogin . '",
                    userIdType: "login",
                    userFirstName: "",
                    userLastName: "",
                    webChatToken: "' . $webChatToken . '",
                    originId: "GLPI"
                },
                height: "80%",
                width: "30%",
                chatButtonIcon: {
                    url: "https://wikit-files-hpg.s3.eu-de.objectstorage.softlayer.net/1657139091885-Neo.png",
                    altText: null,
                    height: "100px",
                    width: "100px",
                    borderRadius: "50%",
                },
                chatButtonTooltip: {
                    text: "' . $description_text . '",
                    backgroundColor: "#243469",
                    textColor: "#FFFFFF",
                    visibility: "hidden",
                },
                headerButtons: {
                    color: "#fff",
                    closeIconDescription: "' . $close_text . '",
                    launchIconDescription: "' . $open_newwindow_text . '",
                    maximizeIconDescription: "' . $maximize_text . '",
                    minimizeIconDescription: "' . $minimize_text . '",
                },
                opening: {
                    mode: "delay",
                    delay: 7000,
                    memorize: true,
                },
                position: {
                    right: "1rem",
                    bottom: "1rem",
                },
            });
    </script>';
    }
}