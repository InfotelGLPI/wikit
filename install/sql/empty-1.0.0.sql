DROP TABLE IF EXISTS `glpi_plugin_wikit_configs`;
CREATE TABLE `glpi_plugin_wikit_configs`
(
    `id`                     int unsigned NOT NULL auto_increment,
    `webchattoken`           VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

INSERT INTO `glpi_plugin_wikit_configs` (`id`, `webchattoken`)
VALUES ('1', '');


