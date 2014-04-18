-- phpMyAdmin SQL Dump
-- version 4.0.10
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 18 2014 г., 20:35
-- Версия сервера: 5.5.37-log
-- Версия PHP: 5.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `yonote`
--

-- --------------------------------------------------------

--
-- Структура таблицы `yonote_auth_assignment`
--

CREATE TABLE IF NOT EXISTS `yonote_auth_assignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yonote_auth_assignment`
--

INSERT INTO `yonote_auth_assignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('administrator', 'admin', NULL, 'N;'),
('authenticated', 'newuser', NULL, 'N;'),
('guest', 'alone', NULL, 'N;');

-- --------------------------------------------------------

--
-- Структура таблицы `yonote_auth_item`
--

CREATE TABLE IF NOT EXISTS `yonote_auth_item` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yonote_auth_item`
--

INSERT INTO `yonote_auth_item` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('adminAccess', 0, 'Administrative access', NULL, 'N;'),
('administrator', 2, 'Administrator', NULL, 'N;'),
('authenticated', 2, 'Authenticated', 'return !Yii::app()->user->getIsGuest();', 'N;'),
('first', 0, 'My first operation', NULL, 'N;'),
('guest', 2, 'Guest', 'return Yii::app()->user->getIsGuest();', 'N;'),
('second', 0, 'The second operation', NULL, 'N;'),
('subtaskone', 1, 'first subtask', 'true', 'N;'),
('subtasktwo', 1, 'second subtask', '!true', 'N;');

-- --------------------------------------------------------

--
-- Структура таблицы `yonote_auth_item_child`
--

CREATE TABLE IF NOT EXISTS `yonote_auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yonote_auth_item_child`
--

INSERT INTO `yonote_auth_item_child` (`parent`, `child`) VALUES
('administrator', 'adminAccess'),
('authenticated', 'administrator'),
('subtaskone', 'first'),
('subtasktwo', 'first');

-- --------------------------------------------------------

--
-- Структура таблицы `yonote_extension`
--

