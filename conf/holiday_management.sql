-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 20. Apr 2016 um 15:41
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
-- Tabellenstruktur für Tabelle `holiday`
--

DROP TABLE IF EXISTS `holiday`;
CREATE TABLE `holiday` (
  `id` int(11) NOT NULL,
  `employeeID` int(11) NOT NULL,
  `start` int(11) NOT NULL,
  `duration` int(5) NOT NULL,
  `type` char(1) NOT NULL,
  `approved` tinyint(1) DEFAULT NULL
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
('k8t7jmjk9k6hd372tblhrr27v2', 'id|s:1:"1";firstname|s:4:"Timo";lastname|s:10:"Stepputtis";email|s:22:"Timo.Stepputtis@gmx.de";level|s:1:"3";loggedIN|b:1;', 1461159580);

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
(1, 'Timo', 'Stepputtis', 'tstepputtis', '9c402c4806d33430b781492227a47adf30624e9c', 'Timo.Stepputtis@gmx.de', 3);

--
-- Indizes der exportierten Tabellen
--

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
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `holiday`
--
ALTER TABLE `holiday`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
