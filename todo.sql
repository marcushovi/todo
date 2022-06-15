-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Hostiteľ: 127.0.0.1
-- Čas generovania: Št 12.Mar 2020, 18:36
-- Verzia serveru: 10.4.8-MariaDB
-- Verzia PHP: 7.3.11

SET
SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET
AUTOCOMMIT = 0;
START TRANSACTION;
SET
time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáza: `todo`
--

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `tasks`
--

CREATE TABLE `tasks`
(
    `ID`          int(11) UNSIGNED NOT NULL,
    `IdOfUser`    int(11) NOT NULL,
    `title`       varchar(50) NOT NULL,
    `description` varchar(500) DEFAULT NULL,
    `fileName`    varchar(50)  DEFAULT NULL,
    `deadline`    datetime     DEFAULT NULL,
    `priority`    varchar(25)  DEFAULT NULL,
    `isComplete`  int(1) NOT NULL,
    `CreatedAt`   datetime    NOT NULL,
    `UpdatedAt`   datetime    NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `user`
--

CREATE TABLE `user`
(
    `ID`        int(10) UNSIGNED NOT NULL,
    `firstName` varchar(200) NOT NULL,
    `lastName`  varchar(200) NOT NULL,
    `email`     varchar(400) NOT NULL,
    `password`  varchar(64)  NOT NULL,
    `createdAt` datetime     NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Kľúče pre exportované tabuľky
--

--
-- Indexy pre tabuľku `tasks`
--
ALTER TABLE `tasks`
    ADD PRIMARY KEY (`ID`);

--
-- Indexy pre tabuľku `user`
--
ALTER TABLE `user`
    ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT pre exportované tabuľky
--

--
-- AUTO_INCREMENT pre tabuľku `tasks`
--
ALTER TABLE `tasks`
    MODIFY `ID` int (11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=426;

--
-- AUTO_INCREMENT pre tabuľku `user`
--
ALTER TABLE `user`
    MODIFY `ID` int (10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
