-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2025 at 01:37 PM
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
-- Database: `mini_erp`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `create_test_users` (IN `num_users` INT)   BEGIN
    DECLARE i INT DEFAULT 1;
    DECLARE user_email VARCHAR(100);
    DECLARE user_name VARCHAR(50);
    DECLARE user_password VARCHAR(255);
    
    -- Assuming a simple SHA256 hash for a test password 'password123'
    SET user_password = SHA2('password123', 256); 

    -- Start the loop
    WHILE i <= num_users DO
        -- Generate unique user details
        SET user_name = CONCAT('TestUser_', i);
        SET user_email = CONCAT('testuser', i, '@example.com');
        
        -- Insert the new user
        INSERT INTO users (name, email, password_hash)
        VALUES (user_name, user_email, user_password);
        
        SET i = i + 1;
    END WHILE;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `date_time`) VALUES
(1, 1, 'Added Supplier: Magnolia', '2025-12-01 14:34:59'),
(2, 1, 'Created PO for item ID', '2025-11-02 15:21:16'),
(3, 1, 'Created PO for item ID: 12 (Qty: 12)', '2025-11-02 15:22:06'),
(4, 1, 'Created PO for item ID: 12 (Qty: 12)', '2025-11-02 15:35:56'),
(5, 1, 'Created PO for item ID: 12 (Qty: 12)', '2025-11-02 15:36:16'),
(6, 1, 'Created PO for item ID: 12 (Qty: 12)', '2025-11-02 15:36:23'),
(7, 1, 'Created PO for item ID: 12 (Qty: 12)', '2025-10-02 15:37:25'),
(8, 1, 'Received PO ID 5, increasing stock.', '2025-10-02 15:45:27'),
(9, 1, 'Received PO ID 4, increasing stock.', '2025-10-02 15:47:09'),
(10, 1, 'Received PO ID 3, increasing stock.', '2025-10-02 15:47:09'),
(11, 1, 'Received PO ID 2, increasing stock.', '2025-12-02 15:47:10'),
(12, 1, 'Received PO ID 1, increasing stock.', '2025-12-02 15:47:11'),
(13, 1, 'Created PO for item ID: 12 (Qty: 11)', '2025-12-02 15:47:23'),
(14, 1, 'Created PO for item ID: 12 (Qty: 11)', '2025-12-02 15:47:26'),
(15, 1, 'Created PO for item ID: 12 (Qty: 11)', '2025-12-02 15:48:03'),
(16, 1, 'Created PO for item ID: 12 (Qty: 11)', '2025-12-02 15:48:08'),
(17, 1, 'Received PO ID 7, increasing stock.', '2025-12-02 15:48:11'),
(18, 1, 'Received PO ID 8, increasing stock.', '2025-12-02 15:48:37'),
(19, 1, 'Received PO ID 9, increasing stock.', '2025-12-02 15:48:38'),
(20, 1, 'Received PO ID 10, increasing stock.', '2025-12-02 15:48:38'),
(21, 1, 'Administrator jksadhj has logged in.', '2025-12-02 16:07:59'),
(22, 2, 'Staff John Carlo C. Arias has logged in.', '2025-12-02 16:08:13'),
(23, 2, 'Customer: kjashd1 is added.', '2025-12-02 16:11:00'),
(24, 2, 'SaleMilo', '2025-12-02 16:11:57'),
(25, 2, 'Sold 3 pcs of Milo', '2025-12-02 16:12:59'),
(26, 1, 'Administrator jksadhj has logged in.', '2025-12-02 16:21:46'),
(27, 1, 'Administrator jksadhj has logged in.', '2025-12-02 16:23:43'),
(28, 1, 'Added Supplier: ', '2025-12-02 16:44:20'),
(29, 1, 'Administrator jksadhj has logged in.', '2025-12-03 15:35:59'),
(30, 1, 'Created PO for item ID: 12 (Qty: 21)', '2025-12-03 15:51:16'),
(31, 1, 'Received PO ID 11, increasing stock.', '2025-12-03 15:51:21'),
(32, 1, 'Administratorjksadhj Created an Account.', '2025-12-03 16:40:30'),
(33, 1, 'Staff Msajdlssss has logged in.', '2025-12-03 17:04:50'),
(34, 2, 'Administrator John Carlo C. Arias has logged in.', '2025-12-04 15:10:54'),
(35, 2, 'Added item: Coffee (Qty: 23)', '2025-12-04 15:34:48'),
(36, 2, 'Administrator Created an Account.', '2025-12-04 15:51:19'),
(37, 2, 'Added item: Milo (Qty: 33)', '2025-12-04 15:58:19'),
(38, 2, 'Added item: Milo (Qty: 200)', '2025-12-04 17:04:58'),
(39, 9, 'Administrator Michael has logged in.', '2025-12-05 18:12:26'),
(40, 9, 'Administrator Created an Account.', '2025-12-05 18:16:18'),
(41, 9, 'Administrator Created an Account.', '2025-12-05 18:16:30'),
(42, 9, 'Deleted User: ', '2025-12-05 18:20:07'),
(43, 9, 'Deleted User: ', '2025-12-05 18:20:09'),
(44, 9, 'Deleted User: ', '2025-12-05 18:24:37'),
(45, 10, 'Administrator John Carlo has logged in.', '2025-12-05 18:25:18'),
(46, 10, 'Administrator Created an Account.', '2025-12-05 18:25:38'),
(47, 10, 'Deleted User: ', '2025-12-05 18:29:32'),
(48, 10, 'Deleted User: TestUser_5', '2025-12-05 18:30:30'),
(49, 10, 'Added item: Milo (Qty: 23)', '2025-12-05 18:34:59'),
(50, 10, 'Deleted Item: Milo', '2025-12-05 18:35:00'),
(51, 10, 'Added item: Milo (Qty: 55)', '2025-12-05 18:37:16'),
(52, 10, 'Item Updated: Milo', '2025-12-05 18:37:19'),
(53, 10, 'Deleted Item: Milo', '2025-12-05 18:47:51'),
(54, 10, 'Added item: Milo (Qty: 23)', '2025-12-05 18:48:06'),
(55, 10, '{\'Milo\'} quantity changed from\'\' to \'2332\' ', '2025-12-05 18:49:21'),
(56, 10, 'Item (ID: 18) updated, but no logged fields were changed.', '2025-12-05 18:53:55'),
(57, 10, 'Item (ID: 18) updated, but no logged fields were changed.', '2025-12-05 18:54:22'),
(58, 10, 'Item (ID: 18) updated, but no logged fields were changed.', '2025-12-05 18:55:19'),
(59, 10, 'Item (ID: 18) updated, but no logged fields were changed.', '2025-12-05 18:55:22'),
(60, 10, 'Item (ID: 18) updated, but no logged fields were changed.', '2025-12-05 18:56:04'),
(61, 10, 'Item (ID: 18) updated, but no logged fields were changed.', '2025-12-05 18:56:45'),
(62, 10, 'Item (ID: 18) updated, but no logged fields were changed.', '2025-12-05 18:58:33'),
(63, 10, 'Inventory Update (ID: 18): {\'Milo2\'} quantity changed from\'219\' to \'2191\' ', '2025-12-05 18:59:04'),
(64, 10, 'Inventory Update (ID: 18): Item name changed to \'Milo\' ; {\'Milo\'} quantity changed from \'2191\' to \'219\' ', '2025-12-05 19:36:43'),
(65, 10, 'Inventory Update (ID: 18): Item name changed to Milo1 ; {\'Milo1\'} quantity changed from \'219\' to \'2191\' ', '2025-12-05 19:37:36'),
(66, 10, 'Inventory Update (ID: 18): Item name changed to Milo ; Milo quantity changed from 2191 to 219 ', '2025-12-05 19:37:58'),
(67, 10, 'Inventory Update (ID: 18): Item name changed to Milo1 and Milo1 quantity changed from 219 to 2191 ', '2025-12-05 19:38:17'),
(68, 10, 'Administrator John Carlo has logged in.', '2025-12-06 22:12:28'),
(69, 10, ' Logged out.', '2025-12-06 22:14:50'),
(70, 10, 'Administrator John Carlo has logged in.', '2025-12-06 22:15:29'),
(71, 10, 'John Carlo Logged out.', '2025-12-06 22:15:36'),
(72, 10, 'Administrator John Carlo has logged in.', '2025-12-06 22:17:44'),
(73, 10, 'Administrator John Carlo Logged out.', '2025-12-06 22:17:47'),
(74, 10, 'Administrator John Carlo has logged in.', '2025-12-06 22:17:54'),
(75, 10, 'Administrator edited User (ID: 1)', '2025-12-06 22:27:59'),
(76, 10, 'Administrator edited User (ID: 1)', '2025-12-06 22:28:02'),
(77, 10, 'Administrator edited User (ID: 1)', '2025-12-06 22:28:21'),
(78, 10, 'Administrator edited User (ID: 1)', '2025-12-06 22:28:23'),
(79, 10, 'Administrator updated User (ID: 1) – Changes: Role: \'staff\' → \'admin\'', '2025-12-06 22:52:38'),
(80, 10, 'Administrator updated User (ID: 1) – Changes: Name: Carlo → Carloo, Email: carlo12@gmail.com → carlo312@gmail.com, Role: admin → staff', '2025-12-06 22:53:24'),
(81, 10, 'Deleted Item: Milo1', '2025-12-06 23:00:28'),
(82, 10, 'Added Supplier: Feeds', '2025-12-06 23:00:44'),
(83, 10, 'Administrator John Carlo logged in.', '2025-12-07 23:27:10'),
(84, 10, 'Added item: B-MEG (Qty: 21)', '2025-12-07 23:29:20'),
(85, 10, 'Created PO for item ID: 19 (Qty: 33)', '2025-12-07 23:29:26'),
(86, 10, 'Received PO ID 12, increasing stock.', '2025-12-07 23:29:56'),
(87, 10, 'Created PO for item ID: 19 (Qty: 22)', '2025-12-07 23:32:16'),
(88, 10, 'Received PO ID 13, increasing stock.', '2025-12-07 23:34:38'),
(89, 10, 'Added item: Milo (Qty: 0)', '2025-12-07 23:39:37'),
(90, 10, 'Added item: Bear Brand (Qty: 0)', '2025-12-07 23:41:13'),
(91, 10, 'Inventory Update (ID: 21): Bear Brand quantity changed from 0 to 1 ', '2025-12-07 23:43:57'),
(92, 10, 'Item (ID: 21) updated, but no logged fields were changed.', '2025-12-07 23:45:18'),
(93, 10, 'Inventory Update (ID: 20): Milo quantity changed from 0 to 1 ', '2025-12-07 23:45:26'),
(94, 10, 'Administrator John Carlo logged out.', '2025-12-07 01:47:24'),
(95, 10, 'Administrator John Carlo logged in.', '2025-12-07 17:01:35'),
(96, 10, 'Administrator John Carlo logged in.', '2025-12-07 17:03:58'),
(97, 10, 'Administrator John Carlo logged in.', '2025-12-07 17:09:23'),
(98, 10, 'Created PO for item ID: 19 (Qty: 33)', '2025-12-07 17:15:47'),
(99, 10, 'Inventory Update (ID: 19): B-MEG quantity changed from 76 to 5 ', '2025-12-07 17:17:37'),
(100, 10, 'Administrator updated User (ID: 10) – Changes: Name: John Carlo → John Carlo Arias', '2025-12-08 17:30:14'),
(101, 10, 'Administrator John Carlo logged out.', '2025-12-08 17:59:22'),
(102, 10, 'Administrator logged in.', '2025-12-09 15:37:51'),
(103, 10, 'Created PO for item ID: 19 (Qty: 11)', '2025-12-09 16:18:50'),
(104, 10, 'Inventory Update (ID: 19): B-MEG price updated from 5 to 5 ', '2025-12-09 16:44:06'),
(105, 10, 'Inventory Update (ID: 19): B-MEG price updated from 5 to 5 ', '2025-12-09 16:44:14'),
(106, 10, 'Inventory Update (ID: 19): B-MEG price updated from 200 to 2000 ', '2025-12-09 16:44:34'),
(107, 10, 'Added item: asasd (Qty: 21)', '2025-12-09 16:49:28'),
(108, 10, 'Deleted Item: asasd', '2025-12-09 16:49:35'),
(109, 10, 'Added item: asdkhas (Qty: 21)', '2025-12-09 16:49:41'),
(110, 10, 'Deleted Item: asdkhas', '2025-12-09 16:53:51'),
(111, 10, 'Inventory Update (ID: 19): B-MEG price updated from 2000 to 2000.59 ', '2025-12-09 16:54:45'),
(112, 10, 'Inventory Update (ID: 19): B-MEG price updated from 2001 to 2001.01 ', '2025-12-09 16:55:09'),
(113, 10, 'Inventory Update (ID: 19): B-MEG price updated from 2001.00 to 2001.21 ', '2025-12-09 16:58:34'),
(114, 10, 'Inventory Update (ID: 19): B-MEG price updated from 2001.21 to 2001.59 ', '2025-12-09 16:58:38'),
(115, 10, 'Received PO ID 15, increasing stock.', '2025-12-09 16:58:56'),
(116, 10, 'Received PO ID 14, increasing stock.', '2025-12-09 16:59:01'),
(117, 10, 'Deleted User: Carloo', '2025-12-09 17:02:50'),
(118, 10, 'Deleted User: TestUser_4', '2025-12-09 17:03:23'),
(119, 10, 'Deleted User: TestUser_3', '2025-12-09 17:08:12'),
(120, 10, 'Deleted User: TestUser_2', '2025-12-09 17:11:12'),
(121, 10, 'Deleted User: TestUser_10', '2025-12-09 17:16:14'),
(122, 10, 'Deleted User: TestUser_9', '2025-12-09 17:16:36'),
(123, 10, 'Deleted User: TestUser_8', '2025-12-09 17:18:07'),
(124, 10, 'Deleted User: TestUser_7', '2025-12-09 17:19:12'),
(125, 10, 'Deleted User: TestUser_6', '2025-12-09 17:19:22'),
(126, 10, 'Administrator updated User (ID: 2) – Changes: Name: Mich → Mich2', '2025-12-09 17:19:37'),
(127, 10, 'Added item: Coffee (Qty: 21)', '2025-12-09 17:25:38'),
(128, 10, 'Deleted Item: Coffee', '2025-12-09 17:25:49'),
(129, 10, 'Deleted Item: Milo', '2025-12-09 17:34:07'),
(130, 10, 'Deleted Item: Bear Brand', '2025-12-09 17:34:12'),
(131, 10, 'Deleted Item: B-MEG', '2025-12-09 17:35:43'),
(132, 10, 'Added item: Milo (Qty: 20)', '2025-12-09 17:36:34'),
(133, 10, 'Deleted Item: Milo', '2025-12-09 17:37:06'),
(134, 10, 'Added item: Milo (Qty: 22)', '2025-12-09 17:38:20'),
(135, 10, 'Inventory Update (ID: 26): Milo quantity updated from 22 to 223 ', '2025-12-09 17:41:02'),
(136, 10, 'Inventory Update (ID: 26): Milo quantity updated from 223 to 22 ', '2025-12-09 17:42:08'),
(137, 10, 'Administrator logged in.', '2025-12-09 17:45:41'),
(138, 10, 'Administrator updated User (ID: 2) – Changes: Name: Mich2 → Mich2s', '2025-12-09 17:49:54'),
(139, 10, 'Inventory Update (ID: 26): Milo price updated from 12.23 to 12.99 ', '2025-12-09 17:50:20'),
(140, 10, 'Inventory Update (ID: 26): Milo quantity updated from 22 to 222 ', '2025-12-09 17:55:06'),
(141, 10, 'Added Supplier: Nestle', '2025-12-09 17:56:18'),
(142, 10, 'Added Supplier: jack', '2025-12-09 17:56:40'),
(143, 10, 'Created PO for item ID: 26 (Qty: 23)', '2025-12-09 17:57:17'),
(144, 10, 'Created PO for item ID: 26 (Qty: 23)', '2025-12-09 17:57:33'),
(145, 10, 'Created PO for item ID: 26 (Qty: 11)', '2025-12-09 17:57:41'),
(146, 10, 'Added Supplier: Polaskjd', '2025-12-09 17:59:31'),
(147, 10, 'Administrator John Carlo Arias logged out.', '2025-12-09 19:40:16'),
(148, 10, 'Inventory Update (ID: 26): Milo quantity updated from 222 to 2 ', '2025-12-10 00:06:34'),
(149, 10, 'Administrator John Carlo Arias logged out.', '2025-12-10 00:30:31'),
(150, 10, 'Staff logged in.', '2025-12-10 17:34:37'),
(151, 10, 'Sold 1 pcs of Milo', '2025-12-10 17:43:12'),
(152, 10, 'Sold 1 pcs of Milo', '2025-12-10 17:46:44'),
(153, 10, 'Received PO ID 18, increasing stock.', '2025-12-10 17:52:21'),
(154, 10, 'Received PO ID 17, increasing stock.', '2025-12-10 17:52:22'),
(155, 10, 'Received PO ID 16, increasing stock.', '2025-12-10 17:52:22'),
(156, 10, 'Sold 57 pcs of Milo', '2025-12-10 17:52:44'),
(157, 10, 'Created PO for item ID: 26 (Qty: 90)', '2025-12-10 17:56:35'),
(158, 10, 'Received PO ID 19, increasing stock.', '2025-12-10 17:56:42'),
(159, 10, 'Sold 1 pcs of Milo to Carlo', '2025-12-10 18:00:27'),
(160, 10, 'Sold 12 pcs of Milo to Carlo', '2025-12-10 18:02:01'),
(161, 10, 'Item (ID: 26) updated, but no logged fields were changed.', '2025-12-10 18:33:51'),
(162, 10, 'Added item: Bear Brand (Qty: 1)', '2025-12-10 18:34:29'),
(163, 10, 'Inventory Update (ID: 26): Milo image path updated', '2025-12-10 18:35:36'),
(164, 10, 'Item (ID: 26) updated, but no logged fields were changed.', '2025-12-10 18:42:09'),
(165, 10, 'Item (ID: 27) updated, but no logged fields were changed.', '2025-12-10 18:43:10'),
(166, 10, 'Inventory Update (ID: 27): Bear Brand image path updated', '2025-12-10 18:43:55'),
(167, 10, 'Inventory Update (ID: 27): Bear Brand image path updated', '2025-12-10 18:44:00'),
(168, 10, 'Inventory Update (ID: 27): Bear Brand image path updated', '2025-12-10 18:44:27'),
(169, 10, 'Inventory Update (ID: 27): Bear Brand quantity updated from 1 to 20 ', '2025-12-10 18:46:46'),
(170, 10, 'Administrator Created an Account.', '2025-12-10 20:31:38'),
(171, 10, 'Administrator Created an Account.', '2025-12-10 20:31:55'),
(172, 10, 'Administrator Created an Account.', '2025-12-10 20:32:25'),
(173, 10, 'Administrator Created an Account.', '2025-12-10 20:32:43'),
(174, 10, 'Staff John Carlo Arias logged out.', '2025-12-10 20:33:11');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `phone` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `phone`) VALUES
(1, 'Carlo', 9823912),
(2, 'Paul', 2147483647),
(3, 'Saaskld', 20930123),
(4, 'sadsa', 3213213),
(5, 'Mak', 921831212),
(6, 'aksdj', 983123),
(7, 'sadas', 21321312),
(8, 'heliosad', 12321545),
(9, 'kjashd1', 8273124);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `item_name` varchar(45) NOT NULL,
  `description` varchar(45) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `item_name`, `description`, `qty`, `price`, `image_path`) VALUES
