CREATE TABLE `users` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255),
  `surname` varchar(255),
  `mail` varchar(255) UNIQUE,
  `password` varchar(255),
  `isadmin` boolean DEFAULT false,
  `isseller` boolean DEFAULT false
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
