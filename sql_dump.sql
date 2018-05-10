-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vytvořeno: Čtv 10. kvě 2018, 10:59
-- Verze serveru: 5.7.21-0ubuntu0.16.04.1
-- Verze PHP: 7.0.28-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `w2final`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `Address`
--

CREATE TABLE `Address` (
  `id` int(11) NOT NULL,
  `street_fk` int(11) DEFAULT NULL,
  `streetNumber` int(11) DEFAULT NULL,
  `city_fk` int(11) DEFAULT NULL,
  `state_fk` int(11) DEFAULT NULL,
  `psc_fk` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struktura tabulky `City`
--

CREATE TABLE `City` (
  `id` int(11) NOT NULL,
  `cityName` varchar(64) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struktura tabulky `NewsleterSubscribers`
--

CREATE TABLE `NewsleterSubscribers` (
  `id` int(11) NOT NULL,
  `user_fk` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struktura tabulky `PSC`
--

CREATE TABLE `PSC` (
  `id` int(11) NOT NULL,
  `pscNumber` int(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struktura tabulky `Route`
--

CREATE TABLE `Route` (
  `id` int(11) NOT NULL,
  `user_fk` int(11) DEFAULT NULL,
  `distance` int(11) DEFAULT NULL,
  `mode_fk` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struktura tabulky `RouteMode`
--

CREATE TABLE `RouteMode` (
  `id` int(11) NOT NULL,
  `mode` varchar(16) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struktura tabulky `Run`
--

CREATE TABLE `Run` (
  `id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `distance` int(11) DEFAULT NULL,
  `route_fk` int(11) DEFAULT NULL,
  `user_fk` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struktura tabulky `School`
--

CREATE TABLE `School` (
  `id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `address_fk` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struktura tabulky `State`
--

CREATE TABLE `State` (
  `id` int(11) NOT NULL,
  `stateName` varchar(64) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struktura tabulky `Street`
--

CREATE TABLE `Street` (
  `id` int(11) NOT NULL,
  `streetName` varchar(64) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struktura tabulky `User`
--

CREATE TABLE `User` (
  `id` int(11) NOT NULL,
  `login` varchar(96) COLLATE utf8_bin NOT NULL,
  `password_salt` varchar(64) COLLATE utf8_bin NOT NULL,
  `password` varchar(64) COLLATE utf8_bin NOT NULL,
  `isActivated` tinyint(1) DEFAULT NULL,
  `email` varchar(64) COLLATE utf8_bin NOT NULL,
  `name` varchar(64) COLLATE utf8_bin DEFAULT NULL,
  `surname` varchar(64) COLLATE utf8_bin DEFAULT NULL,
  `address_fk` int(11) DEFAULT NULL,
  `role_fk` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struktura tabulky `UserActiveRoute`
--

CREATE TABLE `UserActiveRoute` (
  `id` int(11) NOT NULL,
  `user_fk` int(11) DEFAULT NULL,
  `route_fk` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struktura tabulky `UserRole`
--

CREATE TABLE `UserRole` (
  `id` int(11) NOT NULL,
  `Role` varchar(16) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struktura tabulky `VerificatonHash`
--

CREATE TABLE `VerificatonHash` (
  `id` int(11) NOT NULL,
  `hash` varchar(64) COLLATE utf8_bin DEFAULT NULL,
  `user_fk` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `Address`
--
ALTER TABLE `Address`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Address_id_uindex` (`id`),
  ADD KEY `Street_fk` (`street_fk`),
  ADD KEY `City_fk` (`city_fk`),
  ADD KEY `State_fk` (`state_fk`),
  ADD KEY `Psc_fk` (`psc_fk`);

--
-- Klíče pro tabulku `City`
--
ALTER TABLE `City`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `City_id_uindex` (`id`),
  ADD UNIQUE KEY `City_cityName_uindex` (`cityName`);

--
-- Klíče pro tabulku `NewsleterSubscribers`
--
ALTER TABLE `NewsleterSubscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NewsleterSubscribers_id_uindex` (`id`),
  ADD KEY `NewsUser_fk` (`user_fk`);

--
-- Klíče pro tabulku `PSC`
--
ALTER TABLE `PSC`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `PSC_id_uindex` (`id`),
  ADD UNIQUE KEY `PSC_pscNumber_uindex` (`pscNumber`);

--
-- Klíče pro tabulku `Route`
--
ALTER TABLE `Route`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Route_id_uindex` (`id`),
  ADD KEY `Mode_fk` (`mode_fk`),
  ADD KEY `UserRoute_fk` (`user_fk`);

--
-- Klíče pro tabulku `RouteMode`
--
ALTER TABLE `RouteMode`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `RouteMode_id_uindex` (`id`);

--
-- Klíče pro tabulku `Run`
--
ALTER TABLE `Run`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Run_id_uindex` (`id`),
  ADD KEY `RouteRun_fk` (`route_fk`),
  ADD KEY `UserRun_fk` (`user_fk`);

--
-- Klíče pro tabulku `School`
--
ALTER TABLE `School`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `School_id_uindex` (`id`),
  ADD KEY `Address_fk` (`address_fk`);

--
-- Klíče pro tabulku `State`
--
ALTER TABLE `State`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `State_id_uindex` (`id`),
  ADD UNIQUE KEY `State_stateName_uindex` (`stateName`);

--
-- Klíče pro tabulku `Street`
--
ALTER TABLE `Street`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Street_id_uindex` (`id`),
  ADD UNIQUE KEY `Street_streetName_uindex` (`streetName`);

--
-- Klíče pro tabulku `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `User_id_uindex` (`id`),
  ADD KEY `Adress_fk` (`address_fk`),
  ADD KEY `Role_fk` (`role_fk`);

--
-- Klíče pro tabulku `UserActiveRoute`
--
ALTER TABLE `UserActiveRoute`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UserActiveRoute_id_uindex` (`id`),
  ADD KEY `UserActiveRoute_fk` (`user_fk`),
  ADD KEY `ActiveRoute_fk` (`route_fk`);

--
-- Klíče pro tabulku `UserRole`
--
ALTER TABLE `UserRole`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UserRole_id_uindex` (`id`);

--
-- Klíče pro tabulku `VerificatonHash`
--
ALTER TABLE `VerificatonHash`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `VerificatonHash_id_uindex` (`id`),
  ADD KEY `User_fk` (`user_fk`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `Address`
--
ALTER TABLE `Address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pro tabulku `City`
--
ALTER TABLE `City`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pro tabulku `NewsleterSubscribers`
--
ALTER TABLE `NewsleterSubscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pro tabulku `PSC`
--
ALTER TABLE `PSC`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pro tabulku `Route`
--
ALTER TABLE `Route`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pro tabulku `RouteMode`
--
ALTER TABLE `RouteMode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pro tabulku `Run`
--
ALTER TABLE `Run`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pro tabulku `School`
--
ALTER TABLE `School`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pro tabulku `State`
--
ALTER TABLE `State`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pro tabulku `Street`
--
ALTER TABLE `Street`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pro tabulku `User`
--
ALTER TABLE `User`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pro tabulku `UserActiveRoute`
--
ALTER TABLE `UserActiveRoute`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pro tabulku `UserRole`
--
ALTER TABLE `UserRole`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pro tabulku `VerificatonHash`
--
ALTER TABLE `VerificatonHash`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `Address`
--
ALTER TABLE `Address`
  ADD CONSTRAINT `City_fk` FOREIGN KEY (`city_fk`) REFERENCES `City` (`id`),
  ADD CONSTRAINT `Psc_fk` FOREIGN KEY (`psc_fk`) REFERENCES `PSC` (`id`),
  ADD CONSTRAINT `State_fk` FOREIGN KEY (`state_fk`) REFERENCES `State` (`id`),
  ADD CONSTRAINT `Street_fk` FOREIGN KEY (`street_fk`) REFERENCES `Street` (`id`);

--
-- Omezení pro tabulku `NewsleterSubscribers`
--
ALTER TABLE `NewsleterSubscribers`
  ADD CONSTRAINT `NewsUser_fk` FOREIGN KEY (`user_fk`) REFERENCES `User` (`id`);

--
-- Omezení pro tabulku `Route`
--
ALTER TABLE `Route`
  ADD CONSTRAINT `Mode_fk` FOREIGN KEY (`mode_fk`) REFERENCES `RouteMode` (`id`),
  ADD CONSTRAINT `UserRoute_fk` FOREIGN KEY (`user_fk`) REFERENCES `User` (`id`);

--
-- Omezení pro tabulku `Run`
--
ALTER TABLE `Run`
  ADD CONSTRAINT `RouteRun_fk` FOREIGN KEY (`route_fk`) REFERENCES `Route` (`id`),
  ADD CONSTRAINT `UserRun_fk` FOREIGN KEY (`user_fk`) REFERENCES `User` (`id`);

--
-- Omezení pro tabulku `School`
--
ALTER TABLE `School`
  ADD CONSTRAINT `Address_fk` FOREIGN KEY (`address_fk`) REFERENCES `Address` (`id`);

--
-- Omezení pro tabulku `User`
--
ALTER TABLE `User`
  ADD CONSTRAINT `Adress_fk` FOREIGN KEY (`address_fk`) REFERENCES `Address` (`id`),
  ADD CONSTRAINT `Role_fk` FOREIGN KEY (`role_fk`) REFERENCES `UserRole` (`id`);

--
-- Omezení pro tabulku `UserActiveRoute`
--
ALTER TABLE `UserActiveRoute`
  ADD CONSTRAINT `ActiveRoute_fk` FOREIGN KEY (`route_fk`) REFERENCES `Route` (`id`),
  ADD CONSTRAINT `UserActiveRoute_fk` FOREIGN KEY (`user_fk`) REFERENCES `User` (`id`);

--
-- Omezení pro tabulku `VerificatonHash`
--
ALTER TABLE `VerificatonHash`
  ADD CONSTRAINT `User_fk` FOREIGN KEY (`user_fk`) REFERENCES `User` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
