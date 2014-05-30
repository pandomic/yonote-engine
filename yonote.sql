-- phpMyAdmin SQL Dump
-- version 4.0.10
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 30 2014 г., 16:52
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
('admin.index', 0, 'Administrative panel access', NULL, 'N;'),
('admin.modules.add', 0, 'Allow modules uploading', NULL, 'N;'),
('admin.modules.down', 0, 'Allow move modules down', NULL, 'N;'),
('admin.modules.index', 0, 'Access modules index', NULL, 'N;'),
('admin.modules.info', 0, 'Allow view modules info', NULL, 'N;'),
('admin.modules.remove', 0, 'Allow modules removing', NULL, 'N;'),
('admin.modules.status', 0, 'Toggle module status', NULL, 'N;'),
('admin.modules.up', 0, 'Allow move modules up', NULL, 'N;'),
('admin.pages.add', 0, 'Allow add pages', NULL, 'N;'),
('admin.pages.edit', 0, 'Allow edit pages', NULL, 'N;'),
('admin.pages.index', 0, 'Access to the Pages module index', NULL, 'N;'),
('admin.pages.remove', 0, 'Allow remove pages', NULL, 'N;'),
('admin.pages.settings', 0, 'Allow access to the settings of the pages module', NULL, 'N;'),
('admin.pm.index', 0, 'PM manager access', NULL, 'N;'),
('admin.pm.new', 0, 'Allow send new pm messages', NULL, 'N;'),
('admin.pm.outbox', 0, 'PM outbox access', NULL, 'N;'),
('admin.pm.read', 0, 'Allow pm read', NULL, 'N;'),
('admin.pm.remove', 0, 'Allow pm remove', NULL, 'N;'),
('admin.pm.settings', 0, 'PM settings access', NULL, 'N;'),
('admin.posts.add', 0, 'Allow add new posts', NULL, NULL),
('admin.posts.edit', 0, 'Allow edit posts', NULL, 'N;'),
('admin.posts.hashtags.index', 0, 'Allow access to hashtags manager of posts module', NULL, 'N;'),
('admin.posts.hashtags.remove', 0, 'Allow remove hashtags of posts module', NULL, 'N;'),
('admin.posts.index', 0, 'Allow access to the Posts module', NULL, 'N;'),
('admin.posts.remove', 0, 'Allow remove posts', NULL, 'N;'),
('admin.posts.settings', 0, 'Allow access to the Posts module settings', NULL, 'N;'),
('admin.roles.add', 0, 'Allow add auth items', NULL, 'N;'),
('admin.roles.edit', 0, 'Allow edit auth items', NULL, 'N;'),
('admin.roles.index', 0, 'Roles manager access', NULL, 'N;'),
('admin.roles.remove', 0, 'Allow remove auth items', NULL, 'N;'),
('admin.settings.index', 0, 'Allow access to system settings management', NULL, 'N;'),
('admin.users.add', 0, 'Allow to add new users', NULL, 'N;'),
('admin.users.edit', 0, 'Allow edit user info', NULL, 'N;'),
('admin.users.index', 0, 'Allow users manager access', NULL, 'N;'),
('admin.users.profile', 0, 'Allow edit user profile', NULL, 'N;'),
('admin.users.remove', 0, 'Allow remove users', NULL, 'N;'),
('admin.users.settings', 0, 'Users settings access', NULL, 'N;'),
('administrator', 2, 'Administrator', '', 'N;'),
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
('administrator', 'admin.index'),
('administrator', 'admin.modules.add'),
('administrator', 'admin.modules.down'),
('administrator', 'admin.modules.index'),
('administrator', 'admin.modules.info'),
('administrator', 'admin.modules.remove'),
('administrator', 'admin.modules.status'),
('administrator', 'admin.modules.up'),
('administrator', 'admin.pages.add'),
('administrator', 'admin.pages.edit'),
('administrator', 'admin.pages.index'),
('administrator', 'admin.pages.remove'),
('administrator', 'admin.pages.settings'),
('administrator', 'admin.pm.index'),
('administrator', 'admin.pm.new'),
('administrator', 'admin.pm.outbox'),
('administrator', 'admin.pm.read'),
('administrator', 'admin.pm.remove'),
('administrator', 'admin.pm.settings'),
('administrator', 'admin.posts.add'),
('administrator', 'admin.posts.edit'),
('administrator', 'admin.posts.hashtags.index'),
('administrator', 'admin.posts.hashtags.remove'),
('administrator', 'admin.posts.index'),
('administrator', 'admin.posts.remove'),
('administrator', 'admin.posts.settings'),
('administrator', 'admin.roles.add'),
('administrator', 'admin.roles.edit'),
('administrator', 'admin.roles.index'),
('administrator', 'admin.roles.remove'),
('administrator', 'admin.settings.index'),
('administrator', 'admin.users.add'),
('administrator', 'admin.users.edit'),
('administrator', 'admin.users.index'),
('administrator', 'admin.users.profile'),
('administrator', 'admin.users.remove'),
('administrator', 'admin.users.settings');

