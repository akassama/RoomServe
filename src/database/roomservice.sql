-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 27 2019 г., 21:36
-- Версия сервера: 5.6.34
-- Версия PHP: 7.1.21RC1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `roomservice`
--

-- --------------------------------------------------------

--
-- Структура таблицы `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('01t17keh77c3jpvrbucbsfo71viums86', '127.0.0.1', 1572201030, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323230313033303b),
('0baqtg9oatg2r2g6o3a82npst93if6c1', '127.0.0.1', 1572198414, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323139383431343b757365727c4f3a383a22737464436c617373223a383a7b733a373a22757365725f6964223b733a313a2231223b733a353a2270686f746f223b4e3b733a31303a2266697273745f6e616d65223b733a353a2241646d696e223b733a393a226c6173745f6e616d65223b733a303a22223b733a353a22656d61696c223b733a32323a2261646d696e40726f6f6f6d736572766963652e636f6d223b733a31323a22757365725f726f6c655f6964223b733a313a2231223b733a383a2267726f75705f6964223b733a313a2231223b733a31303a2267726f75705f6e616d65223b733a303a22223b7d6c6f67676564696e7c623a313b),
('1fr07n6ph5o6jkvdhlgdotl73kpgci7a', '127.0.0.1', 1572169191, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323136393139313b757365727c4f3a383a22737464436c617373223a383a7b733a373a22757365725f6964223b733a313a2231223b733a353a2270686f746f223b4e3b733a31303a2266697273745f6e616d65223b733a353a2241646d696e223b733a393a226c6173745f6e616d65223b733a303a22223b733a353a22656d61696c223b733a32323a2261646d696e40726f6f6f6d736572766963652e636f6d223b733a31323a22757365725f726f6c655f6964223b733a313a2231223b733a383a2267726f75705f6964223b733a313a2231223b733a31303a2267726f75705f6e616d65223b733a303a22223b7d6c6f67676564696e7c623a313b6e65775f6974656d7c613a323a7b733a363a226d6f64756c65223b733a31303a2263617465676f72696573223b733a323a226964223b693a373b7d),
('2lct62h9s7t30ugttqs85efg05bahpuu', '127.0.0.1', 1572200074, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323230303037343b757365727c4f3a383a22737464436c617373223a383a7b733a373a22757365725f6964223b733a333a22323133223b733a353a2270686f746f223b4e3b733a31303a2266697273745f6e616d65223b733a353a224b61747461223b733a393a226c6173745f6e616d65223b733a303a22223b733a353a22656d61696c223b733a31323a22626f6c6140626f6c612e757a223b733a31323a22757365725f726f6c655f6964223b733a313a2232223b733a383a2267726f75705f6964223b733a313a2231223b733a31303a2267726f75705f6e616d65223b733a303a22223b7d6c6f67676564696e7c623a313b),
('9dm8gqtv6bc6co1joljefandovpao9d0', '127.0.0.1', 1572170608, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323137303630383b757365727c4f3a383a22737464436c617373223a383a7b733a373a22757365725f6964223b733a313a2231223b733a353a2270686f746f223b4e3b733a31303a2266697273745f6e616d65223b733a353a2241646d696e223b733a393a226c6173745f6e616d65223b733a303a22223b733a353a22656d61696c223b733a32323a2261646d696e40726f6f6f6d736572766963652e636f6d223b733a31323a22757365725f726f6c655f6964223b733a313a2231223b733a383a2267726f75705f6964223b733a313a2231223b733a31303a2267726f75705f6e616d65223b733a303a22223b7d6c6f67676564696e7c623a313b6e65775f6974656d7c613a323a7b733a363a226d6f64756c65223b733a31303a2263617465676f72696573223b733a323a226964223b693a373b7d),
('b54mcb7t1i26a9adctua8h5aup9h3eep', '127.0.0.1', 1572200392, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323230303339323b757365727c4f3a383a22737464436c617373223a383a7b733a373a22757365725f6964223b733a333a22323133223b733a353a2270686f746f223b4e3b733a31303a2266697273745f6e616d65223b733a353a224b61747461223b733a393a226c6173745f6e616d65223b733a303a22223b733a353a22656d61696c223b733a31323a22626f6c6140626f6c612e757a223b733a31323a22757365725f726f6c655f6964223b733a313a2232223b733a383a2267726f75705f6964223b733a313a2231223b733a31303a2267726f75705f6e616d65223b733a303a22223b7d6c6f67676564696e7c623a313b),
('b9suei0nuj18jdd66mbssu62chpe5s32', '127.0.0.1', 1572172812, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323137323831323b757365727c4f3a383a22737464436c617373223a383a7b733a373a22757365725f6964223b733a313a2231223b733a353a2270686f746f223b4e3b733a31303a2266697273745f6e616d65223b733a353a2241646d696e223b733a393a226c6173745f6e616d65223b733a303a22223b733a353a22656d61696c223b733a32323a2261646d696e40726f6f6f6d736572766963652e636f6d223b733a31323a22757365725f726f6c655f6964223b733a313a2231223b733a383a2267726f75705f6964223b733a313a2231223b733a31303a2267726f75705f6e616d65223b733a303a22223b7d6c6f67676564696e7c623a313b6e65775f6974656d7c613a323a7b733a363a226d6f64756c65223b733a31303a2263617465676f72696573223b733a323a226964223b693a373b7d),
('bqqlobdkf8hidrb3tkdtad8998bf1n3p', '127.0.0.1', 1572171806, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323137313830363b757365727c4f3a383a22737464436c617373223a383a7b733a373a22757365725f6964223b733a313a2231223b733a353a2270686f746f223b4e3b733a31303a2266697273745f6e616d65223b733a353a2241646d696e223b733a393a226c6173745f6e616d65223b733a303a22223b733a353a22656d61696c223b733a32323a2261646d696e40726f6f6f6d736572766963652e636f6d223b733a31323a22757365725f726f6c655f6964223b733a313a2231223b733a383a2267726f75705f6964223b733a313a2231223b733a31303a2267726f75705f6e616d65223b733a303a22223b7d6c6f67676564696e7c623a313b6e65775f6974656d7c613a323a7b733a363a226d6f64756c65223b733a31303a2263617465676f72696573223b733a323a226964223b693a373b7d),
('c0qlpncmmicd8kml50ccvudu5rmshqi1', '127.0.0.1', 1572190028, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323139303032383b757365727c4f3a383a22737464436c617373223a383a7b733a373a22757365725f6964223b733a313a2231223b733a353a2270686f746f223b4e3b733a31303a2266697273745f6e616d65223b733a353a2241646d696e223b733a393a226c6173745f6e616d65223b733a303a22223b733a353a22656d61696c223b733a32323a2261646d696e40726f6f6f6d736572766963652e636f6d223b733a31323a22757365725f726f6c655f6964223b733a313a2231223b733a383a2267726f75705f6964223b733a313a2231223b733a31303a2267726f75705f6e616d65223b733a303a22223b7d6c6f67676564696e7c623a313b),
('dvulp8m27rj7eln5bf6fkigi07o72usp', '127.0.0.1', 1572173286, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323137333238363b757365727c4f3a383a22737464436c617373223a383a7b733a373a22757365725f6964223b733a313a2231223b733a353a2270686f746f223b4e3b733a31303a2266697273745f6e616d65223b733a353a2241646d696e223b733a393a226c6173745f6e616d65223b733a303a22223b733a353a22656d61696c223b733a32323a2261646d696e40726f6f6f6d736572766963652e636f6d223b733a31323a22757365725f726f6c655f6964223b733a313a2231223b733a383a2267726f75705f6964223b733a313a2231223b733a31303a2267726f75705f6e616d65223b733a303a22223b7d6c6f67676564696e7c623a313b6e65775f6974656d7c613a323a7b733a363a226d6f64756c65223b733a31303a2263617465676f72696573223b733a323a226964223b693a373b7d),
('fa62ngjig3tr2e0sonjc5qt7optm1dct', '127.0.0.1', 1572190061, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323139303032383b757365727c4f3a383a22737464436c617373223a383a7b733a373a22757365725f6964223b733a313a2231223b733a353a2270686f746f223b4e3b733a31303a2266697273745f6e616d65223b733a353a2241646d696e223b733a393a226c6173745f6e616d65223b733a303a22223b733a353a22656d61696c223b733a32323a2261646d696e40726f6f6f6d736572766963652e636f6d223b733a31323a22757365725f726f6c655f6964223b733a313a2231223b733a383a2267726f75705f6964223b733a313a2231223b733a31303a2267726f75705f6e616d65223b733a303a22223b7d6c6f67676564696e7c623a313b),
('fcv5fim1g2s99orsd72cftcr7lhva44p', '127.0.0.1', 1572188045, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323138383034353b757365727c4f3a383a22737464436c617373223a383a7b733a373a22757365725f6964223b733a313a2231223b733a353a2270686f746f223b4e3b733a31303a2266697273745f6e616d65223b733a353a2241646d696e223b733a393a226c6173745f6e616d65223b733a303a22223b733a353a22656d61696c223b733a32323a2261646d696e40726f6f6f6d736572766963652e636f6d223b733a31323a22757365725f726f6c655f6964223b733a313a2231223b733a383a2267726f75705f6964223b733a313a2231223b733a31303a2267726f75705f6e616d65223b733a303a22223b7d6c6f67676564696e7c623a313b),
('g10h3b6c5comc84u6595qrsbv1q70281', '127.0.0.1', 1572169609, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323136393630393b757365727c4f3a383a22737464436c617373223a383a7b733a373a22757365725f6964223b733a313a2231223b733a353a2270686f746f223b4e3b733a31303a2266697273745f6e616d65223b733a353a2241646d696e223b733a393a226c6173745f6e616d65223b733a303a22223b733a353a22656d61696c223b733a32323a2261646d696e40726f6f6f6d736572766963652e636f6d223b733a31323a22757365725f726f6c655f6964223b733a313a2231223b733a383a2267726f75705f6964223b733a313a2231223b733a31303a2267726f75705f6e616d65223b733a303a22223b7d6c6f67676564696e7c623a313b6e65775f6974656d7c613a323a7b733a363a226d6f64756c65223b733a31303a2263617465676f72696573223b733a323a226964223b693a373b7d),
('jve2abtls78abi3o4bb614m9lentmbqf', '127.0.0.1', 1572198060, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323139383036303b757365727c4f3a383a22737464436c617373223a383a7b733a373a22757365725f6964223b733a313a2231223b733a353a2270686f746f223b4e3b733a31303a2266697273745f6e616d65223b733a353a2241646d696e223b733a393a226c6173745f6e616d65223b733a303a22223b733a353a22656d61696c223b733a32323a2261646d696e40726f6f6f6d736572766963652e636f6d223b733a31323a22757365725f726f6c655f6964223b733a313a2231223b733a383a2267726f75705f6964223b733a313a2231223b733a31303a2267726f75705f6e616d65223b733a303a22223b7d6c6f67676564696e7c623a313b),
('m0bifijdur50v8r71s1624gt2p19o1vp', '127.0.0.1', 1572198744, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323139383734343b757365727c4f3a383a22737464436c617373223a383a7b733a373a22757365725f6964223b733a313a2231223b733a353a2270686f746f223b4e3b733a31303a2266697273745f6e616d65223b733a353a2241646d696e223b733a393a226c6173745f6e616d65223b733a303a22223b733a353a22656d61696c223b733a32323a2261646d696e40726f6f6f6d736572766963652e636f6d223b733a31323a22757365725f726f6c655f6964223b733a313a2231223b733a383a2267726f75705f6964223b733a313a2231223b733a31303a2267726f75705f6e616d65223b733a303a22223b7d6c6f67676564696e7c623a313b),
('m5r0medc1jrbn9m822fsd0pjk55rbvj3', '127.0.0.1', 1571838788, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537313833383738373b),
('ojhj9m6rsu1u8uvk4s9ii14be1ejpcsg', '127.0.0.1', 1572173469, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323137333238363b757365727c4f3a383a22737464436c617373223a383a7b733a373a22757365725f6964223b733a313a2231223b733a353a2270686f746f223b4e3b733a31303a2266697273745f6e616d65223b733a353a2241646d696e223b733a393a226c6173745f6e616d65223b733a303a22223b733a353a22656d61696c223b733a32323a2261646d696e40726f6f6f6d736572766963652e636f6d223b733a31323a22757365725f726f6c655f6964223b733a313a2231223b733a383a2267726f75705f6964223b733a313a2231223b733a31303a2267726f75705f6e616d65223b733a303a22223b7d6c6f67676564696e7c623a313b6e65775f6974656d7c613a323a7b733a363a226d6f64756c65223b733a31303a2263617465676f72696573223b733a323a226964223b693a373b7d),
('q47o6ib6qp7mmpoekb25lsfdnci46u8d', '127.0.0.1', 1572171247, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323137313234373b757365727c4f3a383a22737464436c617373223a383a7b733a373a22757365725f6964223b733a313a2231223b733a353a2270686f746f223b4e3b733a31303a2266697273745f6e616d65223b733a353a2241646d696e223b733a393a226c6173745f6e616d65223b733a303a22223b733a353a22656d61696c223b733a32323a2261646d696e40726f6f6f6d736572766963652e636f6d223b733a31323a22757365725f726f6c655f6964223b733a313a2231223b733a383a2267726f75705f6964223b733a313a2231223b733a31303a2267726f75705f6e616d65223b733a303a22223b7d6c6f67676564696e7c623a313b6e65775f6974656d7c613a323a7b733a363a226d6f64756c65223b733a31303a2263617465676f72696573223b733a323a226964223b693a373b7d),
('qlfdqu76p981nsejn14135alk8se9vrf', '127.0.0.1', 1572172432, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323137323433323b757365727c4f3a383a22737464436c617373223a383a7b733a373a22757365725f6964223b733a313a2231223b733a353a2270686f746f223b4e3b733a31303a2266697273745f6e616d65223b733a353a2241646d696e223b733a393a226c6173745f6e616d65223b733a303a22223b733a353a22656d61696c223b733a32323a2261646d696e40726f6f6f6d736572766963652e636f6d223b733a31323a22757365725f726f6c655f6964223b733a313a2231223b733a383a2267726f75705f6964223b733a313a2231223b733a31303a2267726f75705f6e616d65223b733a303a22223b7d6c6f67676564696e7c623a313b6e65775f6974656d7c613a323a7b733a363a226d6f64756c65223b733a31303a2263617465676f72696573223b733a323a226964223b693a373b7d),
('r411vpnuk9975nh3a68fdlafe7oph2c0', '127.0.0.1', 1572199747, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323139393534333b757365727c4f3a383a22737464436c617373223a383a7b733a373a22757365725f6964223b733a313a2231223b733a353a2270686f746f223b4e3b733a31303a2266697273745f6e616d65223b733a353a2241646d696e223b733a393a226c6173745f6e616d65223b733a303a22223b733a353a22656d61696c223b733a32323a2261646d696e40726f6f6f6d736572766963652e636f6d223b733a31323a22757365725f726f6c655f6964223b733a313a2231223b733a383a2267726f75705f6964223b733a313a2231223b733a31303a2267726f75705f6e616d65223b733a303a22223b7d6c6f67676564696e7c623a313b),
('rjcf5nkbjfafbcqpp5682nj6qqqlfbaq', '127.0.0.1', 1572199543, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323139393534333b757365727c4f3a383a22737464436c617373223a383a7b733a373a22757365725f6964223b733a313a2231223b733a353a2270686f746f223b4e3b733a31303a2266697273745f6e616d65223b733a353a2241646d696e223b733a393a226c6173745f6e616d65223b733a303a22223b733a353a22656d61696c223b733a32323a2261646d696e40726f6f6f6d736572766963652e636f6d223b733a31323a22757365725f726f6c655f6964223b733a313a2231223b733a383a2267726f75705f6964223b733a313a2231223b733a31303a2267726f75705f6e616d65223b733a303a22223b7d6c6f67676564696e7c623a313b),
('sc1tvaor189cu5di75ujg3o35ite0fuf', '127.0.0.1', 1572170220, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323137303232303b757365727c4f3a383a22737464436c617373223a383a7b733a373a22757365725f6964223b733a313a2231223b733a353a2270686f746f223b4e3b733a31303a2266697273745f6e616d65223b733a353a2241646d696e223b733a393a226c6173745f6e616d65223b733a303a22223b733a353a22656d61696c223b733a32323a2261646d696e40726f6f6f6d736572766963652e636f6d223b733a31323a22757365725f726f6c655f6964223b733a313a2231223b733a383a2267726f75705f6964223b733a313a2231223b733a31303a2267726f75705f6e616d65223b733a303a22223b7d6c6f67676564696e7c623a313b6e65775f6974656d7c613a323a7b733a363a226d6f64756c65223b733a31303a2263617465676f72696573223b733a323a226964223b693a373b7d),
('ttin8c9dkg63cg8o0ri6hjv6gdbdnsg2', '127.0.0.1', 1572200799, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537323230303739393b757365727c4f3a383a22737464436c617373223a383a7b733a373a22757365725f6964223b733a333a22323133223b733a353a2270686f746f223b4e3b733a31303a2266697273745f6e616d65223b733a353a224b61747461223b733a393a226c6173745f6e616d65223b733a303a22223b733a353a22656d61696c223b733a31323a22626f6c6140626f6c612e757a223b733a31323a22757365725f726f6c655f6964223b733a313a2232223b733a383a2267726f75705f6964223b733a313a2231223b733a31303a2267726f75705f6e616d65223b733a303a22223b7d6c6f67676564696e7c623a313b);

-- --------------------------------------------------------

--
-- Структура таблицы `pls_cleaning_options`
--

CREATE TABLE `pls_cleaning_options` (
  `option_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `price` int(10) DEFAULT NULL,
  `currency` varchar(3) DEFAULT 'RUB',
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Дамп данных таблицы `pls_cleaning_options`
--

