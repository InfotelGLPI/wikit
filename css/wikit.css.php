<?php
header("Content-type: text/css; charset: UTF-8");
include('../../../inc/includes.php');
$config = new PluginWikitConfig();
$config->getFromDB(1);
$top = $config->fields['top'];
$bottom = $config->fields['bottom'];
$left = $config->fields['left'];
$right = $config->fields['right'];
?>

.webchat__btn {
    top: <?php echo $top; ?>%;
    bottom: <?php echo $bottom; ?>%;
    left: <?php echo $left; ?>%;
    right: <?php echo $right; ?>%;
}
