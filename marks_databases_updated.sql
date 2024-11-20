-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 29, 2024 at 04:20 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `marks_databases`;
USE `marks_databases`;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Table structure for table `attendance`
CREATE TABLE `attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` varchar(20) NOT NULL,
  `branch` varchar(100) NOT NULL,
  `semester` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `status` enum('Present','Absent') NOT NULL,
  `total_days` int(11) NOT NULL DEFAULT 0,
  `present_days` int(11) NOT NULL DEFAULT 0,
  `absent_days` int(11) NOT NULL DEFAULT 0,
  `working_days` int(11) NOT NULL DEFAULT 0,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `attendance`
INSERT INTO `attendance` (`id`, `student_id`, `branch`, `semester`, `month`, `year`, `status`, `total_days`, `present_days`, `absent_days`, `working_days`, `notes`, `created_at`) VALUES
(1, '22352', 'cme', 1, 2, 2024, 'Present', 0, 22, 2, 24, 'h', '2024-09-27 16:55:53'),
(2, '22', 'cme', 2, 1, 2024, 'Present', 0, 26, 2, 28, 'kk', '2024-09-28 13:38:49'),
(3, '21', 'cme', 2, 1, 2024, 'Present', 0, 25, 3, 28, 'kk', '2024-09-28 13:45:23');

-- Table structure for table `external1_marks`
CREATE TABLE `external1_marks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` varchar(50) NOT NULL,
  `semester` enum('I','III','IV','V','VI') NOT NULL,
  `sub1` int(11) NOT NULL,
  `sub2` int(11) NOT NULL,
  `sub3` int(11) NOT NULL,
  `sub4` int(11) NOT NULL,
  `sub5` int(11) NOT NULL,
  `sub6` int(11) NOT NULL,
  `sub7` int(11) NOT NULL,
  `sub8` int(11) NOT NULL,
  `sub9` int(11) NOT NULL,
  `sub10` int(11) NOT NULL,
  `total_marks` int(11) GENERATED ALWAYS AS (`sub1` + `sub2` + `sub3` + `sub4` + `sub5` + `sub6` + `sub7` + `sub8` + `sub9` + `sub10`) STORED,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `external1_marks`
INSERT INTO `external1_marks` (`id`, `student_id`, `semester`, `sub1`, `sub2`, `sub3`, `sub4`, `sub5`, `sub6`, `sub7`, `sub8`, `sub9`, `sub10`) VALUES
(1, '22352-ME-020', 'I', 44, 34, 34, 34, 43, 33, 45, 44, 33, 45),
(2, '22352-CM-006', 'I', 34, 34, 33, 22, 22, 22, 22, 22, 22, 22),
(3, '22352-CM-006', 'I', 70, 34, 33, 22, 22, 22, 22, 22, 22, 22),
(4, '22352-CM-045', 'I', 80, 34, 33, 22, 22, 22, 28, 22, 22, 22),
(5, '22352-CM-001', 'I', 0, 2, 2, 0, 20, 20, 20, 20, 20, 20);

-- Table structure for table `external2_marks`
CREATE TABLE `external2_marks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` varchar(50) NOT NULL,
  `semester` enum('I','III','IV','V','VI') NOT NULL,
  `sub1` int(11) NOT NULL,
  `sub2` int(11) NOT NULL,
  `sub3` int(11) NOT NULL,
  `sub4` int(11) NOT NULL,
  `sub5` int(11) NOT NULL,
  `sub6` int(11) NOT NULL,
  `sub7` int(11) NOT NULL,
  `sub8` int(11) NOT NULL,
  `sub9` int(11) NOT NULL,
  `total_marks` int(11) GENERATED ALWAYS AS (`sub1` + `sub2` + `sub3` + `sub4` + `sub5` + `sub6` + `sub7` + `sub8` + `sub9`) STORED,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `external2_marks`
INSERT INTO `external2_marks` (`id`, `student_id`, `semester`, `sub1`, `sub2`, `sub3`, `sub4`, `sub5`, `sub6`, `sub7`, `sub8`, `sub9`) VALUES
(1, '22352-CM-045', 'I', 80, 80, 33, 22, 22, 22, 28, 22, 22),
(2, '22352-CM-001', 'III', 2, 2, 20, 12, 12, 12, 12, 12, 12);

