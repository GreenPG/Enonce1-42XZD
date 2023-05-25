CREATE TABLE IF NOT EXISTS `{{prefix}}totalsurvey_entries` (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `uid` varchar(40) COLLATE utf8mb4_general_ci NOT NULL,
    `survey_uid` varchar(40) COLLATE utf8mb4_general_ci NOT NULL,
    `user_id` int(10) UNSIGNED DEFAULT NULL,
    `ip` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
    `agent` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` datetime DEFAULT NULL,
    `deleted_at` datetime DEFAULT NULL,
    `data` longtext COLLATE utf8mb4_general_ci NOT NULL,
    `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
    PRIMARY KEY (`id`),
    KEY `UID_INDEX` (`uid`),
    KEY `SURVEY_ID` (`survey_uid`),
    KEY `IP_INDEX` (`ip`),
    KEY `AGENT_INDEX` (`agent`),
    KEY `STATUS_INDEX` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;