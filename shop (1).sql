-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 31, 2021 at 04:13 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Ordering` int(11) DEFAULT NULL,
  `Visibility` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Comments` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `Ordering`, `Visibility`, `Allow_Comments`, `Allow_Ads`) VALUES
(13, 'Hand Made  ', 'Hand Made Items ', 1, 0, 0, 0),
(14, 'Computers', 'Computers Items', 2, 0, 0, 0),
(15, 'Cell Phones', 'Cell Phones Items', 0, 0, 0, 0),
(16, 'Clothing', 'Clothing And Fashion', 4, 0, 0, 0),
(17, 'Tools', 'Home Tools', 5, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `C_ID` int(11) NOT NULL,
  `Comment` text NOT NULL,
  `Status` tinyint(4) NOT NULL,
  `Comment_Date` date NOT NULL,
  `Item_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`C_ID`, `Comment`, `Status`, `Comment_Date`, `Item_ID`, `User_ID`) VALUES
(16, 'GOOOOOOOOOOOOOOOOOOOOD', 1, '2021-12-31', 24, 37),
(17, 'GOOOOOOOOOOOOOOOOOOOOD', 1, '2021-12-31', 24, 37),
(18, 'GOOOOOOOOOOOOOOOOOOOOD', 1, '2021-12-31', 24, 37),
(19, 'GOOOOOOOOOOOOOOOOOOOOD', 0, '2021-12-31', 24, 37),
(20, 'GOOOOOOOOOOOOOOOOOOOOD', 0, '2021-12-31', 24, 37),
(21, 'GOOOOOOOOOOOOOOOOOOOOD', 0, '2021-12-31', 24, 37),
(22, 'GOOOOOOOOOOOOOOOOOOOOD', 0, '2021-12-31', 24, 37);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_ID` int(11) NOT NULL,
  `Name` varchar(255) CHARACTER SET utf8 COLLATE utf8_danish_ci NOT NULL,
  `Description` text NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Add_Date` date NOT NULL,
  `Country_Made` varchar(255) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Rating` smallint(6) NOT NULL,
  `Approve` tinyint(4) NOT NULL DEFAULT 0,
  `Cat_ID` int(11) NOT NULL,
  `Member_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_ID`, `Name`, `Description`, `Price`, `Add_Date`, `Country_Made`, `Image`, `Status`, `Rating`, `Approve`, `Cat_ID`, `Member_ID`) VALUES
(15, 'AMD Proccessor', 'Rayzon 3 2200G', '$2000', '2021-12-26', 'USA', '', '1', 0, 0, 14, 2),
(17, 'SSD Hard', 'SSD Hard 500 GIGA BYTE', '$40', '2021-12-26', 'Island', '', '2', 0, 1, 14, 2),
(18, 'Mother Board', 'Mother Board For Your Personal Computer', '$120', '2021-12-26', 'USA', '', '1', 0, 1, 14, 1),
(22, 'bejame', 'bejame', '$30', '2021-12-26', 'Egypt', '', '1', 0, 1, 16, 2),
(23, 'Shirt', 'Shirt', '$30', '2021-12-26', 'Egypt', '', '1', 0, 1, 16, 2),
(24, 'T_Shirt', 'T_Shirt', '$40', '2021-12-26', 'Italia', '', '2', 0, 1, 16, 7),
(25, ' Swwet Shirt', ' Swwet Shirt', '$30', '2021-12-26', 'Egypt', '', '1', 0, 1, 16, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserD` int(11) NOT NULL,
  `UserName` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `FullName` varchar(255) CHARACTER SET utf8 NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT 0,
  `TrustStatus` int(11) NOT NULL DEFAULT 0,
  `RegStatus` int(11) NOT NULL DEFAULT 0,
  `Dateandtime` date DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserD`, `UserName`, `Password`, `Email`, `FullName`, `GroupID`, `TrustStatus`, `RegStatus`, `Dateandtime`, `avatar`) VALUES
(1, 'salama', '3417fb851e96cf2f09d3b02d636ae74077230639', 'salama@gmail.com', 'mohamed salama', 1, 0, 1, NULL, ''),
(2, 'Mohamed', '601f1889667efaebb33b8c12572835da3f027f78', 'mohamed@gmail.com', 'mohamed salama', 1, 0, 1, NULL, ''),
(7, 'ibrahim', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'ibrahim@gmail.com', 'ibrahim ahmed', 0, 0, 1, '2021-12-14', ''),
(20, 'shawky', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'shawky@gmail.com', 'shawky ali', 0, 0, 1, '2021-12-14', ''),
(25, 'Zeyad', '601f1889667efaebb33b8c12572835da3f027f78', 'Zeyad@gmail.com', 'Zeyad Ahmed', 0, 0, 1, '2021-12-26', ''),
(37, 'Mario', '8cb2237d0679ca88db6464eac60da96345513964', 'Mario@gmail.com', 'Mario Mario', 0, 0, 1, '2021-12-31', '4275970723_Mario-PNG-File.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`C_ID`),
  ADD KEY `items_comments` (`Item_ID`),
  ADD KEY `users_comments` (`User_ID`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_ID`),
  ADD KEY `member_1` (`Member_ID`),
  ADD KEY `cat_1` (`Cat_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserD`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `C_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserD` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `items_comments` FOREIGN KEY (`Item_ID`) REFERENCES `items` (`item_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_comments` FOREIGN KEY (`User_ID`) REFERENCES `users` (`UserD`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cat_1` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_1` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`UserD`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
