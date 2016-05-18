-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 17. Mai 2016 um 11:45
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
(19, 1, 1514242800, '2. Weichnatschtag'),
(21, 1, 1464213600, 'FrÃ¶hlich'),
(22, 1, 1452034800, 'Heilige drei KÃ¶nige');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `holiday`
--

DROP TABLE IF EXISTS `holiday`;
CREATE TABLE `holiday` (
  `id` int(11) NOT NULL,
  `employeeID` int(11) NOT NULL,
  `processedByID` int(11) DEFAULT NULL,
  `startdate` int(11) NOT NULL,
  `enddate` int(11) NOT NULL,
  `submitdate` int(11) NOT NULL,
  `processeddate` int(11) DEFAULT NULL,
  `note` tinytext,
  `response_note` tinytext,
  `extdata` mediumblob,
  `type` char(1) NOT NULL,
  `status` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `holiday`
--

INSERT INTO `holiday` (`id`, `employeeID`, `processedByID`, `startdate`, `enddate`, `submitdate`, `processeddate`, `note`, `response_note`, `extdata`, `type`, `status`) VALUES
(30, 1, 1, 1466373600, 1466892000, 1462875045, 1463478038, 'Kreta', '', 0x613a333a7b733a333a22736170223b733a313a2231223b733a333a22757565223b4e3b733a333a226d6170223b733a313a2231223b7d, 'H', 1),
(31, 1, 0, 1471816800, 1472335200, 1462875360, NULL, 'Nordsee mit den Kindern', NULL, NULL, 'H', 0),
(35, 1, 1, 1467583200, 1468706400, 1463036477, 1463120796, 'Blubb', NULL, NULL, 'H', 2),
(52, 2, 0, 1463954400, 1464472800, 1463052200, NULL, '', NULL, NULL, 'H', 0),
(57, 1, 0, 1479078000, 1479596400, 1463084910, NULL, '', 'Klappt es?', NULL, 'H', 2),
(58, 1, 0, 1479250800, 1479337200, 1463084958, NULL, '', '', NULL, 'I', 3);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `holiday_custom`
--

DROP TABLE IF EXISTS `holiday_custom`;
CREATE TABLE `holiday_custom` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `start` int(11) NOT NULL,
  `duration` int(5) NOT NULL,
  `description` mediumtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `holiday_custom`
--

INSERT INTO `holiday_custom` (`id`, `userID`, `start`, `duration`, `description`) VALUES
(6, 1, 1460325600, 12, 'Urlaub'),
(7, 1, 1459720800, 3, 'BrÃ¼ckentage'),
(8, 1, 1463349600, 3, 'Unternehmung Arbeit'),
(9, 1, 1465768800, 2, 'Sonderurlaub'),
(10, 1, 1470607200, 21, 'Ferien');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mhy`
--

DROP TABLE IF EXISTS `mhy`;
CREATE TABLE `mhy` (
  `employeeID` int(11) NOT NULL,
  `maxHoliday` int(11) NOT NULL,
  `year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Max Holiday per year for each user';

--
-- Daten für Tabelle `mhy`
--

INSERT INTO `mhy` (`employeeID`, `maxHoliday`, `year`) VALUES
(1, 30, 2016),
(1, 30, 2017),
(2, 30, 2016),
(2, 30, 2017),
(3, 30, 2016),
(3, 30, 2017),
(4, 30, 2016),
(4, 30, 2017),
(5, 30, 2016),
(5, 30, 2017),
(6, 30, 2016),
(6, 30, 2017),
(7, 30, 2016),
(7, 30, 2017),
(8, 30, 2016),
(8, 30, 2017),
(9, 30, 2016),
(9, 30, 2017),
(10, 30, 2016),
(10, 30, 2017),
(11, 30, 2016),
(11, 30, 2017),
(12, 30, 2016),
(12, 30, 2017),
(16, 30, 2016),
(16, 30, 2017),
(20, 30, 2016),
(20, 30, 2017);

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
('k8t7jmjk9k6hd372tblhrr27v2', 'id|s:1:"1";firstname|s:4:"Timo";lastname|s:10:"Stepputtis";email|s:22:"Timo.Stepputtis@gmx.de";level|s:1:"3";loggedIN|b:1;timestamp|s:10:"1463478086";', 1463478091);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `staffid` int(11) NOT NULL,
  `createdate` int(11) NOT NULL,
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

INSERT INTO `users` (`id`, `staffid`, `createdate`, `firstname`, `lastname`, `username`, `password`, `email`, `level`) VALUES
(1, 500000, 1463034999, 'Timo', 'Stepputtis', 'tstepputtis', 'c642c20448ae67d1e27f499d9fcfdc3058641519', 'Timo.Stepputtis@gmx.de', 3),
(2, 500001, 1463034999, 'Heinzi', 'Mustermann', 'heinz', '023087601ffa058f24441d227962c1f9b15aa85d', 'heinz@gmx.de', 1),
(3, 500002, 1463034999, 'Harry', 'Beinfurt', 'harry', 'b8cf35b1e4d9c6ac9f02c27e32d5341848d3a272', 'harry@gmx.de', 1),
(4, 500003, 1463034999, 'Tim', 'Rohrbruch', 'timmy', 'c43d74a74283c11cf6002b023ca8aab9851a2b68', 'timmy@gmx.de', 1),
(5, 500004, 1463034999, 'Karl', 'Kleisterbaum', 'karlito', '2b65529da7df79cd70da9a8ceb7a2a2ea6800993', 'karl@gmx.de', 1),
(6, 500005, 1463034999, 'Phillip', 'Becker', 'phillip', 'a1875a5070b9a6cf28e90f6339f27796bee73922', 'phillip@gmx.de', 1),
(7, 500006, 1463034999, 'Andreas', 'Maier', 'andreas', 'f99d9af5fa25aa965419fc507fd7e71b788bdd3a', 'andreas@gmx.de', 1),
(8, 500007, 1463034999, 'Hannelore', 'Geisner', 'hannelore', '251e21782378011e81f08eac4a385f4e35ac2e34', 'hannelore@web.de', 1),
(9, 500008, 1463034999, 'Gisela', 'Geier', 'gisela', '4f09c93b28559bdbbe59cc30777ce82e0915f716', 'gisela@gmail.com', 1),
(10, 500009, 1463034999, 'Alexandra', 'Kraft', 'alexandra', 'd11b93c86b976997fec1026436201d32b5d0efa6', 'alex.andra@yahoo.com', 1),
(11, 500010, 1463034999, 'Olliver', 'Gunst', 'olli', 'b04225b21bdde516eb1b7d30fc28e9cd6a44b8af', 'olli.p@t-online.de', 1),
(12, 500011, 1463034999, 'Ralf', 'Zacherl', 'ralf', 'e72f4fe7d3f27849dc7d171935ec6db7541dc211', 'ralfz@rtl2.de', 1),
(16, 500012, 1463034999, 'Bobby', 'Brown', 'bobby', '6b81eda5198ddc08891a5d434616aa4afb2c02b2', 'bobby@bobtail.com', 1),
(20, 500018, 1463093508, 'Test', 'You', 'testu', '2cbbd70f3f734583e122b9c37f2d5440d84bf3f1', 'testu@hubble.com', 1);

--
-- Trigger `users`
--
DROP TRIGGER IF EXISTS `clear_data`;
DELIMITER $$
CREATE TRIGGER `clear_data` AFTER DELETE ON `users` FOR EACH ROW BEGIN
DELETE FROM mhy WHERE employeeID = OLD.id;
DELETE FROM holiday WHERE employeeID = OLD.id;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `create_createdate_insert`;
DELIMITER $$
CREATE TRIGGER `create_createdate_insert` BEFORE INSERT ON `users` FOR EACH ROW SET new.createdate = UNIX_TIMESTAMP(NOW())
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `create_mhy_after_insert`;
DELIMITER $$
CREATE TRIGGER `create_mhy_after_insert` AFTER INSERT ON `users` FOR EACH ROW INSERT INTO mhy VALUES (NEW.id, 30, YEAR(CURDATE()))
$$
DELIMITER ;

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
-- Indizes für die Tabelle `holiday_custom`
--
ALTER TABLE `holiday_custom`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `start` (`start`);

--
-- Indizes für die Tabelle `mhy`
--
ALTER TABLE `mhy`
  ADD UNIQUE KEY `employeeID` (`employeeID`,`year`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT für Tabelle `holiday`
--
ALTER TABLE `holiday`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT für Tabelle `holiday_custom`
--
ALTER TABLE `holiday_custom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
DELIMITER $$
--
-- Ereignisse
--
DROP EVENT IF EXISTS `Add_maxHoliday_Year`$$
CREATE DEFINER=`root`@`localhost` EVENT `Add_maxHoliday_Year` ON SCHEDULE EVERY 1 YEAR STARTS '2016-01-01 00:00:00' ON COMPLETION PRESERVE ENABLE DO BEGIN
SET @curYear = YEAR(CURRENT_DATE);
INSERT IGNORE INTO mhy
SELECT id, 30, @curYear FROM users;
INSERT IGNORE INTO mhy
SELECT id, 30, @curYear+1 FROM users;
END$$

DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
