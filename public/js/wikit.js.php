<?php

header('Content-Type: text/javascript');

// The referer only hides the widget on some pages for comfort, it is not a security control
$hidden_on = ['displaypreference', 'ticket.form.php', 'ticketcheck.form.php'];
$referer   = $_SERVER['HTTP_REFERER'] ?? '';
foreach ($hidden_on as $page) {
    if ($referer !== '' && str_contains($referer, $page)) {
        exit;
    }
}

$options = PluginWikitConfig::getWebChatOptions();
if ($options === null) {
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

//------ Wikit integration (D87 / Bob) ------

// Every server value is emitted as a JSON literal, never between hand-written quotes
var wikitWebchatOptions = <?php echo PluginWikitConfig::toJs($options); ?>;

var loadWebChat = function() {
    wrapWebchat(wikitWebchatOptions);
}

loadScript(<?php echo PluginWikitConfig::toJs(PluginWikitConfig::VENDOR_SCRIPT_URL); ?>, loadWebChat);
