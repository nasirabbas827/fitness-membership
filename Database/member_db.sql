-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 02, 2023 at 07:11 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `member_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `AttendanceID` int(11) NOT NULL,
  `MemberID` int(11) NOT NULL,
  `ClassID` int(11) NOT NULL,
  `Attendance_Date` date NOT NULL,
  `Check_in_Time` time NOT NULL,
  `Check_out_Time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`AttendanceID`, `MemberID`, `ClassID`, `Attendance_Date`, `Check_in_Time`, `Check_out_Time`) VALUES
(1, 2, 1, '2023-09-01', '12:00:00', '12:00:00'),
(2, 1, 1, '2023-09-02', '09:12:00', '14:17:00');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `ClassID` int(11) NOT NULL,
  `Level_id` int(11) NOT NULL,
  `Class_Name` varchar(100) NOT NULL,
  `Instructor_Name` varchar(100) NOT NULL,
  `Schedule` datetime NOT NULL,
  `Maximum_Capacity` int(11) NOT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`ClassID`, `Level_id`, `Class_Name`, `Instructor_Name`, `Schedule`, `Maximum_Capacity`, `Description`) VALUES
(1, 3, 'Fitness Class one ', 'Haider', '2023-09-20 11:38:00', 19, 'You should attend the class ');

-- --------------------------------------------------------

--
-- Table structure for table `diet_plans`
--

CREATE TABLE `diet_plans` (
  `DietPlanID` int(11) NOT NULL,
  `MemberID` int(11) NOT NULL,
  `Plan_Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diet_plans`
--

INSERT INTO `diet_plans` (`DietPlanID`, `MemberID`, `Plan_Name`, `Description`, `Date`) VALUES
(1, 2, 'ss', 'ss', '2023-10-06'),
(2, 2, 'ss', 'ss', '2023-10-06'),
(3, 1, 'Plan 1', 'dd', '2023-09-02');

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `DiscountID` int(11) NOT NULL,
  `discount_details` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `EventID` int(11) NOT NULL,
  `event_details` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`EventID`, `event_details`) VALUES
(1, 'THis is Dummy Event');

-- --------------------------------------------------------

--
-- Table structure for table `fitness_training_routines`
--

CREATE TABLE `fitness_training_routines` (
  `RoutineID` int(11) NOT NULL,
  `MemberID` int(11) NOT NULL,
  `Routine_Name` varchar(100) NOT NULL,
  `Description` text NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fitness_training_routines`
--

INSERT INTO `fitness_training_routines` (`RoutineID`, `MemberID`, `Routine_Name`, `Description`, `Date`) VALUES
(1, 2, 'vva', 'vv', '2023-09-01'),
(2, 1, 'Training Dumbles', 'ddd', '2023-09-02');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `MemberID` int(11) NOT NULL,
  `profileimage` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `membership_start_date` date NOT NULL,
  `membership_expiry_date` date NOT NULL,
  `membership_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`MemberID`, `profileimage`, `name`, `gender`, `email`, `password`, `phone`, `address`, `membership_start_date`, `membership_expiry_date`, `membership_level`) VALUES
(1, 'MY PIC.PNG', 'NASIR', 'Male', 'nasiryt.827@gmail.com', 'admin', '0123', 'ss', '2023-09-01', '2024-08-31', 3),
(2, 'Web Traffic.PNG', 'Basit', 'Male', 'basit@gmail.com', '123', '0123', 'ss', '2023-09-01', '2024-08-31', 3),
(3, 'PrintNASIR ABBAS.png', 'you was', 'Male', 'you@gmail.com', '123', '0123', 'ss', '2023-10-06', '2024-10-05', 1),
(4, 'No BG Pic_11zon.jpg', 'Nasir Abbas', 'Male', 'admin@admin.com', '123', '03176526827', '5', '2023-10-05', '2024-10-04', 1),
(5, 'No BG Pic_11zon.jpg', 'NASIR', 'Male', 'you1@gmail.com', '123', '0123', 'ss', '2023-09-01', '2024-08-31', 1),
(7, 'CV .jpg', 'Nasir Abbas', 'Male', 'adminz@admin.com', '123', '03176526827', '5', '2023-10-03', '2024-10-02', 1),
(8, 'PrintNASIR ABBAS.png', 'NASIR12w', 'Male', 'you12@gmail.com', '123', '0123', 'ss', '2023-09-08', '2024-09-07', 1),
(9, 'Web Traffic.PNG', 'Basit12', 'Male', 'youee1@gmail.com', '123', '0123', 'ss', '2023-09-02', '2024-09-01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `membership_levels`
--

CREATE TABLE `membership_levels` (
  `LevelID` int(11) NOT NULL,
  `level_name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `features` text NOT NULL,
  `duration` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `membership_levels`
--

INSERT INTO `membership_levels` (`LevelID`, `level_name`, `description`, `price`, `features`, `duration`) VALUES
(1, 'Primary', 'dd', 40.00, 'None', '3 months'),
(3, 'Secondary', 'dd', 123.00, 'None', '6 months');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message_text` text DEFAULT NULL,
  `sent_datetime` datetime DEFAULT current_timestamp(),
  `reply_text` text DEFAULT NULL,
  `reply_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message_text`, `sent_datetime`, `reply_text`, `reply_datetime`) VALUES
(4, 2, 0, 'Hy', '2023-09-01 12:07:25', 'Yes ', '2023-09-01 12:12:27'),
(5, 1, 0, 'Heell', '2023-09-02 10:10:15', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `OfferID` int(11) NOT NULL,
  `offer_details` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`OfferID`, `offer_details`) VALUES
(1, 'This is Dummy offer');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `PaymentID` int(11) NOT NULL,
  `MemberID` int(11) NOT NULL,
  `LevelID` int(11) NOT NULL,
  `PaymentDate` date NOT NULL,
  `PaymentAmount` decimal(10,2) NOT NULL,
  `PaymentMethod` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`PaymentID`, `MemberID`, `LevelID`, `PaymentDate`, `PaymentAmount`, `PaymentMethod`) VALUES