INSERT INTO `pls_cleaning_options` (`option_id`, `name`, `description`, `price`, `currency`, `status`, `created_at`, `updated_at`, `is_deleted`, `deleted_at`) VALUES
(1, 'Kitchen', NULL, 0, 'RUB', 1, '2018-01-31 07:41:08', '0000-00-00 00:00:00', 0, NULL),
(2, 'Bathroom', NULL, 0, 'RUB', 1, '2018-01-31 07:47:49', '0000-00-00 00:00:00', 0, NULL),
(3, 'Whole apartment', 'test', 200, 'RUB', 1, '2018-01-31 07:48:39', '2019-10-27 10:16:44', 0, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `pls_email_templates`
--

CREATE TABLE `pls_email_templates` (
  `template_id` int(11) UNSIGNED NOT NULL,
  `template_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `pls_email_templates_translations` (
  `template_id` int(11) UNSIGNED NOT NULL,
  `language` varchar(10) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pls_email_templates_translations`
--

INSERT INTO `pls_email_templates_translations` (`template_id`, `language`, `subject`, `body`) VALUES
(1, 'en', 'Password reset', 'You\'re receiving this e-mail because you requested a password reset for your user account at {{web_site}}.<br/>Please go to the following page and choose a new password:<br/><br/>{{verification_link}}<br/><br/>Thanks for using our site!<br/><br/>PLS team'),
(2, 'en', 'Email verification', 'Dear {{full_name}}<br/><br/>Welcome to Skrill. In order to obtain access to all the features of your account, please verify your email address by clicking on the link below:<br/><br/>{{verification_link}}<br/><br/>If you have any questions about your account, please visit our web-site: {{web_site}}.<br/><br/>Best Regards,<br/><br/>PLS team');

-- --------------------------------------------------------

--
-- Структура таблицы `pls_orders`
--

CREATE TABLE `pls_orders` (
  `order_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL DEFAULT '0',
  `personnel_id` int(10) DEFAULT NULL,
  `student_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `payment_type` varchar(255) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Дамп данных таблицы `pls_orders`
--

INSERT INTO `pls_orders` (`order_id`, `option_id`, `personnel_id`, `student_id`, `order_date`, `payment_type`, `status`, `reason_id`, `approved_by`, `approved_at`, `created_at`, `created_by`, `updated_at`, `updated_by`, `is_deleted`, `deleted_by`, `deleted_at`, `draft_order_id`) VALUES
(1, 2, NULL, 0, '2019-10-21 21:00:00', '', 1, 0, NULL, NULL, '2019-10-22 08:19:16', 1, '2019-10-22 08:25:32', 1, 0, NULL, NULL, 0),
(2, 2, NULL, 0, '2019-10-21 21:00:00', '', 1, 0, NULL, NULL, '2019-10-22 08:19:16', 1, '2019-10-22 08:25:32', 1, 0, NULL, NULL, 1),
(3, 3, 2, 213, '2019-10-22 21:00:00', 'card', 1, 0, 1, '2019-10-23 13:20:31', '2019-10-22 09:29:05', 213, '2019-10-23 13:23:54', 1, 0, NULL, NULL, 0),
(4, 3, 2, 213, '2019-10-22 21:00:00', 'card', 1, 0, 1, '2019-10-23 13:20:31', '2019-10-22 09:29:05', 213, '2019-10-23 13:23:54', 1, 0, NULL, NULL, 3),
(5, 0, NULL, 218, '0000-00-00 00:00:00', '', -2, 0, NULL, NULL, '2019-10-23 08:21:27', 218, '0000-00-00 00:00:00', NULL, 0, NULL, NULL, 0),
(6, 2, NULL, 218, '2020-07-22 21:00:00', '', 1, 0, 1, '2019-10-23 09:22:22', '2019-10-23 08:22:57', 218, '2019-10-23 09:22:22', 1, 0, NULL, NULL, 5),
(7, 2, NULL, 218, '2020-07-22 21:00:00', '', 4, 0, 1, '2019-10-23 09:22:22', '2019-10-23 08:22:57', 218, '2019-10-23 09:22:22', 1, 0, NULL, NULL, 0),
(8, 3, NULL, 218, '2019-11-27 21:00:00', '', 4, 0, NULL, NULL, '2019-10-23 11:06:53', 218, '2019-10-23 12:47:03', 1, 0, NULL, NULL, 7),
(10, 0, NULL, 0, '2019-10-27 13:33:08', '', -2, 0, NULL, NULL, '2019-10-27 13:33:08', 0, '0000-00-00 00:00:00', NULL, 0, NULL, NULL, 0),
(11, 0, NULL, 213, '2019-10-27 18:23:15', '', -2, 0, NULL, NULL, '2019-10-27 18:23:15', 0, '0000-00-00 00:00:00', NULL, 0, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `pls_orders_translations`
--

CREATE TABLE `pls_orders_translations` (
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
(6, 'en', '3-322', 'my comment', ''),
(7, 'en', '3-322', 'my comment', ''),
(8, 'en', '2333', 'e', ''),
(9, 'en', '2333', 'e', '');

-- --------------------------------------------------------

--
-- Структура таблицы `pls_post_messages`
--

CREATE TABLE `pls_post_messages` (
  `message_id` int(11) NOT NULL,
  `type` enum('order') NOT NULL,
  `type_id` int(11) NOT NULL,
  `message` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `message_type` enum('decline','cancel','inactivate','expire') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pls_users`
--

CREATE TABLE `pls_users` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `verification_code` varchar(60) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `user_role_id` int(11) UNSIGNED DEFAULT '1',
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pls_users`
--

INSERT INTO `pls_users` (`user_id`, `email`, `password`, `verification_code`, `first_name`, `last_name`, `phone`, `user_role_id`, `language`, `status`, `photo`, `created_at`, `created_by`, `updated_at`, `updated_by`, `is_deleted`, `deleted_at`, `deleted_by`) VALUES
(1, 'admin@rooomservice.com', 'a10d004130c7edb015640d3b145fb1ab4afc4f76', NULL, 'Admin', '', NULL, 1, 'en', 1, NULL, '2018-02-14 10:29:42', 1, '2018-02-14 12:29:03', 1, 0, NULL, NULL),
(213, 'bola@bola.uz', 'a05df4fb660067f8884de0e23c0345f07017d353', NULL, 'Katta', 'Kichik', NULL, 2, 'en', 1, NULL, '2018-07-24 06:35:47', 1, '2019-10-27 18:30:05', 1, 0, NULL, NULL),
(218, 'bobzimor@gmail.com', 'abf7040794c6a222c8d5ab85a7de7cbe1a79eba8', NULL, 'Bob', 'Zimors', NULL, 2, 'en', 1, NULL, '2019-10-22 21:42:42', NULL, '2019-10-27 17:50:38', 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `pls_users_access_attempts`
--

CREATE TABLE `pls_users_access_attempts` (
  `user_attemp_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL DEFAULT 'login',
  `user_agent` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `attempts` int(5) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pls_users_groups`
--

CREATE TABLE `pls_users_groups` (
  `user_group_id` int(11) UNSIGNED NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pls_users_groups`
--

INSERT INTO `pls_users_groups` (`user_group_id`, `name`, `type`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`, `is_deleted`, `deleted_at`, `deleted_by`) VALUES
(1, 'Super Administrator', 'admin', 1, '2018-02-06 07:00:34', 0, '0000-00-00 00:00:00', NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `pls_users_groups_permissions_rel`
--

CREATE TABLE `pls_users_groups_permissions_rel` (
  `user_group_id` int(11) UNSIGNED NOT NULL,
  `user_permission_id` int(11) UNSIGNED NOT NULL,
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

CREATE TABLE `pls_users_groups_rel` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `user_group_id` int(11) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pls_users_groups_rel`
--

INSERT INTO `pls_users_groups_rel` (`user_id`, `user_group_id`, `created_at`, `created_by`) VALUES
(1, 1, '2018-02-06 07:01:18', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `pls_users_permissions`
--

CREATE TABLE `pls_users_permissions` (
  `user_permission_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `module` enum('order','administrator','user_group','cleaning_option','setting') DEFAULT NULL,
  `type` enum('admin','partner') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `pls_users_roles` (
  `user_role_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  ADD PRIMARY KEY (`order_id`,`lang`);
ALTER TABLE `pls_orders_translations` ADD FULLTEXT KEY `name` (`name`);
ALTER TABLE `pls_orders_translations` ADD FULLTEXT KEY `name_description` (`name`,`description`,`search_keywords`);

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
  MODIFY `option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT для таблицы `pls_email_templates`
--
ALTER TABLE `pls_email_templates`
  MODIFY `template_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `pls_orders`
--
ALTER TABLE `pls_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT для таблицы `pls_post_messages`
--
ALTER TABLE `pls_post_messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `pls_users`
--
ALTER TABLE `pls_users`
  MODIFY `user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=219;
--
-- AUTO_INCREMENT для таблицы `pls_users_access_attempts`
--
ALTER TABLE `pls_users_access_attempts`
  MODIFY `user_attemp_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `pls_users_groups`
--
ALTER TABLE `pls_users_groups`
  MODIFY `user_group_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;
--
-- AUTO_INCREMENT для таблицы `pls_users_permissions`
--
ALTER TABLE `pls_users_permissions`
  MODIFY `user_permission_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;
--
-- AUTO_INCREMENT для таблицы `pls_users_roles`
--
ALTER TABLE `pls_users_roles`
  MODIFY `user_role_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
