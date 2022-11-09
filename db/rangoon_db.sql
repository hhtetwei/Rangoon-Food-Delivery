-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2020 at 06:35 PM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 7.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rangoon_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `contractdetail`
--

CREATE TABLE `contractdetail` (
  `ContractID` varchar(30) NOT NULL,
  `RestaurantID` int(11) NOT NULL,
  `ContractPrice` varchar(60) NOT NULL,
  `Month` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contractdetail`
--

INSERT INTO `contractdetail` (`ContractID`, `RestaurantID`, `ContractPrice`, `Month`) VALUES
('C-000002', 3, '', '12'),
('C-000003', 2, '100000', '12'),
('C-000004', 3, '100000', '12'),
('C-000005', 1, '10000', '12'),
('C-000005', 2, '120000', '12'),
('C-000006', 3, '10000', '12'),
('C-000007', 1, '1000', '1'),
('C-000007', 2, '1000', '2'),
('C-000008', 1, '1111', '11'),
('C-000009', 7, '1000', '3'),
('C-000009', 2, '2000', '2'),
('C-000010', 7, '12000', '20');

-- --------------------------------------------------------

--
-- Table structure for table `contractrestaurants`
--

CREATE TABLE `contractrestaurants` (
  `ContractID` int(11) NOT NULL,
  `ContractDate` date NOT NULL,
  `ContractTotalAmount` varchar(60) NOT NULL,
  `ContractTotalMonth` varchar(60) NOT NULL,
  `GovernmentTax` varchar(60) NOT NULL,
  `VAT` varchar(60) NOT NULL,
  `GrandTotal` varchar(60) NOT NULL,
  `RestaurantID` int(11) NOT NULL,
  `Staff_ID` int(11) NOT NULL,
  `Status` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contractrestaurants`
--

INSERT INTO `contractrestaurants` (`ContractID`, `ContractDate`, `ContractTotalAmount`, `ContractTotalMonth`, `GovernmentTax`, `VAT`, `GrandTotal`, `RestaurantID`, `Staff_ID`, `Status`) VALUES
(1, '0000-00-00', '$txtTotalAmount', '$txtMonth', '$txtVAT', '', '$txtGrandTotal', 0, 0, '$Status'),
(2, '2020-09-22', '0', '0', '0', '', '0', 0, 0, 'Pending'),
(3, '2020-09-22', '1200000', '0', '60000', '', '1260000', 0, 0, 'Pending'),
(4, '2020-09-22', '1200000', '0', '60000', '', '1260000', 0, 0, 'Pending'),
(5, '2020-09-22', '1440000', '0', '72000', '', '1512000', 0, 0, 'Pending'),
(6, '2020-09-22', '120000', '0', '6000', '', '126000', 0, 0, 'Pending'),
(7, '2020-10-14', '3000', '0', '150', '', '3150', 0, 0, 'Pending'),
(8, '2020-10-14', '12221', '12832.05', '611.05', '', '12832.05', 0, 0, 'Pending'),
(9, '2020-10-14', '7000', '0', '350', '', '7350', 0, 0, 'Pending'),
(10, '2020-10-16', '240000', '0', '12000', '', '252000', 0, 0, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `CustomerID` int(11) NOT NULL,
  `CustomerName` varchar(100) NOT NULL,
  `Password` varchar(30) NOT NULL,
  `Phone` varchar(50) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CustomerID`, `CustomerName`, `Password`, `Phone`, `Address`, `Email`) VALUES
(4, 'yoon', 'yoon', '097654888', 'YGN', 'y@email.com');

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

CREATE TABLE `delivery` (
  `DeliveryID` int(11) NOT NULL,
  `DeliveryDate` varchar(60) NOT NULL,
  `DeliveryTime` varchar(60) NOT NULL,
  `EstimatedTime` varchar(60) NOT NULL,
  `ArrivalTime` varchar(60) NOT NULL,
  `Township` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `MenuID` int(11) NOT NULL,
  `MenuName` varchar(100) NOT NULL,
  `Price` int(60) NOT NULL,
  `MenuTypeID` varchar(100) NOT NULL,
  `RestaurantID` int(11) NOT NULL,
  `ShortDescription` varchar(100) NOT NULL,
  `Promotion` varchar(30) NOT NULL,
  `Quantity` int(30) NOT NULL,
  `Image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`MenuID`, `MenuName`, `Price`, `MenuTypeID`, `RestaurantID`, `ShortDescription`, `Promotion`, `Quantity`, `Image`) VALUES
(16, 'Fried chicken', 4500, '4', 1, 'Tasty fried chicken', '5% discount', 0, 'image/_1568222255998.jpeg'),
(17, 'Hotpot', 25000, '5', 3, 'Popular food', 'None', 0, 'image/_vietnamese-hot-pot-recipe_8297w-2.jpg'),
(19, 'Sushi', 5000, '2', 4, 'Healthy food', 'None', 0, 'image/_download.jpg'),
(21, 'Burger', 4000, '4', 2, 'Looks good', 'None', 0, 'image/_lotteria.jpg'),
(22, 'Satay', 4500, '1', 7, 'Tasty', 'None', 0, 'image/_img82070.768x512.jpg'),
(23, 'Coca Cola', 1500, '1', 1, 'Cold drink', 'None', 0, 'image/_OB_CC_1.5L-300x300.jpg'),
(24, 'Seafood sushi', 6000, '1', 4, 'Healthy food', 'None', 0, 'image/_unnamed.jpg'),
(34, 'Kyay Oh', 4000, '5', 7, 'Delicious', 'None', 0, 'image/_Pork Rib Kyay-Oh@2x.png');

-- --------------------------------------------------------

--
-- Table structure for table `menutype`
--

CREATE TABLE `menutype` (
  `MenuTypeID` int(11) NOT NULL,
  `MenuTypeName` varchar(100) NOT NULL,
  `ShortDescription` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menutype`
--

INSERT INTO `menutype` (`MenuTypeID`, `MenuTypeName`, `ShortDescription`) VALUES
(1, 'Dessert', 'Various kinds of desserts'),
(2, 'Korean', 'Red, hot, and spicy...'),
(3, 'French foods', 'Delicious french foods'),
(4, 'Fastfood', 'Fast and easy'),
(5, 'Chinese foods', 'For those who love chinese foods');

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `OrderID` varchar(30) NOT NULL,
  `MenuID` int(30) NOT NULL,
  `Price` int(30) NOT NULL,
  `Quantity` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orderdetails`
--

INSERT INTO `orderdetails` (`OrderID`, `MenuID`, `Price`, `Quantity`) VALUES
('ORD-000010', 13, 15000, 1),
('ORD-000011', 13, 15000, 3),
('ORD-000011', 15, 15000, 1),
('ORD-000012', 14, 15000, 1),
('ORD-000013', 11, 15000, 2),
('ORD-000014', 13, 15000, 1),
('ORD-000017', 11, 15000, 2),
('ORD-000018', 13, 15000, 1),
('ORD-000019', 14, 15000, 1),
('ORD-000020', 13, 15000, 1),
('ORD-000022', 14, 15000, 1),
('ORD-000023', 11, 15000, 2),
('ORD-000024', 11, 15000, 1),
('ORD-000025', 13, 15000, 1),
('ORD-000001', 17, 25000, 1),
('ORD-000002', 24, 6000, 7),
('ORD-000003', 21, 4000, 1),
('ORD-000004', 22, 4500, 1),
('ORD-000004', 24, 6000, 1),
('ORD-000004', 21, 4000, 1),
('ORD-000005', 24, 6000, 1),
('ORD-000006', 24, 6000, 1),
('ORD-000007', 24, 6000, 1),
('ORD-000007', 21, 4000, 1),
('ORD-000008', 24, 6000, 1),
('ORD-000008', 21, 4000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` varchar(30) NOT NULL,
  `OrderDate` date NOT NULL,
  `CustomerID` int(30) NOT NULL,
  `DeliveryAddress` varchar(60) NOT NULL,
  `DeliveryPhone` int(30) NOT NULL,
  `TotalQuantity` int(30) NOT NULL,
  `TotalAmount` int(30) NOT NULL,
  `VAT` int(30) NOT NULL,
  `GrandTotal` int(30) NOT NULL,
  `PaymentType` varchar(30) NOT NULL,
  `CardNo` int(30) NOT NULL,
  `Direction` varchar(30) NOT NULL,
  `Status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `OrderDate`, `CustomerID`, `DeliveryAddress`, `DeliveryPhone`, `TotalQuantity`, `TotalAmount`, `VAT`, `GrandTotal`, `PaymentType`, `CardNo`, `Direction`, `Status`) VALUES
('ORD-000001', '2020-10-15', 4, 'YGN', 97654888, 1, 25000, 1250, 28250, 'COD', 0, '', 'Complete'),
('ORD-000002', '2020-10-16', 4, 'YGN', 97654888, 7, 42000, 2100, 0, 'COD', 0, '', 'Pending'),
('ORD-000003', '2020-10-16', 4, 'YGN', 97654888, 1, 4000, 200, 6200, 'MPU', 9384889, 'YGN', 'Pending'),
('ORD-000004', '2020-10-16', 4, 'YGN', 97654888, 3, 14500, 725, 16225, 'COD', 0, '', 'Pending'),
('ORD-000005', '2020-10-16', 4, 'YGN', 97654888, 1, 6000, 300, 8300, 'COD', 0, 'ssssssssssssssssssssssssssssss', 'Pending'),
('ORD-000006', '2020-10-17', 4, 'YGN', 97654888, 1, 6000, 300, 0, 'COD', 0, '', 'Pending'),
('ORD-000007', '2020-10-17', 4, 'YGN', 97654888, 2, 10000, 500, 0, 'COD', 0, '', 'Pending'),
('ORD-000008', '2020-10-17', 4, 'YGN', 97654888, 2, 10000, 500, 0, 'COD', 0, '', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `RestaurantID` int(11) NOT NULL,
  `RestaurantName` varchar(60) NOT NULL,
  `Location` text NOT NULL,
  `Phone` varchar(60) NOT NULL,
  `Email` varchar(60) NOT NULL,
  `Image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`RestaurantID`, `RestaurantName`, `Location`, `Phone`, `Email`, `Image`) VALUES
(1, 'KFC', 'Sanchaung', '09888888888', 'kfc@gmail.com', ''),
(2, 'Lotteria', 'Latha', '01231245', 'lotteria@gmail.com', ''),
(3, 'Jojo Hotpot', 'Lanmadaw', '0943555', 'jojo@gmail.com', ''),
(4, 'Sushi King', 'Latha', '09833553421', 'sushi@gmail.com', ''),
(7, 'YKKO', 'Sanchaung', '09888811111', 'ykko@gmail.com', '');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_owner`
--

CREATE TABLE `restaurant_owner` (
  `restaurantowner_ID` int(11) NOT NULL,
  `Name` varchar(60) NOT NULL,
  `Email` varchar(60) NOT NULL,
  `Address` text NOT NULL,
  `Phone` varchar(60) NOT NULL,
  `YearofEstablishment` varchar(60) NOT NULL,
  `Achievement` text NOT NULL,
  `Branch` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `restaurant_owner`
--

INSERT INTO `restaurant_owner` (`restaurantowner_ID`, `Name`, `Email`, `Address`, `Phone`, `YearofEstablishment`, `Achievement`, `Branch`) VALUES
(1, 'su', 'susu@gmail.com', 'YGN', '09888', 'sdiahid', 'sbdsjdbjki', 'skdios'),
(2, 'Khine', 'k@gmail.com', 'YGN', '0948890', 'nasiudi', 'assodpj', ' asjdb');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `Staff_ID` int(11) NOT NULL,
  `Staff_Name` varchar(100) NOT NULL,
  `Password` varchar(30) NOT NULL,
  `Phone` varchar(30) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `StaffType` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`Staff_ID`, `Staff_Name`, `Password`, `Phone`, `Address`, `Email`, `StaffType`) VALUES
(11, 'Choco', 'choco', '09123441322', 'Hlaing', 'choco@gmail.com', 'Manager'),
(12, 'Jennie', 'jennie', '09866746534', 'Latha', 'jennie@gmail.com', 'Customer service'),
(13, 'Rose', 'rose', '09878987678', 'Insein', 'rose@gmail.com', 'Finance'),
(16, 'susu', 'sssssss', '0999999', 'YGN', 's@gmail.com', '');

-- --------------------------------------------------------

--
-- Table structure for table `townships`
--

CREATE TABLE `townships` (
  `TownshipID` int(11) NOT NULL,
  `TownshipName` varchar(255) NOT NULL,
  `DeliveryCost` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `townships`
--

INSERT INTO `townships` (`TownshipID`, `TownshipName`, `DeliveryCost`) VALUES
(1, 'Lanmadaw', 1000),
(2, 'Hlaing', 1000),
(3, 'Latha', 2000),
(4, 'Kamayut', 2000),
(5, 'Botahtaung', 1500),
(6, 'Insein', 1500);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contractrestaurants`
--
ALTER TABLE `contractrestaurants`
  ADD PRIMARY KEY (`ContractID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CustomerID`);

--
-- Indexes for table `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`DeliveryID`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`MenuID`);

--
-- Indexes for table `menutype`
--
ALTER TABLE `menutype`
  ADD PRIMARY KEY (`MenuTypeID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`RestaurantID`);

--
-- Indexes for table `restaurant_owner`
--
ALTER TABLE `restaurant_owner`
  ADD PRIMARY KEY (`restaurantowner_ID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`Staff_ID`);

--
-- Indexes for table `townships`
--
ALTER TABLE `townships`
  ADD PRIMARY KEY (`TownshipID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contractrestaurants`
--
ALTER TABLE `contractrestaurants`
  MODIFY `ContractID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `DeliveryID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `MenuID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `menutype`
--
ALTER TABLE `menutype`
  MODIFY `MenuTypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `RestaurantID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `restaurant_owner`
--
ALTER TABLE `restaurant_owner`
  MODIFY `restaurantowner_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `Staff_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `townships`
--
ALTER TABLE `townships`
  MODIFY `TownshipID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