CREATE TABLE IF NOT EXISTS `yonote_extension` (
  `name` varchar(64) NOT NULL,
  `description` text,
  `author` varchar(64) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `website` varchar(128) DEFAULT NULL,
  `copyright` varchar(128) DEFAULT NULL,
  `licence` text,
  `data` text,
  `title` varchar(128) DEFAULT NULL,
  `updatetime` int(11) DEFAULT '0',
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yonote_extension`
--

INSERT INTO `yonote_extension` (`name`, `description`, `author`, `email`, `website`, `copyright`, `licence`, `data`, `title`, `updatetime`) VALUES
('Extension name', 'My first extension', 'Extension author', 'Author email', 'http://mycoolextension.com', NULL, NULL, 'a:5:{s:5:"files";a:1:{i:0;s:67:"D:\\INSTALLED\\OpenServer\\domains\\engine\\engine/testfolder/2/info.txt";}s:7:"folders";a:3:{i:0;s:56:"D:\\INSTALLED\\OpenServer\\domains\\engine\\engine/testfolder";i:1;s:58:"D:\\INSTALLED\\OpenServer\\domains\\engine\\engine/testfolder/2";i:2;s:55:"D:\\INSTALLED\\OpenServer\\domains\\engine\\admin/testfolder";}s:10:"operations";a:4:{i:0;s:5:"first";i:1;s:10:"subtaskone";i:2;s:10:"subtasktwo";i:3;s:6:"second";}s:7:"appends";a:1:{i:0;a:2:{i:0;s:66:"D:\\INSTALLED\\OpenServer\\domains\\engine\\engine/languages/ru/wow.php";i:1;s:40:"\n    ''wow'' => ''wow'',\n    ''wow'' => ''wow''\n";}}s:6:"tables";a:1:{i:0;s:11:"{{mytable}}";}}', NULL, 1397478627);

-- --------------------------------------------------------

--
-- Структура таблицы `yonote_module`
--

CREATE TABLE IF NOT EXISTS `yonote_module` (
  `name` varchar(64) NOT NULL,
  `extension` varchar(64) NOT NULL,
  `priority` int(11) DEFAULT '0',
  `installed` tinyint(1) DEFAULT '0',
  `title` varchar(128) DEFAULT NULL,
  `updatetime` int(11) DEFAULT '0',
  PRIMARY KEY (`name`,`extension`),
  KEY `extension` (`extension`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yonote_module`
--

INSERT INTO `yonote_module` (`name`, `extension`, `priority`, `installed`, `title`, `updatetime`) VALUES
('test', 'Extension name', 10, 0, 'Hello world!', 1397664959);

-- --------------------------------------------------------

--
-- Структура таблицы `yonote_profile`
--

CREATE TABLE IF NOT EXISTS `yonote_profile` (
  `userid` varchar(64) NOT NULL,
  `name` varchar(128) DEFAULT NULL,
  `photo` varchar(128) DEFAULT NULL,
  `language` varchar(32) DEFAULT NULL,
  `country` varchar(128) DEFAULT NULL,
  `city` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yonote_profile`
--

INSERT INTO `yonote_profile` (`userid`, `name`, `photo`, `language`, `country`, `city`) VALUES
('newuser', '', NULL, 'kok', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `yonote_setting`
--

CREATE TABLE IF NOT EXISTS `yonote_setting` (
  `category` varchar(100) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL DEFAULT '',
  `value` text,
  `updateTime` int(11) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`category`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yonote_setting`
--

INSERT INTO `yonote_setting` (`category`, `name`, `value`, `updateTime`, `description`) VALUES
('admin', 'language', 'ru', 1125699850, 'Default administrative language'),
('admin', 'template', 'default', 6598, 'Default administrative template'),
('admin', 'timeZone', 'Europe/Kaliningrad', 1397170868, 'Admin default timezone'),
('extensions', 'maxSize', '5242880', 1125699855, 'Maximum extension file size'),
('system', 'loginDuration', '604800', 1125699851, 'Login session duration (seconds)'),
('system', 'urlFormat', 'path', 1125699849, 'Default URL format'),
('user', 'name.length.max', '20', 454864545, 'Username max len'),
('user', 'name.length.min', '2', 158954465, 'Username min length'),
('user', 'password.length.max', '50', 5458456, 'User password max length'),
('user', 'password.length.min', '6', 4548665, 'User password min length'),
('user', 'profile.fields.length.max', '50', 158455, 'User profile fields max length'),
('user', 'profile.fields.length.min', '2', 56456215, 'User profile fields min length'),
('user', 'profile.photo.height.max', '1000', 5442169, 'User photo max height'),
('user', 'profile.photo.height.min', '300', 483647, 'User photo min height'),
('user', 'profile.photo.quality', '80', 565865, 'User photo quality'),
('user', 'profile.photo.resize.enabled', '1', 5698565, 'Resize user photos'),
('user', 'profile.photo.resize.height', '300', 5454854, 'User profile resize height'),
('user', 'profile.photo.resize.width', '300', 656985, 'User photo resize width'),
('user', 'profile.photo.size.max', '819200', 65652154, 'User photo max size'),
('user', 'profile.photo.width.max', '1000', 545452, 'User photo max width'),
('user', 'profile.photo.width.min', '300', 542154, 'User photo min width'),
('website', 'language', 'ru', 5699854, 'Default website language'),
('website', 'template', 'default', 12345, 'Default website template'),
('website', 'timeZone', 'Europe/Kaliningrad', 1397170867, 'Website default time zone');

-- --------------------------------------------------------

--
-- Структура таблицы `yonote_template`
--

CREATE TABLE IF NOT EXISTS `yonote_template` (
  `name` varchar(64) NOT NULL,
  `extension` varchar(64) NOT NULL,
  `updateTime` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`,`extension`),
  KEY `extension` (`extension`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yonote_template`
--

INSERT INTO `yonote_template` (`name`, `extension`, `updateTime`) VALUES
('Alertoox', 'Extension name', 1397478627),
('Wowx', 'Extension name', 1397478627);

-- --------------------------------------------------------

--
-- Структура таблицы `yonote_user`
--

CREATE TABLE IF NOT EXISTS `yonote_user` (
  `name` varchar(64) NOT NULL,
  `password` text NOT NULL,
  `token` text,
  `email` varchar(64) NOT NULL DEFAULT '',
  `activated` tinyint(1) DEFAULT '0',
  `verified` tinyint(1) DEFAULT '0',
  `subscribed` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yonote_user`
--

INSERT INTO `yonote_user` (`name`, `password`, `token`, `email`, `activated`, `verified`, `subscribed`) VALUES
('admin', '$2a$13$dKmIZvU4j0ZBuJ/NNTITJ.fZc1i4Qlyng90zbccfemEDJ1iOujSRO', '$2a$13$sU/0TMouNg6hhxbmW22FHk', 'email@email.com', 0, 0, 0),
('alone', '$2a$13$/CPcryuCXUw8AHiryj0YR.UNdRQ0X5j9DuL8/vK/BIU66YaV6S22S', NULL, 'fsd@dgh.df', 1, 1, 1),
('newuser', '$2a$13$Xj25wAX9RwRO7JUK/rCsze7aLAfmXUuE5qKu/Vz21ryp3Y9HBcvme', NULL, 'fsd@dgh.df', 1, 1, 0),
('nikita', '$2a$13$J4Gk.kkH9YAGwp8RNkaD5.DKtTF.Bz7M0jJG2ha70GreKCwmlUSnG', NULL, 'email@mail.com', 0, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `yonote_widget`
--

CREATE TABLE IF NOT EXISTS `yonote_widget` (
  `name` varchar(64) NOT NULL,
  `extension` varchar(64) NOT NULL,
  `classPath` varchar(128) NOT NULL,
  `type` int(11) DEFAULT NULL,
  `title` varchar(128) DEFAULT NULL,
  `description` text,
  `usePids` text,
  `usePidsFlag` tinyint(1) DEFAULT '0',
  `unusePids` text,
  `unusePidsFlag` tinyint(1) DEFAULT '0',
  `params` text,
  `updateTime` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT '0',
  PRIMARY KEY (`name`,`extension`,`classPath`),
  KEY `extension` (`extension`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yonote_widget`
--

INSERT INTO `yonote_widget` (`name`, `extension`, `classPath`, `type`, `title`, `description`, `usePids`, `usePidsFlag`, `unusePids`, `unusePidsFlag`, `params`, `updateTime`, `position`) VALUES
('name', 'Extension name', 'class', 0, 'title', 'description', NULL, 0, NULL, 0, NULL, 1397478627, 0);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `yonote_auth_assignment`
--
ALTER TABLE `yonote_auth_assignment`
  ADD CONSTRAINT `yonote_auth_assignment_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `yonote_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `yonote_auth_assignment_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `yonote_user` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `yonote_auth_item_child`
--
ALTER TABLE `yonote_auth_item_child`
  ADD CONSTRAINT `yonote_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `yonote_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `yonote_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `yonote_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `yonote_module`
--
ALTER TABLE `yonote_module`
  ADD CONSTRAINT `yonote_module_ibfk_1` FOREIGN KEY (`extension`) REFERENCES `yonote_extension` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `yonote_profile`
--
ALTER TABLE `yonote_profile`
  ADD CONSTRAINT `yonote_profile_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `yonote_user` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `yonote_template`
--
ALTER TABLE `yonote_template`
  ADD CONSTRAINT `yonote_template_ibfk_1` FOREIGN KEY (`extension`) REFERENCES `yonote_extension` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `yonote_widget`
--
ALTER TABLE `yonote_widget`
  ADD CONSTRAINT `yonote_widget_ibfk_1` FOREIGN KEY (`extension`) REFERENCES `yonote_extension` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
