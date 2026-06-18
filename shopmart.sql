-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2026 at 07:27 AM
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
-- Database: `shopmart`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_qty` int(11) DEFAULT 0,
  `category` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock_qty`, `category`, `created_at`) VALUES
(1, 'Wireless Headphones', 'Noise-cancelling Bluetootu headphones', 3500.00, 20, 'Electronics', '2026-06-13 13:09:28'),
(2, 'Running shoes', 'Lightweight breathable running shoes', 2800.00, 15, 'Footwear', '2026-06-13 13:09:28'),
(3, 'Leather Wallet', 'Slim genuine leather bifold wallet', 950.00, 30, 'Accesories', '2026-06-13 13:09:28'),
(4, 'Stainless Water Bottle', '1L insulated stainless steel bottle', 750.00, 50, 'Kitchen ware', '2026-06-13 13:09:28'),
(5, 'Desk Lamp', 'LED desk lamp with adjustable brightness', 1200.00, 10, 'Home and office', '2026-06-13 13:09:28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','customer') DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Admin User', 'admin@shopmart.com', '$2y$10$oKYlkvvRE4yvXbWVpftCTulZfD.EebJ.gdAue6HtBzd/BBiEAnXXq', 'admin', '2026-06-01 12:30:27'),
(2, 'Alice Kamau', 'alice@example.com', '$2y$10$hiRoV1Xv9Xj2V5jpYZnJJeyQdFZ0KoNS.eCMitTKB3332Wm8EKO26', 'customer', '2026-06-01 12:30:27'),
(3, 'Brian Otieno', 'brian@example.com', '$2y$10$mALgEwk2C1940I89hmqWGum2qVU4LkaCiwYZck3zW0ZkDLvdqUYGe', 'customer', '2026-06-01 12:30:27'),
(4, 'Grace Wanjiku', 'grace@example.com', '$2y$10$/x5fplVSMQ.NMlMZqDxVQe2pLCUp4rnbBKKhyPwNv/qis3F77D7Re', 'customer', '2026-06-01 12:53:40'),
(5, 'David Mwangi', 'david@example.com', '$2y$10$a//lB4rET06uI4MSb33bF.lmbHPIBXKBfdQDxs7O2Qu9aJBNM0EqC', 'customer', '2026-06-01 12:53:41'),
(6, 'Fatuma Hassan', 'fatuma@example.com', '$2y$10$DSVB8SOrIyZDPjat95cSBuBC19pHXTGT9.kLU2TnwphWLWDCURfhe', 'customer', '2026-06-01 12:53:41'),
(7, 'Peter Odhiambo', 'peter@example.com', '$2y$10$8VqPo0QjRX6LSP03rH3wFucHzKv6ZKHVyRFLt3pgxe1oK2ZTZFjAS', 'customer', '2026-06-01 12:53:41'),
(8, 'Mercy Njeri', 'mercy@example.com', '$2y$10$HmVJBl.G60ClG1Q3.uAmzuzuWECyuRtk5Dx.QNMA.EuR5XIBCz9pa', 'customer', '2026-06-01 12:53:41'),
(9, 'James Kipchoge', 'james@example.com', '$2y$10$UlENCGJ8EqXfplcuHMMkMu/elzAru/fqnpYA37.EYtp2gKIhUZA2y', 'customer', '2026-06-01 12:53:41'),
(10, 'Amina Abdullahi', 'amina@example.com', '$2y$10$6h/XM3Ow.YHG7Mh8GfEtfOZU3jnJGcOPgQC.ecM8YQbVcmSZ9BCla', 'customer', '2026-06-01 12:53:42'),
(11, 'Kevin Mutua', 'kevin@example.com', '$2y$10$m5wp8TC24YRtXCceZap33eOrZkXbMt/lcgQvEJpShEXXRERroF3Xm', 'customer', '2026-06-01 12:53:42'),
(12, 'Shop Manager', 'manager@shopmart.com', '$2y$10$chlZiVbDN42cpSvgasb.COOid4A8fJHqfOfPdh4jUIokbZzIWLy8u', 'admin', '2026-06-01 12:53:42'),
(34, 'stephen otyende', 'abdikarimroz@gmail.com', '$2y$10$uWKZFEtFCgi2NK3cEnho5.qo7QeCawwo4Mvx7PQHM0P3z41IMFqC2', 'customer', '2026-06-10 13:29:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
