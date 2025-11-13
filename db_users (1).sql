-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2025 at 11:48 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_users`
--

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(10) NOT NULL,
  `product_name` varchar(30) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `type` varchar(30) NOT NULL,
  `stock` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `price`, `type`, `stock`, `supplier_id`) VALUES
(1, 'Susu Kurma', 9900, 'Minuman', 20, 1),
(2, 'sensodyne', 14000, 'personal care', 12, 2),
(3, 'Ultramilk Coklat', 9900, 'Minuman', 11, 1),
(4, 'Ultramilk stroberi', 8900, 'Minuman', 12, 1),
(5, 'Lifebuoy', 6000, 'personal care', 12, 2),
(6, 'Gentlegen', 14000, 'personal care', 4, 2),
(7, 'Bear Brand', 10000, 'Minuman', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `supplier_id` int(11) NOT NULL,
  `supplier_name` varchar(30) NOT NULL,
  `contact` int(12) NOT NULL,
  `address` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supplier_id`, `supplier_name`, `contact`, `address`) VALUES
(0, 'Kakan', 2147483647, 'jl.cisaat'),
(1, 'Siti Nurhalimah', 821004455, 'jl.kalapanunggal'),
(2, 'Meli Meliani', 98765432, 'jl.cibolang'),
(3, 'Agisna Rahmatia', 8975785, 'jl.palabuhan');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `transaction_id` int(11) NOT NULL,
  `total` int(50) DEFAULT NULL,
  `transaction_date_time` varchar(30) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_detail`
--

CREATE TABLE `transaction_detail` (
  `detail_id` int(11) NOT NULL,
  `subtotal` varchar(50) DEFAULT NULL,
  `quantity` int(15) DEFAULT NULL,
  `id_kasir` int(10) DEFAULT NULL,
  `product_id` int(10) DEFAULT NULL,
  `transaction_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(1, 'stinrhlmh__', 's.nurhalimahh1@gmail.com', '$2y$10$zyXIJyTEnp9JCBTVxflQq.2y0keam9nkw6drDn.9mvQKcGl0HIFbS', 'admin'),
(2, 'sikuta', 'sikuta@gmail.com', '$2y$10$HRhn6MgC3edo0x4XW1rkSej.kDzj9oQKUYrkbewGAYYBOnDiSf0lS', 'user'),
(12, 'meli', 'meli@gmail.com', '$2y$10$WxUDwu69mdZn8OhaH87OX.qp2zOMbV/yuEptb5wqNDjt4H8LJr/BO', 'user'),
(13, 'sifa', 'sifa@gmail.com', '$2y$10$ARY4.Z974ogJ1AxHNcRbTOSLrASQbyi6ca0LRvYu.hw.z4XcK3GwG', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `fk_product_supplier` (`supplier_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `transaction_detail`
--
ALTER TABLE `transaction_detail`
  ADD PRIMARY KEY (`detail_id`),
  ADD UNIQUE KEY `id_kasir` (`id_kasir`,`product_id`,`transaction_id`),
  ADD KEY `fk_product` (`product_id`),
  ADD KEY `transaction_id` (`transaction_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`);

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `transaction_detail`
--
ALTER TABLE `transaction_detail`
  ADD CONSTRAINT `fk_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  ADD CONSTRAINT `transaction_detail_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transaction` (`transaction_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
