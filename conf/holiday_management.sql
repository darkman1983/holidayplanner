-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 26. Apr 2016 um 13:28
-- Server-Version: 10.1.9-MariaDB
-- PHP-Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `holiday_management`
--
CREATE DATABASE IF NOT EXISTS `holiday_management` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `holiday_management`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `feastdays`
--

DROP TABLE IF EXISTS `feastdays`;
CREATE TABLE `feastdays` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `start` int(11) NOT NULL,
  `duration` int(5) NOT NULL,
  `description` tinytext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `feastdays`
--

INSERT INTO `feastdays` (`id`, `userID`, `start`, `duration`, `description`) VALUES
(1, 1, 1451602800, 1, 'Neujahr'),
(2, 1, 1458860400, 1, 'Karfreitag'),
(3, 1, 1459116000, 1, 'Ostermontag'),
(4, 1, 1462053600, 1, 'Tag der Arbeit'),
(5, 1, 1462399200, 1, 'Christi Himmefahrt'),
(6, 1, 1463349600, 1, 'Pfingstmontag'),
(7, 1, 1475445600, 1, 'Tag der Deutschen Einheit'),
(8, 1, 1482620400, 1, '1. Weihnachtstag'),
(9, 1, 1482706800, 1, '2. Weihnachtstag');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `holiday`
--

DROP TABLE IF EXISTS `holiday`;
CREATE TABLE `holiday` (
  `id` int(11) NOT NULL,
  `employeeID` int(11) NOT NULL,
  `start` int(11) NOT NULL,
  `duration` int(5) NOT NULL,
  `note` tinytext CHARACTER SET armscii8,
  `response_note` tinytext,
  `type` char(1) NOT NULL,
  `approved` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `data` mediumtext NOT NULL,
  `timestamp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `sessions`
--

INSERT INTO `sessions` (`id`, `data`, `timestamp`) VALUES
('k8t7jmjk9k6hd372tblhrr27v2', 'timestamp|s:10:"1461670074";id|s:1:"1";firstname|s:4:"Timo";lastname|s:10:"Stepputtis";email|s:22:"Timo.Stepputtis@gmx.de";level|s:1:"3";loggedIN|b:1;', 1461670075);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `username` varchar(80) NOT NULL,
  `password` varchar(40) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `level` int(1) NOT NULL DEFAULT '0' COMMENT '0 = Initial 1 = Normal user 2 = Can approve holiday 3 = Can create users'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`, `email`, `level`) VALUES
(1, 'Timo', 'Stepputtis', 'tstepputtis', '9c402c4806d33430b781492227a47adf30624e9c', 'Timo.Stepputtis@gmx.de', 3),
(2, 'Heinz', 'Mustermann', 'heinz', '023087601ffa058f24441d227962c1f9b15aa85d', 'heinz@gmx.de', 1),
(3, 'Harry', 'Beinfurt', 'harry', 'b8cf35b1e4d9c6ac9f02c27e32d5341848d3a272', 'harry@gmx.de', 1),
(4, 'Tim', 'Rohrbruch', 'timmy', 'c43d74a74283c11cf6002b023ca8aab9851a2b68', 'timmy@gmx.de', 1),
(5, 'Karl', 'Kleisterbaum', 'karlito', '2b65529da7df79cd70da9a8ceb7a2a2ea6800993', 'karl@gmx.de', 1),
(6, 'Phillip', 'Becker', 'phillip', 'a1875a5070b9a6cf28e90f6339f27796bee73922', 'phillip@gmx.de', 1),
(7, 'Andreas', 'Maier', 'andreas', 'f99d9af5fa25aa965419fc507fd7e71b788bdd3a', 'andreas@gmx.de', 1),
(8, 'Hannelore', 'Geisner', 'hannelore', '251e21782378011e81f08eac4a385f4e35ac2e34', 'hannelore@web.de', 1),
(9, 'Gisela', 'Geier', 'gisela', '4f09c93b28559bdbbe59cc30777ce82e0915f716', 'gisela@gmail.com', 1),
(10, 'Alexandra', 'Kraft', 'alexandra', 'd11b93c86b976997fec1026436201d32b5d0efa6', 'alex.andra@yahoo.com', 1),
(11, 'Olliver', 'Gunst', 'olli', 'b04225b21bdde516eb1b7d30fc28e9cd6a44b8af', 'olli.p@t-online.de', 1),
(12, 'Ralf', 'Zacherl', 'ralf', 'e72f4fe7d3f27849dc7d171935ec6db7541dc211', 'ralfz@rtl2.de', 1);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `feastdays`
--
ALTER TABLE `feastdays`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `start` (`start`);

--
-- Indizes für die Tabelle `holiday`
--
ALTER TABLE `holiday`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `feastdays`
--
ALTER TABLE `feastdays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT für Tabelle `holiday`
--
ALTER TABLE `holiday`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
