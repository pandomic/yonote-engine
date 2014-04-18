--
-- Drop tables, if exists
--

drop table if exists `{{auth_assignment}}`;
drop table if exists `{{extension}}`;
drop table if exists `{{module}}`;
drop table if exists `{{widget}}`;
drop table if exists `{{template}}`;
drop table if exists `{{user}}`;
drop table if exists `{{profile}}`;
drop table if exists `{{setting}}`;

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
-- Extensions table
--

create table `{{extension}}`
(
   `name`             varchar(64) not null,
   `title`            varchar(128),
   `description`      text,
   `author`           varchar(64),
   `email`            varchar(64),
   `website`          varchar(128),
   `copyright`        varchar(128),
   `licence`          text,
   `data`             text,
   `updateTime`       integer default 0,
   primary key (`name`)
) engine InnoDB;

--
-- Modules table (many-to-one)
-- Module is a part of extension
--

create table `{{module}}`
(
   `name`             varchar(64) not null,
   `title`            varchar(128),
   `extension`        varchar(64) not null,
   `priority`         integer default 0,
   `installed`        boolean default 0,
   `updateTime`       integer default 0,
   primary key (`name`,`extension`),
   foreign key (`extension`) references `{{extension}}` (`name`) on delete cascade on update cascade
) engine InnoDB;

--
-- Base widgets table (many-to-one)
-- Widget is a part if extension
--

create table `{{widget}}`
(
   `name`             varchar(64) not null,
   `extension`        varchar(64) not null,
   `classPath`        varchar(128) not null,
   `type`             integer,
   `title`            varchar(128),
   `description`      text,
   `usePids`          text,
   `usePidsFlag`      boolean default 0,
   `unusePids`        text,
   `unusePidsFlag`    boolean default 0,
   `params`           text,
   `updateTime`       integer,
   `position`         integer default 0,
   primary key (`name`,`extension`,`classPath`),
   foreign key (`extension`) references `{{extension}}` (`name`) on delete cascade on update cascade
) engine InnoDB;

--
-- Templates table (many-to-one)
-- Provides general reference to extension
-- Template is a part of extension
--

create table `{{template}}`
(
   `name`             varchar(64) not null,
   `extension`        varchar(64) not null,
   `updateTime`       integer default 0,
   primary key (`name`,`extension`),
   foreign key (`extension`) references `{{extension}}` (`name`) on delete cascade on update cascade
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
   primary key (`username`)
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