-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2020 at 10:54 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php`
--

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id` bigint(20) NOT NULL,
  `city` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `city`, `province`) VALUES
(1, 'Nivelles', 'Brabant Wallon'),
(2, 'Ath', 'Hainaut'),
(3, 'Charleroi', 'Hainaut'),
(4, 'Mons', 'Hainaut'),
(5, 'Mouscron', 'Hainaut'),
(6, 'Soignies', 'Hainaut'),
(7, 'Thuin', 'Hainaut'),
(8, 'Tournai', 'Hainaut'),
(9, 'Huy', 'Liège'),
(10, 'Liège', 'Liège'),
(11, 'Verviers', 'Liège'),
(12, 'Waremme', 'Liège'),
(13, 'Arlon', 'Luxembourg'),
(14, 'Bastogne', 'Luxembourg'),
(15, 'Marche-en-Famenne', 'Luxembourg'),
(16, 'Neufchateau', 'Luxembourg'),
(17, 'Virton', 'Luxembourg'),
(18, 'Dinant', 'Namur'),
(19, 'Namur', 'Namur'),
(20, 'Philippeville', 'Namur');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `city` (`city`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
