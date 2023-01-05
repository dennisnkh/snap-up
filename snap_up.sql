-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 05, 2022 at 08:38 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `snap_up`
--

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `brandID` int(10) NOT NULL,
  `brandName` varchar(100) NOT NULL,
  `categoryID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`brandID`, `brandName`, `categoryID`) VALUES
(1, 'Dairyland', 1),
(2, 'Silk', 1),
(3, 'No Name', 2),
(4, 'Golden Valley', 2),
(5, 'Simply', 3),
(6, 'Tropicana', 3);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `categoryID` int(10) NOT NULL,
  `categoryName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categoryID`, `categoryName`) VALUES
(1, 'Dairy'),
(2, 'Eggs'),
(3, 'Juice');

-- --------------------------------------------------------

--
-- Table structure for table `chain`
--

CREATE TABLE `chain` (
  `chainID` int(10) NOT NULL,
  `chainName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chain`
--

INSERT INTO `chain` (`chainID`, `chainName`) VALUES
(1, 'Walmart'),
(2, 'Real Canadian Superstore'),
(3, 'T&T Supermarket'),
(4, 'Shoppers Drug Mart'),
(5, 'PriceSmart Foods'),
(6, 'H Mart');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `itemID` int(10) NOT NULL,
  `itemName` varchar(100) NOT NULL,
  `brandID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`itemID`, `itemName`, `brandID`) VALUES
(5, 'No Name, Large Grade A Eggs (12 eggs)', 3),
(6, 'No Name, Grade A Extra Large Eggs (12 eggs)', 3),
(7, 'Golden Valley, White Eggs, Extra Large (18 eggs)', 4),
(8, 'Golden Valley, Born 3 White Eggs, Large (12 eggs)', 4),
(9, 'Simply, Pulp Free Orange Juice (2.63 l)', 5),
(10, 'Simply, With Pulp Orange Juice (2.63 l)', 5),
(11, 'Tropicana, Orange Juice No Pulp (1.54 l)', 6),
(12, 'Tropicana, Orange Juice Some Pulp (1.54 l)', 6),
(13, 'Dairyland, Milk, 2% (4 l)', 1),
(15, 'Silk, Almond For Coffee, Vanilla, Plant Based, Dairy Free Coffee Creamer (473 ml)', 2),
(16, 'Silk, Oat For Coffee, Vanilla, Plant Based, Dairy Free Coffee Creamer', 2),
(26, 'Dairyland, Homogenized Milk (4 l)', 1);

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `reportID` int(10) NOT NULL,
  `userID` int(10) NOT NULL,
  `itemID` int(11) NOT NULL,
  `storeID` int(11) NOT NULL,
  `price` float NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`reportID`, `userID`, `itemID`, `storeID`, `price`, `date`, `time`) VALUES