-- Table structure for table `external3_marks`
CREATE TABLE `external3_marks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` varchar(15) NOT NULL,
  `semester` varchar(10) NOT NULL,
  `subject` varchar(10) NOT NULL,
  `external` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `external3_marks`
INSERT INTO `external3_marks` (`id`, `student_id`, `semester`, `subject`, `external`, `total`, `created_at`) VALUES
(1, '22352-CM-001', 'I', '601', 40, 40, '2024-09-27 17:33:29'),
(2, '22352-CM-008', 'VI', '601', 2, 2, '2024-09-29 07:21:52');

-- Table structure for table `external_marks`
CREATE TABLE `external_marks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` varchar(50) NOT NULL,
  `semester` enum('I','III','IV','V','VI') NOT NULL,
  `sub1` int(11) NOT NULL,
  `sub2` int(11) NOT NULL,
  `sub3` int(11) NOT NULL,
  `sub4` int(11) NOT NULL,
  `sub5` int(11) NOT NULL,
  `sub6` int(11) NOT NULL,
  `sub7` int(11) NOT NULL,
  `sub8` int(11) NOT NULL,
  `sub9` int(11) NOT NULL,
  `sub10` int(11) NOT NULL,
  `total_marks` int(11) GENERATED ALWAYS AS (`sub1` + `sub2` + `sub3` + `sub4` + `sub5` + `sub6` + `sub7` + `sub8` + `sub9` + `sub10`) STORED,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `external_marks`
INSERT INTO `external_marks` (`id`, `student_id`, `semester`, `sub1`, `sub2`, `sub3`, `sub4`, `sub5`, `sub6`, `sub7`, `sub8`, `sub9`, `sub10`) VALUES
(1, '22352-CM-001', 'I', 70, 80, 80, 80, 80, 80, 80, 80, 80, 80),
(2, '22352-CM-001', 'III', 70, 80, 80, 80, 80, 80, 80, 80, 80, 80);

-- Table structure for table internal1_marks
--