(1, 1, 1, '2023-09-14', 40.00, 'Physical'),
(2, 2, 3, '2023-09-01', 123.00, 'Physical'),
(3, 3, 1, '2023-09-01', 40.00, 'Physical'),
(4, 4, 1, '2023-09-01', 40.00, 'Physical'),
(5, 5, 1, '2023-09-01', 12.00, 'Physical'),
(6, 7, 1, '2023-09-01', 10.00, 'Physical'),
(7, 8, 1, '2023-09-01', 20.00, 'Physical'),
(8, 9, 1, '2023-09-02', 40.00, 'Physical');

-- --------------------------------------------------------

--
-- Table structure for table `progress_tracking`
--

CREATE TABLE `progress_tracking` (
  `ProgressID` int(11) NOT NULL,
  `MemberID` int(11) DEFAULT NULL,
  `Date` date NOT NULL,
  `Weight` decimal(5,2) NOT NULL,
  `Body_Measurements` varchar(255) NOT NULL,
  `Fitness_Achievements` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `progress_tracking`
--

INSERT INTO `progress_tracking` (`ProgressID`, `MemberID`, `Date`, `Weight`, `Body_Measurements`, `Fitness_Achievements`) VALUES
(1, 2, '2023-09-01', 64.99, 'ghjk', 'tynkm'),
(3, 1, '2023-09-16', 25.00, 'ghjk', 'fghk');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`AttendanceID`),
  ADD KEY `MemberID` (`MemberID`),
  ADD KEY `ClassID` (`ClassID`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`ClassID`),
  ADD KEY `Level_id` (`Level_id`);

--
-- Indexes for table `diet_plans`
--
ALTER TABLE `diet_plans`
  ADD PRIMARY KEY (`DietPlanID`),
  ADD KEY `MemberID` (`MemberID`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`DiscountID`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`EventID`);

--
-- Indexes for table `fitness_training_routines`
--
ALTER TABLE `fitness_training_routines`
  ADD PRIMARY KEY (`RoutineID`),
  ADD KEY `MemberID` (`MemberID`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`MemberID`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `membership_level` (`membership_level`);

--
-- Indexes for table `membership_levels`
--
ALTER TABLE `membership_levels`
  ADD PRIMARY KEY (`LevelID`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`OfferID`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`PaymentID`),
  ADD KEY `MemberID` (`MemberID`),
  ADD KEY `LevelID` (`LevelID`);

--
-- Indexes for table `progress_tracking`
--
ALTER TABLE `progress_tracking`
  ADD PRIMARY KEY (`ProgressID`),
  ADD KEY `MemberID` (`MemberID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `AttendanceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `ClassID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `diet_plans`
--
ALTER TABLE `diet_plans`
  MODIFY `DietPlanID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `DiscountID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `EventID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fitness_training_routines`
--
ALTER TABLE `fitness_training_routines`
  MODIFY `RoutineID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `MemberID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `membership_levels`
--
ALTER TABLE `membership_levels`
  MODIFY `LevelID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `OfferID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `progress_tracking`
--
ALTER TABLE `progress_tracking`
  MODIFY `ProgressID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`MemberID`) REFERENCES `members` (`MemberID`),
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`ClassID`) REFERENCES `classes` (`ClassID`);

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`Level_id`) REFERENCES `membership_levels` (`LevelID`);

--
-- Constraints for table `diet_plans`
--
ALTER TABLE `diet_plans`
  ADD CONSTRAINT `diet_plans_ibfk_1` FOREIGN KEY (`MemberID`) REFERENCES `members` (`MemberID`);

--
-- Constraints for table `fitness_training_routines`
--
ALTER TABLE `fitness_training_routines`
  ADD CONSTRAINT `fitness_training_routines_ibfk_1` FOREIGN KEY (`MemberID`) REFERENCES `members` (`MemberID`);

--
-- Constraints for table `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `members_ibfk_1` FOREIGN KEY (`membership_level`) REFERENCES `membership_levels` (`LevelID`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`MemberID`) REFERENCES `members` (`MemberID`),
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`LevelID`) REFERENCES `membership_levels` (`LevelID`);

--
-- Constraints for table `progress_tracking`
--
ALTER TABLE `progress_tracking`
  ADD CONSTRAINT `progress_tracking_ibfk_1` FOREIGN KEY (`MemberID`) REFERENCES `members` (`MemberID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
