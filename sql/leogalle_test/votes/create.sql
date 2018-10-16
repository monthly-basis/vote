CREATE TABLE `votes` (
    `entity_type_id` int(10) unsigned not null,
    `type_id` int(10) unsigned not null,
    `up_votes` int(1) unsigned not null default '0',
    `down_votes` int(1) unsigned not null default '0',
    PRIMARY KEY (`entity_type_id`, `type_id`)
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