CREATE TABLE internal1_marks (
  id int(11) NOT NULL,
  student_id varchar(50) NOT NULL,
  semester enum('I','III','IV','V','VI') NOT NULL,
  sub1 int(11) NOT NULL,
  sub2 int(11) NOT NULL,
  sub3 int(11) NOT NULL,
  sub4 int(11) NOT NULL,
  sub5 int(11) NOT NULL,
  sub6 int(11) NOT NULL,
  sub7 int(11) NOT NULL,
  sub8 int(11) NOT NULL,
  sub9 int(11) NOT NULL,
  sub10 int(11) NOT NULL,
  total_marks int(11) GENERATED ALWAYS AS (sub1 + sub2 + sub3 + sub4 + sub5 + sub6 + sub7 + sub8 + sub9 + sub10) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table internal1_marks
--

INSERT INTO internal1_marks (id, student_id, semester, sub1, sub2, sub3, sub4, sub5, sub6, sub7, sub8, sub9, sub10) VALUES
(2, '22352-CM-001', 'I', 0, 20, 2, 0, 20, 20, 20, 20, 20, 20);

-- --------------------------------------------------------

--
-- Table structure for table internal2_marks
--

CREATE TABLE internal2_marks (
  id int(11) NOT NULL,
  student_id varchar(50) NOT NULL,
  semester enum('I','III','IV','V','VI') NOT NULL,
  sub1 int(11) NOT NULL,
  sub2 int(11) NOT NULL,
  sub3 int(11) NOT NULL,
  sub4 int(11) NOT NULL,
  sub5 int(11) NOT NULL,
  sub6 int(11) NOT NULL,
  sub7 int(11) NOT NULL,
  sub8 int(11) NOT NULL,
  sub9 int(11) NOT NULL,
  total_marks int(11) GENERATED ALWAYS AS (sub1 + sub2 + sub3 + sub4 + sub5 + sub6 + sub7 + sub8 + sub9) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table internal2_marks
--

INSERT INTO internal2_marks (id, student_id, semester, sub1, sub2, sub3, sub4, sub5, sub6, sub7, sub8, sub9) VALUES
(1, '22352-CM-001', 'III', 2, 2, 20, 12, 12, 12, 12, 12, 12);

-- --------------------------------------------------------

--
-- Table structure for table internal3_marks
--

CREATE TABLE internal3_marks (
  id int(11) NOT NULL,
  student_id varchar(15) NOT NULL,
  semester varchar(10) NOT NULL,
  subject varchar(10) NOT NULL,
  internal int(11) NOT NULL,
  total int(11) NOT NULL,
  created_at timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table internal3_marks
--

INSERT INTO internal3_marks (id, student_id, semester, subject, internal, total, created_at) VALUES
(1, '22352-CM-008', 'VI', '601', 2, 2, '2024-09-29 12:53:08');

-- --------------------------------------------------------

--
-- Table structure for table internal_marks
--

CREATE TABLE internal_marks (
  id int(11) NOT NULL,
  student_id varchar(50) NOT NULL,
  semester enum('I','III','IV','V','VI') NOT NULL,
  sub1 int(11) NOT NULL,
  sub2 int(11) NOT NULL,
  sub3 int(11) NOT NULL,
  sub4 int(11) NOT NULL,
  sub5 int(11) NOT NULL,
  sub6 int(11) NOT NULL,
  sub7 int(11) NOT NULL,
  sub8 int(11) NOT NULL,
  sub9 int(11) NOT NULL,
  sub10 int(11) NOT NULL,
  sub11 int(11) NOT NULL,
  total_marks int(11) GENERATED ALWAYS AS (sub1 + sub2 + sub3 + sub4 + sub5 + sub6 + sub7 + sub8 + sub9 + sub10 + sub11) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table internal_marks
--

INSERT INTO internal_marks (id, student_id, semester, sub1, sub2, sub3, sub4, sub5, sub6, sub7, sub8, sub9, sub10, sub11) VALUES
(2, '22352-ME-001', 'III', 32, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12),
(3, '22352-ME-045', 'IV', 20, 20, 20, 12, 12, 12, 12, 12, 12, 12, 20),
(4, '22352-ME-045', 'III', 20, 20, 20, 12, 12, 12, 12, 12, 12, 12, 20);

--
-- Indexes for dumped tables
--

--
-- Indexes for table attendance
--
ALTER TABLE attendance
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY student_id (student_id,branch,semester,month,year);

--
-- Indexes for table external1_marks
--
ALTER TABLE external1_marks
  ADD PRIMARY KEY (id);

--
-- Indexes for table external2_marks
--
ALTER TABLE external2_marks
  ADD PRIMARY KEY (id);

--
-- Indexes for table external3_marks
--
ALTER TABLE external3_marks
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY idx_unique_student_semester_subject (student_id,semester,subject),
  ADD KEY idx_student_semester (student_id,semester);

--
-- Indexes for table external_marks
--
ALTER TABLE external_marks
  ADD PRIMARY KEY (id);

--
-- Indexes for table internal1_marks
--
ALTER TABLE internal1_marks
  ADD PRIMARY KEY (id);

--
-- Indexes for table internal2_marks
--
ALTER TABLE internal2_marks
  ADD PRIMARY KEY (id);

--
-- Indexes for table internal3_marks
--
ALTER TABLE internal3_marks
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY unique_student_semester (student_id,semester),
  ADD KEY idx_student_semester (student_id,semester);

--
-- Indexes for table internal_marks
--
ALTER TABLE internal_marks
  ADD PRIMARY KEY (id);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table attendance
--
ALTER TABLE attendance
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table external1_marks
--
ALTER TABLE external1_marks
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table external2_marks
--
ALTER TABLE external2_marks
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table external3_marks
--
ALTER TABLE external3_marks
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table external_marks
--
ALTER TABLE external_marks
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table internal1_marks
--
ALTER TABLE internal1_marks
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table internal2_marks
--
ALTER TABLE internal2_marks
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table internal3_marks
--
ALTER TABLE internal3_marks
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table internal_marks
--
ALTER TABLE internal_marks
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;; 