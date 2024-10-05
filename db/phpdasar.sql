-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 05, 2024 at 01:11 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phpdasar`
--

-- --------------------------------------------------------

--
-- Table structure for table `anime_list`
--

CREATE TABLE `anime_list` (
  `id` int NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `season` varchar(255) DEFAULT NULL,
  `genre` json DEFAULT NULL,
  `episode` int DEFAULT NULL,
  `studio` varchar(255) DEFAULT NULL,
  `skor` decimal(3,2) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `anime_list`
--

INSERT INTO `anime_list` (`id`, `judul`, `season`, `genre`, `episode`, `studio`, `skor`, `gambar`) VALUES
(1, 'Bungou Stray Dogs S4', 'Winter 2023', '[\"Action\", \"Mystery\", \"Supernatural\"]', 13, 'Bones', 8.40, 'bsd.jpg'),
(2, 'Dark Gathering', 'Summer 2023', '[\"Horror\", \"Supernatural\", \"Thriller\"]', 25, 'OLM', 8.70, 'dark.jpg'),
(3, 'Sousou no Frieren', 'Fall 2023', '[\"Adventure\", \"Fantasy\", \"Drama\"]', 24, 'Madhouse', 9.00, 'frieren.jpg'),
(4, 'Jigokuraku', 'Spring 2023', '[\"Action\", \"Adventure\", \"Historical\"]', 13, 'MAPPA', 8.20, 'jgk.jpg'),
(5, 'Jujutsu Kaisen S2', 'Summer 2023', '[\"Action\", \"Fantasy\", \"Supernatural\"]', 24, 'MAPPA', 8.80, 'jjk.jpg'),
(6, 'Kusuriya no Hitorigoto', 'Fall 2023', '[\"Drama\", \"Historical\", \"Mystery\"]', 12, 'Toho Animation', 8.30, 'knh.jpg'),
(7, 'Kimetsu no Yaiba S3', 'Spring 2023', '[\"Action\", \"Supernatural\", \"Shounen\"]', 11, 'ufotable', 8.90, 'kny.jpg'),
(8, 'Oshi no Ko', 'Spring 2023', '[\"Drama\", \"Supernatural\", \"Psychological\"]', 11, 'Doga Kobo', 9.10, 'onk.jpg'),
(9, 'Dr. Stone S3', 'Spring 2023', '[\"Adventure\", \"Sci-Fi\", \"Shounen\"]', 11, 'TMS Entertainment', 8.30, 'stone.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(2, 'shiba', '$2y$10$F76vtsq83Y3ACXInjBguJeawdSKu0b/IEpWCvLkyV.qqWfxb5Syby');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anime_list`
--
ALTER TABLE `anime_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anime_list`
--
ALTER TABLE `anime_list`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
