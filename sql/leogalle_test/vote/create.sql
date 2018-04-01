CREATE TABLE `vote` (
    `vote_id` int(10) unsigned auto_increment,
    `user_id` int(10) unsigned not null,
    `entity_id` int(10) unsigned default null,
    `entity_type_id` int(10) unsigned not null,
    `type_id` int(10) unsigned not null,
    `value` int(1) signed not null,
    `created` datetime not null,
    `updated` datetime default null,
    PRIMARY KEY (`vote_id`),
    UNIQUE (`user_id`, `entity_type_id`, `type_id`),
    KEY (`entity_type_id`, `type_id`, `value`)
) charset=utf8;
