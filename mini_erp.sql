-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2025 at 10:11 AM
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `create_test_products` (IN `num_products` INT)   BEGIN
    -- Variables for loop control
    DECLARE i INT DEFAULT 1;
    
    -- Variables for product data
    DECLARE product_name VARCHAR(45);
    DECLARE product_description VARCHAR(45); -- Matches VARCHAR(45) from your table structure
    DECLARE product_stock INT(11);          -- Matches int(11)
    DECLARE product_price DECIMAL(10, 2);   -- Matches decimal(10,2)
    DECLARE product_image_path VARCHAR(255); -- Matches varchar(255)
    
    -- Define the minimum and maximum values for random data generation
    DECLARE min_stock INT DEFAULT 10;
    DECLARE max_stock INT DEFAULT 1000;
    DECLARE min_price INT DEFAULT 5;
    DECLARE max_price INT DEFAULT 500;
    
    -- Start the loop
    WHILE i <= num_products DO
        -- Generate unique product details
        SET product_name = CONCAT('Test Product ', i);
        -- Keep description brief to match VARCHAR(45) length constraint
        SET product_description = CONCAT('Test item #', i); 
        
        -- Generate random stock quantity (between min_stock and max_stock)
        SET product_stock = FLOOR(min_stock + (RAND() * (max_stock - min_stock + 1)));
        
        -- Generate random price (between min_price and max_price, rounded to two decimal places)
        SET product_price = ROUND(min_price + (RAND() * (max_price - min_price)), 2);
        
        -- Set a generic placeholder path (matches the table's default NULL option)
        SET product_image_path = CONCAT('/images/test/', i, '.jpg'); 
        
        -- Insert the new product into the inventory table
        INSERT INTO inventory (item_name, description, qty, price, image_path)
        VALUES (product_name, product_description, product_stock, product_price, product_image_path);
        
        SET i = i + 1;
    END WHILE;
END$$

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
(174, 10, 'Staff John Carlo Arias logged out.', '2025-12-10 20:33:11'),
(175, 10, 'Staff logged in.', '2025-12-11 18:10:36'),
(176, 10, 'Sold 12 pcs of Milo to Carlo', '2025-12-11 18:17:21'),
(177, 10, 'Customer: Michale is added.', '2025-12-11 18:25:17'),
(178, 10, 'Customer: Michael is added.', '2025-12-11 18:27:50'),
(179, 10, 'Customer: micahs is added.', '2025-12-11 18:29:23'),
(180, 10, 'Customer: Mehasdj is added.', '2025-12-11 18:31:51'),
(181, 10, 'Customer: jhsajjkh is added.', '2025-12-11 18:32:21'),
(182, 10, 'Customer: Paulskie is added.', '2025-12-11 18:32:29'),
(183, 10, 'Created PO for item ID: 27 (Qty: 90)', '2025-12-11 19:08:45'),
(184, 10, 'Staff John Carlo Arias logged out.', '2025-12-11 19:17:18'),
(185, 10, 'Staff logged in.', '2025-12-11 19:17:26'),
(186, 10, 'Staff John Carlo Arias logged out.', '2025-12-11 19:19:40'),
(187, 10, 'Staff logged in.', '2025-12-11 19:19:46'),
(188, 10, 'Customer: Carlo is updated.', '2025-12-11 19:39:24'),
(189, 10, 'Customer: aksdj was deleted.', '2025-12-11 19:47:51'),
(190, 10, 'Customer: aksdj was deleted.', '2025-12-11 19:52:40'),
(191, 10, 'Customer: Carlo is updated.', '2025-12-11 19:53:25'),
(192, 10, 'Customer: Carloo is updated.', '2025-12-11 20:23:02'),
(193, 10, 'Customer: Paul is updated.', '2025-12-11 20:27:59'),
(194, 10, 'Customer: Carloo is updated.', '2025-12-11 20:28:13'),
(195, 10, 'Customer: Carloo is updated.', '2025-12-11 20:28:19'),
(196, 10, 'Customer: Carloo is updated.', '2025-12-11 20:28:45'),
(197, 10, 'Customer: Carloo is updated.', '2025-12-11 20:28:51'),
(198, 10, 'Customer: Carloo is updated.', '2025-12-11 20:28:58'),
(199, 10, 'Customer: Carloo is updated.', '2025-12-11 20:29:10'),
(200, 10, 'Customer: heliosad is updated.', '2025-12-11 20:29:20'),
(201, 10, 'Customer: Carloo is updated.', '2025-12-11 20:29:32'),
(202, 10, 'Customer: heliosad is updated.', '2025-12-11 20:29:47'),
(203, 10, 'Customer: Carloo is updated.', '2025-12-11 20:31:09'),
(204, 10, 'Customer: Carloo is updated.', '2025-12-11 20:31:16'),
(205, 10, 'Customer: heliosad was deleted.', '2025-12-11 20:31:21'),
(206, 10, 'Staff John Carlo Arias logged out.', '2025-12-11 21:39:10'),
(207, 10, 'Staff logged in.', '2025-12-11 22:19:25'),
(208, 10, 'Customer: jhsajjkh was deleted.', '2025-12-11 22:20:15'),
(209, 10, 'Added Supplier: Prince', '2025-12-11 22:42:23'),
(210, 10, 'Created PO for item ID: 27 (Qty: 23)', '2025-12-11 22:43:18'),
(211, 10, 'Created PO for item ID: 26 (Qty: 21)', '2025-12-11 22:45:06'),
(212, 10, 'Added Supplier: Gaisano', '2025-12-11 22:45:36'),
(213, 10, 'Supplier: Feeds is updated.', '2025-12-11 22:46:14'),
(214, 10, 'Supplier: Feeds is updated.', '2025-12-11 22:47:26'),
(215, 10, 'Supplier: Feeds21 is updated.', '2025-12-11 22:47:33'),
(216, 10, 'Supplier: Feeds21 was deleted.', '2025-12-11 22:47:40'),
(217, 10, 'Supplier: Feeds21 was deleted.', '2025-12-11 22:48:19'),
(218, 10, 'Supplier: jack was deleted.', '2025-12-11 22:49:27'),
(219, 10, 'Supplier: Polaskjd was deleted.', '2025-12-11 22:49:32'),
(220, 10, 'Staff John Carlo Arias logged out.', '2025-12-11 22:52:45'),
(221, 10, 'Administrator logged in.', '2025-12-11 22:52:49'),
(222, 10, 'Administrator John Carlo Arias logged out.', '2025-12-11 22:56:33'),
(223, 10, 'Administrator logged in.', '2025-12-12 15:05:40'),
(224, 10, 'Received PO ID 20, increasing stock.', '2025-12-12 15:11:03'),
(225, 10, 'Supplier: Nestle is updated.', '2025-12-12 15:11:13'),
(226, 10, 'Supplier: Nestle is updated.', '2025-12-12 15:11:21'),
(227, 10, 'Supplier: Gaisano2 is updated.', '2025-12-12 15:11:25'),
(228, 10, 'Supplier: Gaisano is updated.', '2025-12-12 15:11:29'),
(229, 10, 'Administrator logged in.', '2025-12-12 15:13:51'),
(230, 10, 'Supplier: Gaisano is updated.', '2025-12-12 15:17:44'),
(231, 10, 'Supplier: Gaisano is updated.', '2025-12-12 15:17:47'),
(232, 10, 'Supplier: Gaisano is updated.', '2025-12-12 15:17:53'),
(233, 10, 'Created PO for item ID: 27 (Qty: 21)', '2025-12-12 15:18:00'),
(234, 10, 'Created PO for item ID: 26 (Qty: 90)', '2025-12-12 15:30:14'),
(235, 10, 'Created PO for item ID: 27 (Qty: 21)', '2025-12-12 15:30:18'),
(236, 10, 'Created PO for item ID: 26 (Qty: 20)', '2025-12-12 15:30:24'),
(237, 10, 'Created PO for item ID: 27 (Qty: 20)', '2025-12-12 15:31:09'),
(238, 10, 'Created PO for item ID: 27 (Qty: 20)', '2025-12-12 15:31:59'),
(239, 10, 'Added item: Kopiko (Qty: 20)', '2025-12-12 15:32:56'),
(240, 10, 'Item (ID: 27) updated, but no logged fields were changed.', '2025-12-12 15:33:03'),
(241, 10, 'Inventory Update (ID: 26): Milo description changed to Chocolate Drink ', '2025-12-12 15:34:09'),
(242, 10, 'Created PO for item ID: 28 (Qty: 21)', '2025-12-12 15:34:23'),
(243, 10, 'Created PO for item ID: 28 (Qty: 80)', '2025-12-12 15:34:30'),
(244, 10, 'Deleted User: TestUser_5', '2025-12-12 15:42:46'),
(245, 10, 'Deleted User: TestUser_4', '2025-12-12 15:44:15'),
(246, 10, 'Administrator updated User (ID: 22) – Changes: Role: admin → staff', '2025-12-12 15:44:27'),
(247, 10, 'Deleted User: TestUser_2', '2025-12-12 15:49:41'),
(248, 10, 'Administrator updated User (ID: 20) – Changes: Role: admin → staff', '2025-12-12 15:49:52'),
(249, 10, 'Administrator updated User (ID: 22) – Changes: Role: staff → admin', '2025-12-12 15:50:08'),
(250, 10, 'Administrator updated User (ID: 22) – Changes: Role: admin → staff', '2025-12-12 15:50:41'),
(251, 10, 'Administrator updated User (ID: 20) – Changes: Role: staff → admin', '2025-12-12 15:52:49'),
(252, 10, 'Deleted User: TestUser_1', '2025-12-12 15:52:56'),
(253, 10, 'Administrator updated User (ID: 22) – Changes: Role: staff → admin', '2025-12-12 15:58:17'),
(254, 10, 'Administrator updated User (ID: 22) – Changes: Role: admin → staff', '2025-12-12 16:00:22'),
(255, 10, 'Administrator updated User (ID: 22) – Changes: Role: staff → admin', '2025-12-12 16:01:56'),
(256, 10, 'Administrator updated User (ID: 22) – Changes: Role: admin → staff', '2025-12-12 16:02:04'),
(257, 10, 'Administrator updated User (ID: 22) – Changes: Role: staff → admin', '2025-12-12 16:02:19'),
(258, 10, 'Deleted User: TestUser_3', '2025-12-12 16:02:25'),
(259, 10, 'Item (ID: 27) updated, but no logged fields were changed.', '2025-12-12 16:02:40'),
(260, 10, 'Item (ID: 26) updated, but no logged fields were changed.', '2025-12-12 16:03:05'),
(261, 10, 'Item (ID: 26) updated, but no logged fields were changed.', '2025-12-12 16:04:43'),
(262, 10, 'Item (ID: 29) updated, but no logged fields were changed.', '2025-12-12 16:12:59'),
(263, 10, 'Deleted Item: Test Product 1', '2025-12-12 16:13:06'),
(264, 10, 'Supplier: Gaisano was deleted.', '2025-12-12 16:30:53'),
(265, 10, 'Supplier: Gaisano was deleted.', '2025-12-12 16:33:13'),
(266, 10, 'Supplier: Magnolia was deleted.', '2025-12-12 16:35:43'),
(267, 10, 'Supplier: Magnolia was deleted.', '2025-12-12 16:35:58'),
(268, 10, 'Supplier: Nestle was deleted.', '2025-12-12 16:36:01'),
(269, 10, 'Supplier: Nestle was deleted.', '2025-12-12 16:36:04'),
(270, 10, 'Supplier: Prince was deleted.', '2025-12-12 16:36:07'),
(271, 10, 'Supplier: Prince was deleted.', '2025-12-12 16:36:32'),
(272, 10, 'Supplier: Prince was deleted.', '2025-12-12 16:36:59'),
(273, 10, 'Supplier: Prince was deleted.', '2025-12-12 16:40:10'),
(274, 10, 'Supplier: Prince was deleted.', '2025-12-12 16:40:15'),
(275, 10, 'Supplier: Prince was deleted.', '2025-12-12 16:41:01'),
(276, 10, 'Supplier:  was deleted.', '2025-12-12 16:53:32'),
(277, 10, 'Supplier:  was deleted.', '2025-12-12 16:56:17'),
(278, 10, 'Supplier: Gaisano is updated.', '2025-12-12 17:01:39'),
(279, 10, 'Supplier: Gaisano212 is updated.', '2025-12-12 17:02:06'),
(280, 10, 'Supplier: Gaisano is updated.', '2025-12-12 17:03:01'),
(281, 10, 'Supplier: Gaisano is updated.', '2025-12-12 17:03:08'),
(282, 10, 'Supplier:  was deleted.', '2025-12-12 17:03:15'),
(283, 10, 'Supplier: Nestle was deleted.', '2025-12-12 17:03:33'),
(284, 10, 'Supplier: Magnolia was deleted.', '2025-12-12 17:03:38'),
(285, 10, 'Supplier: Prince21 is updated.', '2025-12-12 17:04:08'),
(286, 10, 'Supplier: Prince is updated.', '2025-12-12 17:05:56');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `phone`, `is_deleted`) VALUES
(1, 'Carloo', '09275078123', 0),
(2, 'Paul', '1234056786', 0),
(3, 'Saaskld', '20930123', 0),
(4, 'sadsa', '3213213', 0),
(5, 'Mak', '921831212', 0),
(6, 'aksdj', '983123', 1),
(7, 'sadas', '21321312', 0),
(8, 'heliosad', '2147483647', 1),
(9, 'kjashd1', '8273124', 0),
(10, 'Michale', '0', 0),
(11, 'Michael', '234412', 0),
(12, 'micahs', '12837812', 0),
(13, 'Mehasdj', '213123124', 0),
(14, 'jhsajjkh', '2147483647', 1),
(15, 'Paulskie', '218973124', 0);

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
(26, 'Milo', 'Chocolate Drink', 8, 12.99, '../../images/products/download.jpg'),
(27, 'Bear Brand', 'Milk', 110, 12.00, '../../images/products/download (1).jpg'),
(28, 'Kopiko', 'Coffee', 20, 10.00, '../../images/products/8996001410547_800x.webp'),
(30, 'Test Product 2', 'Test item #2', 912, 25.28, '/images/test/2.jpg'),
(31, 'Test Product 3', 'Test item #3', 477, 121.14, '/images/test/3.jpg'),
(32, 'Test Product 4', 'Test item #4', 761, 49.25, '/images/test/4.jpg'),
(33, 'Test Product 5', 'Test item #5', 179, 295.43, '/images/test/5.jpg'),
(34, 'Test Product 6', 'Test item #6', 426, 174.91, '/images/test/6.jpg'),
(35, 'Test Product 7', 'Test item #7', 460, 124.43, '/images/test/7.jpg'),
(36, 'Test Product 8', 'Test item #8', 846, 249.98, '/images/test/8.jpg'),
(37, 'Test Product 9', 'Test item #9', 944, 119.69, '/images/test/9.jpg'),
(38, 'Test Product 10', 'Test item #10', 335, 474.23, '/images/test/10.jpg');

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
(19, 4, 26, 90, 'Received', '2025-12-10 17:56:35'),
(20, 4, 27, 90, 'Received', '2025-12-11 19:08:45'),
(21, 8, 27, 23, 'Pending', '2025-12-11 22:43:18'),
(22, 8, 26, 21, 'Pending', '2025-12-11 22:45:06'),
(23, 9, 27, 21, 'Pending', '2025-12-12 15:18:00'),
(24, 9, 26, 90, 'Pending', '2025-12-12 15:30:14'),
(25, 1, 27, 21, 'Pending', '2025-12-12 15:30:18'),
(26, 8, 26, 20, 'Pending', '2025-12-12 15:30:24'),
(27, 9, 27, 20, 'Pending', '2025-12-12 15:31:09'),
(28, 1, 27, 20, 'Pending', '2025-12-12 15:31:59'),
(29, 8, 28, 21, 'Pending', '2025-12-12 15:34:23'),
(30, 1, 28, 80, 'Pending', '2025-12-12 15:34:30');

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
(29, 1, 26, 12, '2025-12-10 18:02:01', 155.88),
(30, 1, 26, 12, '2025-12-11 18:17:21', 155.88);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `supplier_name` varchar(45) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `supplier_name`, `phone`, `is_deleted`) VALUES
(1, 'Magnolia', '920831923', 0),
(4, 'Feeds21', '092378194', 0),
(5, 'Nestle', '1273612', 0),
(6, 'jack', '1293821312', 0),
(7, 'Polaskjd', '2173123', 0),
(8, 'Prince', '021421412', 0),
(9, 'Gaisano', '12', 0);

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
(10, 'John Carlo Arias', 'carlo@gmail.com', '$2y$10$b/KlZueTDzZ7Fx/DKX/r2.6Re/IEiQgC6mXFZS6BifGwyrSBauP76', 'admin'),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=287;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
