-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-09-2014 a las 01:14:03
-- Versión del servidor: 5.6.15-log
-- Versión de PHP: 5.5.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `blackfw`
--
CREATE DATABASE IF NOT EXISTS `blackfw` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `blackfw`;

-- --------------------------------------------------------


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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imported_id` int(10) unsigned NOT NULL,
  `title` varchar(1000) NOT NULL,
  `intro` text NOT NULL,
  `body` text NOT NULL,
  `section` varchar(30) NOT NULL,
  `region` varchar(100) NOT NULL,
  `image` varchar(700) NOT NULL,
  `image_comment` varchar(1200) NOT NULL DEFAULT '',
  `images` text,
  `placeholder` varchar(30) DEFAULT NULL,
  `views` bigint(20) unsigned NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `enabled` tinyint(4) NOT NULL DEFAULT '1',
  `source` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `section` (`section`),
  KEY `placeholder` (`placeholder`),
  KEY `region` (`region`),
  KEY `source` (`source`),
  KEY `imported_id` (`imported_id`),
  FULLTEXT KEY `region_2` (`region`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


--
-- Estructura de tabla para la tabla `news_regions`
--

DROP TABLE IF EXISTS `news_regions`;
CREATE TABLE IF NOT EXISTS `news_regions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------


DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(600) NOT NULL DEFAULT 'User',
  `email` varchar(600) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role` varchar(200) NOT NULL DEFAULT 'user',
  `parameters` text NOT NULL,
  `enabled` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `enabled` (`enabled`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
