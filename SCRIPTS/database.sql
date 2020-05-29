-- Database: `php`
--
CREATE DATABASE IF NOT EXISTS `php` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `php`;

-- --------------------------------------------------------

--
-- Table structure for table `entreprises`
--

CREATE TABLE `entreprises` (
  `id` bigint(20) NOT NULL,
  `owner` bigint(20) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` bigint(20) DEFAULT NULL,
  `products` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id` bigint(20) NOT NULL,
  `city` varchar(30) DEFAULT NULL,
  `province` varchar(30) DEFAULT NULL
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

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `mail` varchar(70) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `isadmin` tinyint(1) DEFAULT 0,
  `isseller` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Triggers `users`
--
DELIMITER $$
CREATE TRIGGER `Delete entreprise` BEFORE DELETE ON `users` FOR EACH ROW DELETE FROM entreprises WHERE entreprises.owner=OLD.id
$$
DELIMITER ;

--
-- Indexes for table `entreprises`
--
ALTER TABLE `entreprises`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner` (`owner`),
  ADD KEY `city` (`city`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `city` (`city`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mail` (`mail`);


--
-- Constraints for table `entreprises`
--
ALTER TABLE `entreprises`
  ADD CONSTRAINT `entreprises_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `entreprises_ibfk_2` FOREIGN KEY (`city`) REFERENCES `location` (`id`);


--
-- Insert moderator
--

INSERT INTO `users` (`id`, `name`, `surname`, `mail`, `password`, `isadmin`, `isseller`) VALUES
(0, 'RooToto', 'RooToto', 'root@toto.roto', '$2y$10$.rZOpgUJL9wYICxLeGsIVOsniWrWijy246TJwXC.byrhbw0m9WHRu', 1, 0);


--
-- Add privilege to toto
--

GRANT USAGE ON *.* TO '5WKRRSM8bzMJEkSKrqzVA6wt5se3vT'@'%' IDENTIFIED BY 'BGn7tapdsstqmhY7QtP8x3sxCDLkcm';

GRANT SELECT, INSERT, UPDATE, DELETE ON `php`.* TO '5WKRRSM8bzMJEkSKrqzVA6wt5se3vT'@'%';