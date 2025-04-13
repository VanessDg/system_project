-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2025 at 07:42 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `system_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `email`, `created_at`) VALUES
(4, 'admin', '240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9', 'admin@example.com', '2025-03-31 13:45:10');

-- --------------------------------------------------------

--
-- Table structure for table `map_editor`
--

CREATE TABLE `map_editor` (
  `id` int(11) NOT NULL,
  `location_name` varchar(255) DEFAULT NULL,
  `age` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `map_editor`
--

INSERT INTO `map_editor` (`id`, `location_name`, `age`, `description`, `category`, `latitude`, `longitude`, `image_path`, `created_at`) VALUES
(2, 'hotdog', '1000', '1234', 'Monument', 15.867563, 120.238495, 'uploads/1744035490_im.jfif', '2025-04-07 14:18:10');

-- --------------------------------------------------------

--
-- Table structure for table `published_sites`
--

CREATE TABLE `published_sites` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `published_date` date DEFAULT NULL,
  `historical_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `published_sites`
--

INSERT INTO `published_sites` (`id`, `name`, `location`, `description`, `image`, `published_date`, `historical_date`) VALUES
(1, 'Lingayen Capitol', 'Lingayen', 'Built in 1840 as the Provincial Capitol, the Casa Real is a landmark in Pangasinan’s history, serving various governmental purposes.', 'capitol.jpg', '2025-04-13', '1840-01-01'),
(2, 'Palaris Revolt', 'Binalatongan', 'In 1762, Juan dela Cruz Palaris led a rebellion against Spanish rule in the province of Pangasinan. This revolt symbolized local resistance against foreign colonization.', 'palaris_revolt.jpg', '2025-04-13', '1762-01-01'),
(3, 'Malong Revolt', 'Binalatongan', 'A 1660 uprising led by Andres Malong, who proclaimed himself as king in Pangasinan in a bid to resist Spanish colonial authorities.', 'malong_revolt.jpg', '2025-04-13', '1660-01-01'),
(4, 'Sual Port', 'Sual', 'Designated as an official port for foreign trade by the Spanish government in 1855, Sual played a pivotal role in international trade, especially rice exports.', 'sual_port.jpg', '2025-04-13', '1855-01-01'),
(5, 'Battle of Pangasinan', 'Dagupan', 'During World War II, the USAFFE and Japanese army engaged in combat in Pangasinan, specifically in Pozorrubio, Binalonan, and Tayug.', 'battle_of_pangasinan.jpg', '2025-04-13', '1941-12-22'),
(6, 'La Marcha Nacional Filipina', 'Bautista', 'Jose Palma wrote the lyrics for the national anthem “Lupang Hinirang” in Bautista, Pangasinan, on a historic day in 1899.', 'marcha_nacional.jpg', '2025-04-13', '1899-11-22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `map_editor`
--
ALTER TABLE `map_editor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `published_sites`
--
ALTER TABLE `published_sites`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `map_editor`
--
ALTER TABLE `map_editor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `published_sites`
--
ALTER TABLE `published_sites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
