-- Login Credentials for Super User
-- EMAIL: justinmhoch@gmail.com
-- PASSWORD: Passandstuff1$
-- *****************************************
-- This is not the password for the super user on the live site! But it will work for this database import.
-- *****************************************


-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Generation Time: Apr 28, 2022 at 10:12 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `your_movie_club`
--
CREATE DATABASE IF NOT EXISTS `your_movie_club` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `your_movie_club`;

-- --------------------------------------------------------

--
-- Table structure for table `club_movies`
--

DROP TABLE IF EXISTS `club_movies`;
CREATE TABLE `club_movies` (
  `id` int(11) NOT NULL,
  `api_movie_id` int(11) DEFAULT NULL,
  `movie_club_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `queue_number` int(11) DEFAULT NULL,
  `date_added` date DEFAULT NULL,
  `watched_status` tinyint(1) DEFAULT NULL,
  `movie_title` varchar(255) DEFAULT NULL,
  `poster_path` varchar(255) DEFAULT NULL,
  `watched_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `club_movies`:
--   `movie_club_id`
--       `movie_clubs` -> `id`
--   `user_id`
--       `users` -> `id`
--

--
-- Dumping data for table `club_movies`
--

INSERT INTO `club_movies` (`id`, `api_movie_id`, `movie_club_id`, `user_id`, `queue_number`, `date_added`, `watched_status`, `movie_title`, `poster_path`, `watched_date`) VALUES
(10, 550, 4, 1, 0, '2022-04-10', 0, NULL, NULL, NULL),
(32, 634649, 1, 1, NULL, '2022-04-19', 1, 'Spider-Man: No Way Home', '/1g0dhYtq4irTY1GPXvft6k4YLjm.jpg', '2022-04-23'),
(33, 919689, 1, 1, NULL, '2022-04-19', 0, 'War of the Worlds: Annihilation', '/9eiUNsUAw2iwVyMeXNNiNQQad4E.jpg', NULL),
(34, 508947, 1, 1, NULL, '2022-04-19', 0, 'Turning Red', '/qsdjk9oAKSQMWs0Vt5Pyfh6O4GZ.jpg', NULL),
(35, 406759, 1, 1, NULL, '2022-04-19', 0, 'Moonfall', '/odVv1sqVs0KxBXiA8bhIBlPgalx.jpg', NULL),
(36, 675353, 1, 1, NULL, '2022-04-19', 0, 'Sonic the Hedgehog 2', '/6DrHO1jr3qVrViUO6s6kFiAGM7.jpg', NULL),
(37, 414906, 1, 1, NULL, '2022-04-19', 0, 'The Batman', '/74xTEgt7R36Fpooo50r9T25onhq.jpg', NULL),
(38, 696806, 1, 1, NULL, '2022-04-19', 0, 'The Adam Project', '/wFjboE0aFZNbVOF05fzrka9Fqyx.jpg', NULL),
(39, 823625, 1, 1, NULL, '2022-04-19', 0, 'Blacklight', '/7gFo1PEbe1CoSgNTnjCGdZbw0zP.jpg', NULL),
(40, 760868, 1, 1, NULL, '2022-04-19', 0, 'Black Crab', '/mcIYHZYwUbvhvUt8Lb5nENJ7AlX.jpg', NULL),
(41, 414906, 2, 1, NULL, '2022-04-21', 1, 'The Batman', '/74xTEgt7R36Fpooo50r9T25onhq.jpg', '2022-04-21'),
(42, 634649, 2, 1, NULL, '2022-04-21', 0, 'Spider-Man: No Way Home', '/1g0dhYtq4irTY1GPXvft6k4YLjm.jpg', NULL),
(43, 919689, 2, 1, NULL, '2022-04-21', 0, 'War of the Worlds: Annihilation', '/9eiUNsUAw2iwVyMeXNNiNQQad4E.jpg', NULL),
(44, 414906, 7, 15, NULL, '2022-04-21', 1, 'The Batman', '/74xTEgt7R36Fpooo50r9T25onhq.jpg', '2022-04-21'),
(45, 634649, 7, 15, NULL, '2022-04-21', 1, 'Spider-Man: No Way Home', '/1g0dhYtq4irTY1GPXvft6k4YLjm.jpg', '2022-04-21'),
(46, 508947, 7, 15, NULL, '2022-04-21', 1, 'Turning Red', '/qsdjk9oAKSQMWs0Vt5Pyfh6O4GZ.jpg', '2022-04-21'),
(48, 406759, 7, 15, NULL, '2022-04-21', 1, 'Moonfall', '/odVv1sqVs0KxBXiA8bhIBlPgalx.jpg', '2022-04-21'),
(49, 606402, 7, 15, NULL, '2022-04-21', 0, 'Yaksha: Ruthless Operations', '/7MDgiFOPUCeG74nQsMKJuzTJrtc.jpg', NULL),
(50, 799876, 7, 15, NULL, '2022-04-21', 0, 'The Outfit', '/lZa5EB6PVJBT5mxhgZS5ftqdAm6.jpg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `movie_clubs_id` int(11) DEFAULT NULL,
  `club_movie_id` int(11) DEFAULT NULL,
  `comment_text` text DEFAULT NULL,
  `date_created` date DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `comments`:
--   `user_id`
--       `users` -> `id`
--   `movie_clubs_id`
--       `movie_clubs` -> `id`
--   `club_movie_id`
--       `club_movies` -> `id`
--   `parent_id`
--       `comments` -> `id`
--

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `movie_clubs_id`, `club_movie_id`, `comment_text`, `date_created`, `parent_id`) VALUES
(16, 15, 7, 48, 'This is a great movie', '2022-04-21', NULL),
(17, 1, 1, 32, 'Test Comment', '2022-04-23', NULL),
(18, 1, 1, 32, 'Another Test comment', '2022-04-23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `movie_clubs`
--

DROP TABLE IF EXISTS `movie_clubs`;
CREATE TABLE `movie_clubs` (
  `id` int(11) NOT NULL,
  `club_name` varchar(255) DEFAULT NULL,
  `club_owner_id` int(11) DEFAULT NULL,
  `date_created` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `avatar_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `movie_clubs`:
--   `club_owner_id`
--       `users` -> `id`
--

--
-- Dumping data for table `movie_clubs`
--

INSERT INTO `movie_clubs` (`id`, `club_name`, `club_owner_id`, `date_created`, `description`, `avatar_path`) VALUES
(1, 'Movie Bandits', 1, '2022-02-09', 'Justins movie club', '/somepath'),
(2, 'Test Club update', 1, '2022-04-05', 'this is a test club update', ''),
(4, 'Test Club 2', 1, '2022-04-05', 'This is test club 2', ''),
(7, 'Testmember Test club', 15, '2022-04-21', 'This is a test club for testmember', ''),
(8, 'This is a quick test club', 1, '2022-04-23', 'This is a quick test club for testing the empty space image.', '');

-- --------------------------------------------------------

--
-- Table structure for table `movie_club_members`
--

DROP TABLE IF EXISTS `movie_club_members`;
CREATE TABLE `movie_club_members` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `movie_club_id` int(11) DEFAULT NULL,
  `joined_status` tinyint(1) DEFAULT NULL,
  `date_joined` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `movie_club_members`:
--   `user_id`
--       `users` -> `id`
--   `movie_club_id`
--       `movie_clubs` -> `id`
--

--
-- Dumping data for table `movie_club_members`
--

INSERT INTO `movie_club_members` (`id`, `user_id`, `movie_club_id`, `joined_status`, `date_joined`) VALUES
(1, 2, 1, 1, '2022-02-09'),
(2, 3, 1, 1, '2022-02-09'),
(3, 1, 1, 1, '2022-02-09'),
(4, 15, 1, 1, '2022-03-23'),
(8, 1, 2, 1, '2022-04-05'),
(10, 1, 4, 1, '2022-04-05'),
(20, 15, 2, 1, '2022-04-21'),
(21, 15, 7, 1, '2022-04-21'),
(22, 1, 8, 1, '2022-04-23'),
(24, 28, 1, 1, '2022-04-24');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `password_resets`:
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `date_created` date DEFAULT NULL,
  `user_level` int(11) DEFAULT NULL,
  `avatar_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `users`:
--   `user_level`
--       `user_levels` -> `id`
--

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `date_created`, `user_level`, `avatar_path`) VALUES
(1, 'Justin', 'justinmhoch@gmail.com', '$2y$10$VvYFMnh/9wzyrtuCLkd1COmNB5L3j57qIaFffwfaSCIweKlOFueQS', '2022-02-09', 3, 'blue-cat.webp'),
(2, 'testadmin1', 'testadmin1@gmail.com', '$2y$10$VvYFMnh/9wzyrtuCLkd1COmNB5L3j57qIaFffwfaSCIweKlOFueQS', '2022-02-09', 2, 'green-dog.webp'),
(3, 'testmember1', 'testmember1@gmail.com', '$2y$10$VvYFMnh/9wzyrtuCLkd1COmNB5L3j57qIaFffwfaSCIweKlOFueQS', '2022-02-09', 1, 'purple-rabbit.webp'),
(14, 'testuser1', 'testuser1@gmail.com', '$2y$10$/dYhaqW6nOXK4yJFYYr2MuEfXyK98S4m1Ojy9omm9ycQT05dgbqz.', '2022-03-02', 1, 'purple-dog.webp'),
(15, 'testmember', 'testmember@gmail.com', '$2y$10$yPTYPYSspyh3ZEWnrKsxSedqzc6lLV/NWqQJKm8ByQU/U/26ozOhO', '2022-03-21', 1, 'blue-cat.webp'),
(28, 'deadfunky', 'dead.funky@gmail.com', '$2y$10$rwPa4r6gBkxnY/7UW62Zoeic7oPP.rXr2cvJiJIc6vAQn.6u0lWji', '2022-04-24', 1, 'blue-cat.webp');

-- --------------------------------------------------------

--
-- Table structure for table `user_levels`
--

DROP TABLE IF EXISTS `user_levels`;
CREATE TABLE `user_levels` (
  `id` int(11) NOT NULL,
  `level_name` varchar(50) DEFAULT NULL,
  `level_description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `user_levels`:
--

--
-- Dumping data for table `user_levels`
--

INSERT INTO `user_levels` (`id`, `level_name`, `level_description`) VALUES
(1, 'member', 'Memeber level can create, read, update, and delete personal movie clubs and their own comments'),
(2, 'admin', 'Admin level can create, read, update, and delete personal movie clubs, members, admins, and comments'),
(3, 'super-admin', 'Super Admin level can create, read, update, and delete personal movie clubs, members, admins, super admins, and comments');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `club_movies`
--
ALTER TABLE `club_movies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_club_id` (`movie_club_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `movie_clubs_id` (`movie_clubs_id`),
  ADD KEY `club_movie_id` (`club_movie_id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `movie_clubs`
--
ALTER TABLE `movie_clubs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `club_owner_id` (`club_owner_id`);

--
-- Indexes for table `movie_club_members`
--
ALTER TABLE `movie_club_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `movie_club_id` (`movie_club_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_level` (`user_level`);

--
-- Indexes for table `user_levels`
--
ALTER TABLE `user_levels`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `club_movies`
--
ALTER TABLE `club_movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `movie_clubs`
--
ALTER TABLE `movie_clubs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `movie_club_members`
--
ALTER TABLE `movie_club_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `user_levels`
--
ALTER TABLE `user_levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `club_movies`
--
ALTER TABLE `club_movies`
  ADD CONSTRAINT `club_movies_ibfk_1` FOREIGN KEY (`movie_club_id`) REFERENCES `movie_clubs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `club_movies_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`movie_clubs_id`) REFERENCES `movie_clubs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`club_movie_id`) REFERENCES `club_movies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_4` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `movie_clubs`
--
ALTER TABLE `movie_clubs`
  ADD CONSTRAINT `movie_clubs_ibfk_1` FOREIGN KEY (`club_owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `movie_club_members`
--
ALTER TABLE `movie_club_members`
  ADD CONSTRAINT `movie_club_members_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `movie_club_members_ibfk_2` FOREIGN KEY (`movie_club_id`) REFERENCES `movie_clubs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`user_level`) REFERENCES `user_levels` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
