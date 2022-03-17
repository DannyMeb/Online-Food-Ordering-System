-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2021 at 09:18 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_restaurant`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Phone` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`ID`, `Name`, `Phone`, `Email`, `Address`, `Password`) VALUES
(1, 'Daniel', '0545999123', 'daniel@gmail.com', ' Zayed University, Abu Dhabi, UAE', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`ID`, `Name`) VALUES
(1, 'Burger'),
(2, 'Pizza'),
(3, 'Biryani'),
(4, 'Drinks');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Phone` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`ID`, `Name`, `Phone`, `Email`, `Address`, `password`) VALUES
(1, 'Daniel', '0545999123', 'daniel@gmail.com', ' Zayed University, Abu Dhabi, UAE', '12345'),
(42, 'Aron', '051232345345', NULL, 'Abu Dhabi UAE', '228'),
(44, 'Reem', '051232345345', NULL, 'Abu Dhabi UAE', '123'),
(46, 'Mewael', '051232345345', NULL, 'Abu Dhabi UAE', '123'),
(47, 'Aronn', '051232345345', NULL, 'Abu Dhabi UAE', '228');

-- --------------------------------------------------------

--
-- Table structure for table `menulist`
--

CREATE TABLE `menulist` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menulist`
--

INSERT INTO `menulist` (`ID`, `Name`, `description`, `price`, `category`, `status`) VALUES
(1, 'NICE BURGER', 'Made with Italian Sauce, Chicken, & organic veg', '20.00', 1, 'Available'),
(2, 'TRIPPLE WHOPPER', 'Flame-grilled beef topped with juicy tomatoes', '29.00', 1, 'Available'),
(3, 'MUSHROOM SWISS XL', 'Melted swiss cheese on two grilled beef patties', '25.00', 1, 'Available'),
(4, 'CHICKEN ROYALE', 'Made with white meat chicken & topped with lettuce', '23.00', 1, 'Available'),
(5, 'BIG CHICKY', 'Crowned by corn-dusted bun, delicious 4 Half\'s bacon', '28.00', 1, 'Available'),
(6, 'CHICKEN FILLET', 'Loaded with chopped lettuce and creamy mayonnaise', '23.00', 1, 'Available'),
(7, 'APPLE JUICE', ' A tasty and nutritious is fortified with vitamin C', '16.00', 4, 'Available'),
(8, 'ORANGE JUICE', ' A tasty and nutritious with primary Orange Fruit', '19.00', 4, 'Available'),
(9, 'AVACDO JUICE', ' A tasty and nutritious with primary fresh Avacado \r\n ', '19.00', 4, 'Not Available'),
(10, 'COCKTAIL JUICE', ' A tasty and nutritious with primary fresh Mango fruit\r\n', '12.00', 4, 'Available'),
(11, 'PEPSI', ' Carbonated soft drink manufactured by PepsiCo\r\n', '3.00', 4, 'Not Available'),
(12, 'COLA', ' Carbonated soft drink manufactured by Coca-Cola Inc', '3.00', 4, 'Available'),
(13, 'FANTA', ' Fruit-flavored carbonated soft drinks by Coca-Cola', '3.00', 4, 'Available'),
(14, 'CLASSIC CHICKEN', ' Grilled Chicken, Mozzzarell, and Onions', '49.00', 2, 'Available'),
(15, 'CLASSIC PEPPERONI', ' Mozzarella and Pepperoni with Chiotle BBQ Dip', '51.00', 2, 'Available'),
(16, 'CHICKEN BRIYANI', ' Delicious biryani made from toasted chicken & rice', '25.00', 3, 'Available'),
(17, 'BEEF BRIYANI', 'Delicious biryani made from staked beef', '28.00', 3, 'Available'),
(22, 'New', 'new', '6.00', 2, 'Not Available'),
(24, 'Epic Burger', 'Made from chicken topped with juicy tomatoes and onion', '31.00', 1, 'Not Available'),
(25, 'Epic Pizza', 'Made from chicken topped with juicy tomatoes and onion', '34.00', 2, 'Available'),
(26, 'Felafl', 'Made from chicken topped with juicy tomatoes and onion', '3.00', 1, 'Not Available');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `ID` int(11) NOT NULL,
  `orderedDate` varchar(255) DEFAULT NULL,
  `Item_ID` int(11) NOT NULL,
  `status_ID` int(11) NOT NULL,
  `customer_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`ID`, `orderedDate`, `Item_ID`, `status_ID`, `customer_ID`) VALUES
(109, '2021-12-05', 12, 4, 47);

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`ID`, `Name`) VALUES
(1, 'Ordered'),
(2, 'Preparing'),
(3, 'Delivering'),
(4, 'Delivered'),
(5, 'Cancelled');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `menulist`
--
ALTER TABLE `menulist`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `belongs` (`category`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `item` (`Item_ID`),
  ADD KEY `customer` (`customer_ID`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrator`
--
ALTER TABLE `administrator`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `menulist`
--
ALTER TABLE `menulist`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menulist`
--
ALTER TABLE `menulist`
  ADD CONSTRAINT `belongs` FOREIGN KEY (`category`) REFERENCES `category` (`ID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `customer` FOREIGN KEY (`customer_ID`) REFERENCES `customer` (`ID`),
  ADD CONSTRAINT `item` FOREIGN KEY (`Item_ID`) REFERENCES `menulist` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
