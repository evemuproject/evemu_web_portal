-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 26-06-2011 a las 00:51:12
-- Versión del servidor: 5.5.8
-- Versión de PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `eveportal`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forum_categories`
--

CREATE TABLE IF NOT EXISTS `forum_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `priority` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcar la base de datos para la tabla `forum_categories`
--

INSERT INTO `forum_categories` (`id`, `name`, `description`, `priority`) VALUES
(4, 'Welcome', 'Welcome to EVEmu Portal. You can delete/edit this category. Feel free to play with the code of the portal. Any help would be good. ^^', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forum_replies`
--

CREATE TABLE IF NOT EXISTS `forum_replies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `topicid` int(11) NOT NULL,
  `creatorID` int(10) NOT NULL,
  `date` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Volcar la base de datos para la tabla `forum_replies`
--

INSERT INTO `forum_replies` (`id`, `message`, `topicid`, `creatorID`, `date`) VALUES
(6, '[b][green]Changelog[/green][/b]:\r\n-Rewrited completely the source\r\n-Server status indicator\r\n-Main forum system in place\r\n-Item listing for characters\r\n-Added base forum system( categories, topics, replyes... )\r\n-Fixed all visual errors on IE8 and other browsers\r\n-Added edit function to forum system\r\n-Added cache system to forum system\r\n-Added paging for posts and subforums\r\n-Added sticky topics system\r\n-Added lock topics system\r\n-Added base report system\r\n-Validated CSS as W3C Standard\r\n-Some basic BBcode-style support\r\n-Quoting support for forums\r\n-Added basic character info script\r\n-Full integration with Incursion server and image server\r\n-Its possible to close the connections to the portal\r\n-Added caching system for character portraits when incursion server is on\r\n-Easy images'' link mask for character portraits\r\n-Added administration panel\r\n-Added caching system for item icons when image.eveonline.com is accesible\r\n-Easy images'' link mask for item icons\r\n\r\n[b][center][h2]FAQ[/h2][/center][/b]\r\n[b]Question[/b]: I installed the portal without the install.php script, but when i login with my admin account i cant acces to Administration panel and/or News management. What should i do ?\r\n[b]Answer[/b]: EVEmu Portal uses a defined and unique role for administratiors'' accounts. By default this value is set to 18014398509481984( incursion administrator ). If you''re using Apocrypha or a diferent admin role you should edit &quot;$adminRole = 18014398509481984;&quot; in config.php to match your admin role.\r\n\r\n[b]Question[/b]: I cant login into News Management.\r\n[b]Answer[/b]: You should use a diferent combination of username/password. By default these are:\r\n[center][b]Username[/b]: Administrator\r\n[b]Password[/b]: 123456789[/center]\r\nYou can change this in the config of News management', 6, 1, 1309041976);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forum_reports`
--

CREATE TABLE IF NOT EXISTS `forum_reports` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `reason` text NOT NULL,
  `fromID` int(10) NOT NULL,
  `replyID` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Volcar la base de datos para la tabla `forum_reports`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forum_topics`
--

CREATE TABLE IF NOT EXISTS `forum_topics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `creatorID` int(10) NOT NULL,
  `date` bigint(20) NOT NULL,
  `reads` int(10) NOT NULL,
  `sticky` tinyint(1) NOT NULL,
  `closed` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Volcar la base de datos para la tabla `forum_topics`
--

INSERT INTO `forum_topics` (`id`, `name`, `categoryid`, `creatorID`, `date`, `reads`, `sticky`, `closed`) VALUES
(6, 'EVEmu Portal Changelog', 4, 1, 1309041976, 0, 0, 0);
