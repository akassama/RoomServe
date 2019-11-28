-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Ноя 28 2019 г., 11:02
-- Версия сервера: 5.7.23-24
-- Версия PHP: 5.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `u0868360_default`
--

-- --------------------------------------------------------

--
-- Структура таблицы `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('17fd09eb23c96c285a2e317fe5f84ffe2dfd70ca', '89.163.242.241', 1574920243, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537343932303234333b),
('3349bd925c7ed8f4b95923afbb5c8854ce8c2748', '146.185.200.192', 1574922232, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537343932323232363b),
('4270b57843602270f1d7a0f64804cd3ffa2514dd', '2a02:c207:2016:8090::1', 1574926760, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537343932363736303b),
('6ad0f1a8b8eb44a305333abe244b0ff8d3a6354c', '2a02:c207:2016:8090::1', 1574926760, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537343932363736303b),
('7ea3f3d8fd99e0360088b3c94ed8433604f9b7eb', '188.130.155.163', 1574924705, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537343932343636383b757365727c4f3a383a22737464436c617373223a383a7b733a373a22757365725f6964223b733a333a22323930223b733a353a2270686f746f223b4e3b733a31303a2266697273745f6e616d65223b733a353a2241646d696e223b733a393a226c6173745f6e616d65223b733a353a2241646d696e223b733a353a22656d61696c223b733a33303a2261646d696e40726f6f6d73657276696365696e6e6f706f6c69732e636f6d223b733a31323a22757365725f726f6c655f6964223b733a313a2231223b733a383a2267726f75705f6964223b733a313a2231223b733a31303a2267726f75705f6e616d65223b733a303a22223b7d6c6f67676564696e7c623a313b6e65775f6974656d7c613a323a7b733a363a226d6f64756c65223b733a31363a22706572736f6e616c5f6f7074696f6e73223b733a323a226964223b693a31323b7d),
('93b7bf8f3b110e2e2ca571b99daef07da19ff328', '89.163.242.241', 1574920243, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537343932303234333b),
('cd35ff8fddc3f69c8b0cc0a91e717625b456cdcb', '2a02:c207:2016:8090::1', 1574926761, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537343932363736313b);

-- --------------------------------------------------------

--
-- Структура таблицы `pls_cleaning_options`
--

CREATE TABLE IF NOT EXISTS `pls_cleaning_options` (
  `option_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `price` int(10) DEFAULT NULL,
  `currency` varchar(3) DEFAULT 'RUB',
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Дамп данных таблицы `pls_cleaning_options`
--

INSERT INTO `pls_cleaning_options` (`option_id`, `name`, `description`, `price`, `currency`, `status`, `created_at`, `updated_at`, `is_deleted`, `deleted_by`, `deleted_at`) VALUES
(1, 'Kitchen', '', 1000, 'RUB', 1, '2018-01-31 07:41:08', '2019-11-24 23:54:46', 0, NULL, NULL),
(2, 'Bathroom', '', 250, 'RUB', 1, '2018-01-31 07:47:49', '2019-11-24 23:54:38', 0, NULL, NULL),
(3, 'Whole ap.', 'test', 200, 'RUB', 1, '2018-01-31 07:48:39', '2019-11-24 23:54:28', 0, NULL, NULL),
(9, 'Cleaning', '', 2500, 'RUB', 1, '2019-11-26 07:35:43', '2019-11-26 07:57:14', 1, 290, '2019-11-26 07:57:14');

-- --------------------------------------------------------

--
-- Структура таблицы `pls_email_templates`
--

