-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2024 at 06:00 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `giveandtake`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `categories_id` int(11) NOT NULL,
  `categories_name` varchar(100) NOT NULL,
  `categories_name_ar` varchar(100) NOT NULL,
  `categories_image` varchar(255) NOT NULL,
  `categories_datetime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categories_id`, `categories_name`, `categories_name_ar`, `categories_image`, `categories_datetime`) VALUES
(1, 'Furniture', 'أثاث', 'laptop.svg', '2023-07-21 00:35:57'),
(2, 'Household ِAppliances', 'منزليات', 'camera.svg', '2023-07-21 00:37:28'),
(3, 'Clothes', 'ملابس', 'mobile.svg', '2023-07-21 00:37:28');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `items_id` int(11) NOT NULL,
  `items_name` varchar(100) NOT NULL,
  `items_desc` varchar(255) NOT NULL,
  `items_image` varchar(255) NOT NULL,
  `items_status` tinyint(4) NOT NULL DEFAULT 1,
  `items_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `items_cat` int(11) NOT NULL,
  `items_owner` int(11) NOT NULL,
  `items_owner_show` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`items_id`, `items_name`, `items_desc`, `items_image`, `items_status`, `items_date`, `items_cat`, `items_owner`, `items_owner_show`) VALUES
(13, 'كاميرا', '7807camera', '7807camera-removebg-preview.png', 2, '2023-12-26 19:08:12', 3, 26, 1),
(14, 'ملابس', 'ملابس قديمة', '70401000_F_118678164_E58ObGsOpmQcyfPTBB8jGOHoO4kqprwu.jpg', 2, '2023-12-26 22:29:03', 2, 27, 1),
(15, 'كنب', 'كنب قطعنتين', 'gg40.jpg', 1, '2024-05-12 15:21:05', 1, 26, 1),
(16, 'كنب اخضر', 'كنب قطعه واحده لون اخضر', 'gg39.png', 1, '2024-05-12 15:21:05', 1, 34, 1),
(17, 'كنب', 'كنب قطعنتين', 'gg38.jpg', 1, '2024-05-12 15:21:05', 1, 34, 1),
(18, 'كنب لون بيج', 'كنب قطعه مع اربع مخدات', 'gg40.jpg', 1, '2024-05-12 15:21:05', 1, 34, 1),
(19, 'غرفة نوم صغيره', 'غرفة نوم صغيره لون بيج', 'gg31.jpg', 1, '2024-05-12 15:21:05', 1, 34, 1),
(20, 'مكيف', 'مكيف قطعة واحدة', 'gg26.jpg', 1, '2024-05-12 15:21:05', 2, 34, 1),
(21, 'طاولة', 'طاولة خشبية', 'gg34.jpeg', 1, '2024-05-12 15:21:05', 1, 35, 1),
(22, 'ثلاجة', 'ثلاجة صغيره', 'gg21.webp', 1, '2024-05-12 15:21:05', 2, 35, 1),
(23, 'سرير', 'سرير نفر', 'gg14.jpg', 1, '2024-05-12 15:21:05', 1, 35, 1),
(24, 'دولاب كبير وسغير', 'دولاب ملابس كبير مع دولاب سغير لون خشبي', 'gg13.jpg', 1, '2024-05-12 15:21:05', 1, 35, 1),
(25, 'غسالة مابس', 'غسالة ملابس كهربائية', 'gg23.webp', 1, '2024-05-12 15:21:05', 2, 34, 1),
(26, 'مكيف بانكول', 'مكيف قطعتين', 'gg27.jpg', 1, '2024-05-12 15:21:05', 2, 35, 1),
(27, 'ملابس نسائية', ' مجموعة ملابس نسائية', 'gg02.webp', 1, '2024-05-12 15:21:05', 3, 35, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orderr`
--

CREATE TABLE `orderr` (
  `notif_id` int(11) NOT NULL,
  `notif_item` int(11) NOT NULL,
  `notif_status` tinyint(4) NOT NULL,
  `notif_orderby` int(11) NOT NULL,
  `notif_detials` varchar(255) NOT NULL,
  `notif_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_type` int(11) NOT NULL DEFAULT 0,
  `user_name` varchar(255) NOT NULL,
  `user_phone` varchar(100) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_verifycode` int(11) NOT NULL,
  `user_approve` tinyint(4) NOT NULL DEFAULT 1,
  `user_create` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_type`, `user_name`, `user_phone`, `user_password`, `user_email`, `user_verifycode`, `user_approve`, `user_create`) VALUES
(26, 0, 'arwa', '211212', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'test@gmail.com', 48051, 1, '2023-07-26 23:45:46'),
(27, 3, 'admin@gmail.com', '73737', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'admin@gmail.com', 70577, 2, '2023-07-28 00:35:06'),
(33, 1, 'daaddsd', '123456', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'nawafmesa@gmail.com', 48970, 1, '2024-03-28 23:05:52'),
(34, 1, 'Haneen Mohammed', '0555555555', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'haneenmohammed@gmail.com', 211221, 1, '2024-05-11 15:27:24'),
(35, 1, 'Aisha Mahdi', '0554555455', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'aishamahdi@gmail.com', 2121, 1, '2024-05-11 15:30:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categories_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`items_id`),
  ADD KEY `itemFG1` (`items_cat`),
  ADD KEY `itemFG2` (`items_owner`);

--
-- Indexes for table `orderr`
--
ALTER TABLE `orderr`
  ADD PRIMARY KEY (`notif_id`),
  ADD KEY `notifFG2` (`notif_orderby`),
  ADD KEY `notifFG1` (`notif_item`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categories_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `items_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `orderr`
--
ALTER TABLE `orderr`
  MODIFY `notif_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `itemFG1` FOREIGN KEY (`items_cat`) REFERENCES `categories` (`categories_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `itemFG2` FOREIGN KEY (`items_owner`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orderr`
--
ALTER TABLE `orderr`
  ADD CONSTRAINT `notifFG1` FOREIGN KEY (`notif_item`) REFERENCES `items` (`items_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `notifFG2` FOREIGN KEY (`notif_orderby`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
