-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2025 at 11:57 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `real_estate_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `showing_date` datetime DEFAULT NULL,
  `status` enum('pending','confirmed','cancelled') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `property_id`, `booking_date`, `showing_date`, `status`) VALUES
(3, 2, 1, '2025-05-28 19:00:27', NULL, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `bedrooms` int(11) NOT NULL,
  `bathrooms` int(11) NOT NULL,
  `area` int(11) NOT NULL,
  `location` varchar(100) NOT NULL,
  `type` enum('house','apartment','villa','land') NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `maps_link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `title`, `description`, `price`, `bedrooms`, `bathrooms`, `area`, `location`, `type`, `image_path`, `created_at`, `maps_link`) VALUES
(1, 'Beachfront villa', '7 bedroom villa with private beach access', '32000.00', 7, 3, 3200, 'batroun  by the sea Area', 'villa', 'beach2-house.jpg', '2025-05-28 08:43:24', 'https://maps.app.goo.gl/FaLffR85oqHHyM5XA'),
(2, 'Downtown Apartment', 'Modern 2-bed apartment in city center', '75000.00', 2, 2, 1200, 'Beirut Downtoun', 'apartment', 'downtown-apartment.jpg', '2025-05-28 08:43:24', 'https://maps.app.goo.gl/VcfAWFdA5wvBGhsM6'),
(3, 'Countryside House', 'Cozy 3-bed house with large garden', '120000.00', 3, 2, 1800, 'Nbatiyeh area ', 'house', 'country-house.jpg', '2025-05-28 08:43:24', 'https://maps.app.goo.gl/aG18i6HoPzHXm7YSA');

-- --------------------------------------------------------

--
-- Table structure for table `property_images`
--

CREATE TABLE `property_images` (
  `id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `image_type` enum('interior','exterior') NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `property_images`
--

INSERT INTO `property_images` (`id`, `property_id`, `image_path`, `image_type`, `uploaded_at`) VALUES
(1, 1, 'beach-villa-ext1.jpg', 'exterior', '2025-05-31 08:24:39'),
(2, 1, 'beach-villa-ext2.jpg', 'exterior', '2025-05-31 08:24:39'),
(3, 1, 'beach-villa-int1.jpg', 'interior', '2025-05-31 08:24:39'),
(4, 1, 'beach-villa-int2.jpg', 'interior', '2025-05-31 08:24:39'),
(5, 2, 'downtown-apt-ext1.jpg', 'exterior', '2025-05-31 08:24:39'),
(6, 2, 'downtown-apt-ext2.jpg', 'exterior', '2025-05-31 08:24:39'),
(7, 2, 'downtown-apt-int1.jpg', 'interior', '2025-05-31 08:24:39'),
(8, 2, 'downtown-apt-int2.jpg', 'interior', '2025-05-31 08:24:39'),
(9, 3, 'country-house-ext1.jpg', 'exterior', '2025-05-31 08:24:39'),
(10, 3, 'country-house-ext2.jpg', 'exterior', '2025-05-31 08:24:39'),
(11, 3, 'country-house-int1.jpg', 'interior', '2025-05-31 08:24:39'),
(12, 3, 'country-house-int2.jpg', 'interior', '2025-05-31 08:24:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `full_name`, `phone`, `created_at`) VALUES
(2, 'sandra', 'sandra@gmail.com', '$2y$10$tDPmEYGbXV4qT47E11ialef5L5/rsMbPBU455niyffnjAI56nQ6Xu', 'sandra asmar', '70923422', '2025-05-28 18:59:43'),
(6, 'aa', 'a@a', '$2y$10$i3fQ1Bd9V5.57fUjrxUmfOybLaRR/yL3doV8KKYhgFIyQgveRTZyO', 'ma', '2', '2025-05-31 11:49:44'),
(7, 'mahdy', 'mahdy73@ostories.me', '$2y$10$HOIpA0J.AClfcyeATzVHAOMPGFbH6G44eeuccKjmD2CGjrW4o5nYy', 'mahdi youssef mallah', '81667291', '2025-05-31 15:46:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_images`
--
ALTER TABLE `property_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `property_images`
--
ALTER TABLE `property_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`);

--
-- Constraints for table `property_images`
--
ALTER TABLE `property_images`
  ADD CONSTRAINT `property_images_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