CREATE TABLE IF NOT EXISTS `pls_email_templates` (
  `template_id` int(11) unsigned NOT NULL,
  `template_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pls_email_templates`
--

INSERT INTO `pls_email_templates` (`template_id`, `template_name`, `created_at`) VALUES
(1, 'remind_password', '2018-01-09 16:46:00'),
(2, 'email_verification', '2018-01-09 16:46:39');

-- --------------------------------------------------------

--
-- Структура таблицы `pls_email_templates_translations`
--

CREATE TABLE IF NOT EXISTS `pls_email_templates_translations` (
  `template_id` int(11) unsigned NOT NULL,
  `language` varchar(10) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pls_email_templates_translations`
--

INSERT INTO `pls_email_templates_translations` (`template_id`, `language`, `subject`, `body`) VALUES
(1, 'en', 'Password reset', 'You''re receiving this e-mail because you requested a password reset for your user account at {{web_site}}.<br/>Please go to the following page and choose a new password:<br/><br/>{{verification_link}}<br/><br/>Thanks for using our site!<br/><br/>PLS team'),
(2, 'en', 'Email verification', 'Dear {{full_name}}<br/><br/>Welcome to Skrill. In order to obtain access to all the features of your account, please verify your email address by clicking on the link below:<br/><br/>{{verification_link}}<br/><br/>If you have any questions about your account, please visit our web-site: {{web_site}}.<br/><br/>Best Regards,<br/><br/>PLS team');

-- --------------------------------------------------------

--
-- Структура таблицы `pls_orders`
--

CREATE TABLE IF NOT EXISTS `pls_orders` (
  `order_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL DEFAULT '0',
  `personnel_id` int(10) DEFAULT NULL,
  `student_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `payment_type` varchar(255) NOT NULL,
  `cost` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `reason_id` int(11) NOT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `draft_order_id` int(11) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=258 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Дамп данных таблицы `pls_orders`
--

INSERT INTO `pls_orders` (`order_id`, `option_id`, `personnel_id`, `student_id`, `order_date`, `payment_type`, `cost`, `status`, `reason_id`, `approved_by`, `approved_at`, `created_at`, `created_by`, `updated_at`, `updated_by`, `is_deleted`, `deleted_by`, `deleted_at`, `draft_order_id`) VALUES
(256, 3, 11, 219, '2019-11-25 21:00:00', '25', 200, 0, 0, NULL, '2019-11-26 08:07:31', '2019-11-26 08:06:30', 219, '2019-11-26 08:07:36', NULL, 0, NULL, NULL, 0),
(257, 3, 11, 219, '2019-11-25 21:00:00', '25', 200, 0, 0, NULL, '2019-11-26 08:07:31', '2019-11-26 08:06:30', 219, '2019-11-26 08:07:36', NULL, 0, NULL, NULL, 256);

-- --------------------------------------------------------

--
-- Структура таблицы `pls_orders_translations`
--

CREATE TABLE IF NOT EXISTS `pls_orders_translations` (
  `order_id` int(11) NOT NULL,
  `lang` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `search_keywords` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Дамп данных таблицы `pls_orders_translations`
--

INSERT INTO `pls_orders_translations` (`order_id`, `lang`, `name`, `description`, `search_keywords`) VALUES
(1, 'en', '3-234', 'test', ''),
(2, 'en', '3-234', 'test', ''),
(3, 'en', 'test', 'test xi', ''),
(4, 'en', 'test', 'test xi', ''),
(6, 'en', 'eeeee', 'ee', ''),
(7, 'en', '3-322', 'my comment', ''),
(8, 'en', '3-322', 'my comment', ''),
(9, 'en', '2333', 'e', ''),
(18, 'en', '3-415', 'Clean', ''),
(19, 'en', '3-415', 'Clean', ''),
(41, 'en', 'vrf', 'rfr', ''),
(42, 'en', 'vrf', 'rfr', ''),
(43, 'en', 'gjjrgnr', 'derg', ''),
(44, 'en', 'gjjrgnr', 'derg', ''),
(45, 'en', 'sdfghjm', 'sdfghjk', ''),
(46, 'en', 'sdfghjm', 'sdfghjk', ''),
(5, 'en', 'eeeee', 'ee', ''),
(47, 'en', 'ertref', 'sdfg', ''),
(48, 'en', 'ertref', 'sdfg', ''),
(49, 'en', 'jchj', 'lkjhgfghjk', ''),
(50, 'en', 'jchj', 'lkjhgfghjk', ''),
(52, 'en', 'kjhgf', 'kjhg', ''),
(53, 'en', 'kjhgf', 'kjhg', ''),
(54, 'en', 'gfdfghjkjhg', 'liuf', ''),
(55, 'en', 'gfdfghjkjhg', 'liuf', ''),
(56, 'en', 'sedf', 'sdfg', ''),
(57, 'en', 'sedf', 'sdfg', ''),
(58, 'en', 'lkjhgc', 'jhgf', ''),
(59, 'en', 'lkjhgc', 'jhgf', ''),
(60, 'en', ';lkjhv', 'lkjhbv', ''),
(61, 'en', ';lkjhv', 'lkjhbv', ''),
(62, 'en', '.,mnbv', '.kljhnbv', ''),
(63, 'en', '.,mnbv', '.kljhnbv', ''),
(64, 'en', ',mnbv', ',.mnb', ''),
(65, 'en', ',mnbv', ',.mnb', ''),
(67, 'en', 'frgrg', 'grgrgr', ''),
(68, 'en', 'frgrg', 'grgrgr', ''),
(69, 'en', 'rgrgergdgg', 'gergergfefdgvwdwd', ''),
(70, 'en', 'rgrgergdgg', 'gergergfefdgv', ''),
(71, 'en', 'jkhggcvhbj', 'mnbhvgc', ''),
(72, 'en', 'jkhggcvhbj', 'mnbhvgc', ''),
(73, 'en', 'lkhgf', 'lkjhg', ''),
(74, 'en', 'lkhgf', 'lkjhg', ''),
(75, 'en', 'kjhgffdf', 'jhgf', ''),
(76, 'en', 'kjhgffdf', 'jhgf', ''),
(77, 'en', 'kjhgfhj', 'jhgf', ''),
(78, 'en', 'kjhgfhj', 'jhgf', ''),
(79, 'en', 'dfghjhgfd', 'wertytre', ''),
(80, 'en', 'dfghjhgfd', 'wertytre', ''),
(81, 'en', 'ertgfr', 'wertgfd', ''),
(82, 'en', 'ertgfr', 'wertgfd', ''),
(83, 'en', 'kjbv', 'lkjb', ''),
(84, 'en', 'kjbv', 'lkjb', ''),
(85, 'en', 'dgfdgf', 'dfdfs', ''),
(86, 'en', 'dgfdgf', 'dfdfs', ''),
(87, 'en', 'dsdg', 'dfsd', ''),
(88, 'en', 'dsdg', 'dfsd', ''),
(89, 'en', '343', 'fg', ''),
(90, 'en', '343', 'fg', ''),
(91, 'en', 'dwd', 'wdwsd', ''),
(92, 'en', 'dwd', 'wdwsd', ''),
(93, 'en', '434', '3434r', ''),
(94, 'en', '434', '3434r', ''),
(95, 'en', 'fgfdr', 'gdf', ''),
(96, 'en', 'fgfdr', 'gdf', ''),
(97, 'en', 'fdsf', 'sdfsd', ''),
(98, 'en', 'fdsf', 'sdfsd', ''),
(99, 'en', 'fghjg', 'kgh', ''),
(100, 'en', 'fghjg', 'kgh', ''),
(101, 'en', 'dwd', 'wdwd', ''),
(102, 'en', 'dwd', 'wdwd', ''),
(103, 'en', 'asdsa', 'asdad', ''),
(104, 'en', 'asdsa', 'asdad', ''),
(105, 'en', 'ryry', 'yrry', ''),
(106, 'en', 'ryry', 'yrry', ''),
(107, 'en', 'fdgd', 'fdfg', ''),
(108, 'en', 'fdgd', 'fdfg', ''),
(109, 'en', 'yuty', 'tyuy', ''),
(110, 'en', 'yuty', 'tyuy', ''),
(111, 'en', 'sadsf', 'dsfdsf', ''),
(112, 'en', 'sadsf', 'dsfdsf', ''),
(113, 'en', 'ewr', 'ewre', ''),
(114, 'en', 'ewr', 'ewre', ''),
(115, 'en', 'fsd', 'sdfsjkhn', ''),
(116, 'en', 'fsd', 'sdfsjkhn', ''),
(117, 'en', 'efef', 'efewf', ''),
(118, 'en', 'efef', 'efewf', ''),
(119, 'en', 'rgrg', 'regerg', ''),
(120, 'en', 'rgrg', 'regerg', ''),
(121, 'en', 'rtret', 'rtret', ''),
(122, 'en', 'rtret', 'rtret', ''),
(123, 'en', 'hngfh', 'gfhgfhfg', ''),
(124, 'en', 'hngfh', 'gfhgfhfg', ''),
(125, 'en', 'hfh', 'hfgh', ''),
(126, 'en', 'hfh', 'hfgh', ''),
(128, 'en', 'trhtrh', 'thrhrt', ''),
(129, 'en', 'trhtrh', 'thrhrt', ''),
(130, 'en', 'hth', 'htrht', ''),
(131, 'en', 'hth', 'htrht', ''),
(133, 'en', 'fefef', 'efewf', ''),
(134, 'en', 'fefef', 'efewf', ''),
(135, 'en', 'mghmg', 'gjytj', ''),
(136, 'en', 'mghmg', 'gjytj', ''),
(137, 'en', 'fgfg', 'fgfdgf', ''),
(138, 'en', 'fgfg', 'fgfdgf', ''),
(139, 'en', 'ffe1ewererer', 'efegdggdgd', ''),
(140, 'en', 'ffe1ewererer', 'efegdggdgd', ''),
(141, 'en', '34534', '4545', ''),
(142, 'en', '34534', '4545', ''),
(143, 'en', '4545', 'retret', ''),
(144, 'en', '4545', 'retret', ''),
(145, 'en', 'gdfg', 'dfgdfgdf', ''),
(146, 'en', 'gdfg', 'dfgdfgdf', ''),
(147, 'en', 'grdfg', 'dfdfgfdg', ''),
(148, 'en', 'grdfg', 'dfdfgfdg', ''),
(149, 'en', 'hfghfgh', 'hytrh', ''),
(150, 'en', 'hfghfgh', 'hytrh', ''),
(151, 'en', 'htfhth', 'thtrhtr', ''),
(152, 'en', 'htfhth', 'thtrhtr', ''),
(153, 'en', 'kjhchj', 'lkjhgvm', ''),
(154, 'en', 'kjhchj', 'lkjhgvm', ''),
(155, 'en', 'rgerg', 'rgergr', ''),
(156, 'en', 'rgerg', 'rgergr', ''),
(157, 'en', 'lkjgcvbn', 'lkjhggc', ''),
(158, 'en', 'lkjgcvbn', 'lkjhggc', ''),
(159, 'en', 'l;kjhgcvbnm,', 'kjhcgvbb', ''),
(160, 'en', 'l;kjhgcvbnm,', 'kjhcgvbb', ''),
(163, 'en', 'grg', 'rgrgr', ''),
(164, 'en', 'grg', 'rgrgr', ''),
(165, 'en', 'kljhg', 'lkjh', ''),
(166, 'en', 'kljhg', 'lkjh', ''),
(167, 'en', 'lkjhgf', 'l;kjhg', ''),
(168, 'en', 'lkjhgf', 'l;kjhg', ''),
(169, 'en', 'kjlkj', 'kj', ''),
(170, 'en', 'kjlkj', 'kj', ''),
(171, 'en', '568', 'lkjhgf', ''),
(172, 'en', '568', 'lkjhgf', ''),
(173, 'en', '7654', ',m', ''),
(174, 'en', '7654', ',m', ''),
(178, 'en', 'kjhg', 'lkjhgcvbn', ''),
(179, 'en', 'kjhg', 'lkjhgcvbn', ''),
(180, 'en', 'kugf', 'kjhg', ''),
(181, 'en', 'kugf', 'kjhg', ''),
(185, 'en', '303', 'kill my neigboor', ''),
(186, 'en', '303', 'kill my neigboor', ''),
(184, 'en', '444', 'gerge', ''),
(187, 'en', '444', 'gerge', ''),
(188, 'en', '425', 'ASAP CLEAN EVERYTHING', ''),
(189, 'en', '425', 'ASAP CLEAN EVERYTHING', ''),
(190, 'en', '189', 'ASAP CLEAN THIS', ''),
(191, 'en', '189', 'ASAP CLEAN THIS', ''),
(192, 'en', '189', 'Please clean this', ''),
(193, 'en', '189', 'Please clean this', ''),
(194, 'en', '189', 'Please clean this', ''),
(195, 'en', '189', 'Please clean this', ''),
(196, 'en', '189', 'Please clean this', ''),
(197, 'en', '189', 'Please clean this', ''),
(199, 'en', '189', 'Please clean this', ''),
(200, 'en', '189', 'Please clean this', ''),
(201, 'en', 'kjhgf', 'lkj', ''),
(202, 'en', 'kjhgf', 'lkj', ''),
(207, 'en', 'kjh', 'kjh', ''),
(208, 'en', 'kjh', 'kjh', ''),
(209, 'en', 'jchj', 'kjuhg', ''),
(210, 'en', 'jchj', 'kjuhg', ''),
(212, 'en', '4566', '', ''),
(213, 'en', '4566', '', ''),
(214, 'en', '87654', 'lkjh', ''),
(215, 'en', '87654', 'lkjh', ''),
(216, 'en', '8765', 'kjhg', ''),
(217, 'en', '8765', 'kjhg', ''),
(218, 'en', '6556', 'kjh', ''),
(219, 'en', '6556', 'kjh', ''),
(220, 'en', 'mnbbv', 'mnbv', ''),
(221, 'en', 'mnbbv', 'mnbv', ''),
(222, 'en', '876', 'mnb', ''),
(223, 'en', '876', 'mnb', ''),
(224, 'en', 'kjhgb', 'jnb', ''),
(225, 'en', 'kjhgb', 'jnb', ''),
(226, 'en', '765456', 'vcvbn', ''),
(227, 'en', '765456', 'vcvbn', ''),
(228, 'en', 'dfgngf', 'dfghf', ''),
(229, 'en', 'dfgngf', 'dfghf', ''),
(230, 'en', '456765', 'dfghgf', ''),
(231, 'en', '456765', 'dfghgf', ''),
(232, 'en', '547', 'kjh', ''),
(233, 'en', '547', 'kjh', ''),
(234, 'en', '2323', 'frgrg', ''),
(235, 'en', '2323', 'frgrg', ''),
(236, 'en', 'uytrfgb', 'lkjh', ''),
(237, 'en', 'uytrfgb', 'lkjh', ''),
(238, 'en', 'kjgfcv', 'jhgvbn', ''),
(239, 'en', 'kjgfcv', 'jhgvbn', ''),
(240, 'en', '3-415', 'Please', ''),
(241, 'en', '3-415', 'Please', ''),
(242, 'en', 'hgfgh', 'kjhgh', ''),
(243, 'en', 'hgfgh', 'kjhgh', ''),
(244, 'en', '3-415', 'Clean it, please', ''),
(245, 'en', '3-415', 'Clean it, please', ''),
(246, 'en', '2-444', 'This is a coment', ''),
(247, 'en', '2-444', 'This is a coment', ''),
(248, 'en', '3-145', 'Clean room 3-145', ''),
(249, 'en', '3-145', 'Clean room 3-145', ''),
(250, 'en', '2-345', '', ''),
(251, 'en', '2-345', '', ''),
(252, 'en', '4-222', 'This is a comment', ''),
(253, 'en', '4-222', 'This is a comment', ''),
(254, 'en', '3-415', 'Clean room 3-415', ''),
(255, 'en', '3-415', 'Clean room 3-415', ''),
(256, 'en', '3-415', 'Clean room 3-415', ''),
(257, 'en', '3-415', 'Clean room 3-415', '');

-- --------------------------------------------------------

--
-- Структура таблицы `pls_payment_options`
--

CREATE TABLE IF NOT EXISTS `pls_payment_options` (
  `payment_id` int(11) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_deleted` int(11) NOT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pls_payment_options`
--

INSERT INTO `pls_payment_options` (`payment_id`, `name`, `description`, `status`, `created_at`, `updated_at`, `is_deleted`, `deleted_by`, `deleted_at`) VALUES
(1, 'Bank card', '', 1, '2019-11-26 07:54:33', '2019-11-26 07:54:33', 0, NULL, '0000-00-00 00:00:00'),
(24, 'Cash', '', 1, '2019-11-26 07:55:34', '2019-11-26 07:55:34', 1, 290, '2019-11-26 07:55:34'),
(25, 'Cash', '', 1, '2019-11-26 07:59:06', '2019-11-26 07:59:06', 0, NULL, '0000-00-00 00:00:00'),
(26, '', '', -2, '2019-11-28 07:04:37', '0000-00-00 00:00:00', 0, NULL, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `pls_personal_options`
--

CREATE TABLE IF NOT EXISTS `pls_personal_options` (
  `personal_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_deleted` int(11) NOT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pls_personal_options`
--

INSERT INTO `pls_personal_options` (`personal_id`, `name`, `description`, `status`, `created_at`, `updated_at`, `is_deleted`, `deleted_by`, `deleted_at`) VALUES
(5, 'Olga', 'kjh', 0, '2019-11-25 23:30:54', '2019-11-26 07:56:28', 1, 290, '2019-11-26 07:56:28'),
(6, 'Inga', '', 1, '2019-11-25 23:31:09', '2019-11-25 23:31:14', 0, NULL, NULL),
(8, 'John Doe', '', 0, '2019-11-26 07:41:51', '2019-11-26 07:59:30', 0, NULL, NULL),
(9, '', NULL, -2, '2019-11-26 07:43:10', '0000-00-00 00:00:00', 0, NULL, NULL),
(10, '', NULL, -2, '2019-11-26 07:43:22', '0000-00-00 00:00:00', 0, NULL, NULL),
(11, 'Ann', '', 1, '2019-11-26 07:59:15', '2019-11-26 07:59:22', 0, NULL, NULL),
(12, '', NULL, -2, '2019-11-28 07:05:00', '0000-00-00 00:00:00', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `pls_post_messages`
--

CREATE TABLE IF NOT EXISTS `pls_post_messages` (
  `message_id` int(11) NOT NULL,
  `type` enum('order') NOT NULL,
  `type_id` int(11) NOT NULL,
  `message` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `message_type` enum('decline','cancel','inactivate','expire') NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pls_post_messages`
--

INSERT INTO `pls_post_messages` (`message_id`, `type`, `type_id`, `message`, `message_type`) VALUES
(3, 'order', 81, 'nnugvbj', 'decline'),
(4, 'order', 143, 'hfhghfghfgh', 'decline'),
(5, 'order', 145, 'fdghfghjhjtify', 'decline'),
(7, 'order', 151, 'thurthytfhtf', 'cancel'),
(8, 'order', 149, 'sfcdfvsgv', 'cancel'),
(9, 'order', 157, 'lkjhgc', 'cancel'),
(10, 'order', 163, 'кtyuytf', 'decline'),
(11, 'order', 185, 'We are not killing neighbors', 'decline'),
(12, 'order', 180, 'Test', 'cancel');

-- --------------------------------------------------------

--
-- Структура таблицы `pls_users`
--

CREATE TABLE IF NOT EXISTS `pls_users` (
  `user_id` int(11) unsigned NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `verification_code` varchar(60) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `user_role_id` int(11) unsigned DEFAULT '1',
  `language` varchar(10) DEFAULT 'en',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=292 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pls_users`
--

INSERT INTO `pls_users` (`user_id`, `email`, `password`, `verification_code`, `first_name`, `last_name`, `phone`, `user_role_id`, `language`, `status`, `photo`, `created_at`, `created_by`, `updated_at`, `updated_by`, `is_deleted`, `deleted_at`, `deleted_by`) VALUES
(1, 'admin@rooomservice.com', 'a10d004130c7edb015640d3b145fb1ab4afc4f76', NULL, 'Admin', '', NULL, 1, 'en', 1, NULL, '2018-02-14 10:29:42', 1, '2018-02-14 12:29:03', 1, 0, NULL, NULL),
(213, 'bola@bola.uz', 'a05df4fb660067f8884de0e23c0345f07017d353', NULL, 'Katta16', 'Kichik', NULL, 1, 'en', 1, NULL, '2018-07-24 06:35:47', 1, '2019-11-15 15:16:53', 1, 1, '2019-11-15 15:16:53', 219),
(218, 'bobzimor@gmail.com', 'abf7040794c6a222c8d5ab85a7de7cbe1a79eba8', NULL, 'Bob', 'Zimors', NULL, 2, 'en', 1, NULL, '2019-10-22 21:42:42', NULL, '2019-10-27 17:50:38', 1, 0, NULL, NULL),
(219, 'valeriayurinskaya@gmail.com', '880d8c1e873253110f78cb85f827166bc4e94cbb', NULL, 'Valeria', 'Yurinskaya', NULL, 2, 'en', 1, NULL, '2019-11-06 11:58:20', NULL, '2019-11-24 23:49:30', NULL, 0, NULL, NULL),
(280, 'qqq@qqq.qqq', 'c69bb11322b2cb7265fd326867baccd5b403c486', NULL, 'qqq', 'qqq', NULL, 2, 'en', 1, NULL, '2019-11-25 14:05:35', NULL, '2019-11-25 14:05:35', NULL, 0, NULL, NULL),
(281, 'q@mail.ru', 'f61a74bee9a8f36998bb7e104b3ba2b99206f0d8', NULL, 'qqq', 'qqq', NULL, 2, 'en', 1, NULL, '2019-11-25 14:06:01', NULL, '2019-11-25 14:06:01', NULL, 0, NULL, NULL),
(282, 'vova@mail.ru', '0339bad3847ed0a6fd90b003f34cb3e560364f37', NULL, 'vladimir', 'solovev', NULL, 2, 'en', 1, NULL, '2019-11-25 14:06:33', NULL, '2019-11-25 14:06:33', NULL, 0, NULL, NULL),
(283, 'vladimir@gmail.com', '606bebb0819734cd2caee4d5a94d713acfa1fc86', NULL, 'Vladimir', 'Semenov', NULL, 2, 'en', 1, NULL, '2019-11-25 15:15:03', NULL, '2019-11-25 15:17:18', NULL, 1, '2019-11-25 15:17:18', 258),
(284, 'semenov@gmail.com', '7aab02b5b4dcb3196f2f50eda7e77a33b90c7d2a', NULL, 'Vladimir', 'Semenov', NULL, 2, 'en', 1, NULL, '2019-11-25 15:15:15', NULL, '2019-11-25 15:17:25', NULL, 1, '2019-11-25 15:17:25', 258),
(285, 'vladimirsem@mail.com', '46af98bf5642cb2cfd58b13251e9a301d6fc1831', NULL, 'Vladimir', 'Semenov', NULL, 2, 'en', 1, NULL, '2019-11-25 15:15:43', NULL, '2019-11-25 22:00:40', NULL, 0, NULL, NULL),
(290, 'admin@roomserviceinnopolis.com', 'a173da9033c9bab0b57be43cb1c192ea53f86774', NULL, 'Admin', 'Admin', NULL, 1, 'en', 1, NULL, '2019-11-26 01:34:43', NULL, '2019-11-26 01:34:43', NULL, 0, NULL, NULL),
(291, 'marvin@lopez.com', '8c8f2f75f1b86db23c4d705e1b01831ac014d79e', NULL, 'Marvin', 'Lopez', NULL, 2, 'en', 1, NULL, '2019-11-26 07:36:14', NULL, '2019-11-26 07:36:14', NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `pls_users_access_attempts`
--

CREATE TABLE IF NOT EXISTS `pls_users_access_attempts` (
  `user_attemp_id` int(11) unsigned NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL DEFAULT 'login',
  `user_agent` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `attempts` int(5) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=139 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pls_users_access_attempts`
--

INSERT INTO `pls_users_access_attempts` (`user_attemp_id`, `user_id`, `email`, `action`, `user_agent`, `ip`, `attempts`, `status`, `created_at`) VALUES
(1, NULL, 'admin@roomservice.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '::1', 1, 0, '2019-11-06 11:54:55'),
(2, NULL, 'admin@roomservice.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '::1', 2, 0, '2019-11-06 11:54:57'),
(3, NULL, 'admin@roomservice.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '::1', 3, 0, '2019-11-06 11:55:17'),
(4, NULL, 'admin@roomservice.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '::1', 4, 0, '2019-11-06 11:55:52'),
(5, NULL, 'admin@roomservice.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '::1', 5, 0, '2019-11-06 11:56:03'),
(6, NULL, 'admin@roomservice.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '::1', 6, 0, '2019-11-06 11:56:54'),
(7, 219, 'valeriayurinskaya@gmail.com', 'signup', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '::1', 1, 1, '2019-11-06 11:58:21'),
(8, NULL, 'valeriayurinskaya@gmail.com', 'signup', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '::1', 1, 0, '2019-11-06 11:58:35'),
(9, NULL, 'valeriayurinskaya@gmail.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '::1', 1, 0, '2019-11-06 11:59:07'),
(10, NULL, 'valeriayurinskaya@gmail.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '::1', 2, 0, '2019-11-06 14:06:48'),
(11, NULL, 'valeriayurinskaya@gmail.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '::1', 1, 0, '2019-11-06 16:40:56'),
(12, 220, 'val@yandex.ru', 'signup', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '::1', 1, 1, '2019-11-07 00:16:52'),
(13, NULL, 'val@yandex.ru', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '::1', 1, 0, '2019-11-07 00:18:31'),
(14, 221, 'test@test.com', 'signup', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Mobile Safari/537.36', '::1', 1, 1, '2019-11-07 06:30:31'),
(15, 222, 'Test@test1.com', 'signup', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Mobile Safari/537.36', '::1', 1, 1, '2019-11-07 06:33:41'),
(16, NULL, 'valeriayurinskaya@gmail.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '::1', 1, 0, '2019-11-12 11:21:26'),
(17, NULL, 'admin@roomservice.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '::1', 1, 0, '2019-11-12 11:26:21'),
(18, NULL, 'admin@roomservice.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '::1', 2, 0, '2019-11-12 11:26:36'),
(19, NULL, 'admin@roomservice.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '::1', 3, 0, '2019-11-12 11:26:38'),
(20, NULL, 'admin@roomservice.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '::1', 4, 0, '2019-11-12 11:27:16'),
(21, NULL, 'admin@roomservice.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '::1', 5, 0, '2019-11-12 11:27:26'),
(22, NULL, 'valeriayurinskaya@gmail.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '::1', 2, 0, '2019-11-12 11:28:13'),
(23, NULL, 'valeriayurinskaya@gmail.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '::1', 3, 0, '2019-11-12 13:11:07'),
(24, NULL, 'valeriayurinskaya@gmail.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', '::1', 4, 0, '2019-11-12 13:39:40'),
(25, NULL, 'valeriayurinskaya@gmail.com', 'login', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Mobile Safari/537.36', '::1', 5, 0, '2019-11-12 13:48:15'),
(26, NULL, 'valeriayurinskaya@gmail.com', 'login', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Mobile Safari/537.36', '::1', 6, 0, '2019-11-12 14:03:49'),
(27, NULL, 'valeriayurinskaya@gmail.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', '::1', 1, 0, '2019-11-12 20:39:05'),
(28, NULL, 'valeriayurinskaya@gmail.com', 'login', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Mobile Safari/537.36', '::1', 1, 0, '2019-11-13 13:03:59'),
(29, NULL, 'valeriayurinskaya@gmail.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', '::1', 2, 0, '2019-11-13 13:36:44'),
(30, NULL, 'valeriayurinskaya@gmail.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', '::1', 1, 0, '2019-11-14 09:43:42'),
(31, NULL, 'valeriayurinskaya@gmail.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', '::1', 1, 0, '2019-11-14 20:03:35'),
(32, NULL, 'valeriayurinskaya@gmail.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', '::1', 2, 0, '2019-11-14 20:04:21'),
(33, NULL, 'valeriayurinskaya@gmail.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', '::1', 1, 0, '2019-11-15 12:46:59'),
(34, NULL, 'valeriayurinskaya@gmail.com', 'login', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Mobile Safari/537.36', '::1', 1, 0, '2019-11-15 16:57:02'),
(35, NULL, 'valeriayurinskaya@gmail.com', 'login', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Mobile Safari/537.36', '::1', 2, 0, '2019-11-15 17:35:34'),
(36, NULL, 'valeriayurinskaya@gmail.com', 'login', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Mobile Safari/537.36', '::1', 3, 0, '2019-11-15 18:38:16'),
(37, 255, 'lera0349314@yandex.ru', 'signup', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '::1', 1, 1, '2019-11-15 18:49:37'),
(38, NULL, 'lera0349314@yandex.ru', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '::1', 1, 0, '2019-11-15 18:50:04'),
(39, NULL, 'lera0349314@yandex.ru', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '::1', 1, 0, '2019-11-15 21:12:09'),
(40, 256, 'Inni@food.ru', 'signup', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '::1', 1, 1, '2019-11-15 23:48:21'),
(41, NULL, 'valeriayurinskaya@gmail.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '89.232.118.211', 1, 0, '2019-11-24 12:34:56'),
(42, NULL, 'valeriayurinskaya@gmail.com', 'login', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Mobile Safari/537.36', '89.232.118.211', 2, 0, '2019-11-24 12:35:16'),
(43, NULL, 'valeriayurinskaya@gmail.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', '89.232.118.211', 3, 0, '2019-11-24 12:38:14'),
(44, NULL, 'lera0349314@yandex.ru', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', '89.232.118.211', 1, 0, '2019-11-24 14:14:55'),
(45, NULL, 'valeriayurinskaya@gmail.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', '89.232.118.211', 1, 0, '2019-11-24 14:15:28'),
(46, NULL, 'admin@roomservice.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '89.232.118.211', 1, 0, '2019-11-24 14:48:58'),
(47, NULL, 'admin@roomservice.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '89.232.118.211', 2, 0, '2019-11-24 14:49:04'),
(48, NULL, 'admin@roomservice.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '89.232.118.211', 3, 0, '2019-11-24 14:49:05'),
(49, NULL, 'admin@roomservice.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '89.232.118.211', 4, 0, '2019-11-24 14:50:17'),
(50, NULL, 'admin@roomservice.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '89.232.118.211', 5, 0, '2019-11-24 14:51:04'),
(51, 258, 'admin@roomserviceinnopolis.com', 'signup', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '89.232.118.211', 1, 1, '2019-11-24 14:52:00'),
(52, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '89.232.118.211', 1, 0, '2019-11-24 14:52:12'),
(53, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '89.232.118.211', 2, 0, '2019-11-24 14:52:55'),
(54, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '89.232.118.211', 1, 0, '2019-11-24 18:14:03'),
(55, NULL, 'valeriayurinskaya@gmail.com', 'login', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Mobile Safari/537.36', '89.232.118.211', 1, 0, '2019-11-24 18:17:07'),
(56, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', '89.232.118.211', 1, 0, '2019-11-24 20:45:02'),
(57, NULL, 'valeriayurinskaya@gmail.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '89.232.118.211', 1, 0, '2019-11-24 23:34:12'),
(58, NULL, 'valeriayurinskaya@gmail.com', 'login', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Mobile Safari/537.36', '89.232.118.211', 2, 0, '2019-11-24 23:43:56'),
(59, NULL, 'admin@roomserviceinnopolis.ru', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', '89.232.118.211', 1, 0, '2019-11-24 23:52:58'),
(60, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', '89.232.118.211', 1, 0, '2019-11-24 23:53:30'),
(61, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', '89.232.72.86', 1, 0, '2019-11-25 13:34:37'),
(62, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', '188.130.155.161', 1, 0, '2019-11-25 14:02:19'),
(63, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', '188.130.155.161', 2, 0, '2019-11-25 14:03:35'),
(64, 280, 'qqq@qqq.qqq', 'signup', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', '188.130.155.161', 1, 1, '2019-11-25 14:05:35'),
(65, NULL, 'qqq@qqq.qqq', 'signup', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', '188.130.155.161', 1, 0, '2019-11-25 14:05:40'),
(66, 281, 'q@mail.ru', 'signup', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', '188.130.155.161', 1, 1, '2019-11-25 14:06:01'),
(67, NULL, 'q@mail.ru', 'signup', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', '188.130.155.161', 1, 0, '2019-11-25 14:06:04'),
(68, NULL, 'q@mail.ru', 'signup', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', '188.130.155.161', 2, 0, '2019-11-25 14:06:05'),
(69, NULL, 'q@mail.ru', 'signup', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', '188.130.155.161', 3, 0, '2019-11-25 14:06:05'),
(70, NULL, 'q@mail.ru', 'signup', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', '188.130.155.161', 4, 0, '2019-11-25 14:06:05'),
(71, NULL, 'q@mail.ru', 'signup', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', '188.130.155.161', 5, 0, '2019-11-25 14:06:05'),
(72, 282, 'vova@mail.ru', 'signup', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', '188.130.155.161', 1, 1, '2019-11-25 14:06:33'),
(73, NULL, 'vova@mail.ru', 'signup', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', '188.130.155.161', 1, 0, '2019-11-25 14:06:43'),
(74, NULL, 'qqq@qqq.qqq', 'login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', '188.130.155.161', 1, 0, '2019-11-25 14:07:44'),
(75, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', '188.130.155.161', 3, 0, '2019-11-25 14:09:34'),
(76, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_1) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '2a02:2698:2807:21af:49ea:5f59:ba33:67bc', 1, 0, '2019-11-25 15:08:54'),
(77, 283, 'vladimir@gmail.com', 'signup', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_1) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '2a02:2698:2807:21af:49ea:5f59:ba33:67bc', 1, 1, '2019-11-25 15:15:03'),
(78, NULL, 'vladimir@gmail.com', 'signup', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_1) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '2a02:2698:2807:21af:49ea:5f59:ba33:67bc', 1, 0, '2019-11-25 15:15:07'),
(79, 284, 'semenov@gmail.com', 'signup', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_1) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '2a02:2698:2807:21af:49ea:5f59:ba33:67bc', 1, 1, '2019-11-25 15:15:15'),
(80, NULL, 'semenov@gmail.com', 'signup', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_1) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '2a02:2698:2807:21af:49ea:5f59:ba33:67bc', 1, 0, '2019-11-25 15:15:21'),
(81, 285, 'vladimirsem@mail.com', 'signup', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_1) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '2a02:2698:2807:21af:49ea:5f59:ba33:67bc', 1, 1, '2019-11-25 15:15:43'),
(82, NULL, 'vladimirsem@mail.com', 'signup', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_1) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '2a02:2698:2807:21af:49ea:5f59:ba33:67bc', 1, 0, '2019-11-25 15:16:16'),
(83, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', '188.130.155.157', 2, 0, '2019-11-25 15:16:22'),
(84, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', '188.130.155.157', 3, 0, '2019-11-25 15:16:53'),
(85, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_1) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '2a02:2698:2807:21af:49ea:5f59:ba33:67bc', 4, 0, '2019-11-25 15:16:58'),
(86, 286, 'valeria@hma.ru', 'signup', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '89.232.72.86', 1, 1, '2019-11-25 15:23:21'),
(87, NULL, 'valeria@hma.ru', 'signup', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '89.232.72.86', 1, 0, '2019-11-25 15:23:25'),
(88, 287, 'lera100@gmai.com', 'signup', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Mobile Safari/537.36', '89.232.72.86', 1, 1, '2019-11-25 15:24:54'),
(89, NULL, 'vladimirsem@mail.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_1) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '92.255.201.207', 1, 0, '2019-11-25 15:25:09'),
(90, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', '188.130.155.157', 1, 0, '2019-11-25 15:31:30'),
(91, 288, 'EFEF@EMAIL.COM', 'signup', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Mobile Safari/537.36', '89.232.72.86', 1, 1, '2019-11-25 15:33:20'),
(92, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', '89.232.72.86', 2, 0, '2019-11-25 15:37:56'),
(93, NULL, 'vladimirsem@mail.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_1) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '2a02:2698:2807:21af:49ea:5f59:ba33:67bc', 1, 0, '2019-11-25 15:42:02'),
(94, NULL, 'vladimirsem@mail.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_1) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '2a02:2698:2807:21af:49ea:5f59:ba33:67bc', 2, 0, '2019-11-25 15:50:51'),
(95, NULL, 'vladimirsem@mail.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_1) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '2a02:2698:2807:21af:49ea:5f59:ba33:67bc', 1, 0, '2019-11-25 16:05:44'),
(96, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_1) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '2a02:2698:2807:21af:49ea:5f59:ba33:67bc', 1, 0, '2019-11-25 16:27:49'),
(97, NULL, 'vladimirsem@mail.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_1) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '2a02:2698:2807:21af:49ea:5f59:ba33:67bc', 1, 0, '2019-11-25 16:32:52'),
(98, NULL, 'vladimirsem@mail.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_1) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '2a02:2698:2807:21af:49ea:5f59:ba33:67bc', 2, 0, '2019-11-25 16:34:55'),
(99, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_1) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '2a02:2698:2807:21af:49ea:5f59:ba33:67bc', 2, 0, '2019-11-25 16:36:21'),
(100, NULL, 'valeriayurinskaya@gmail.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', '89.232.72.86', 1, 0, '2019-11-25 19:01:36'),
(101, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', '89.232.72.86', 1, 0, '2019-11-25 19:28:24'),
(102, NULL, 'valeriayurinskaya@gmail.com', 'login', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Mobile Safari/537.36', '89.232.72.86', 1, 0, '2019-11-25 19:29:31'),
(103, NULL, 'valeriayurinskaya@gmail.com', 'login', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Mobile Safari/537.36', '89.232.72.86', 2, 0, '2019-11-25 19:29:40'),
(104, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Mobile Safari/537.36', '89.232.72.86', 1, 0, '2019-11-25 19:41:14'),
(105, NULL, 'valeriayurinskaya@gmail.com', 'login', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Mobile Safari/537.36', '89.232.72.86', 1, 0, '2019-11-25 19:42:55'),
(106, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Mobile Safari/537.36', '89.232.72.86', 1, 0, '2019-11-25 20:03:22'),
(107, NULL, 'valeria@hma.ru', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '89.232.72.86', 1, 0, '2019-11-25 22:21:23'),
(108, NULL, 'valeriayurinskaya@gmail.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '89.232.72.86', 1, 0, '2019-11-25 22:21:45'),
(109, NULL, 'valeriayurinskaya@gmail.com', 'login', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Mobile Safari/537.36', '89.232.72.86', 1, 0, '2019-11-25 22:39:06'),
(110, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Mobile Safari/537.36', '89.232.72.86', 1, 0, '2019-11-25 22:40:51'),
(111, 289, 'admin@roomserviceinnopolis.com', 'signup', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '89.232.72.86', 1, 1, '2019-11-26 01:29:28'),
(112, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '89.232.72.86', 1, 0, '2019-11-26 01:29:33'),
(113, 290, 'admin@roomserviceinnopolis.com', 'signup', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', '89.232.72.86', 1, 1, '2019-11-26 01:34:43'),
(114, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', '89.232.72.86', 2, 0, '2019-11-26 01:35:05'),
(115, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', '188.130.155.164', 1, 0, '2019-11-26 07:10:24'),
(116, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', '188.130.155.164', 2, 0, '2019-11-26 07:10:35'),
(117, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', '188.130.155.164', 3, 0, '2019-11-26 07:11:23'),
(118, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:70.0) Gecko/20100101 Firefox/70.0', '188.130.155.157', 4, 0, '2019-11-26 07:15:28'),
(119, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:70.0) Gecko/20100101 Firefox/70.0', '188.130.155.157', 5, 0, '2019-11-26 07:24:17'),
(120, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', '188.130.155.164', 6, 0, '2019-11-26 07:29:39'),
(121, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', '188.130.155.164', 7, 0, '2019-11-26 07:30:55'),
(122, NULL, 'valeriayurinskaya@gmail.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', '188.130.155.164', 1, 0, '2019-11-26 07:33:14'),
(123, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', '188.130.155.164', 8, 0, '2019-11-26 07:34:46'),
(124, 291, 'marvin@lopez.com', 'signup', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:70.0) Gecko/20100101 Firefox/70.0', '188.130.155.157', 1, 1, '2019-11-26 07:36:14'),
(125, NULL, 'marvin@lopez.com', 'login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:70.0) Gecko/20100101 Firefox/70.0', '188.130.155.157', 1, 0, '2019-11-26 07:36:54'),
(126, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:70.0) Gecko/20100101 Firefox/70.0', '188.130.155.157', 9, 0, '2019-11-26 07:38:38'),
(127, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:70.0) Gecko/20100101 Firefox/70.0', '188.130.155.157', 10, 0, '2019-11-26 07:40:32'),
(128, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', '188.130.155.164', 1, 0, '2019-11-26 07:54:20'),
(129, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', '188.130.155.164', 2, 0, '2019-11-26 07:55:26'),
(130, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', '188.130.155.164', 3, 0, '2019-11-26 07:58:06'),
(131, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', '188.130.155.164', 4, 0, '2019-11-26 07:58:54'),
(132, NULL, 'valeriayurinskaya@gmail.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', '188.130.155.164', 1, 0, '2019-11-26 07:59:50'),
(133, NULL, 'valeriayurinskaya@gmail.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', '188.130.155.164', 2, 0, '2019-11-26 08:01:33'),
(134, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', '188.130.155.164', 5, 0, '2019-11-26 08:02:10'),
(135, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', '188.130.155.164', 6, 0, '2019-11-26 08:04:52'),
(136, NULL, 'valeriayurinskaya@gmail.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', '188.130.155.164', 3, 0, '2019-11-26 08:06:04'),
(137, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', '188.130.155.164', 7, 0, '2019-11-26 08:07:21'),
(138, NULL, 'admin@roomserviceinnopolis.com', 'login', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15', '188.130.155.163', 1, 0, '2019-11-28 07:04:32');

-- --------------------------------------------------------

--
-- Структура таблицы `pls_users_groups`
--

CREATE TABLE IF NOT EXISTS `pls_users_groups` (
  `user_group_id` int(11) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('admin','partner') DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pls_users_groups`
--

INSERT INTO `pls_users_groups` (`user_group_id`, `name`, `type`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`, `is_deleted`, `deleted_at`, `deleted_by`) VALUES
(1, 'Super Administrator', 'admin', 1, '2018-02-06 07:00:34', 0, '0000-00-00 00:00:00', NULL, 0, NULL, NULL),
(2, 'User', 'partner', 1, '2018-02-06 07:00:34', 0, '0000-00-00 00:00:00', NULL, 0, NULL, NULL),
(3, '', 'admin', -2, '2019-11-25 20:58:52', 0, '0000-00-00 00:00:00', NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `pls_users_groups_permissions_rel`
--

CREATE TABLE IF NOT EXISTS `pls_users_groups_permissions_rel` (
  `user_group_id` int(11) unsigned NOT NULL,
  `user_permission_id` int(11) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pls_users_groups_permissions_rel`
--

INSERT INTO `pls_users_groups_permissions_rel` (`user_group_id`, `user_permission_id`, `created_at`, `created_by`) VALUES
(1, 1, '2018-02-06 01:53:39', 0),
(1, 2, '2018-02-06 01:53:39', 0),
(1, 3, '2018-02-06 01:53:39', 0),
(1, 4, '2018-02-06 01:53:39', 0),
(1, 5, '2018-02-06 01:53:39', 0),
(1, 6, '2018-02-06 01:53:39', 0),
(1, 7, '2018-02-06 01:53:39', 0),
(1, 8, '2018-02-06 01:53:39', 0),
(1, 9, '2018-02-06 01:53:40', 0),
(1, 10, '2018-02-06 01:53:40', 0),
(1, 11, '2018-02-06 01:53:40', 0),
(1, 12, '2018-02-06 01:53:40', 0),
(1, 13, '2018-02-06 01:53:40', 0),
(1, 14, '2018-02-06 01:53:40', 0),
(1, 15, '2018-02-06 01:53:40', 0),
(1, 16, '2018-02-06 01:53:40', 0),
(1, 17, '2018-02-06 01:53:40', 0),
(1, 18, '2018-02-06 01:53:40', 0),
(1, 19, '2018-02-06 01:53:40', 0),
(1, 20, '2018-02-06 01:53:40', 0),
(1, 21, '2018-02-06 01:53:40', 0),
(1, 22, '2018-02-06 01:53:40', 0),
(1, 23, '2018-02-06 01:53:40', 0),
(1, 24, '2018-02-06 01:53:41', 0),
(1, 25, '2018-02-06 01:53:41', 0),
(1, 26, '2018-02-06 01:53:41', 0),
(1, 27, '2018-02-06 01:53:41', 0),
(1, 28, '2018-02-06 01:53:41', 0),
(1, 29, '2018-02-06 01:53:41', 0),
(1, 30, '2018-02-06 02:23:36', 0),
(1, 31, '2018-02-06 02:23:37', 0),
(1, 32, '2018-02-06 02:23:37', 0),
(1, 33, '2018-02-06 02:23:37', 0),
(1, 34, '2018-02-06 02:23:37', 0),
(1, 35, '2018-02-06 02:23:37', 0),
(1, 36, '2018-02-06 02:23:37', 0),
(1, 37, '2018-02-06 02:23:37', 0),
(1, 38, '2018-02-06 02:23:37', 0),
(1, 39, '2018-02-06 02:23:37', 0),
(1, 40, '2018-02-06 02:23:37', 0),
(1, 41, '2018-02-06 02:23:37', 0),
(1, 42, '2018-02-06 02:23:37', 0),
(1, 43, '2018-02-06 02:23:37', 0),
(1, 44, '2018-02-06 02:23:37', 0),
(1, 45, '2018-02-06 02:23:37', 0),
(1, 46, '2018-02-06 02:23:37', 0),
(1, 47, '2018-02-06 02:23:37', 0),
(1, 48, '2018-02-06 02:23:37', 0),
(1, 49, '2018-02-06 02:23:37', 0),
(1, 50, '2018-02-06 02:23:38', 0),
(1, 51, '2018-02-06 02:23:38', 0),
(1, 52, '2018-02-06 02:23:38', 0),
(1, 53, '2018-02-06 02:23:38', 0),
(1, 54, '2018-02-06 01:53:41', 0),
(1, 55, '2018-02-06 01:53:41', 0),
(1, 56, '2018-02-06 01:53:41', 0),
(1, 57, '2018-02-06 01:53:41', 0),
(1, 58, '2018-02-06 01:53:41', 0),
(1, 59, '2018-02-06 02:23:38', 0),
(1, 60, '2018-02-06 01:53:41', 0),
(1, 61, '2018-02-06 01:53:41', 0),
(1, 62, '2018-02-06 01:53:41', 0),
(1, 63, '2018-02-06 01:53:41', 0),
(1, 64, '2018-02-06 01:53:41', 0),
(1, 65, '2018-02-06 01:53:41', 0),
(1, 66, '2018-02-06 01:53:42', 0),
(1, 67, '2018-02-06 02:23:38', 0),
(1, 68, '2018-02-06 01:53:42', 0),
(1, 69, '2018-02-06 01:53:42', 0),
(1, 70, '2018-02-06 01:53:42', 0),
(1, 71, '2018-02-06 01:53:42', 0),
(1, 72, '2018-02-06 01:53:42', 0),
(1, 73, '2018-02-13 16:32:18', 0),
(1, 74, '2018-04-28 11:19:46', 1),
(1, 75, '2018-04-30 17:28:38', 0),
(1, 76, '2018-04-30 17:28:38', 0),
(1, 77, '2018-04-30 17:28:38', 0),
(1, 78, '2018-04-30 17:28:38', 0),
(1, 79, '2018-04-30 17:28:38', 0),
(1, 80, '2018-05-08 16:13:46', 0),
(1, 81, '2018-05-08 16:13:46', 0),
(1, 82, '2018-06-27 11:51:13', 1),
(1, 83, '2018-06-27 11:51:13', 1),
(1, 84, '2018-06-27 11:51:13', 1),
(1, 85, '2018-06-27 11:51:13', 1),
(1, 86, '2018-06-27 11:51:13', 1),
(1, 87, '2018-06-27 11:51:13', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `pls_users_groups_rel`
--

CREATE TABLE IF NOT EXISTS `pls_users_groups_rel` (
  `user_id` int(11) unsigned NOT NULL,
  `user_group_id` int(11) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pls_users_groups_rel`
--

INSERT INTO `pls_users_groups_rel` (`user_id`, `user_group_id`, `created_at`, `created_by`) VALUES
(1, 1, '2018-02-06 07:01:18', 0),
(219, 2, '2019-11-24 23:45:17', 0),
(258, 1, '2019-11-24 23:33:35', 0),
(278, 2, '2019-11-24 17:48:47', 0),
(279, 2, '2019-11-25 00:32:59', 0),
(280, 0, '2019-11-25 14:05:35', 0),
(281, 0, '2019-11-25 14:06:01', 0),
(282, 0, '2019-11-25 14:06:33', 0),
(283, 0, '2019-11-25 15:15:03', 0),
(284, 0, '2019-11-25 15:15:15', 0),
(285, 2, '2019-11-25 15:15:43', 0),
(286, 2, '2019-11-25 15:23:21', 0),
(287, 2, '2019-11-25 15:24:54', 0),
(288, 2, '2019-11-25 15:33:20', 0),
(289, 2, '2019-11-26 01:29:28', 0),
(290, 2, '2019-11-26 01:34:43', 0),
(291, 2, '2019-11-26 07:36:14', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `pls_users_permissions`
--

CREATE TABLE IF NOT EXISTS `pls_users_permissions` (
  `user_permission_id` int(11) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `module` enum('order','administrator','user_group','cleaning_option','setting') DEFAULT NULL,
  `type` enum('admin','partner') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pls_users_permissions`
--

INSERT INTO `pls_users_permissions` (`user_permission_id`, `name`, `module`, `type`, `created_at`) VALUES
(10, 'access_orders', 'order', 'admin', '2018-01-21 17:16:12'),
(11, 'create_orders', 'order', 'admin', '2018-01-21 17:16:12'),
(12, 'update_orders', 'order', 'admin', '2018-01-21 17:16:12'),
(13, 'delete_orders', 'order', 'admin', '2018-01-21 17:16:12'),
(20, 'access_administrators', 'administrator', 'admin', '2018-01-21 17:16:12'),
(21, 'create_administrators', 'administrator', 'admin', '2018-01-21 17:16:12'),
(22, 'update_administrators', 'administrator', 'admin', '2018-01-21 17:16:12'),
(23, 'delete_administrators', 'administrator', 'admin', '2018-01-21 17:16:12'),
(24, 'export_administrators', 'administrator', 'admin', '2018-01-21 17:16:12'),
(25, 'access_usergroups', 'user_group', 'admin', '2018-01-21 17:16:12'),
(26, 'create_usergroups', 'user_group', 'admin', '2018-01-21 17:16:12'),
(27, 'update_usergroups', 'user_group', 'admin', '2018-01-21 17:16:12'),
(28, 'delete_usergroups', 'user_group', 'admin', '2018-01-21 17:16:12'),
(29, 'export_usergroups', 'user_group', 'admin', '2018-01-21 17:16:12'),
(34, 'access_orders_partner', 'order', 'partner', '2018-01-21 17:16:12'),
(35, 'create_orders_partner', 'order', 'partner', '2018-01-21 17:16:12'),
(36, 'update_orders_partner', 'order', 'partner', '2018-01-21 17:16:12'),
(37, 'delete_orders_partner', 'order', 'partner', '2018-01-21 17:16:12'),
(44, 'access_administrators_partner', 'administrator', 'partner', '2018-01-21 17:16:12'),
(45, 'create_administrators_partner', 'administrator', 'partner', '2018-01-21 17:16:12'),
(46, 'update_administrators_partner', 'administrator', 'partner', '2018-01-21 17:16:12'),
(47, 'delete_administrators_partner', 'administrator', 'partner', '2018-01-21 17:16:12'),
(48, 'export_administrators_partner', 'administrator', 'partner', '2018-01-21 17:16:12'),
(49, 'access_usergroups_partner', 'user_group', 'partner', '2018-01-21 17:16:12'),
(50, 'create_usergroups_partner', 'user_group', 'partner', '2018-01-21 17:16:12'),
(51, 'update_usergroups_partner', 'user_group', 'partner', '2018-01-21 17:16:12'),
(52, 'delete_usergroups_partner', 'user_group', 'partner', '2018-01-21 17:16:12'),
(53, 'export_usergroups_partner', 'user_group', 'partner', '2018-01-21 17:16:12'),
(63, 'access_categories', '', 'admin', '2018-01-26 03:26:41'),
(64, 'create_categories', '', 'admin', '2018-01-26 03:26:57'),
(65, 'update_categories', '', 'admin', '2018-01-26 03:26:57'),
(66, 'delete_categories', '', 'admin', '2018-01-26 03:27:15'),
(67, 'partner_setting_partner', 'setting', 'partner', '2018-01-30 14:20:15'),
(73, 'approve_orders', 'order', 'admin', '2018-02-13 16:31:33');

-- --------------------------------------------------------

--
-- Структура таблицы `pls_users_roles`
--

CREATE TABLE IF NOT EXISTS `pls_users_roles` (
  `user_role_id` int(11) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pls_users_roles`
--

INSERT INTO `pls_users_roles` (`user_role_id`, `name`, `created_at`) VALUES
(1, 'administrator', '2018-01-09 16:46:00'),
(2, 'partner_administrator', '2018-01-16 11:05:24');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Индексы таблицы `pls_cleaning_options`
--
ALTER TABLE `pls_cleaning_options`
  ADD PRIMARY KEY (`option_id`);

--
-- Индексы таблицы `pls_email_templates`
--
ALTER TABLE `pls_email_templates`
  ADD PRIMARY KEY (`template_id`);

--
-- Индексы таблицы `pls_email_templates_translations`
--
ALTER TABLE `pls_email_templates_translations`
  ADD PRIMARY KEY (`template_id`,`language`);

--
-- Индексы таблицы `pls_orders`
--
ALTER TABLE `pls_orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `category_id` (`option_id`),
  ADD KEY `partner_id` (`student_id`),
  ADD KEY `status` (`status`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Индексы таблицы `pls_orders_translations`
--
ALTER TABLE `pls_orders_translations`
  ADD PRIMARY KEY (`order_id`,`lang`),
  ADD FULLTEXT KEY `name` (`name`);
ALTER TABLE `pls_orders_translations`
  ADD FULLTEXT KEY `name_description` (`name`,`description`,`search_keywords`);

--
-- Индексы таблицы `pls_payment_options`
--
ALTER TABLE `pls_payment_options`
  ADD PRIMARY KEY (`payment_id`);

--
-- Индексы таблицы `pls_personal_options`
--
ALTER TABLE `pls_personal_options`
  ADD PRIMARY KEY (`personal_id`);

--
-- Индексы таблицы `pls_post_messages`
--
ALTER TABLE `pls_post_messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Индексы таблицы `pls_users`
--
ALTER TABLE `pls_users`
  ADD PRIMARY KEY (`user_id`);

--
-- Индексы таблицы `pls_users_access_attempts`
--
ALTER TABLE `pls_users_access_attempts`
  ADD PRIMARY KEY (`user_attemp_id`);

--
-- Индексы таблицы `pls_users_groups`
--
ALTER TABLE `pls_users_groups`
  ADD PRIMARY KEY (`user_group_id`);

--
-- Индексы таблицы `pls_users_groups_permissions_rel`
--
ALTER TABLE `pls_users_groups_permissions_rel`
  ADD PRIMARY KEY (`user_group_id`,`user_permission_id`),
  ADD KEY `user_permission_id` (`user_permission_id`) USING BTREE;

--
-- Индексы таблицы `pls_users_groups_rel`
--
ALTER TABLE `pls_users_groups_rel`
  ADD PRIMARY KEY (`user_id`,`user_group_id`),
  ADD KEY `pls_users_groups_rel_ibfk_2` (`user_group_id`);

--
-- Индексы таблицы `pls_users_permissions`
--
ALTER TABLE `pls_users_permissions`
  ADD PRIMARY KEY (`user_permission_id`);

--
-- Индексы таблицы `pls_users_roles`
--
ALTER TABLE `pls_users_roles`
  ADD PRIMARY KEY (`user_role_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `pls_cleaning_options`
--
ALTER TABLE `pls_cleaning_options`
  MODIFY `option_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT для таблицы `pls_email_templates`
--
ALTER TABLE `pls_email_templates`
  MODIFY `template_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `pls_orders`
--
ALTER TABLE `pls_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=258;
--
-- AUTO_INCREMENT для таблицы `pls_payment_options`
--
ALTER TABLE `pls_payment_options`
  MODIFY `payment_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT для таблицы `pls_personal_options`
--
ALTER TABLE `pls_personal_options`
  MODIFY `personal_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT для таблицы `pls_post_messages`
--
ALTER TABLE `pls_post_messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT для таблицы `pls_users`
--
ALTER TABLE `pls_users`
  MODIFY `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=292;
--
-- AUTO_INCREMENT для таблицы `pls_users_access_attempts`
--
ALTER TABLE `pls_users_access_attempts`
  MODIFY `user_attemp_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=139;
--
-- AUTO_INCREMENT для таблицы `pls_users_groups`
--
ALTER TABLE `pls_users_groups`
  MODIFY `user_group_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `pls_users_permissions`
--
ALTER TABLE `pls_users_permissions`
  MODIFY `user_permission_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=74;
--
-- AUTO_INCREMENT для таблицы `pls_users_roles`
--
ALTER TABLE `pls_users_roles`
  MODIFY `user_role_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
