-- phpMyAdmin SQL Dump
-- version 4.0.10
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 13 2014 г., 20:59
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
  PRIMARY KEY (`itemname`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yonote_auth_assignment`
--

INSERT INTO `yonote_auth_assignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('administrator', 'admin', NULL, 'N;');

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
('guest', 2, 'Guest', 'return Yii::app()->user->getIsGuest();', 'N;');

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
('authenticated', 'administrator');

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
  `updateTime` int(11) DEFAULT '0',
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `updateTime` int(11) DEFAULT '0',
  PRIMARY KEY (`name`,`extension`),
  KEY `extension` (`extension`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

-- --------------------------------------------------------

--
-- Структура таблицы `yonote_user`
--

CREATE TABLE IF NOT EXISTS `yonote_user` (
  `username` varchar(64) NOT NULL,
  `password` text NOT NULL,
  `token` text,
  `email` varchar(64) NOT NULL DEFAULT '',
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yonote_user`
--

INSERT INTO `yonote_user` (`username`, `password`, `token`, `email`) VALUES
('admin', '$2a$13$PSXMTh49ffFDYT7AWNsdJOiEburFJhwF8yGvuSQG5c9xnZT75H.Re', '$2a$13$6f11r9UsCyMRZujveFeINu', 'email@email.com');

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
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `yonote_auth_assignment`
--
ALTER TABLE `yonote_auth_assignment`
  ADD CONSTRAINT `yonote_auth_assignment_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `yonote_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

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
