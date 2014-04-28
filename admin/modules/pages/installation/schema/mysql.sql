--
-- Drop table, if exists
--

drop table if exists `{{mod_page}}`;

--
-- Pages table
--

create table `{{mod_page}}`
(
   `alias`                varchar(64) not null,
   `title`                varchar(128) not null,
   `content`              text,
   `language`             varchar(32),
   `updatetime`           integer,
   primary key (`alias`)
) engine InnoDB;