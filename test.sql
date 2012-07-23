-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Mar 03 Juillet 2012 à 18:29
-- Version du serveur: 5.5.16
-- Version de PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `test`
--

-- --------------------------------------------------------

--
-- Structure de la table `villes`
--

DROP TABLE IF EXISTS `villes`;
CREATE TABLE IF NOT EXISTS `villes` (
  `CODVILLE` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant',
  `NOMVILLE` varchar(100) NOT NULL COMMENT 'Nom',
  `LATTGPS` double DEFAULT NULL COMMENT 'Lattitude',
  `LONGGPS` double DEFAULT NULL COMMENT 'Longitude',
  PRIMARY KEY (`CODVILLE`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Table des Villes' AUTO_INCREMENT=12 ;

--
-- Contenu de la table `villes`
--

INSERT INTO `villes` (`CODVILLE`, `NOMVILLE`, `LATTGPS`, `LONGGPS`) VALUES
(1, 'Le Havre', 49.49437, 0.107929),
(4, 'Paris', 48.856614, 2.3522219),
(5, 'Marseille', 43.296482, 5.36978),
(6, 'Lille', 50.62925, 3.057256),
(7, 'Nantes', 47.218371, -1.553621),
(8, 'Yébleron', 49.633037, 0.5373869),
(9, 'Bolbec', 49.575329, 0.483881),
(10, 'Amsterdam', 52.3702157, 4.8951679),
(11, '222 route de foucart 76640 yébleron', 49.6309038, 0.5424954);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
