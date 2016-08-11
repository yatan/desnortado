-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-08-2016 a las 12:30:44
-- Versión del servidor: 5.6.17
-- Versión de PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `desnortado`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id_item` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  PRIMARY KEY (`id_item`),
  KEY `item_id` (`id_item`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

--
-- Volcado de datos para la tabla `items`
--

INSERT INTO `items` (`id_item`, `type`, `params`) VALUES
(1, 1, ''),
(44, 1, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `maps`
--

CREATE TABLE IF NOT EXISTS `maps` (
  `map_id` int(11) NOT NULL,
  `X` int(11) NOT NULL,
  `Y` int(11) NOT NULL,
  `terrain` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ownership`
--

CREATE TABLE IF NOT EXISTS `ownership` (
  `item_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL DEFAULT '0',
  `X` int(11) NOT NULL,
  `Y` int(11) NOT NULL,
  PRIMARY KEY (`X`,`Y`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ownership`
--

INSERT INTO `ownership` (`item_id`, `owner_id`, `X`, `Y`) VALUES
(1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `players`
--

CREATE TABLE IF NOT EXISTS `players` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pass` text NOT NULL,
  `email` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `players`
--

INSERT INTO `players` (`id`, `pass`, `email`) VALUES
(1, '81dc9bdb52d04dc20036dbd8313ed055', '1234');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `players_game`
--

CREATE TABLE IF NOT EXISTS `players_game` (
  `id` int(11) NOT NULL,
  `nick` varchar(20) NOT NULL,
  `status` int(11) NOT NULL,
  `X` int(11) NOT NULL DEFAULT '0',
  `Y` int(11) NOT NULL DEFAULT '0',
  `HP` int(11) NOT NULL DEFAULT '0',
  `AP` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`nick`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `players_game`
--

INSERT INTO `players_game` (`id`, `nick`, `status`, `X`, `Y`, `HP`, `AP`) VALUES
(1, 'yatan', 0, 1, 1, 0, 0);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `players_game`
--
ALTER TABLE `players_game`
  ADD CONSTRAINT `checkID` FOREIGN KEY (`id`) REFERENCES `players` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
