CREATE TABLE `vote_by_ip` (
    `ip` varchar(45) not null,
    `entity_type_id` int(10) unsigned not null,
    `type_id` int(10) unsigned not null,
    `value` int(1) signed not null,
    PRIMARY KEY (`ip`, `entity_type_id`, `type_id`)
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
