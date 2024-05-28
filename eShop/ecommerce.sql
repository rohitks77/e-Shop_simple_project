-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2024 at 06:07 PM
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
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`) VALUES
(71, 'Samsung S23ultras/ RAM-12BG/ROM-1TB/ High display /Smartphone', ' 8GB or 12GB of RAM\r\n256GB to 1TB of ROM', '2,49999', 'upload/samsung s23ultra.jpeg'),
(73, 'VIVOv29e RAM-8/ROM-256 /Smartphone', 'VIVOv29e RAM-8/ROM-256 /Smartphone', '42,999', 'upload/vivo v29e.jpg'),
(74, 'OnePlus 11 5G 16GB RAM 256GB ROM/ Smartphone', 'OnePlus 11 5G 16GB RAM 256GB ROM', '39,999', 'upload/OnePlus 11 5G 16GB RAM 256GB ROM.jpeg'),
(75, 'OPPO Reno8 pro /ram-8GB /ROM-128GB/ Smartphone-5G', 'OPPO Reno8 pro /ram-8GB /ROM-128GB/ Smartphone-5G', '60,000', 'upload/oppo.jpg'),
(76, 'Apple MacBook Pro 14-inch/ Ram-8GB/ROM-1TB ', 'Apple MacBook Pro 14-inch/ Ram-8GB/ROM-1TB ', '179,900', 'upload/Apple macbook pro.png'),
(82, 'ASUS  VIVOBook 14 Laptop/ 12Gen/Core-i7', 'ASUS  VIVOBook 14 Laptop/ 12Gen/Core-i7', '61,999', 'upload/ASUS LAPTOP.jpg'),
(83, 'lenovo slim9pro laptop / Display-14inch/RAM-8GB/SSD-256GB', 'lenovo slim9pro laptop / Display-14inch/RAM-8GB/SSD-256GB', '69,999', 'upload/lenovo laptop.jpg'),
(84, 'HP i7 laptop /dispaly-14inch/ ', 'HP i7 laptop /dispaly-14inch/ ', '79,999', 'upload/HP-Pavilion-13-3-FHD-Intel-Core-i3-8GBHP LAPTOP.jpeg'),
(85, 'DELL inspire display-14inch  core-i5', 'DELL inspire display-14inch ', '65,999', 'upload/dell-laptop-3400-latitude-i5-win10pro.jpeg'),
(86, 'ANKER SPACE Q45 HEADPHONE', 'ANKER SPACE Q45 HEADPHONE', '9,900', 'upload/ANKER SPACE Q45 HEADPHONE.jpg'),
(87, 'Airbud 5 / High Quality sounds', 'Airbud 5 / High Quality sounds', '5,000', 'upload/Airbud.jpg'),
(88, 'ULTIMA HEADSETS', 'ULTIMA HEADSETS', '11,900', 'upload/ULTIMA HEADSETS.jpg'),
(89, 'JBL TUNE 720BT WIRELESS', 'JBL TUNE 720BT WIRELESS', '13,600', 'upload/JBL TUNE 720BT WIRELESS.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(6) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(36, 'rohitks', 'info@rohitks.com.np', 'u7twWilU');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
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
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