(5, 2, 5, 5, 3.78, '2022-07-28', '23:31:21'),
(6, 2, 26, 8, 4.3, '2022-08-03', '04:02:51'),
(7, 2, 7, 2, 6.19, '2022-07-28', '23:32:53'),
(8, 2, 8, 6, 4.08, '2022-07-28', '23:32:53'),
(9, 2, 9, 10, 4.97, '2022-07-28', '23:35:41'),
(10, 2, 11, 12, 4, '2022-07-28', '23:35:41'),
(11, 2, 10, 11, 4.97, '2022-07-28', '23:36:26'),
(12, 3, 12, 6, 4, '2022-07-28', '23:36:26'),
(38, 3, 12, 13, 3.97, '2022-07-30', '11:07:37'),
(39, 3, 13, 13, 5.32, '2022-08-01', '08:53:41'),
(47, 6, 13, 8, 3.99, '2022-08-02', '08:00:05'),
(48, 6, 5, 5, 3.79, '2022-08-02', '08:02:11'),
(49, 2, 16, 1, 4.52, '2022-08-02', '08:12:15'),
(50, 2, 10, 12, 4.66, '2022-08-02', '08:14:05'),
(51, 2, 15, 7, 4.44, '2022-08-02', '08:15:22'),
(52, 4, 8, 9, 2.31, '2022-08-03', '04:31:05'),
(53, 4, 6, 8, 5.23, '2022-08-03', '04:36:50'),
(54, 2, 7, 7, 3.22, '2022-08-03', '07:12:56'),
(56, 2, 8, 11, 2.34, '2022-08-04', '01:02:29'),
(57, 2, 5, 1, 8.88, '2022-08-04', '23:46:13');

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE `store` (
  `storeID` int(10) NOT NULL,
  `storeName` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `chainID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `store`
--

INSERT INTO `store` (`storeID`, `storeName`, `address`, `chainID`) VALUES
(1, 'T&T Supermarket (Lansdowne Centre)', '8311 Lansdowne Rd, Richmond, BC V6X 3A4', 3),
(2, 'T&T Supermarket (Marine Gateway)', 'Marine Gateway, 458 SW Marine Dr, Vancouver, BC V5X 0C4', 3),
(5, 'Walmart Supercentre (Central at Garden City)', '9251 Alderbridge Way, Richmond, BC V6X 0N1', 1),
(6, 'Walmart Supercentre (Metropolis at Metrotown)', '4545 Central Blvd, Burnaby, BC V5H 4J5', 1),
(7, 'Real Canadian Superstore (No.3 Road)', '4651 No. 3 Rd, Richmond, BC V6X 2C4', 2),
(8, 'Real Canadian Superstore (Metropolis at Metrotown)', '4700 Kingsway, Burnaby, BC V5H 4M1', 2),
(9, 'H-Mart (Richmond)', '1780-4151 Hazelbridge Way, Richmond, BC V6X 4J7', 6),
(10, 'H-Mart (Coquitlam)', '329 North Rd, Coquitlam, BC V3K 3V8', 6),
(11, 'Shoppers Drug Mart (CF Richmond Centre)', '6060 Minoru Blvd Unit 2286, Richmond, BC V6Y 2V7', 4),
(12, 'Shoppers Drug Mart (Cambie Plaza)', '11800 Cambie Rd., Richmond, BC V6X 1L5', 4),
(13, 'PriceSmart Foods (Richmond)', '8200 Ackroyd Rd, Richmond, BC V6X 1B5', 5),
(14, 'PriceSmart Foods (Burnaby)', '4650 Kingsway, Burnaby, BC V5H 4L9', 5),
(15, 'T&T Supermarket (Hollybridge Way)', '5511 Hollybridge Way, Richmond, BC V7C 0C3', 3);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(10) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `username`, `password`, `isAdmin`) VALUES
(1, 'admin', 'admin', 1),
(2, 'dennis', 'dennis322!', 0),
(3, 'abcde', 'abcde123!', 0),
(4, 'chuchu', 'G00g00isg00g00!', 0),
(5, 'abcde123', 'abcde123!', 0),
(6, 'dennis1', 'dennis322!', 0),
(7, 'steven', 'steven123!', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`brandID`),
  ADD KEY `brand_ibfk_1` (`categoryID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`categoryID`);

--
-- Indexes for table `chain`
--
ALTER TABLE `chain`
  ADD PRIMARY KEY (`chainID`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`itemID`),
  ADD KEY `item_ibfk_2` (`brandID`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`reportID`),
  ADD KEY `report_ibfk_1` (`itemID`),
  ADD KEY `report_ibfk_2` (`storeID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`storeID`),
  ADD KEY `chainID` (`chainID`) USING BTREE;

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `brandID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `categoryID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `chain`
--
ALTER TABLE `chain`
  MODIFY `chainID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `itemID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `reportID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `store`
--
ALTER TABLE `store`
  MODIFY `storeID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `brand`
--
ALTER TABLE `brand`
  ADD CONSTRAINT `brand_ibfk_1` FOREIGN KEY (`categoryID`) REFERENCES `category` (`categoryID`) ON UPDATE CASCADE;

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_2` FOREIGN KEY (`brandID`) REFERENCES `brand` (`brandID`) ON UPDATE CASCADE;

--
-- Constraints for table `report`
--
ALTER TABLE `report`
  ADD CONSTRAINT `report_ibfk_1` FOREIGN KEY (`itemID`) REFERENCES `item` (`itemID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `report_ibfk_2` FOREIGN KEY (`storeID`) REFERENCES `store` (`storeID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `report_ibfk_3` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `store`
--
ALTER TABLE `store`
  ADD CONSTRAINT `store_ibfk_1` FOREIGN KEY (`chainID`) REFERENCES `chain` (`chainID`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
