-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-08-2017 a las 14:35:22
-- Versión del servidor: 5.7.14
-- Versión de PHP: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `myapplication`
--
CREATE DATABASE IF NOT EXISTS `myapplication` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `myapplication`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modules`
--

DROP TABLE IF EXISTS `modules`;
CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(300) NOT NULL,
  `type` varchar(300) NOT NULL,
  `parameters` text NOT NULL,
  `html` text NOT NULL,
  `pages` text,
  `placeholders` text NOT NULL COMMENT 'serialized',
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `enabled` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `enabled` (`enabled`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imported_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(1000) NOT NULL,
  `intro` text NOT NULL,
  `body` text NOT NULL,
  `section` varchar(30) NOT NULL,
  `region` varchar(100) NOT NULL,
  `image` varchar(700) NOT NULL,
  `image_comment` varchar(1200) NOT NULL DEFAULT '',
  `images` text,
  `placeholder` varchar(30) DEFAULT NULL,
  `views` bigint(20) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `enabled` tinyint(4) NOT NULL DEFAULT '1',
  `source` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `section` (`section`),
  KEY `placeholder` (`placeholder`),
  KEY `region` (`region`),
  KEY `source` (`source`),
  KEY `imported_id` (`imported_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `news_regions`
--

DROP TABLE IF EXISTS `news_regions`;
CREATE TABLE IF NOT EXISTS `news_regions` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(600) NOT NULL DEFAULT 'User',
  `email` varchar(600) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role` varchar(200) NOT NULL DEFAULT 'user',
  `image` varchar(300) DEFAULT NULL,
  `parameters` text NOT NULL,
  `enabled` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `date_created` datetime NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `enabled` (`enabled`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `image`, `parameters`, `enabled`, `date_created`, `date_modified`) VALUES
(1, 'Administrator', 'admin@email.com', '12345678', 'admin', NULL, 'O:8:"stdClass":2:{s:1:"0";b:0;s:9:"lastLogin";O:8:"stdClass":3:{s:4:"date";s:24:"2017-08-18T14:26:39+0000";s:2:"ip";s:3:"::1";s:8:"uniqueId";s:20:"[uid_1]5996f91f05f11";}}', 1, '2017-08-18 11:25:34', '2017-08-18 11:26:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `videos`
--

DROP TABLE IF EXISTS `videos`;
CREATE TABLE IF NOT EXISTS `videos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(600) DEFAULT NULL,
  `link` varchar(600) DEFAULT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `news`
--
ALTER TABLE `news` ADD FULLTEXT KEY `region_2` (`region`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
