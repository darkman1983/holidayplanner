-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 02. Mai 2016 um 14:40
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

DELIMITER $$
--
-- Funktionen
--
DROP FUNCTION IF EXISTS `getNumDays`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `getNumDays` (`start_date` INT, `end_date` INT, `whatToGet` INT) RETURNS INT(11) READS SQL DATA
    COMMENT 'Parameters start_date and end_date as UNIX_TIMESTAMP'
BEGIN
DECLARE sd VARCHAR(11);
DECLARE ed VARCHAR(11);
DECLARE fd INT;
DECLARE ws VARCHAR(11);
DECLARE we INT;
DECLARE td INT;
DECLARE md INT;

SET sd = FROM_UNIXTIME(start_date, "%Y-%m-%d");
SET ed = FROM_UNIXTIME(end_date, "%Y-%m-%d");
SET fd = (SELECT COUNT(*) FROM feastdays WHERE FROM_UNIXTIME(date, "%Y-%m-%d") BETWEEN sd AND ed AND WEEKDAY(FROM_UNIXTIME(date, "%Y-%m-%d")) NOT IN(5,6));
SET ws = sd;
SET we = 0;
SET td = 0;

WHILE ws <= ed DO
IF WEEKDAY(ws) IN (5,6) THEN
SET we = we + 1;
END IF;
SET ws = DATE_ADD(ws, INTERVAL 1 DAY);
END WHILE;

CASE
WHEN whatToGet = 1 THEN
SET md = we;
WHEN whatToGet = 2 THEN
SET md = fd;
WHEN whatToGet = 3 THEN
SET md = fd + we;
ELSE
SET md = 0;
END CASE;

SET td = (SELECT (DATEDIFF(ed, sd) + 1) - md AS Days);

RETURN td;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `feastdays`
--

DROP TABLE IF EXISTS `feastdays`;
CREATE TABLE `feastdays` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `description` tinytext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `feastdays`
--

INSERT INTO `feastdays` (`id`, `userID`, `date`, `description`) VALUES
(1, 1, 1451602800, 'Neujahr'),
(2, 1, 1458860400, 'Karfreitag'),
(3, 1, 1459116000, 'Ostermontag'),
(4, 1, 1462053600, 'Tag der Arbeit'),
(5, 1, 1462399200, 'Christi Himmefahrt'),
(6, 1, 1463349600, 'Pfingstmontag'),
(7, 1, 1475445600, 'Tag der Deutschen Einheit'),
(8, 1, 1482620400, '1. Weihnachtstag'),
(9, 1, 1482706800, '2. Weihnachtstag'),
(11, 1, 1492120800, 'Karfreitag'),
(12, 1, 1492380000, 'Ostermontag'),
(13, 1, 1493589600, 'Tag der Arbeit'),
(14, 1, 1495663200, 'Christi Himmelfahrt'),
(15, 1, 1496613600, 'Pfingstmontag'),
(16, 1, 1506981600, 'Tag der Deutschen Einheit'),
(17, 1, 1509404400, 'Reformationstag - HH'),
(18, 1, 1514156400, '1. Weichnatchstag'),
(19, 1, 1514242800, '2. Weichnatschtag');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `holiday`
--

