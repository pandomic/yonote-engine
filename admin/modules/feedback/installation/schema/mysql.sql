--
-- Feedback module database schema file
--
-- @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
-- @link http://yonote.org
-- @copyright 2014 Vlad Gramuzov
-- @license http://yonote.org/license.html
--

--
-- Drop tables, if exist
--

drop table if exists `{{mod_feedback}}`;

--
-- Pages table
--

create table `{{mod_feedback}}`
(
   `id`                   int auto_increment,
   `name`                 varchar(128) not null,
   `email`                varchar(128) not null,
   `phone`                varchar(64),
   `message`              text,
   `updatetime`           integer,
   primary key (`id`)
) engine InnoDB;