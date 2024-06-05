DROP TABLE IF EXISTS `glpi_plugin_wikit_configs`;
CREATE TABLE `glpi_plugin_wikit_configs`
(
    `id`                    int unsigned                            NOT NULL auto_increment,
    `webchattoken`          VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `display_on_login`      tinyint                                 NOT NULL DEFAULT '0',
    `home_description_text` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `description_text`      VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `close_text`            VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `open_newwindow_text`   VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `maximize_text`         VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `minimize_text`         VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `persona`               VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Navy',
    `icon_url`              VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci
  ROW_FORMAT = DYNAMIC;
