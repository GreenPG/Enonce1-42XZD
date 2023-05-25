CREATE TABLE IF NOT EXISTS `{{prefix}}totalsurvey_presets`
(
    `id`          int(10) UNSIGNED                                             NOT NULL AUTO_INCREMENT,
    `uid`         varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    `name`        varchar(255) COLLATE utf8mb4_general_ci                      NOT NULL,
    `description` text COLLATE utf8mb4_general_ci                              NOT NULL,
    `survey`      longtext COLLATE utf8mb4_general_ci                          NOT NULL,
    `category`    varchar(255) COLLATE utf8mb4_general_ci                      NOT NULL,
    `source`      varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci         DEFAULT NULL,
    `thumbnail`   varchar(255) COLLATE utf8mb4_general_ci                               DEFAULT NULL,
    `created_at`  datetime                                                     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `deleted_at`  datetime                                                     NULL,
    PRIMARY KEY `id` (`id`),
    KEY `uid` (`uid`),
    KEY `category` (`category`),
    KEY `source` (`source`),
    FULLTEXT `content` (`name`, `description`),
    FULLTEXT `survey` (`survey`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;