(26, 'Milo', '', 20, 12.99, '../../images/products/download.jpg'),
(27, 'Bear Brand', '', 20, 12.00, '../../images/products/download (1).jpg');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `status` varchar(45) NOT NULL DEFAULT 'Pending',
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase_orders`
--

INSERT INTO `purchase_orders` (`id`, `supplier_id`, `item_id`, `qty`, `status`, `date_created`) VALUES
(1, 1, 12, 12, 'Received', '2025-12-02 15:21:16'),
(2, 1, 12, 12, 'Received', '2025-12-02 15:22:05'),
(3, 1, 12, 12, 'Received', '2025-12-02 15:35:56'),
(4, 1, 12, 12, 'Received', '2025-12-02 15:36:16'),
(5, 1, 12, 12, 'Received', '2025-12-02 15:36:23'),
(6, 1, 12, 12, 'Received', '2025-12-02 15:37:25'),
(7, 1, 12, 11, 'Received', '2025-12-02 15:47:23'),
(8, 1, 12, 11, 'Received', '2025-12-02 15:47:26'),
(9, 1, 12, 11, 'Received', '2025-12-02 15:48:03'),
(10, 1, 12, 11, 'Received', '2025-12-02 15:48:08'),
(11, 1, 12, 21, 'Received', '2025-12-03 15:51:16'),
(12, 4, 19, 33, 'Received', '2025-12-07 23:29:26'),
(13, 4, 19, 22, 'Received', '2025-12-07 23:32:16'),
(14, 4, 19, 33, 'Received', '2025-12-08 17:15:47'),
(15, 4, 19, 11, 'Received', '2025-12-09 16:18:50'),
(16, 5, 26, 23, 'Received', '2025-12-09 17:57:17'),
(17, 5, 26, 23, 'Received', '2025-12-09 17:57:33'),
(18, 1, 26, 11, 'Received', '2025-12-09 17:57:41'),
(19, 4, 26, 90, 'Received', '2025-12-10 17:56:35');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `total_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `customer_id`, `item_id`, `qty`, `date_created`, `total_amount`) VALUES
(5, 4, NULL, 5, '2025-12-01 15:37:01', 21.23),
(6, 1, NULL, 1, '2025-12-01 15:38:01', 100.59),
(7, 1, NULL, 3, '2025-12-01 15:38:17', 0.00),
(8, 2, NULL, 7, '2025-12-01 15:42:08', 0.00),
(9, 1, NULL, 3, '2025-12-01 16:09:15', 0.00),
(10, 3, NULL, 10, '2025-12-01 16:09:23', 0.00),
(11, 3, NULL, 10, '2025-12-01 18:18:06', 0.00),
(12, 3, NULL, 10, '2025-12-01 18:18:47', 0.00),
(13, 3, NULL, 10, '2025-12-01 18:23:30', 0.00),
(14, 1, NULL, 20, '2025-12-02 16:11:57', 0.00),
(15, 6, NULL, 3, '2025-12-02 16:12:59', 0.00),
(16, 1, 26, 1, '2025-12-10 17:43:12', 0.00),
(17, 6, 26, 1, '2025-12-10 17:46:44', 12.99),
(18, 1, 26, 57, '2025-12-10 17:52:44', 740.43),
(19, 1, 26, 25, '2025-12-10 17:56:50', 324.75),
(20, 1, 26, 25, '2025-12-10 17:58:26', 324.75),
(21, 1, 26, 1, '2025-12-10 17:58:37', 12.99),
(22, 1, 26, 1, '2025-12-10 17:59:06', 12.99),
(23, 1, 26, 1, '2025-12-10 17:59:08', 12.99),
(24, 1, 26, 1, '2025-12-10 17:59:17', 12.99),
(25, 1, 26, 1, '2025-12-10 17:59:31', 12.99),
(26, 1, 26, 1, '2025-12-10 17:59:33', 12.99),
(27, 6, 26, 1, '2025-12-10 17:59:39', 12.99),
(28, 1, 26, 1, '2025-12-10 18:00:27', 12.99),
(29, 1, 26, 12, '2025-12-10 18:02:01', 155.88);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `supplier_name` varchar(45) NOT NULL,
  `phone` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `supplier_name`, `phone`) VALUES