-- --------------------------------------------------------

--
-- Структура таблицы `yonote_module`
--

CREATE TABLE IF NOT EXISTS `yonote_module` (
  `name` varchar(64) NOT NULL,
  `title` varchar(128) DEFAULT NULL,
  `description` text,
  `author` varchar(64) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `website` varchar(128) DEFAULT NULL,
  `copyright` varchar(128) DEFAULT NULL,
  `license` text,
  `installed` tinyint(1) DEFAULT '0',
  `updatetime` int(11) DEFAULT '0',
  `position` int(11) NOT NULL,
  `version` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yonote_module`
--

INSERT INTO `yonote_module` (`name`, `title`, `description`, `author`, `email`, `website`, `copyright`, `license`, `installed`, `updatetime`, `position`, `version`) VALUES
('feedback', 'Feedback module', 'Feedback module', 'Vlad Gramuzov', 'vlad.gramuzov@gmail.com', 'http://yonote.org', '(c) 2014 Vlad Gramuzov', 'Creative Commons Attribution 4.0 International (CC BY 4.0)', 1, 1398560710, 4, '1.0'),
('loadmeter', 'System load meter module', 'This module provides the base LoadMeterWidget class to access the system load information and represent it via widget. Widget class can be accessed through the "admin.modules.loadmeter.components.widgets.LoadMeterWidget" alais. No configuration needed. Template file should be placed in "views/loadmeter" widget file. In the view you can access "$average" - average system loading (not working on Windows platform), "$memory" - memory used, "$disk" - disk space used.', 'Vlad Gramuzov', 'vlad.gramuzov@gmail.com', 'http://yonote.org', '(c) 2014 Vlad Gramuzov', 'Creative Commons Attribution 4.0 International (CC BY 4.0)', 1, 1398783955, 3, '1.0'),
('pages', 'Pages module', 'This module allows to organize static-style pages, that then can be accessed in "pages/page.html" format.', 'Vlad Gramuzov', 'vlad.gramuzov@gmail.com', 'http://yonote.org', '(c) 2014 Vlad Gramuzov', 'Creative Commons Attribution 4.0 International (CC BY 4.0)', 1, 1398560709, 2, '1.0'),
('posts', 'Posts module', 'This module allows to create and distribute Posts on the specified hashtags.', 'Vlad Gramuzov', 'vlad.gramuzov@gmail.com', 'http://yonote.org', '(c) 2014 Vlad Gramuzov', 'Creative Commons Attribution 4.0 International (CC BY 4.0)', 1, 1398510982, 1, '1.0');

-- --------------------------------------------------------

--
-- Структура таблицы `yonote_mod_feedback`
--

CREATE TABLE IF NOT EXISTS `yonote_mod_feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `phone` varchar(64) DEFAULT NULL,
  `message` text,
  `updatetime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `yonote_mod_feedback`
--

INSERT INTO `yonote_mod_feedback` (`id`, `name`, `email`, `phone`, `message`, `updatetime`) VALUES
(1, 'Николай Петрович', 'email@email.com', '+375291234567', 'Проверка сообщения еще того', 1401172321),
(2, 'Николай Петрович', 'email@email.com', '+375291234567', 'Проверка сообщения еще того', 1401172373),
(3, 'Николай Петрович', 'email@email.com', '+375291234567', 'sdfsdf asdasd asda asd as das dasd as das as asd as das d', 1401172819),
(4, 'Николай Петрович', 'email@email.com', '+375291234567', 'sdfsdf asdasdas asdas as dasd ', 1401172876);

-- --------------------------------------------------------

--
-- Структура таблицы `yonote_mod_page`
--

CREATE TABLE IF NOT EXISTS `yonote_mod_page` (
  `alias` varchar(64) NOT NULL,
  `title` varchar(128) NOT NULL,
  `content` text,
  `language` text,
  `updatetime` int(11) DEFAULT NULL,
  `thumbnail` text,
  PRIMARY KEY (`alias`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yonote_mod_page`
--

INSERT INTO `yonote_mod_page` (`alias`, `title`, `content`, `language`, `updatetime`, `thumbnail`) VALUES
('about-us', 'О нас', '<p>Название нашего агентства было выбрано не случайно: Святой Николай – это самый знаменитый и наиболее почитаемый святой во всем мире, скромный, но с чувством юмора   покровитель путешественников и его почитают православные, католики и протестанты. Часть прибыли, полученной от реализации туров, мы тратим на благотворительные цели.</p>\r\n<p>Туристическое агентство «Св. Николай»  работает на белорусском туристическом рынке с 1997 года. За эти годы основными принципами нашей работы были и остаются профессионализм и индивидуальный подход к каждому клиенту.  Опытность и профессионализм наших менеджеров позволяют отслеживать лучшие предложения на рынке туризма и отдыха. Мы всегда будем рады помочь Вам сориентироваться среди множества предлагаемых туров и найти тот, что наиболее соответствует Вашим запросам.</p>\r\n<p>Мы сотрудничаем с ведущими туроператорами России и Беларуси и Украины,  поэтому в любое время года можем предложить Вам отдых в экзотических странах: Египет, Турция, Индия, ОАЭ, Таиланд и т.д. Благодаря сотрудничеству с надежными туристическими компаниями, мы всегда можем гарантировать высокое качество оказываемых услуг.</p>\r\n<p>Мы тщательно подбираем партнеров, деловые отношения со многими из них проверены годами. Профессионализм и высокое качество обслуживания наших партнеров являются залогом нашего спокойствия за клиента. Покупая у нас - Вы выбираете лучшее. Работая только с надежными партнерами, мы всегда уверены в качестве предлагаемых услуг.Выберет ли клиент скромную «трешку» или же эксклюзивный отель класса «luxe», специалисты туристического агентства с удовольствием подробно расскажут о предстоящем путешествии и ответят на все интересующие вопросы.</p>\r\n<p>Один из бессменных принципов работы нашего турагентства на протяжении многих лет  является не количество туристов, а качество их обслуживания и индивидуальный подход к каждому.</p>\r\n<p>Туристическое агентство «Св.Николай» – это соотношение качества, надежности и профессионализма. Обращайтесь к нам, мы всегда рады видеть как старых, так и новых друзей, и мы вместе с Вами подберем тур и место отдыха для проведения отпуска, каникул или праздничных дней. Вы можете заказать стандартный пакет услуг, либо сформировать свою программу отдыха индивидуально и можете быть уверенны, это будет Ваш незабываемый отдых.</p>', 'ru', 1401451128, 'images/53887278b02dd.jpg'),
('cost', 'Стоимость размещения', '<p>Уважаемые клиенты, напоминаем Вам, что размещенные на данной странице сведения представлены лишь для ознакомления. Для уточнения стоимости размещения объявлений в газете "Рекламный проспект" обращайтесь в редакцию.</p>\r\n<h2>Тарифы на размещение рекламы (бел.руб./см<sup>2</sup>):</h2>\r\n<ul><li>1-я страница (цв.): 15 000;</li>\r\n<li>2-3 страницы (ч/б): 4 000;</li>\r\n<li>4-5 страницы (цв.): 7 000;</li>\r\n<li>6-7 страницы (ч.б. для частных объявлений): 6 000;</li>\r\n<li>8-я страница (цв.): 10 000.</li>\r\n</ul><p>Реклама размещается в газете на условии полной предоплаты.</p>', 'ru', 1401035285, 'images/5380dd36c2406.jpg'),
('for-advertisers', 'Рекламодателям', '<p>Уважаемые клиенты! Для размещения рекламного модуля в газете "Рекламный проспект" Вам необходимо обратиться в наш офис для заключения договора по адресу:</p>\r\n<p><strong>г. Орша, ул. Мира, д.11 корпус "А" офис №9 (старое здание гостиницы "Орша").</strong></p>\r\n<p>Реламные модули в газете печатаются на основе определенных макетов. Такие макеты могут быть предоставлены рекламодателем или изготовлены нами. Требования к макетам и графическим файлам представлены ниже.</p>\r\n<h2>Требования к макетам:</h2>\r\n<ul><li>формат: Corel Draw .CDR (версии 14.0 или ниже);</li>\r\n<li>цветовая схема: CMYK (также для вложенных растровых изображений);</li>\r\n<li>формат текста: кривые;</li>\r\n<li>одноцветная цветовая схема для мелких шрифтов.</li>\r\n</ul><h2>Требования к графическим файлам:</h2>\r\n<ul><li>формат: .TIFF;</li>\r\n<li>цветовая схема: CMYK;</li>\r\n<li>разрешение: 300dpi;</li>\r\n<li>глубина цвета: 8бит/канал.</li>\r\n</ul>', 'ru', 1400953675, 'images/5380db4ba780f.png'),
('the-latest-issue', 'Последний выпуск', '<p>На данной странице расположены основные выпуски газеты "Рекламный проспект". Вы можете скачать себе любой такой выпуск, перейдя по одной из представленных ниже ссылок.</p>\r\n<h2>Последний выпуск</h2>\r\n<p><a title="Выпуск #58 от 12.02.2014" href="#">Выпуск #58 от 12.02.2014</a></p>\r\n<h2>Март 2014</h2>\r\n<p><a title="Выпуск #57 от 12.02.2014" href="#">Выпуск #57 от 12.02.2014</a></p>\r\n<p><a title="Выпуск #56 от 12.02.2014" href="#">Выпуск #56 от 12.02.2014</a></p>\r\n<p><a title="Выпуск #55 от 12.02.2014" href="#">Выпуск #55 от 12.02.2014</a></p>\r\n<p><a title="Выпуск #54 от 12.02.2014" href="#">Выпуск #54 от 12.02.2014</a></p>\r\n<h2>Февраль 2014</h2>\r\n<p>Выпуск #57 от 12.02.2014</p>\r\n<p>Выпуск #56 от 12.02.2014</p>\r\n<p>Выпуск #55 от 12.02.2014</p>\r\n<p>Выпуск #54 от 12.02.2014</p>', 'ru', 1401036846, NULL),
('tours', 'Туры', '<p>Выберите необходимый тур и перейдите по соответствующей ссылке для просмотра дополнительной информации.</p>\r\n<h4>Туры по черному морю:</h4>\r\n<ul><li><a href="../../../../../page/tours-anapa.html">Анапа</a></li>\r\n<li><a href="#">Архипо-осиповка У Светланы</a></li>\r\n<li>Лермонтово</li>\r\n<li>Небуг</li>\r\n<li>Новомихайловский</li>\r\n</ul><h4>Туры по Беларуси:</h4>\r\n<ul><li><a href="#">Беловежская пуща</a></li>\r\n<li><a href="#">Гродно - Коробчицы</a></li>\r\n<li><a href="#">Зюзя Поозерский</a></li>\r\n<li><a href="#">Минск</a></li>\r\n<li><a href="#">Могилевский театр кукол</a></li>\r\n</ul>', 'ru', 1401451587, 'images/53887443815d0.jpg'),
('tours-anapa', 'Туры в Анапу', '<p>Узнайте больше о туристической программе, стоимости и условиях проживания, выбрав интересующее Вас расположение из приведенного ниже списка:</p>\r\n<ul><li><a href="../../../../../page/tours-anapa-anna.html">Анна</a></li>\r\n<li>ЕВА Анапа</li>\r\n<li>Золотой Овен</li>\r\n<li>На Астраханской</li>\r\n<li>Солнечный остров</li>\r\n<li>СПС Анапа</li>\r\n</ul>', 'ru', 1401443064, 'images/5388521cc8ea2.jpg'),
('tours-anapa-anna', 'Гостевой дом Анна', '<p><strong>Местоположение:</strong> Гостевой дом «Анна» расположен в центре города Анапа, в первой курортной зоне. Гостевой дом имеет изолированную, небольшую благоустроенную дворовую территорию. До центрального песчаного пляжа спокойным шагом 10-12 минут, до мелко-галечного пляжа 15-20 минут. В непосредственной близости расположены: городской парк, центр развлечений для больших и маленьких, аквапарк «Золотой пляж», культурные и торговые центры, летний эстрадный театр, кинотеатры, рестораны, бары, многочисленные кафе, дискотеки, центральный продуктовый и вещевой рынки. В одной минуте ходьбы находится остановка, от которой маршрутные автобусы напрямую доставят Вас до развлекательного комплекса "Красная площадь" с сетью магазинов, кафе, кинотеатром, а также до Большого Утриша – уникального реликтового можжевелово-фисташкового леса.</p>\r\n<p><strong>Размещение:</strong> двухэтажное здание. Все номера расположены на 2-м этаже. Каждый номер гостевого дома оснащен необходимым набором корпусной и мягкой мебели, туалетной комнатой с санузлом и душем, (холодная и горячая вода круглосуточно), ЖК-телевизором, холодильником, кондиционером, набором постельных принадлежностей. Имеется уютная летняя терасса со столиками для отдыха, много зелени и цветов. </p>\r\n<p><strong>Питание:</strong> В гостевом доме имеется кухня для самостоятельного приготовления пищи: газовая плита, микроволновая печь, электрический чайник.</p>\r\n<p><strong>Пляжи</strong> Анапы идеально подходят для любого вида отдыха. Береговая зона имеет большую протяженность, поэтому создает комфортные просторные условия для каждого отдыхающего. Различные виды пляжей, песчаные, галечные, каменистые удовлетворят вкусы самых требовательных курортников. Глубина моря на территории для купания значительно мала, поэтому здесь так популярен детский отдых. Ребенок может свободно плескаться в воде, пока мамы, папы, парни и девушки на пляже увлечены разнообразными занятиями.</p>\r\n<p><strong><em>Дополнительно оплачивается в кассу российского туроператора проживание и проезд по территории России (USD):</em></strong></p>\r\n<table class="table table-bordered table-striped table-hover table-condensed table-responsive"><thead><tr><th rowspan="2">Дата заезда</th><th rowspan="2">Кол. ночей</th><th colspan="2">3-х, 4- х местный номер</th><th colspan="2">2-х местный номер</th></tr><tr><th>Взрослый</th><th>Ребенок до 12 лет на ОМ</th><th>Взрослый</th><th>Ребенок до 12 лет на ОМ</th></tr></thead><tbody><tr><td>31.05 – 12.06</td>\r\n<td>10</td>\r\n<td>195</td>\r\n<td>195</td>\r\n<td>210</td>\r\n<td>210</td>\r\n</tr><tr><td>10.06 – 22.06</td>\r\n<td>10</td>\r\n<td>215</td>\r\n<td>215</td>\r\n<td>245</td>\r\n<td>245</td>\r\n</tr><tr><td>20.06 – 02.07</td>\r\n<td>10</td>\r\n<td>245</td>\r\n<td>235</td>\r\n<td>275</td>\r\n<td>265</td>\r\n</tr><tr><td>30.06 – 12.07</td>\r\n<td>10</td>\r\n<td>290</td>\r\n<td>280</td>\r\n<td>320</td>\r\n<td>310</td>\r\n</tr><tr><td>10.07 – 22.07</td>\r\n<td>10</td>\r\n<td>310</td>\r\n<td>300</td>\r\n<td>335</td>\r\n<td>325</td>\r\n</tr><tr><td>20.07 – 01.08</td>\r\n<td>10</td>\r\n<td>310</td>\r\n<td>300</td>\r\n<td>335</td>\r\n<td>325</td>\r\n</tr><tr><td>30.07 – 11.08</td>\r\n<td>10</td>\r\n<td>310</td>\r\n<td>300</td>\r\n<td>335</td>\r\n<td>325</td>\r\n</tr><tr><td>09.08 – 21.08</td>\r\n<td>10</td>\r\n<td>310</td>\r\n<td>300</td>\r\n<td>335</td>\r\n<td>325</td>\r\n</tr><tr><td>19.08 – 31.08</td>\r\n<td>10</td>\r\n<td>280</td>\r\n<td>270</td>\r\n<td>310</td>\r\n<td>300</td>\r\n</tr><tr><td>29.08 – 10.09</td>\r\n<td>10</td>\r\n<td>245</td>\r\n<td>245</td>\r\n<td>275</td>\r\n<td>275</td>\r\n</tr><tr><td>08.09 – 20.09</td>\r\n<td>10</td>\r\n<td>230</td>\r\n<td>230</td>\r\n<td>245</td>\r\n<td>245</td>\r\n</tr></tbody></table><p><strong>Внимание!</strong> Отправление автобуса из Новополоцка, Полоцка будет производиться на 1 день раньше, чем указано в таблице.</p>\r\n<h4>Стоимость туристической услуги: 300 000 белорусских рублей.</h4>\r\n<p>В стоимость входит:</p>\r\n<ul><li>проезд автобусом туркласса (чай, кофе, видео);</li>\r\n<li>сопровождение группы по территории РБ и России;</li>\r\n<li>информационно-консультативная услуга по подбору тура.</li>\r\n</ul><p>Дополнительно оплачивается:</p>\r\n<ul><li>курортный сбор (2,5 у.е. на человека);</li>\r\n<li>медицинская страховка (по желанию).</li>\r\n</ul>', 'ru', 1401454231, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `yonote_mod_post`
--

CREATE TABLE IF NOT EXISTS `yonote_mod_post` (
  `alias` varchar(64) NOT NULL,
  `title` varchar(128) NOT NULL,
  `short` text,
  `full` text,
  `thumbnail` text,
  `language` varchar(32) DEFAULT NULL,
  `updatetime` int(11) DEFAULT NULL,
  PRIMARY KEY (`alias`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yonote_mod_post`
--

INSERT INTO `yonote_mod_post` (`alias`, `title`, `short`, `full`, `thumbnail`, `language`, `updatetime`) VALUES
('hello-world', 'Необычная новость', '<p><span style="font-family:Arial, Helvetica, sans;line-height:14px;text-align:justify;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vel lacinia leo. In ultricies lacus nisi, sed egestas urna ornare sit amet. Aenean interdum nunc vitae velit congue, sit amet elementum diam sagittis. Vestibulum vestibulum, tellus a vestibulum vestibulum, eros nisl dignissim sapien, ac placerat augue lectus ut augue. Sed commodo ligula ornare risus feugiat venenatis. Mauris at nibh tortor. Praesent aliquet, libero eu tincidunt adipiscing, orci massa consectetur justo, sed ultrices nunc nulla a lacus. Donec nec quam varius, varius nisl vehicula, semper odio.</span></p>', '<p><span style="font-family:Arial, Helvetica, sans;line-height:14px;text-align:justify;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vel lacinia leo. In ultricies lacus nisi, sed egestas urna ornare sit amet. Aenean interdum nunc vitae velit congue, sit amet elementum diam sagittis. Vestibulum vestibulum, tellus a vestibulum vestibulum, eros nisl dignissim sapien, ac placerat augue lectus ut augue. Sed commodo ligula ornare risus feugiat venenatis. Mauris at nibh tortor. Praesent aliquet, libero eu tincidunt adipiscing, orci massa consectetur justo, sed ultrices nunc nulla a lacus. Donec nec quam varius, varius nisl vehicula, semper odio.</span></p>\r\n<p><span style="font-family:Arial, Helvetica, sans;line-height:14px;text-align:justify;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vel lacinia leo. In ultricies lacus nisi, sed egestas urna ornare sit amet. Aenean interdum nunc vitae velit congue, sit amet elementum diam sagittis. Vestibulum vestibulum, tellus a vestibulum vestibulum, eros nisl dignissim sapien, ac placerat augue lectus ut augue. Sed commodo ligula ornare risus feugiat venenatis. Mauris at nibh tortor. Praesent aliquet, libero eu tincidunt adipiscing, orci massa consectetur justo, sed ultrices nunc nulla a lacus. Donec nec quam varius, varius nisl vehicula, semper odio.</span></p>\r\n<p><span style="font-family:Arial, Helvetica, sans;line-height:14px;text-align:justify;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vel lacinia leo. In ultricies lacus nisi, sed egestas urna ornare sit amet. Aenean interdum nunc vitae velit congue, sit amet elementum diam sagittis. Vestibulum vestibulum, tellus a vestibulum vestibulum, eros nisl dignissim sapien, ac placerat augue lectus ut augue. Sed commodo ligula ornare risus feugiat venenatis. Mauris at nibh tortor. Praesent aliquet, libero eu tincidunt adipiscing, orci massa consectetur justo, sed ultrices nunc nulla a lacus. Donec nec quam varius, varius nisl vehicula, semper odio.</span></p>', NULL, 'ru', 1401035024),
('my-first-post', 'Привет мир!', '<p><span style="font-family:Arial, Helvetica, sans;line-height:14px;text-align:justify;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vel lacinia leo. In ultricies lacus nisi, sed egestas urna ornare sit amet. Aenean interdum nunc vitae velit congue, sit amet elementum diam sagittis. Vestibulum vestibulum, tellus a vestibulum vestibulum, eros nisl dignissim sapien, ac placerat augue lectus ut augue. Sed commodo ligula ornare risus feugiat venenatis. Mauris at nibh tortor. Praesent aliquet, libero eu tincidunt adipiscing, orci massa consectetur justo, sed ultrices nunc nulla a lacus. Donec nec quam varius, varius nisl vehicula, semper odio.</span></p>', '<p><span style="font-family:Arial, Helvetica, sans;line-height:14px;text-align:justify;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vel lacinia leo. In ultricies lacus nisi, sed egestas urna ornare sit amet. Aenean interdum nunc vitae velit congue, sit amet elementum diam sagittis. Vestibulum vestibulum, tellus a vestibulum vestibulum, eros nisl dignissim sapien, ac placerat augue lectus ut augue. Sed commodo ligula ornare risus feugiat venenatis. Mauris at nibh tortor. Praesent aliquet, libero eu tincidunt adipiscing, orci massa consectetur justo, sed ultrices nunc nulla a lacus. Donec nec quam varius, varius nisl vehicula, semper odio.</span></p>\r\n<p><span style="font-family:Arial, Helvetica, sans;line-height:14px;text-align:justify;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vel lacinia leo. In ultricies lacus nisi, sed egestas urna ornare sit amet. Aenean interdum nunc vitae velit congue, sit amet elementum diam sagittis. Vestibulum vestibulum, tellus a vestibulum vestibulum, eros nisl dignissim sapien, ac placerat augue lectus ut augue. Sed commodo ligula ornare risus feugiat venenatis. Mauris at nibh tortor. Praesent aliquet, libero eu tincidunt adipiscing, orci massa consectetur justo, sed ultrices nunc nulla a lacus. Donec nec quam varius, varius nisl vehicula, semper odio.</span></p>\r\n<p><span style="font-family:Arial, Helvetica, sans;line-height:14px;text-align:justify;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vel lacinia leo. In ultricies lacus nisi, sed egestas urna ornare sit amet. Aenean interdum nunc vitae velit congue, sit amet elementum diam sagittis. Vestibulum vestibulum, tellus a vestibulum vestibulum, eros nisl dignissim sapien, ac placerat augue lectus ut augue. Sed commodo ligula ornare risus feugiat venenatis. Mauris at nibh tortor. Praesent aliquet, libero eu tincidunt adipiscing, orci massa consectetur justo, sed ultrices nunc nulla a lacus. Donec nec quam varius, varius nisl vehicula, semper odio.</span></p>', NULL, 'ru', 1401035167);

-- --------------------------------------------------------

--
-- Структура таблицы `yonote_mod_post_hashtag`
--

CREATE TABLE IF NOT EXISTS `yonote_mod_post_hashtag` (
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yonote_mod_post_hashtag`
--

INSERT INTO `yonote_mod_post_hashtag` (`name`) VALUES
('helloworld');

-- --------------------------------------------------------

--
-- Структура таблицы `yonote_mod_post_relation`
--

CREATE TABLE IF NOT EXISTS `yonote_mod_post_relation` (
  `hashtagid` varchar(64) NOT NULL,
  `postid` varchar(64) NOT NULL,
  PRIMARY KEY (`hashtagid`,`postid`),
  KEY `postid` (`postid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `yonote_pm`
--

CREATE TABLE IF NOT EXISTS `yonote_pm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT NULL,
  `message` text,
  `ownerid` varchar(64) NOT NULL,
  `senderid` varchar(64) NOT NULL,
  `inbox` tinyint(1) DEFAULT '0',
  `outbox` tinyint(1) DEFAULT '0',
  `read` tinyint(1) DEFAULT '0',
  `updatetime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ownerid` (`ownerid`),
  KEY `senderid` (`senderid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `yonote_pm`
--

INSERT INTO `yonote_pm` (`id`, `title`, `message`, `ownerid`, `senderid`, `inbox`, `outbox`, `read`, `updatetime`) VALUES
(1, 'Hello poop', '<p>sdfsdf</p>', 'admin', 'admin', 1, 0, 1, 1398889008);

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
  `updatetime` int(11) DEFAULT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yonote_profile`
--

INSERT INTO `yonote_profile` (`userid`, `name`, `photo`, `language`, `country`, `city`, `updatetime`) VALUES
('admin', 'Vlad Gramuzov', 'photos/535c56f84ecaf.jpg', 'ru', 'Belarus', 'Orsha', 1398560504),
('newuser', 'dfsdf', NULL, 'kok', '', '', 1398377170);

-- --------------------------------------------------------

--
-- Структура таблицы `yonote_setting`
--

CREATE TABLE IF NOT EXISTS `yonote_setting` (
  `category` varchar(100) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL DEFAULT '',
  `value` text,
  `updatetime` int(11) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`category`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yonote_setting`
--

INSERT INTO `yonote_setting` (`category`, `name`, `value`, `updatetime`, `description`) VALUES
('feedback', 'email', 'somemail@mail.ru', 56598985, 'Default feedback email'),
('feedback', 'from', 'noreply@re-spekt.by', 6565985, 'Default sender email (globaly)'),
('feedback', 'sender', 'feedback@re-spekt.by', 56659885, 'Default feedback sender (may be user)'),
('feedback', 'sendmail', '1', 9985654, 'Send additionaly email to manager(s)'),
('feedback', 'subject', 'Форма обратной связи', 656598856, 'Default feedback email subject'),
('pages', 'admin.pages.page.size', '50', 1398703757, 'description.admin.pages.page.size'),
('pages', 'alias.length.max', '50', 1398703757, 'description.alias.length.max'),
('pages', 'alias.length.min', '2', 1398703757, 'description.alias.length.min'),
('pages', 'thumbnail.height.max', '1000', 56565987, 'description.thumbnail.height.max'),
('pages', 'thumbnail.height.min', '300', 45454548, 'description.thumbnail.height.min'),
('pages', 'thumbnail.quality', '80', 56568, 'description.thumbnail.quality'),
('pages', 'thumbnail.resize.enabled', '0', 65658, 'description.thumbnail.resize.enabled'),
('pages', 'thumbnail.resize.height', '300', 565658, 'description.thumbnail.resize.height'),
('pages', 'thumbnail.resize.width', '300', 545458, 'description.thumbnail.resize.width'),
('pages', 'thumbnail.width.max', '1000', 2121587, 'description.thumbnail.width.max'),
('pages', 'thumbnail.width.min', '300', 656568, 'description.thumbnail.width.min'),
('pages', 'title.length.max', '50', 1398720709, 'description.title.length.min'),
('pages', 'title.length.min', '1', 1398720709, 'description.title.length.max'),
('pm', 'message.length.max', '3000', 1398720810, 'description.message.length.max'),
('pm', 'message.length.min', '1', 1398720810, 'description.message.length.min'),
('pm', 'title.length.max', '50', 1398720810, 'description.title.length.max'),
('pm', 'title.length.min', '1', 1398720810, 'description.title.length.min'),
('posts', 'admin.posts.page.size', '50', 1398696710, 'description.admin.posts.page.size'),
('posts', 'alias.length.max', '50', 545458, 'description.alias.length.max'),
('posts', 'alias.length.min', '2', 54589, 'description.alias.length.min'),
('posts', 'full.length.min', '1', 1398696710, 'description.full.length.min'),
('posts', 'short.length.min', '1', 1398696710, 'description.short.length.min'),
('posts', 'thumbnail.height.max', '1000', 1398696710, 'description.thumbnail.height.max'),
('posts', 'thumbnail.height.min', '300', 1398696710, 'description.thumbnail.height.min'),
('posts', 'thumbnail.quality', '80', 1398696710, 'description.thumbnail.quality'),
('posts', 'thumbnail.resize.enabled', '1', 1398696710, 'description.thumbnail.resize.enabled'),
('posts', 'thumbnail.resize.height', '300', 1398696710, 'description.thumbnail.resize.height'),
('posts', 'thumbnail.resize.width', '300', 1398696710, 'description.thumbnail.resize.width'),
('posts', 'thumbnail.size.max', '819200', 1398696710, 'description.thumbnail.size.max'),
('posts', 'thumbnail.width.max', '1000', 1398696710, 'description.thumbnail.width.max'),
('posts', 'thumbnail.width.min', '300', 1398696710, 'description.thumbnail.width.min'),
('posts', 'title.length.max', '80', 6556598, 'description.title.length.max'),
('posts', 'title.length.min', '2', 54548, 'description.title.length.min'),
('system', 'admin.language', 'ru', 1401356908, 'description.admin.language'),
('system', 'admin.template', 'default', 1401356908, 'description.admin.template'),
('system', 'admin.time.zone', 'Europe/Minsk', 1401356908, 'description.admin.time.zone'),
('system', 'languages', 'ru,en', 1401356908, 'description.languages'),
('system', 'login.duration', '604800', 1401356908, 'description.login.duration'),
('system', 'module.size.max', '5242880', 1401356908, 'description.module.size.max'),
('system', 'smtp.enabled', '0', 5454895, 'Enable SMTP authentication for email sending'),
('system', 'smtp.host', 'ssl://smtp.google.com', 656595, 'SMTP host'),
('system', 'smtp.password', 'password', 566586, 'SMTP password'),
('system', 'smtp.port', '465', 56564, 'SMTP port'),
('system', 'smtp.user', 'user', 6565689, 'SMTP user name'),
('system', 'url.format', 'path', 1401356908, 'description.url.format'),
('system', 'url.multilingual', '1', 1401356908, 'Enable multilingual URL mode'),
('system', 'url.redirectondefault', '1', 1401356908, 'description.url.redirectondefault'),
('system', 'website.language', 'ru', 1401356908, 'description.website.language'),
('system', 'website.template', 'nikolai', 1401356908, 'description.website.template'),
('system', 'website.time.zone', 'Europe/Minsk', 1401356908, 'description.website.time.zone'),
('users', 'name.length.max', '20', 1398530025, 'description.name.length.max'),
('users', 'name.length.min', '2', 1398530025, 'description.name.length.min'),
('users', 'password.length.max', '50', 1398530025, 'description.password.length.max'),
('users', 'password.length.min', '6', 1398530025, 'description.password.length.min'),
('users', 'profile.fields.length.max', '50', 1398530025, 'description.profile.fields.length.max'),
('users', 'profile.fields.length.min', '2', 1398530025, 'description.profile.fields.length.min'),
('users', 'profile.photo.height.max', '1000', 1398530025, 'description.profile.photo.height.max'),
('users', 'profile.photo.height.min', '300', 1398530025, 'description.profile.photo.height.min'),
('users', 'profile.photo.quality', '80', 1398530025, 'description.profile.photo.quality'),
('users', 'profile.photo.resize.enabled', '1', 1398530025, 'description.profile.photo.resize.enabled'),
('users', 'profile.photo.resize.height', '300', 1398530025, 'description.profile.photo.resize.height'),
('users', 'profile.photo.resize.width', '300', 1398530025, 'description.profile.photo.resize.width'),
('users', 'profile.photo.size.max', '819200', 1398530025, 'description.profile.photo.size.max'),
('users', 'profile.photo.width.max', '1000', 1398530025, 'description.profile.photo.width.max'),
('users', 'profile.photo.width.min', '300', 1398530025, 'description.profile.photo.width.min'),
('users', 'role.description.length.max', '50', 1398530025, 'description.role.description.length.max'),
('users', 'role.description.length.min', '2', 1398530025, 'description.role.description.length.min'),
('users', 'role.name.length.max', '50', 1398530025, 'description.role.name.length.max'),
('users', 'role.name.length.min', '2', 1398530025, 'description.role.name.length.min'),
('users', 'users.page.size', '50', 1398530025, 'description.users.page.size');

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
  `updatetime` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yonote_user`
--

INSERT INTO `yonote_user` (`name`, `password`, `token`, `email`, `activated`, `verified`, `subscribed`, `updatetime`) VALUES
('admin', '$2a$13$dKmIZvU4j0ZBuJ/NNTITJ.fZc1i4Qlyng90zbccfemEDJ1iOujSRO', '$2a$13$ULJO3qeUmJSzb01qOMJRO0', 'email@email.com', 0, 0, 0, NULL),
('alonex', '', NULL, 'fsd@dgh.df', 1, 1, 1, 1398341536),
('newuser', '$2a$13$Xj25wAX9RwRO7JUK/rCsze7aLAfmXUuE5qKu/Vz21ryp3Y9HBcvme', NULL, 'fsd@dgh.df', 1, 1, 0, NULL),
('nikita', '$2a$13$J4Gk.kkH9YAGwp8RNkaD5.DKtTF.Bz7M0jJG2ha70GreKCwmlUSnG', NULL, 'email@mail.com', 0, 0, 0, NULL);

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
-- Ограничения внешнего ключа таблицы `yonote_mod_post_relation`
--
ALTER TABLE `yonote_mod_post_relation`
  ADD CONSTRAINT `yonote_mod_post_relation_ibfk_1` FOREIGN KEY (`hashtagid`) REFERENCES `yonote_mod_post_hashtag` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `yonote_mod_post_relation_ibfk_2` FOREIGN KEY (`postid`) REFERENCES `yonote_mod_post` (`alias`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `yonote_pm`
--
ALTER TABLE `yonote_pm`
  ADD CONSTRAINT `yonote_pm_ibfk_1` FOREIGN KEY (`ownerid`) REFERENCES `yonote_user` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `yonote_pm_ibfk_2` FOREIGN KEY (`senderid`) REFERENCES `yonote_user` (`name`);

--
-- Ограничения внешнего ключа таблицы `yonote_profile`
--
ALTER TABLE `yonote_profile`
  ADD CONSTRAINT `yonote_profile_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `yonote_user` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
