-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2019 at 06:39 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `finalproject_ryanharpham`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `TimePlaced` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `ProductID` int(11) NOT NULL,
  `Image` varchar(255) NOT NULL DEFAULT 'default.png',
  `Name` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ProductID`, `Image`, `Name`, `Description`, `Price`) VALUES
(2, 'yankee.png', 'Yankee Candle', 'Large - Apple Wreath', '20.22'),
(3, 'fork.png', 'Fork', 'What do you think it is?', '2.25'),
(4, 'potato.png', 'Potato', 'Po-tawt-to', '1.25'),
(5, 'willywonka.png', 'Willy Wonka', 'Yes, the person.', '3.50'),
(6, 'candle.png', 'Candle', 'It\'s on fire, yo', '4.00'),
(7, 'moonshoes.png', 'Moon Shoes', 'Beam me up Scotty', '100.00');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `Alias` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `FirstName` varchar(30) NOT NULL,
  `LastName` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`Alias`, `Email`, `Password`, `FirstName`, `LastName`) VALUES
('Admin', 'rharpham@gmail.com', '$2y$11$Yj4Ptq3RCa2827fMcCCB6uRg7trGg7T20kg56ZfIChPbZlxYblREG', 'Ryan', 'Harpham'),
('JBravo', 'jbravo@scc.edu', '$2y$11$c4FDp52iJbM86L0TsH7TkOKWtGfYwavMfFoBRa9EvCFFr6j3OuSgm', 'Johnny', 'Bravo');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `Alias` varchar(255) NOT NULL,
  `Role` varchar(50) NOT NULL DEFAULT 'Regular'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`Alias`, `Role`) VALUES
('Admin', 'Admin'),
('JBravo', 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `fkProduct` (`ProductID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`Alias`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`Alias`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fkProduct` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ProductID`);

--
-- Constraints for table `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `fkRegistration` FOREIGN KEY (`Alias`) REFERENCES `registration` (`Alias`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
