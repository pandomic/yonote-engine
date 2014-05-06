--
-- YOnote ENGINE database schema file
--
-- @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
-- @link http://yonote.org
-- @copyright 2014 Vlad Gramuzov
-- @license http://yonote.org/license.html
--

--
-- Drop tables, if exist
--

drop table if exists `{{auth_item}}`;
drop table if exists `{{auth_item_child}}`;
drop table if exists `{{auth_assignment}}`;
drop table if exists `{{module}}`;
drop table if exists `{{user}}`;
drop table if exists `{{profile}}`;
drop table if exists `{{setting}}`;
drop table if exists `{{pm}}`;

--
-- Auth items table
--

create table `{{auth_item}}`
(
   `name`                 varchar(64) not null,
   `type`                 integer not null,
   `description`          text,
   `bizrule`              text,
   `data`                 text,
   primary key (`name`)
) engine InnoDB;

--
-- Auth items relations table
--

create table `{{auth_item_child}}`
(
   `parent`               varchar(64) not null,
   `child`                varchar(64) not null,
   primary key (`parent`,`child`),
   foreign key (`parent`) references `{{auth_item}}` (`name`) on delete cascade on update cascade,
   foreign key (`child`) references `{{auth_item}}` (`name`) on delete cascade on update cascade
) engine InnoDB;

--
-- Auth assigments table
--

create table `{{auth_assignment}}`
(
   `itemname`             varchar(64) not null,
   `userid`               varchar(64) not null,
   `bizrule`              text,
   `data`                 text,
   primary key (`itemname`,`userid`),
   foreign key (`itemname`) references `{{auth_item}}` (`name`) on delete cascade on update cascade,
   foreign key (`userid`) references `{{user}}` (`name`) on delete cascade on update cascade
) engine InnoDB;

--
-- Modules table
--

create table `{{module}}`
(
   `name`             varchar(64) not null,
   `title`            varchar(128),
   `description`      text,
   `author`           varchar(64),
   `email`            varchar(64),
   `website`          varchar(128),
   `copyright`        varchar(128),
   `license`          text,
   `position`         integer default 0,
   `installed`        boolean default 0,
   `version`          varchar(64),
   `updateTime`       integer default 0,
   primary key (`name`)
) engine InnoDB;

--
-- Base user information
--

create table `{{user}}`
(
   `userid`           varchar(64) not null,
   `password`         text not null,
   `token`            text,
   `email`            varchar(64) not null,
   `activated`        boolean default 0,
   `verified`         boolean default 0,
   `subscribed`       boolean default 0,
   `updatetime`       integer,
   primary key (`username`)
) engine InnoDB;

--
-- Base user information
--

create table `{{pm}}`
(
   `id`               integer auto_increment,
   `title`            varchar(128),
   `message`          text,
   `ownerid`          varchar(64) not null,
   `senderid`       varchar(64) not null,
   `inbox`            boolean default 0,
   `outbox`           boolean default 0,
   `read`             boolean default 0,
   `updatetime`       integer,
   primary key (`id`),
   foreign key (`ownerid`) references `{{user}}` (`name`) on delete cascade on update cascade,
   foreign key (`senderid`) references `{{user}}` (`name`)
) engine InnoDB;

--
-- User profile
--

create table `{{profile}}`
(
   `userid`           varchar(64) not null,
   `name`             varchar(128),
   `photo`            varchar(128),
   `language`         varchar(32),
   `country`          varchar(128),
   `city`             varchar(128),
   `updatetime`       integer,
   primary key (`userid`),
   foreign key (`userid`) references `{{user}}` (`name`) on delete cascade on update cascade
) engine InnoDB;

--
-- Settings table
-- Provides settings storage
--

create table `{{setting}}`
(
   `category`         varchar(64) not null,
   `name`             varchar(128) not null,
   `value`            text,
   `description`      text,
   `updateTime`       integer,
   primary key (`category`,`name`)
) engine InnoDB;