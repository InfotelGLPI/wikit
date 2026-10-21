<?php
header("Content-type: text/css; charset: UTF-8");

$config = new PluginWikitConfig();
$config->getFromDB(1);
$top = (int) ($config->fields['top'] ?? 0);
$bottom = (int) ($config->fields['bottom'] ?? 0);
$left = (int) ($config->fields['left'] ?? 0);
$right = (int) ($config->fields['right'] ?? 0);
?>

.webchat__btn {
    top: <?php echo $top; ?>%;
    bottom: <?php echo $bottom; ?>%;
    left: <?php echo $left; ?>%;
    right: <?php echo $right; ?>%;
}
