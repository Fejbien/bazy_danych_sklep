-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 09 Lis 2022, 09:14
-- Wersja serwera: 10.4.24-MariaDB
-- Wersja PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `shop`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `login` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `is_admin` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `account`
--

INSERT INTO `account` (`id`, `name`, `login`, `password`, `is_admin`) VALUES
(1, 'Fabian', 'fabian', NULL, 1),
(2, 'Joachim', 'nizer', 'caf1a3dfb505ffed0d024130f58c5cfa', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `item`
--

CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `price` double NOT NULL,
  `description` longtext DEFAULT NULL,
  `created_at` date NOT NULL,
  `sold_at` date DEFAULT NULL,
  `seller` int(11) NOT NULL,
  `buyer` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `item`
--

INSERT INTO `item` (`id`, `name`, `price`, `description`, `created_at`, `sold_at`, `seller`, `buyer`) VALUES
(1, 'Obrazek sciany', 40, 'Ladne zdjecie sciany', '2022-11-14', NULL, 1, NULL),
(2, 'Sciana', 3897, 'Cala sciana blokowa', '2022-11-15', '2022-11-16', 2, 1),
(3, 'Deska', 3, 'Deska z drewna', '2022-11-07', NULL, 1, NULL),
(4, 'Monitor', 499, 'Fajny monitor', '2022-11-10', NULL, 1, NULL),
(5, 'Klawiatura', 250, 'Klawa klawiatura', '2022-11-05', NULL, 1, NULL),
(6, 'Monitor lepszy', 499, 'Lepszy monitor', '2022-11-11', NULL, 2, NULL),
(7, 'Komputer', 3499, 'Fajny Komputer', '2022-11-02', NULL, 1, NULL);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`,`seller`),
  ADD KEY `fk_item_account_idx` (`seller`),
  ADD KEY `fk_item_account1_idx` (`buyer`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `fk_item_account` FOREIGN KEY (`seller`) REFERENCES `account` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_item_account1` FOREIGN KEY (`buyer`) REFERENCES `account` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
