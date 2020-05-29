-- Database: `php`
--
CREATE DATABASE IF NOT EXISTS `php` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `php`;

-- --------------------------------------------------------

CREATE TABLE `users` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255),
  `surname` varchar(255),
  `mail` varchar(255) UNIQUE,
  `password` varchar(255),
  `isadmin` tinyint DEFAULT false,
  `isseller` tinyint DEFAULT false
);

CREATE TABLE `entreprises` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `owner` bigint,
  `name` varchar(255),
  `address` varchar(255),
  `city` bigint,
  `products` varchar(255),
  `phone` varchar(255)
);

CREATE TABLE `location` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `city` varchar(255) UNIQUE,
  `province` varchar(255)
);

ALTER TABLE `entreprises` ADD FOREIGN KEY (`owner`) REFERENCES `users` (`id`);

ALTER TABLE `entreprises` ADD FOREIGN KEY (`city`) REFERENCES `location` (`id`);


--
-- Create trigger remove entreprises for user
--

CREATE TRIGGER `DeleteUserEntreprise` BEFORE DELETE ON `users`
 FOR EACH ROW DELETE FROM `entreprises` WHERE `entreprises`.`owner`=OLD.id;

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
-- Insert moderator
--

INSERT INTO `users` (`name`, `surname`, `mail`, `password`, `isadmin`, `isseller`) VALUES
('RooToto', 'RooToto', 'root@toto.roto', '$2y$10$.rZOpgUJL9wYICxLeGsIVOsniWrWijy246TJwXC.byrhbw0m9WHRu', 1, 0);


--
-- Add privilege to toto
--

GRANT USAGE ON *.* TO '5WKRRSM8bzMJEkSKrqzVA6wt5se3vT'@'%' IDENTIFIED BY 'BGn7tapdsstqmhY7QtP8x3sxCDLkcm';

GRANT SELECT, INSERT, UPDATE, DELETE ON `php`.* TO '5WKRRSM8bzMJEkSKrqzVA6wt5se3vT'@'%';