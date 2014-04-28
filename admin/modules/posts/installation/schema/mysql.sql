--
-- Drop table, if exists
--

drop table if exists `{{mod_post}}`;
drop table if exists `{{mod_post_hashtags}}`;

--
-- Posts table
--

create table `{{mod_post}}`
(
   `alias`                varchar(64) not null,
   `title`                varchar(128) not null,
   `short`                text,
   `full`                 text,
   `thumbnail`            text,
   `language`             varchar(32),
   `updatetime`           int,
   primary key (`alias`)
) engine InnoDB;

--
-- Posts hash tags table
--

create table `{{mod_post_hashtag}}`
(
   `name`                 varchar(64) not null,
   primary key (`name`)
) engine InnoDB;

--
-- Relations table
--

create table `{{mod_post_relation}}`
(
   `hashtagid`            varchar(64) not null,
   `postid`               varchar(64) not null,
   primary key (`hashtagid`,`postid`),
   foreign key (`hashtagid`) references `{{mod_post_hashtag}}` (`name`) on delete cascade on update cascade,
   foreign key (`postid`) references `{{mod_post}}` (`alias`) on delete cascade on update cascade
) engine InnoDB;