(1, 'Magnolia', 920831923),
(4, 'Feeds', 129312412),
(5, 'Nestle', 21398124),
(6, 'jack', 1293821312),
(7, 'Polaskjd', 2173123);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `email` varchar(45) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `roles` enum('admin','staff') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `roles`) VALUES
(2, 'Mich2s', 'micch@gmail.com', '', 'staff'),
(9, 'Michael', 'michael@gmail.com', '$2y$10$9iSaiowJ1YJEaPlLogDtlOsiBZ28l3o6JWp0z1GYLPijn3NIMXJ.i', 'admin'),
(10, 'John Carlo Arias', 'carlo@gmail.com', '$2y$10$b/KlZueTDzZ7Fx/DKX/r2.6Re/IEiQgC6mXFZS6BifGwyrSBauP76', 'staff'),
(20, 'TestUser_1', 'testuser1@example.com', 'ef92b778bafe771e89245b89ecbc08a44a4e166c06659911881f383d4473e94f', 'admin'),
(21, 'TestUser_2', 'testuser2@example.com', 'ef92b778bafe771e89245b89ecbc08a44a4e166c06659911881f383d4473e94f', 'admin'),
(22, 'TestUser_3', 'testuser3@example.com', 'ef92b778bafe771e89245b89ecbc08a44a4e166c06659911881f383d4473e94f', 'admin'),
(23, 'TestUser_4', 'testuser4@example.com', 'ef92b778bafe771e89245b89ecbc08a44a4e166c06659911881f383d4473e94f', 'admin'),
(24, 'TestUser_5', 'testuser5@example.com', 'ef92b778bafe771e89245b89ecbc08a44a4e166c06659911881f383d4473e94f', 'admin'),
(30, 'Kendra Maxene Pisao', 'kendra@gmail.com', '$2y$10$GCby/Vgw7B/CtTyZZxoTVOXHb3JDN9WbwrG9Oq4EZ8ZA6RdWO0xaG', 'staff'),
(31, 'Jelaine Faye Gica', 'jelaine@gmail.com', '$2y$10$5QslgEfjp0C676Hv8fmFb.xHqsWMHS59rHgxoT2g2m1Yce7zBnGGO', 'staff'),
(32, 'Paulo Lumapas', 'paulo@gmail.com', '$2y$10$aVRScHA8Jmle0PSu3/ckJegRcT2OleKbohNj.LmBr1t3L4SQ90AU6', 'staff'),
(33, 'Harvy Drona', 'harvy@gmail.com', '$2y$10$2QX9CGHRQdMIzwaAHFL3Huylu/M0uOLrc/f1MWanHYtLpWz2mSAAq', 'staff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sales_customer` (`customer_id`),
  ADD KEY `fk_sales_item` (`item_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
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
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=175;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `fk_sales_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `fk_sales_item` FOREIGN KEY (`item_id`) REFERENCES `inventory` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
