-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 14, 2023 at 02:36 PM
-- Server version: 8.0.17
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `flightcompany`
--

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `Name` varchar(100) NOT NULL,
  `ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `Name` varchar(255) NOT NULL,
  `Bio` varchar(255) NOT NULL,
  `Location` varchar(255) DEFAULT NULL,
  `Address` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tel` varchar(50) NOT NULL,
  `LogoImg` varchar(255) NOT NULL,
  `Account` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `flight`
--

CREATE TABLE `flight` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `fees` double NOT NULL,
  `startTime` datetime NOT NULL,
  `EndTime` datetime NOT NULL,
  `Completed` tinyint(1) NOT NULL DEFAULT '0',
  `CompanyName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `flight_city`
--

CREATE TABLE `flight_city` (
  `FlightID` int(11) NOT NULL,
  `CityID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `passenger`
--

CREATE TABLE `passenger` (
  `Name` varchar(50) NOT NULL,
  `ID` int(11) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tel` varchar(50) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `passportImg` varchar(255) NOT NULL,
  `Account` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `passenger_flight_status`
--

CREATE TABLE `passenger_flight_status` (
  `FlightID` int(11) NOT NULL,
  `PessangerID` int(11) NOT NULL,
  `Status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`Name`,`ID`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`Name`,`username`);

--
-- Indexes for table `flight`
--
ALTER TABLE `flight`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Company_FlightFK` (`CompanyName`);

--
-- Indexes for table `flight_city`
--
ALTER TABLE `flight_city`
  ADD PRIMARY KEY (`FlightID`,`CityID`);

--
-- Indexes for table `passenger`
--
ALTER TABLE `passenger`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `passenger_flight_status`
--
ALTER TABLE `passenger_flight_status`
  ADD PRIMARY KEY (`FlightID`,`PessangerID`),
  ADD KEY `Passenger_StatusFK` (`PessangerID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `flight`
--
ALTER TABLE `flight`
  ADD CONSTRAINT `Company_FlightFK` FOREIGN KEY (`CompanyName`) REFERENCES `company` (`Name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `flight_city`
--
ALTER TABLE `flight_city`
  ADD CONSTRAINT `City_FlightFK` FOREIGN KEY (`FlightID`) REFERENCES `flight` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `passenger_flight_status`
--
ALTER TABLE `passenger_flight_status`
  ADD CONSTRAINT `Flight_StatusFK` FOREIGN KEY (`FlightID`) REFERENCES `flight` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Passenger_StatusFK` FOREIGN KEY (`PessangerID`) REFERENCES `passenger` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
