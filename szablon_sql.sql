-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 05 Kwi 2022, 20:18
-- Wersja serwera: 10.4.19-MariaDB
-- Wersja PHP: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `kazol_reklamacje`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `archive`
--

CREATE TABLE `archive` (
  `id` int(11) NOT NULL,
  `number` varchar(20) NOT NULL,
  `created` date DEFAULT NULL,
  `customer` text NOT NULL,
  `receipt` text NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `object` text NOT NULL,
  `type` varchar(30) NOT NULL,
  `priority` tinytext NOT NULL,
  `status` varchar(20) NOT NULL,
  `term` date NOT NULL,
  `description` text NOT NULL,
  `history` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `files` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `current_entries`
--

CREATE TABLE `current_entries` (
  `id` int(11) NOT NULL,
  `number` varchar(20) NOT NULL,
  `created` date DEFAULT NULL,
  `customer` text NOT NULL,
  `receipt` text NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `object` text NOT NULL,
  `type` varchar(30) NOT NULL,
  `priority` tinytext NOT NULL,
  `status` varchar(20) NOT NULL,
  `term` date NOT NULL,
  `description` text NOT NULL,
  `history` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `files` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user` varchar(80) NOT NULL,
  `password` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `user`, `password`) VALUES
(1, 'aaa', 'bbb');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_settings`
--

CREATE TABLE `user_settings` (
  `enableMails` tinyint(1) DEFAULT 0,
  `mail_register` tinyint(1) DEFAULT 0,
  `mail_type` tinyint(1) NOT NULL DEFAULT 0,
  `mail_priority` tinyint(1) NOT NULL DEFAULT 0,
  `mail_status` tinyint(1) DEFAULT 0,
  `mail_term` tinyint(1) NOT NULL DEFAULT 0,
  `mail_link` tinyint(1) NOT NULL DEFAULT 0,
  `tasks_types` text NOT NULL DEFAULT 'zwrot;gwarancyjne',
  `status_types` text NOT NULL DEFAULT 'przyjęte;w trakcie realizacji;zrealizowane;anulowane',
  `task_period` smallint(6) NOT NULL DEFAULT 7,
  `logo` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `user_settings`
--

INSERT INTO `user_settings` (`enableMails`, `mail_register`, `mail_type`, `mail_priority`, `mail_status`, `mail_term`, `mail_link`, `tasks_types`, `status_types`, `task_period`, `logo`) VALUES
(1, 1, 1, 0, 1, 1, 1, 'zwrot;gwarancyjne', 'przyjęte;w trakcie realizacji;zrealizowane;anulowane', 7, NULL),
(1, 1, 1, 0, 1, 1, 1, 'zwrot;gwarancyjne', 'przyjęte;w trakcie realizacji;zrealizowane;anulowane', 7, NULL);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `archive`
--
ALTER TABLE `archive`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `current_entries`
--
ALTER TABLE `current_entries`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `archive`
--
ALTER TABLE `archive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `current_entries`
--
ALTER TABLE `current_entries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
