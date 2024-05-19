-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Maj 09, 2024 at 02:28 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `selene`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `promo_code_id` int(11) DEFAULT NULL,
  `cart_subtotal` decimal(12,2) NOT NULL,
  `is_completed` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `promo_code_id`, `cart_subtotal`, `is_completed`) VALUES
(1, 13, 7, 20.00, 1),
(2, 13, 7, 60.00, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cart_product`
--

CREATE TABLE `cart_product` (
  `cart_product_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `cart_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_product`
--

INSERT INTO `cart_product` (`cart_product_id`, `product_id`, `quantity`, `total_price`, `cart_id`) VALUES
(27, 28, 1, 20.00, 1),
(29, 28, 3, 60.00, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `icon` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `name`, `icon`) VALUES
(1, 'Gift Cards', '<i class=\"fa-light fa-gift-card\"></i>'),
(2, 'Games', '<i class=\"fa-light fa-gamepad-modern\"></i>');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `collaboration`
--

CREATE TABLE `collaboration` (
  `collaboration_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `company` varchar(50) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `type` varchar(25) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `favourite_product`
--

CREATE TABLE `favourite_product` (
  `favourite_product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favourite_product`
--

INSERT INTO `favourite_product` (`favourite_product_id`, `user_id`, `product_id`) VALUES
(13, 13, 25);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `mail_verify`
--

CREATE TABLE `mail_verify` (
  `mail_verify_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mail_verify`
--

INSERT INTO `mail_verify` (`mail_verify_id`, `user_id`, `token`) VALUES
(3, 27, '6666c07acc4854a8233b');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `order_`
--

CREATE TABLE `order_` (
  `order_id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `mail` varchar(40) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `adress` text NOT NULL,
  `creation_time` datetime NOT NULL DEFAULT current_timestamp(),
  `order_status_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_`
--

INSERT INTO `order_` (`order_id`, `cart_id`, `name`, `surname`, `mail`, `phone_number`, `adress`, `creation_time`, `order_status_id`) VALUES
(2, 2, 'Jakub', 'Uryga', 'urygajakub@gmail.com', '+48509989752', 'Kamionka Mała 203', '2024-05-09 12:01:36', 2),
(3, 2, 'Jakub', 'Uryga', 'urygajakub@gmail.com', '+48509989752', 'Kamionka Mała 203', '2024-05-09 13:19:07', 2),
(4, 2, 'Jakub', 'Uryga', 'urygajakub@gmail.com', '+48509989752', 'Kamionka Mała 203', '2024-05-09 13:20:36', 2),
(5, 2, 'Jakub', 'Uryga', 'urygajakub@gmail.com', '+48509989752', 'Kamionka Mała 203', '2024-05-09 13:32:53', 2),
(6, 2, 'Jakub', 'Uryga', 'urygajakub@gmail.com', '+48509989752', 'Kamionka Mała 203', '2024-05-09 13:34:38', 2),
(7, 2, 'Jakub', 'Uryga', 'urygajakub@gmail.com', '+48509989752', 'Kamionka Mała 203', '2024-05-09 13:35:32', 2),
(8, 2, 'Jakub', 'Uryga', 'urygajakub@gmail.com', '+48509989752', 'Kamionka Mała 203', '2024-05-09 13:40:23', 2),
(9, 2, 'Jakub', 'Uryga', 'urygajakub@gmail.com', '+48509989752', 'Kamionka Mała 203', '2024-05-09 13:46:04', 2),
(10, 2, 'Jakub', 'Uryga', 'urygajakub@gmail.com', '+48509989752', 'Kamionka Mała 203', '2024-05-09 14:05:28', 2),
(11, 2, 'Jakub', 'Uryga', 'urygajakub@gmail.com', '+48509989752', 'Kamionka Mała 203', '2024-05-09 14:06:28', 2),
(12, 2, 'Jakub', 'Uryga', 'urygajakub@gmail.com', '+48509989752', 'Kamionka Mała 203', '2024-05-09 14:12:19', 2),
(13, 2, 'Jakub', 'Uryga', 'urygajakub@gmail.com', '+48509989752', 'Kamionka Mała 203', '2024-05-09 14:12:53', 2),
(14, 2, 'Jakub', 'Uryga', 'urygajakub@gmail.com', '+48509989752', 'Kamionka Mała 203', '2024-05-09 14:14:25', 2),
(15, 2, 'Jakub', 'Uryga', 'urygajakub@gmail.com', '+48509989752', 'Kamionka Mała 203', '2024-05-09 14:15:06', 2),
(16, 2, 'Jakub', 'Uryga', 'urygajakub@gmail.com', '+48509989752', 'Kamionka Mała 203', '2024-05-09 14:16:03', 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `order_status`
--

CREATE TABLE `order_status` (
  `order_status_id` int(11) NOT NULL,
  `status` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_status`
--

INSERT INTO `order_status` (`order_status_id`, `status`) VALUES
(1, 'Unpaid'),
(2, 'Paid'),
(3, 'Completed'),
(4, 'Cancelled');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `password_reset`
--

CREATE TABLE `password_reset` (
  `password_reset_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` text NOT NULL,
  `expire_time` datetime NOT NULL DEFAULT current_timestamp(),
  `is_used` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_reset`
--

INSERT INTO `password_reset` (`password_reset_id`, `user_id`, `token`, `expire_time`, `is_used`) VALUES
(13, 13, 'fa0a1410eb3245a6a4ab', '2024-05-09 13:43:05', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `price` decimal(10,2) UNSIGNED NOT NULL,
  `lowest_price_30d` decimal(10,2) UNSIGNED NOT NULL,
  `description` text NOT NULL,
  `quantity_available` int(11) UNSIGNED NOT NULL,
  `quantity_sold` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `average_rating` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `name`, `price`, `lowest_price_30d`, `description`, `quantity_available`, `quantity_sold`, `average_rating`) VALUES
(25, 'Koenigsegg Jesko', 205.32, 36.99, 'The Koenigsegg Jesko is a high-performance \"hypercar\" crafted by the Swedish manufacturer Koenigsegg. It represents the pinnacle of automotive engineering, blending cutting-edge technology with unparalleled performance. Powered by a twin-turbocharged V8 engine producing over 1,600 horsepower, the Jesko is capable of reaching speeds in excess of 300 mph. Its advanced aerodynamics and lightweight construction contribute to its exceptional agility and handling prowess. With limited production numbers, the Koenigsegg Jesko stands as an exclusive and coveted masterpiece of automotive excellence.', 3, 5, 4),
(28, 'test2', 20.00, 20.00, 'ADSADSADASDASD', 6, 15, 4);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `product_categories`
--

CREATE TABLE `product_categories` (
  `product_category_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `subcategory_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`product_category_id`, `product_id`, `subcategory_id`) VALUES
(23, 25, 4),
(25, 28, 4),
(26, 28, 2),
(29, 25, 5);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `product_photos`
--

CREATE TABLE `product_photos` (
  `photo_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `path` text NOT NULL,
  `main` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_photos`
--

INSERT INTO `product_photos` (`photo_id`, `product_id`, `path`, `main`) VALUES
(53, 25, '../photos/productPhotos/Koenigsegg Jesko/2020-Koenigsegg-Jesko-012-2160-scaled.jpg', 1),
(55, 28, '../photos/productPhotos/test2/HD-wallpaper-uwu-otakus-pink-anime-cute-anime-girl-e-girl-waifu-removebg-preview.png', 1),
(56, 28, '../photos/productPhotos/test2/HD-wallpaper-uwu-otakus-pink-anime-cute-anime-girl-e-girl-waifu.jpg', 0),
(58, 25, '../photos/productPhotos/Koenigsegg Jesko/maxres2.jpg', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `product_review`
--

CREATE TABLE `product_review` (
  `product_review_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `review_content` text NOT NULL,
  `date_added` date NOT NULL DEFAULT current_timestamp(),
  `rating` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_review`
--

INSERT INTO `product_review` (`product_review_id`, `user_id`, `product_id`, `review_content`, `date_added`, `rating`) VALUES
(1, NULL, 25, 'In summary, the Koenigsegg Jesko represents the pinnacle of automotive engineering and is a true dream for enthusiasts of fast and exclusive vehicles. Its exceptional performance, advanced technology, and luxurious finishes make it one of the most coveted supercars on the market.', '2024-02-29', 5),
(2, NULL, 25, 'Ogólnie fajne takie autko tak 2/10 to był dał pozdro z fartem.', '2024-02-29', 3),
(6, NULL, 25, 'testowa opinia panie kolego', '2024-02-29', 2),
(9, 13, 25, 'sdadsadsaaaaaaaaaaaaasd3142342', '2024-03-06', 4);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `promo_code`
--

CREATE TABLE `promo_code` (
  `promo_code_id` int(11) NOT NULL,
  `code` varchar(25) NOT NULL,
  `discount` decimal(2,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `promo_code`
--

INSERT INTO `promo_code` (`promo_code_id`, `code`, `discount`) VALUES
(7, 'SELENE', 0.20);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `subcategory`
--

CREATE TABLE `subcategory` (
  `subcategory_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`subcategory_id`, `name`, `category_id`) VALUES
(1, 'Spotify', 1),
(2, 'Steam', 1),
(3, 'Xbox', 1),
(4, 'Adventure', 2),
(5, 'Action', 2),
(6, 'test', 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `nickname` text NOT NULL,
  `mail` text NOT NULL,
  `h_password` text NOT NULL,
  `join_date` date NOT NULL DEFAULT current_timestamp(),
  `profile_picture` text NOT NULL DEFAULT 'https://upload.wikimedia.org/wikipedia/commons/2/2c/Default_pfp.svg',
  `user_register_option_id` int(11) NOT NULL DEFAULT 4,
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `nickname`, `mail`, `h_password`, `join_date`, `profile_picture`, `user_register_option_id`, `verified`, `admin`) VALUES
(13, 'St1reX', 'urygajakub@gmail.com', '$2y$10$vZK/TfeOyI3cFgXUrVAOTOSMvjYf5MTxSkgYh2GMehsE2g0EcEGAa', '2024-02-22', '../photos/profilePictures/1709385344gk4cplcv63v61.png', 4, 1, 1),
(14, 'GrafiiPL', 'urygadawid1@gmail.com', '$2y$10$yK14Iohv3XLjdxwb7WtUU.wN2QhQUULZ1lmAtayDepnsbmWESUx.G', '2024-02-22', '../photos/profilePictures/1708632542pobrany_plik-removebg-preview.png', 1, 1, 1),
(27, 'tymek300test1', 'tymek300pl@gmail.com', '$2y$10$1XnuvUJ9dCjQBu9wPwMjj.i.2.zqZ9Yox8idr15Popq3FeK6uLH9W', '2024-03-05', 'https://upload.wikimedia.org/wikipedia/commons/2/2c/Default_pfp.svg', 4, 1, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_register_option`
--

CREATE TABLE `user_register_option` (
  `user_register_option_id` int(11) NOT NULL,
  `name` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_register_option`
--

INSERT INTO `user_register_option` (`user_register_option_id`, `name`) VALUES
(1, 'Discord'),
(2, 'Google'),
(3, 'Facebook'),
(4, 'Website Form');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `promo_code_id` (`promo_code_id`);

--
-- Indeksy dla tabeli `cart_product`
--
ALTER TABLE `cart_product`
  ADD PRIMARY KEY (`cart_product_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `cart_id` (`cart_id`);

--
-- Indeksy dla tabeli `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indeksy dla tabeli `collaboration`
--
ALTER TABLE `collaboration`
  ADD PRIMARY KEY (`collaboration_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeksy dla tabeli `favourite_product`
--
ALTER TABLE `favourite_product`
  ADD PRIMARY KEY (`favourite_product_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indeksy dla tabeli `mail_verify`
--
ALTER TABLE `mail_verify`
  ADD PRIMARY KEY (`mail_verify_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeksy dla tabeli `order_`
--
ALTER TABLE `order_`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `order_status_id` (`order_status_id`);

--
-- Indeksy dla tabeli `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`order_status_id`);

--
-- Indeksy dla tabeli `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`password_reset_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeksy dla tabeli `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indeksy dla tabeli `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`product_category_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `category_id` (`subcategory_id`);

--
-- Indeksy dla tabeli `product_photos`
--
ALTER TABLE `product_photos`
  ADD PRIMARY KEY (`photo_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indeksy dla tabeli `product_review`
--
ALTER TABLE `product_review`
  ADD PRIMARY KEY (`product_review_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indeksy dla tabeli `promo_code`
--
ALTER TABLE `promo_code`
  ADD PRIMARY KEY (`promo_code_id`);

--
-- Indeksy dla tabeli `subcategory`
--
ALTER TABLE `subcategory`
  ADD PRIMARY KEY (`subcategory_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indeksy dla tabeli `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `nickname` (`nickname`,`mail`) USING HASH,
  ADD KEY `user_register_option_id` (`user_register_option_id`);

--
-- Indeksy dla tabeli `user_register_option`
--
ALTER TABLE `user_register_option`
  ADD PRIMARY KEY (`user_register_option_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart_product`
--
ALTER TABLE `cart_product`
  MODIFY `cart_product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `collaboration`
--
ALTER TABLE `collaboration`
  MODIFY `collaboration_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `favourite_product`
--
ALTER TABLE `favourite_product`
  MODIFY `favourite_product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `mail_verify`
--
ALTER TABLE `mail_verify`
  MODIFY `mail_verify_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_`
--
ALTER TABLE `order_`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `order_status`
--
ALTER TABLE `order_status`
  MODIFY `order_status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `password_reset_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `product_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `product_photos`
--
ALTER TABLE `product_photos`
  MODIFY `photo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `product_review`
--
ALTER TABLE `product_review`
  MODIFY `product_review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `promo_code`
--
ALTER TABLE `promo_code`
  MODIFY `promo_code_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `subcategory`
--
ALTER TABLE `subcategory`
  MODIFY `subcategory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `user_register_option`
--
ALTER TABLE `user_register_option`
  MODIFY `user_register_option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`promo_code_id`) REFERENCES `promo_code` (`promo_code_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cart_product`
--
ALTER TABLE `cart_product`
  ADD CONSTRAINT `cart_product_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_product_ibfk_3` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `collaboration`
--
ALTER TABLE `collaboration`
  ADD CONSTRAINT `collaboration_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `favourite_product`
--
ALTER TABLE `favourite_product`
  ADD CONSTRAINT `favourite_product_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `favourite_product_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mail_verify`
--
ALTER TABLE `mail_verify`
  ADD CONSTRAINT `mail_verify_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_`
--
ALTER TABLE `order_`
  ADD CONSTRAINT `order__ibfk_1` FOREIGN KEY (`order_status_id`) REFERENCES `order_status` (`order_status_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `order__ibfk_2` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `password_reset`
--
ALTER TABLE `password_reset`
  ADD CONSTRAINT `password_reset_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD CONSTRAINT `product_categories_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_categories_ibfk_2` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategory` (`subcategory_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_photos`
--
ALTER TABLE `product_photos`
  ADD CONSTRAINT `product_photos_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_review`
--
ALTER TABLE `product_review`
  ADD CONSTRAINT `product_review_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_review_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD CONSTRAINT `subcategory_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`user_register_option_id`) REFERENCES `user_register_option` (`user_register_option_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