DROP TABLE IF EXISTS `holiday`;
CREATE TABLE `holiday` (
  `id` int(11) NOT NULL,
  `employeeID` int(11) NOT NULL,
  `startdate` int(11) NOT NULL,
  `enddate` int(11) NOT NULL,
  `submitdate` int(11) NOT NULL,
  `note` tinytext CHARACTER SET armscii8,
  `response_note` tinytext,
  `type` char(1) NOT NULL,
  `approved` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `holiday`
--

INSERT INTO `holiday` (`id`, `employeeID`, `startdate`, `enddate`, `submitdate`, `note`, `response_note`, `type`, `approved`) VALUES
(9, 1, 1491948000, 1492380000, 1461835864, 'Testurlaub', NULL, 'H', 0);

--
-- Trigger `holiday`
--
DROP TRIGGER IF EXISTS `delete_trigger`;
DELIMITER $$
CREATE TRIGGER `delete_trigger` AFTER DELETE ON `holiday` FOR EACH ROW IF OLD.type = 'H' THEN
UPDATE users SET remainingHoliday = remainingHoliday + (SELECT getNumDays(OLD.startdate, OLD.enddate, 3)) WHERE  OLD.employeeID = id;
ELSE
UPDATE users SET remainingHoliday = remainingHoliday - (SELECT getNumDays(OLD.startdate, OLD.enddate, 3)) WHERE  OLD.employeeID = id;
END IF
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `insert_trigger`;
DELIMITER $$
CREATE TRIGGER `insert_trigger` AFTER INSERT ON `holiday` FOR EACH ROW IF NEW.type = 'H' THEN
UPDATE users SET remainingHoliday = remainingHoliday - (SELECT getNumDays(NEW.startdate, NEW.enddate, 3)) WHERE  NEW.employeeID = id;
ELSE
UPDATE users SET remainingHoliday = remainingHoliday + (SELECT getNumDays(NEW.startdate, NEW.enddate, 3)) WHERE  NEW.employeeID = id;
END IF
$$
DELIMITER ;

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
('k8t7jmjk9k6hd372tblhrr27v2', '', 1462191683);

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
  `maxHoliday` int(2) DEFAULT '30',
  `remainingHoliday` int(2) DEFAULT '30',
  `level` int(1) NOT NULL DEFAULT '0' COMMENT '0 = Initial 1 = Normal user 2 = Can approve holiday 3 = Can create users'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`, `email`, `maxHoliday`, `remainingHoliday`, `level`) VALUES
(1, 'Timo', 'Stepputtis', 'tstepputtis', '9c402c4806d33430b781492227a47adf30624e9c', 'Timo.Stepputtis@gmx.de', 30, 28, 3),
(2, 'Heinz', 'Mustermann', 'heinz', '023087601ffa058f24441d227962c1f9b15aa85d', 'heinz@gmx.de', 30, 30, 1),
(3, 'Harry', 'Beinfurt', 'harry', 'b8cf35b1e4d9c6ac9f02c27e32d5341848d3a272', 'harry@gmx.de', 30, 30, 1),
(4, 'Tim', 'Rohrbruch', 'timmy', 'c43d74a74283c11cf6002b023ca8aab9851a2b68', 'timmy@gmx.de', 30, 30, 1),
(5, 'Karl', 'Kleisterbaum', 'karlito', '2b65529da7df79cd70da9a8ceb7a2a2ea6800993', 'karl@gmx.de', 30, 30, 1),
(6, 'Phillip', 'Becker', 'phillip', 'a1875a5070b9a6cf28e90f6339f27796bee73922', 'phillip@gmx.de', 30, 30, 1),
(7, 'Andreas', 'Maier', 'andreas', 'f99d9af5fa25aa965419fc507fd7e71b788bdd3a', 'andreas@gmx.de', 30, 30, 1),
(8, 'Hannelore', 'Geisner', 'hannelore', '251e21782378011e81f08eac4a385f4e35ac2e34', 'hannelore@web.de', 30, 30, 1),
(9, 'Gisela', 'Geier', 'gisela', '4f09c93b28559bdbbe59cc30777ce82e0915f716', 'gisela@gmail.com', 30, 30, 1),
(10, 'Alexandra', 'Kraft', 'alexandra', 'd11b93c86b976997fec1026436201d32b5d0efa6', 'alex.andra@yahoo.com', 30, 30, 1),
(11, 'Olliver', 'Gunst', 'olli', 'b04225b21bdde516eb1b7d30fc28e9cd6a44b8af', 'olli.p@t-online.de', 30, 30, 1),
(12, 'Ralf', 'Zacherl', 'ralf', 'e72f4fe7d3f27849dc7d171935ec6db7541dc211', 'ralfz@rtl2.de', 30, 30, 1);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `feastdays`
--
ALTER TABLE `feastdays`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `start` (`date`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT für Tabelle `holiday`
--
ALTER TABLE `holiday`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
DELIMITER $$
--
-- Ereignisse
--
DROP EVENT `update_remainingHoliday`$$
CREATE DEFINER=`root`@`localhost` EVENT `update_remainingHoliday` ON SCHEDULE EVERY 1 YEAR STARTS '2016-01-01 00:00:00' ON COMPLETION PRESERVE ENABLE DO UPDATE users SET remainingHoliday = remainingHoliday + maxHoliday$$

DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
