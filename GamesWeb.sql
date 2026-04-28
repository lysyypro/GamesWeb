-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 23, 2026 at 10:51 PM
-- Wersja serwera: 10.4.28-MariaDB
-- Wersja PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `GamesWeb`

CREATE DATABASE IF NOT EXISTS `GamesWeb` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `GamesWeb`;
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Casting`
--

CREATE TABLE `Casting` (
  `id` int(11) NOT NULL,
  `character_id` int(11) NOT NULL,
  `performer_id` int(11) NOT NULL,
  `role_type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Casting`
--

INSERT INTO `Casting` (`id`, `character_id`, `performer_id`, `role_type`) VALUES
(3, 7, 4, 'both'),
(4, 8, 5, 'both'),
(5, 9, 6, 'both'),
(12, 19, 11, 'both'),
(13, 20, 12, 'both'),
(14, 21, 13, 'both'),
(15, 22, 14, 'both'),
(16, 25, 15, 'both'),
(17, 26, 16, 'both');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Characters`
--

CREATE TABLE `Characters` (
  `id` int(11) NOT NULL,
  `title_id` int(11) NOT NULL,
  `character_name` varchar(150) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Characters`
--

INSERT INTO `Characters` (`id`, `title_id`, `character_name`, `type`, `description`) VALUES
(7, 3, 'Michael De Santa', 'protagonist', 'A retired bank robber pulled back into crime.'),
(8, 3, 'Franklin Clinton', 'protagonist', 'A young hustler looking for bigger opportunities.'),
(9, 3, 'Trevor Philips', 'protagonist', 'An unhinged criminal and Michael\'s old partner.'),
(19, 7, 'Jodie Holmes', 'protagonist', 'A young woman psychically linked to a supernatural entity.'),
(20, 7, 'Nathan Dawkins', 'supporting', 'DPA scientist specializing in paranormal activity.'),
(21, 8, 'Kratos', 'protagonist', 'The Ghost of Sparta, now a father navigating Norse mythology.'),
(22, 8, 'Atreus', 'protagonist', 'Kratos\'s son, learning his true identity as Loki.'),
(23, 8, 'Odin', 'antagonist', 'The Allfather of the Norse gods, manipulative and ruthless.'),
(24, 8, 'Thor', 'antagonist', 'God of Thunder and enforcer of Odin\'s will.'),
(25, 9, 'Arthur Morgan', 'protagonist', 'A seasoned outlaw and loyal member of the Van der Linde gang.'),
(26, 9, 'Dutch van der Linde', 'supporting', 'Charismatic but increasingly unstable gang leader.'),
(27, 9, 'John Marston', 'supporting', 'A fellow gang member whose story continues in the first game.');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Critiques`
--

CREATE TABLE `Critiques` (
  `id` int(11) NOT NULL,
  `title_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `score` int(11) DEFAULT NULL CHECK (`score` between 1 and 10),
  `content` text DEFAULT NULL,
  `added_at` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Developers`
--

CREATE TABLE `Developers` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `country` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Developers`
--

INSERT INTO `Developers` (`id`, `name`, `country`) VALUES
(1, 'CD Projekt RED', 'Poland'),
(2, 'Rockstar Games', 'USA'),
(4, 'Quantic Dream', 'France'),
(5, 'Santa Monica Studio', 'USA');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Genres`
--

CREATE TABLE `Genres` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Genres`
--

INSERT INTO `Genres` (`id`, `name`, `description`) VALUES
(1, 'RPG', 'Role-playing games with deep story and character progression'),
(2, 'Action-Adventure', 'Fast-paced games with exploration and story'),
(3, 'Open World', 'Huge sandbox games with free exploration'),
(4, 'Interactive Drama', 'Story-driven games with heavy player choices'),
(6, 'RPG', 'Role-playing games with deep story and character progression'),
(7, 'Action-Adventure', 'Fast-paced games with exploration and story'),
(8, 'Open World', 'Huge sandbox games with free exploration'),
(9, 'Interactive Drama', 'Story-driven games with heavy player choices');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Performers`
--

CREATE TABLE `Performers` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `birth_date` date DEFAULT NULL,
  `nationality` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Performers`
--

INSERT INTO `Performers` (`id`, `first_name`, `last_name`, `birth_date`, `nationality`) VALUES
(1, 'Doug', 'Cockle', '1971-01-05', 'American'),
(4, 'Ned', 'Luke', '1959-01-01', 'American'),
(5, 'Shawn', 'Fonteno', '1970-01-01', 'American'),
(6, 'Steven', 'Ogg', '1973-09-03', 'Canadian'),
(7, 'Young', 'Maylay', '1979-06-01', 'American'),
(8, 'Jesse', 'Williams', '1981-08-05', 'American'),
(9, 'Valorie', 'Curry', '1986-02-12', 'American'),
(10, 'Bryan', 'Dechart', '1987-06-21', 'American'),
(11, 'Elliot\r\n', 'Page', '1987-02-21', 'Canadian'),
(12, 'Willem', 'Dafoe', '1955-07-22', 'American'),
(13, 'Christopher', 'Judge', '1964-10-13', 'American'),
(14, 'Sunny', 'Suljic', '2005-08-10', 'American'),
(15, 'Roger', 'Clark', '1980-11-05', 'American'),
(16, 'Benjamin', 'Byron Davis', '1966-01-01', 'American');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Titles`
--

CREATE TABLE `Titles` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `release_year` int(11) DEFAULT NULL,
  `genre_id` int(11) DEFAULT NULL,
  `developer_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `avg_score` decimal(3,1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Titles`
--

INSERT INTO `Titles` (`id`, `title`, `release_year`, `genre_id`, `developer_id`, `description`, `avg_score`) VALUES
(3, 'GTA V', 2013, 3, 2, 'Three criminals pull off heists across the city of Los Santos.', 9.5),
(7, 'Beyond: Two Souls', 2013, 4, 4, 'Jodie Holmes is connected to a supernatural entity named Aiden her whole life.', 8.2),
(8, 'God of War: Ragnarok', 2022, 2, 5, 'Kratos and Atreus must face the consequences of their actions as Ragnarok approaches.', 9.5),
(9, 'Red Dead Redemption 2', 2018, 3, 2, 'Arthur Morgan and the Van der Linde gang struggle to survive in a changing America.', 9.8);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Users`
--

CREATE TABLE `Users` (
  `id` int(11) NOT NULL,
  `login` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `registered_at` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`id`, `login`, `email`, `password`, `avatar`, `registered_at`) VALUES
(14, 'kaja', 'dhfciusjbdfc@gmail.com', '$2y$10$0ftcBMz4qNMh5H1WaIGNEuTUPiAvSNGWBlZJ3ManuzetDPhlRM3Cu', NULL, '2026-04-13'),
(15, 'a', 'a@gmail.com', '$2y$10$Jv2B4CUPEJ.jydFXvbwQlOtFWn88xAQyBF6QPj6LbAth30vn/C6lG', NULL, '2026-04-21');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `Casting`
--
ALTER TABLE `Casting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `character_id` (`character_id`,`performer_id`),
  ADD KEY `performer_id` (`performer_id`);

--
-- Indeksy dla tabeli `Characters`
--
ALTER TABLE `Characters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `title_id` (`title_id`);

--
-- Indeksy dla tabeli `Critiques`
--
ALTER TABLE `Critiques`
  ADD PRIMARY KEY (`id`),
  ADD KEY `title_id` (`title_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeksy dla tabeli `Developers`
--
ALTER TABLE `Developers`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `Genres`
--
ALTER TABLE `Genres`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `Performers`
--
ALTER TABLE `Performers`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `Titles`
--
ALTER TABLE `Titles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `genre_id` (`genre_id`,`developer_id`),
  ADD KEY `developer_id` (`developer_id`);

--
-- Indeksy dla tabeli `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Casting`
--
ALTER TABLE `Casting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `Characters`
--
ALTER TABLE `Characters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `Critiques`
--
ALTER TABLE `Critiques`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `Developers`
--
ALTER TABLE `Developers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `Genres`
--
ALTER TABLE `Genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `Performers`
--
ALTER TABLE `Performers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `Titles`
--
ALTER TABLE `Titles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Casting`
--
ALTER TABLE `Casting`
  ADD CONSTRAINT `casting_ibfk_1` FOREIGN KEY (`character_id`) REFERENCES `Characters` (`id`),
  ADD CONSTRAINT `casting_ibfk_2` FOREIGN KEY (`performer_id`) REFERENCES `Performers` (`id`);

--
-- Constraints for table `Characters`
--
ALTER TABLE `Characters`
  ADD CONSTRAINT `characters_ibfk_1` FOREIGN KEY (`title_id`) REFERENCES `Titles` (`id`);

--
-- Constraints for table `Critiques`
--
ALTER TABLE `Critiques`
  ADD CONSTRAINT `critiques_ibfk_1` FOREIGN KEY (`title_id`) REFERENCES `Titles` (`id`),
  ADD CONSTRAINT `critiques_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`);

--
-- Constraints for table `Titles`
--
ALTER TABLE `Titles`
  ADD CONSTRAINT `titles_ibfk_1` FOREIGN KEY (`genre_id`) REFERENCES `Genres` (`id`),
  ADD CONSTRAINT `titles_ibfk_2` FOREIGN KEY (`developer_id`) REFERENCES `Developers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
