-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Nov 24, 2023 at 02:08 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbms_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `post_table`
--

CREATE TABLE `post_table` (
  `id` int(55) NOT NULL,
  `username` varchar(250) NOT NULL,
  `text_content` varchar(1000) NOT NULL,
  `title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post_table`
--

INSERT INTO `post_table` (`id`, `username`, `text_content`, `title`) VALUES
(100, 'shuvo', 'Sets the input control to read-only. It won\'t allow the user to change the value. The control however, can receive focus and are included when tabbing through the form controls.', 'javascript'),
(101, 'adnan', 'To create a multi-line text input, use the HTML  tag. You can set the size of a text area using the cols and rows attributes. It is used within a form, to allow users to input text over multiple rows.\r\n\r\nHere are the attributes of tag −', 'javascript'),
(103, 'sabir', 'Time limit: 1.00 s\r\nMemory limit: 512 MB\r\n\r\n\r\nA Gray code is a list of all 2^n bit strings of length n, where any two successive strings differ in exactly one bit (i.e., their Hamming distance is one).\r\nYour task is to create a Gray code for a given length n.', 'c++ problem');

-- --------------------------------------------------------

--
-- Table structure for table `rating_info`
--

CREATE TABLE `rating_info` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rating_info`
--

INSERT INTO `rating_info` (`id`, `post_id`, `user_id`, `status`) VALUES
(7, 101, 1, 'dislike'),
(17, 100, 1, 'dislike');

-- --------------------------------------------------------

--
-- Table structure for table `signups`
--

CREATE TABLE `signups` (
  `username` varchar(100) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `age` datetime DEFAULT NULL,
  `passwords` varchar(500) DEFAULT NULL,
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expire` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `signups`
--

INSERT INTO `signups` (`username`, `name`, `email`, `age`, `passwords`, `reset_token_hash`, `reset_token_expire`) VALUES
('Adnan22', 'Adnanul Isalm', 'adnanulislam22@gmail.com', '2000-05-12 00:00:00', 'asdfrewq', NULL, NULL),
('roza', 'Roza', 'iqbalmdshuvo01@gmail.com', '2002-11-25 00:00:00', '74886@Shuvoroza', NULL, NULL),
('shuvo', 'Md Shuvo', 'iqbalmdshuvo@gmail.com', '2001-11-25 00:00:00', '12345678', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `post_table`
--
ALTER TABLE `post_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rating_info`
--
ALTER TABLE `rating_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `signups`
--
ALTER TABLE `signups`
  ADD PRIMARY KEY (`username`,`email`),
  ADD UNIQUE KEY `reset_token_hash` (`reset_token_hash`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `post_table`
--
ALTER TABLE `post_table`
  MODIFY `id` int(55) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `rating_info`
--
ALTER TABLE `rating_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
