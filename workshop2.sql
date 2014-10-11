-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 11 okt 2014 kl 17:35
-- Serverversion: 5.6.15-log
-- PHP-version: 5.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `workshop2`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `boat`
--

CREATE TABLE IF NOT EXISTS `boat` (
  `boatid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `length` int(10) NOT NULL,
  `ownerMemberFK` varchar(255) NOT NULL,
  `boatTypeFK` int(11) NOT NULL,
  PRIMARY KEY (`boatid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumpning av Data i tabell `boat`
--

INSERT INTO `boat` (`boatid`, `name`, `length`, `ownerMemberFK`, `boatTypeFK`) VALUES
(5, 'testing', 13, '9', 1),
(6, 'min favvo kanot <3', 6, '9', 4),
(7, 'FIREFLY (a flying boat) ', 12, '18', 1),
(14, 'hiro nakamura', 45, '17', 1);

-- --------------------------------------------------------

--
-- Tabellstruktur `boat_type`
--

CREATE TABLE IF NOT EXISTS `boat_type` (
  `typeid` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(12) NOT NULL,
  PRIMARY KEY (`typeid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumpning av Data i tabell `boat_type`
--

INSERT INTO `boat_type` (`typeid`, `name`) VALUES
(1, 'Segelbåt'),
(2, 'Motorseglare'),
(3, 'Motorbåt'),
(4, 'Kajak/Kanot'),
(5, 'Övrigt');

-- --------------------------------------------------------

--
-- Tabellstruktur `member`
--

CREATE TABLE IF NOT EXISTS `member` (
  `memberid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `surname` varchar(150) NOT NULL,
  `personalcn` varchar(12) NOT NULL,
  PRIMARY KEY (`memberid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumpning av Data i tabell `member`
--

INSERT INTO `member` (`memberid`, `name`, `surname`, `personalcn`) VALUES
(9, 'Maria', 'Nygren', 'tjohej'),
(17, 'Annie', 'Minion', '9104220000'),
(18, 'Harry', 'Potter', '8877777777');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
