-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 19, 2024 at 06:29 PM
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
-- Database: `dbfoodsafety`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblblacklist`
--

CREATE TABLE `tblblacklist` (
  `bid` int(11) NOT NULL,
  `repId` int(11) NOT NULL,
  `bDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblblacklist`
--

INSERT INTO `tblblacklist` (`bid`, `repId`, `bDate`, `status`) VALUES
(1, 1, '2023-01-08 15:28:25', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tblfeedback`
--

CREATE TABLE `tblfeedback` (
  `fId` int(11) NOT NULL,
  `pId` int(11) NOT NULL,
  `rId` int(11) NOT NULL,
  `fDate` datetime NOT NULL,
  `feedback` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Submitted'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblfeedback`
--

INSERT INTO `tblfeedback` (`fId`, `pId`, `rId`, `fDate`, `feedback`, `status`) VALUES
(1, 1, 1, '0000-00-00 00:00:00', '2023-01-08 15:48:37', 'Replied'),
(2, 1, 1, '2024-10-15 00:12:35', 'good food', 'Submitted'),
(3, 1, 1, '2024-10-15 00:16:29', 'good food', 'Submitted'),
(4, 1, 1, '2024-10-15 00:19:06', 'good food', 'Submitted'),
(5, 1, 2, '2024-10-15 09:18:29', 'good food', 'Submitted');

-- --------------------------------------------------------

--
-- Table structure for table `tblfooditems`
--

CREATE TABLE `tblfooditems` (
  `food_id` int(11) NOT NULL,
  `rId` int(11) DEFAULT NULL,
  `food_name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `food_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblfooditems`
--

INSERT INTO `tblfooditems` (`food_id`, `rId`, `food_name`, `price`, `description`, `food_image`) VALUES
(1, 2, 'Biriyani', 250.00, 'Chicken biriyani', '../uploads/food/biriyani.jpg'),
(2, 2, 'Masala dosha', 50.00, 'dosha', '../uploads/food/dosha.jpg'),
(3, 1, 'Biriyani', 220.00, 'Chicke biriyani', '../uploads/food/biriyani.jpg'),
(4, 2, 'Veg biriyani', 200.00, 'authentic veg biriyani', '../uploads/food/veg.jpg'),
(5, 2, 'coca cola', 30.00, 'drink', '../uploads/food/cola.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tblinspection`
--

CREATE TABLE `tblinspection` (
  `inspId` int(11) NOT NULL,
  `iId` int(11) NOT NULL,
  `rId` int(11) NOT NULL,
  `inspDate` date NOT NULL,
  `inspRequest` varchar(500) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblinspection`
--

INSERT INTO `tblinspection` (`inspId`, `iId`, `rId`, `inspDate`, `inspRequest`, `status`) VALUES
(1, 1, 1, '2023-01-09', 'Not clean', 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `tblinspector`
--

CREATE TABLE `tblinspector` (
  `iId` int(11) NOT NULL,
  `iName` varchar(50) NOT NULL,
  `iLicense` varchar(50) NOT NULL,
  `iAddress` varchar(100) NOT NULL,
  `iContact` varchar(50) NOT NULL,
  `iEmail` varchar(50) NOT NULL,
  `iImage` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblinspector`
--

INSERT INTO `tblinspector` (`iId`, `iName`, `iLicense`, `iAddress`, `iContact`, `iEmail`, `iImage`) VALUES
(1, 'Michael', 'kjn57', 'Aluva', '9632501478', 'michael@gmail.com', '../images/t1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbllogin`
--

CREATE TABLE `tbllogin` (
  `lId` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `usertype` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbllogin`
--

INSERT INTO `tbllogin` (`lId`, `username`, `password`, `usertype`, `status`) VALUES
(1, 'admin@gmail.com', 'admin', 'admin', '1'),
(2, 'iftharaluva@gmail.com', 'ifthar', 'restaurant', '1'),
(3, 'mathew@gmail.com', 'mathew', 'public', '1'),
(4, 'michael@gmail.com', '9632501478', 'inspector', '1'),
(5, 'seashoreresidencykdlr@gmail.com', 'seashore', 'restaurant', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tblnotification`
--

CREATE TABLE `tblnotification` (
  `notId` int(11) NOT NULL,
  `notDate` date NOT NULL,
  `notification` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblnotification`
--

INSERT INTO `tblnotification` (`notId`, `notDate`, `notification`) VALUES
(1, '2023-01-08', 'kjnkjnkj');

-- --------------------------------------------------------

--
-- Table structure for table `tblorderitems`
--

CREATE TABLE `tblorderitems` (
  `item_id` int(11) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `food_item` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblorderitems`
--

INSERT INTO `tblorderitems` (`item_id`, `order_id`, `food_item`, `quantity`, `price`) VALUES
(9, '6713a63b6b942', 'coca cola', 2, 30.00),
(10, '6713a63b6b942', 'Biriyani', 2, 250.00),
(11, '6713a7f7623ff', 'Biriyani', 2, 250.00),
(12, '6713a7f7623ff', 'coca cola', 3, 30.00),
(13, '6713a7f7623ff', 'Masala dosha', 1, 50.00),
(14, '6713a7f7623ff', 'Veg biriyani', 1, 200.00),
(15, '6713ab68310c7', 'coca cola', 1, 30.00),
(16, '6713ab68310c7', 'Veg biriyani', 1, 200.00),
(17, '6713ab68310c7', 'Masala dosha', 1, 50.00),
(18, '6713ab68310c7', 'Biriyani', 1, 250.00),
(19, '6713ad88604f1', 'Biriyani', 1, 250.00),
(20, '6713ad88604f1', 'Masala dosha', 1, 50.00),
(21, '6713ad88604f1', 'coca cola', 1, 30.00);

-- --------------------------------------------------------

--
-- Table structure for table `tblorders`
--

CREATE TABLE `tblorders` (
  `order_id` varchar(255) NOT NULL,
  `rId` int(11) DEFAULT NULL,
  `delivery_address` text DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','delivered') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblorders`
--

INSERT INTO `tblorders` (`order_id`, `rId`, `delivery_address`, `order_date`, `status`) VALUES
('6713a5f96a7ef', 2, 'Athulkrishna Vallomparambath Panikkassery Phone: 1739400822, Kaiserstraße 95-97, Würselen, Bayern, 521464', '2024-10-19 12:28:41', 'pending'),
('6713a63b6b942', 2, 'Athulkrishna Vallomparambath Panikkassery Phone: 1739400822, Kaiserstraße 95-97, Würselen, NRW, 521464', '2024-10-19 12:29:47', 'delivered'),
('6713a6c60065f', 2, 'Athulkrishna Vallomparambath Panikkassery Phone: 1739400822, Kaiserstraße 95-97, Würselen, NRW, 521464', '2024-10-19 12:32:06', 'pending'),
('6713a7f7623ff', 2, 'Athulkrishna Vallomparambath Panikkassery Phone: 1739400822, Kaiserstraße 95-97, Würselen, NRW, 521463', '2024-10-19 12:37:11', 'delivered'),
('6713ab68310c7', 2, 'Athulkrishna Vallomparambath Panikkassery Phone: 1739400822, Kaiserstraße 95-97, Würselen, NRW, 521464', '2024-10-19 12:51:52', 'delivered'),
('6713ad88604f1', 2, 'Maya Phone: 9496170098, Kodungallur, thrissur, kerala, 680664', '2024-10-19 13:00:56', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `tblpenalty`
--

CREATE TABLE `tblpenalty` (
  `penaltyId` int(11) NOT NULL,
  `repId` int(11) NOT NULL,
  `duedate` date NOT NULL,
  `amt` int(11) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Assigned'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblpenalty`
--

INSERT INTO `tblpenalty` (`penaltyId`, `repId`, `duedate`, `amt`, `status`) VALUES
(1, 1, '2023-01-12', 10000, 'Assigned');

-- --------------------------------------------------------

--
-- Table structure for table `tblpublic`
--

CREATE TABLE `tblpublic` (
  `pId` int(11) NOT NULL,
  `pName` varchar(50) NOT NULL,
  `pAddress` varchar(50) NOT NULL,
  `pEmail` varchar(50) NOT NULL,
  `pContact` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblpublic`
--

INSERT INTO `tblpublic` (`pId`, `pName`, `pAddress`, `pEmail`, `pContact`) VALUES
(1, 'Mathew', 'Aluva', 'mathew@gmail.com', '7485960231'),
(2, 'Public User', 'Public Address', 'public@domain.com', '7885960231');

-- --------------------------------------------------------

--
-- Table structure for table `tblreply`
--

CREATE TABLE `tblreply` (
  `replyId` int(11) NOT NULL,
  `fId` int(11) NOT NULL,
  `reply` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblreply`
--

INSERT INTO `tblreply` (`replyId`, `fId`, `reply`) VALUES
(1, 1, 'kjnmjkln');

-- --------------------------------------------------------

--
-- Table structure for table `tblresponse`
--

CREATE TABLE `tblresponse` (
  `repId` int(11) NOT NULL,
  `inspId` int(11) NOT NULL,
  `repDate` date NOT NULL,
  `report` varchar(100) NOT NULL,
  `rating` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblresponse`
--

INSERT INTO `tblresponse` (`repId`, `inspId`, `repDate`, `report`, `rating`) VALUES
(1, 1, '2023-01-08', 'kjnkijni', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tblrestaurant`
--

CREATE TABLE `tblrestaurant` (
  `rId` int(11) NOT NULL,
  `rName` varchar(50) NOT NULL,
  `rAddress` varchar(100) NOT NULL,
  `rEmail` varchar(50) NOT NULL,
  `rContact` varchar(50) NOT NULL,
  `rLicense` varchar(50) NOT NULL,
  `rImage` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblrestaurant`
--

INSERT INTO `tblrestaurant` (`rId`, `rName`, `rAddress`, `rEmail`, `rContact`, `rLicense`, `rImage`) VALUES
(1, 'Ifthar Aluva', 'Aluva', 'iftharaluva@gmail.com', '9568740231', 'jn85787', '../images/b6.jpg'),
(2, 'Seashore residency', 'Kodungallur near craft hospital', 'seashoreresidencykdlr@gmail.com', '6282702142', '2', '../images/download.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblblacklist`
--
ALTER TABLE `tblblacklist`
  ADD PRIMARY KEY (`bid`);

--
-- Indexes for table `tblfeedback`
--
ALTER TABLE `tblfeedback`
  ADD PRIMARY KEY (`fId`);

--
-- Indexes for table `tblfooditems`
--
ALTER TABLE `tblfooditems`
  ADD PRIMARY KEY (`food_id`);

--
-- Indexes for table `tblinspection`
--
ALTER TABLE `tblinspection`
  ADD PRIMARY KEY (`inspId`);

--
-- Indexes for table `tblinspector`
--
ALTER TABLE `tblinspector`
  ADD PRIMARY KEY (`iId`);

--
-- Indexes for table `tbllogin`
--
ALTER TABLE `tbllogin`
  ADD PRIMARY KEY (`lId`);

--
-- Indexes for table `tblnotification`
--
ALTER TABLE `tblnotification`
  ADD PRIMARY KEY (`notId`);

--
-- Indexes for table `tblorderitems`
--
ALTER TABLE `tblorderitems`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `tblorders`
--
ALTER TABLE `tblorders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `tblpenalty`
--
ALTER TABLE `tblpenalty`
  ADD PRIMARY KEY (`penaltyId`);

--
-- Indexes for table `tblpublic`
--
ALTER TABLE `tblpublic`
  ADD PRIMARY KEY (`pId`);

--
-- Indexes for table `tblreply`
--
ALTER TABLE `tblreply`
  ADD PRIMARY KEY (`replyId`);

--
-- Indexes for table `tblresponse`
--
ALTER TABLE `tblresponse`
  ADD PRIMARY KEY (`repId`);

--
-- Indexes for table `tblrestaurant`
--
ALTER TABLE `tblrestaurant`
  ADD PRIMARY KEY (`rId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblblacklist`
--
ALTER TABLE `tblblacklist`
  MODIFY `bid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblfeedback`
--
ALTER TABLE `tblfeedback`
  MODIFY `fId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblfooditems`
--
ALTER TABLE `tblfooditems`
  MODIFY `food_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblinspection`
--
ALTER TABLE `tblinspection`
  MODIFY `inspId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblinspector`
--
ALTER TABLE `tblinspector`
  MODIFY `iId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbllogin`
--
ALTER TABLE `tbllogin`
  MODIFY `lId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblnotification`
--
ALTER TABLE `tblnotification`
  MODIFY `notId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblorderitems`
--
ALTER TABLE `tblorderitems`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tblpenalty`
--
ALTER TABLE `tblpenalty`
  MODIFY `penaltyId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblpublic`
--
ALTER TABLE `tblpublic`
  MODIFY `pId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblreply`
--
ALTER TABLE `tblreply`
  MODIFY `replyId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblresponse`
--
ALTER TABLE `tblresponse`
  MODIFY `repId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblrestaurant`
--
ALTER TABLE `tblrestaurant`
  MODIFY `rId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblorderitems`
--
ALTER TABLE `tblorderitems`
  ADD CONSTRAINT `tblorderitems_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `tblorders` (`order_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
