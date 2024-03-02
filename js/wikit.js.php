<?php
use Glpi\Event;

include('../../../inc/includes.php');
header('Content-Type: text/javascript');

$user = new User();
$user->getFromDB(Session::getLoginUserID());
$userLogin = $user->fields['name'] ?? 'anonymous';
$firstname = $user->fields['firstname'] ?? 'anonymous';
$realname = $user->fields['realname'] ?? 'anonymous';
$config = new PluginWikitConfig();
$config->getFromDB(1);
$webChatToken = $config->fields['webchattoken'];
$description_text = $config->fields['description_text'] ?? __('A problem ? Ask me your question 😊', 'wikit');
$close_text = $config->fields['close_text'] ?? __('Close the window', 'wikit');
$open_newwindow_text = $config->fields['open_newwindow_text'] ?? __('Open in new tab', 'wikit');
$maximize_text = $config->fields['maximize_text'] ?? __('Enlarge window', 'wikit');
$minimize_text = $config->fields['minimize_text'] ?? __('Shrink window', 'wikit');

if (isset($_SERVER['HTTP_REFERER'])
    && strpos($_SERVER['HTTP_REFERER'], "displaypreference") !== false) {
    exit;
}

if (isset($_SERVER['HTTP_REFERER'])
    && strpos($_SERVER['HTTP_REFERER'], "ticket.form.php") !== false) {
    exit;
}

?>

function loadScript(url, callback)
{
    // Adding the script tag to the head as suggested before
    var head = document.head;
    var script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = url;

    // Then bind the event to the callback function.
    // There are several events for cross browser compatibility.
    script.onreadystatechange = callback;
    script.onload = callback;

    // Fire the loading
    head.appendChild(script);
}

var userLogin = "<?php echo $userLogin ?>";
var userFirstname = "<?php echo $firstname ?>";
var userRealname = "<?php echo $realname ?>";
var webChatToken = "<?php echo $webChatToken ?>";
var description_text = "<?php echo $description_text ?>";
var close_text = "<?php $close_text ?>";
var open_newwindow_text = "<?php echo $open_newwindow_text ?>";
var maximize_text = "<?php echo $maximize_text ?>";
var minimize_text = "<?php echo $minimize_text ?>";

//------ Wikit integration (D87 / Bob) ------

var loadWebChat = function() {
    wrapWebchat({
        color: "#243469",
        webchatParams: {
            userId: userLogin,
            userIdType: "login",
            userFirstName: userFirstname,
            userLastName: userRealname,
            webChatToken: webChatToken,
            originId: "GLPI",
        },
        height: "80%",
        width: "30%",
        chatButtonIcon: {
            url: "https://wikit-files-hpg.s3.eu-de.objectstorage.softlayer.net/1657139091885-Neo.png",
            //url: "https://www.awelty.fr/medias/images/chatbot-illustration-etapes-awelty.png",
            altText: "Bob",
            height: "100px",
            width: "100px",
            borderRadius: "50%",
        },
        chatButtonTooltip: {
            text: description_text,
            backgroundColor: "#005091",
            textColor: "#FFFFFF",
            visibility: "hidden",
        },
        //chatButtonAnimation: { // Animation du bouton de chat
        //    delay: null, // Délais en millisecondes après lequel le bouton s"anime
        //    enabled: true, // Active l"animation
        //    openTooltip: true // Ouvre l"info-bulle après l"animation
        //},
        headerButtons: {
            color: "#fff",
            closeIconDescription: close_text,
            launchIconDescription: open_newwindow_text,
            maximizeIconDescription: maximize_text,
            minimizeIconDescription: minimize_text,
        },
        opening: {
            mode: "close",
            delay: null,
            memorize: true,
        },
        position: {
            right: "1rem",
            bottom: "1rem",
        },
    });
}

loadScript("https://webchat.wikit.ai/webchat-embed.js", loadWebChat);
