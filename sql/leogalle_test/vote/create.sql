CREATE TABLE `vote` (
    `vote_id` int(10) unsigned auto_increment,
    `user_id` int(10) unsigned not null,
    `value` int(1) signed not null,
    `created` datetime not null,
    `updated` datetime default null,
    PRIMARY KEY (`vote_id`)
) charset=utf8;
