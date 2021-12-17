-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2021 at 09:20 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `estudy`
--

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` int(11) NOT NULL,
  `media_origin_name` varchar(255) NOT NULL,
  `media_path` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `media_origin_name`, `media_path`, `created_at`) VALUES
(1, 'cat9.png', '/uploads/61bae4119557dcat9.png', '2021-12-16 14:00:33'),
(2, 'shiba-inu.png', '/uploads/61bae51d9ad10shiba-inu.png', '2021-12-16 14:05:01'),
(3, 'dolphin.png', '/uploads/61bae534cd18ddolphin.png', '2021-12-16 14:05:24'),
(4, 'tree (1).png', '/uploads/61bae54e97382tree (1).png', '2021-12-16 14:05:50'),
(5, 'beach.png', '/uploads/61bae57acaa8cbeach.png', '2021-12-16 14:06:34'),
(6, 'responsive.png', '/uploads/61bae98033f7cresponsive.png', '2021-12-16 14:23:44'),
(7, 'more.png', '/uploads/61baea2bbe0eamore.png', '2021-12-16 14:26:35');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `answers` text NOT NULL,
  `corrects` text NOT NULL,
  `media_id` int(11) DEFAULT NULL,
  `type` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `audio_path` int(11) DEFAULT NULL,
  `audio_name` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `question_quiz`
--

CREATE TABLE `question_quiz` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `question_quantity` int(11) NOT NULL DEFAULT 0,
  `media_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `author_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `topic`
--

CREATE TABLE `topic` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `media_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `topic`
--

INSERT INTO `topic` (`id`, `title`, `description`, `media_id`, `created_at`) VALUES
(1, 'danh từ', '', 1, '2021-12-16 23:02:28'),
(2, 'động từ', '', 1, '2021-12-16 23:02:28'),
(3, 'tính từ', '', 1, '2021-12-16 23:02:28'),
(4, 'giới từ', '', 1, '2021-12-16 23:02:28'),
(5, 'phó từ', '', 1, '2021-12-16 23:02:28'),
(6, 'liên từ', '', 1, '2021-12-16 23:02:28'),
(7, 'thán từ', '', 1, '2021-12-16 23:02:28'),
(8, 'đại từ', '', 1, '2021-12-16 23:02:28'),
(9, 'thành ngữ', '', 1, '2021-12-16 23:02:28'),
(10, 'viết tắt', '', 1, '2021-12-16 23:02:28'),
(11, 'hậu tố', '', 1, '2021-12-16 23:02:28'),
(12, 'tổng hợp', '', 1, '2021-12-16 23:02:28');

-- --------------------------------------------------------

--
-- Table structure for table `topic_vocabulary`
--

CREATE TABLE `topic_vocabulary` (
  `id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `vocabulary_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `type` enum('ADMIN','GUEST') NOT NULL DEFAULT 'GUEST',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vocabulary`
--

CREATE TABLE `vocabulary` (
  `id` int(11) NOT NULL,
  `english` varchar(255) NOT NULL,
  `vietnamese` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `media_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question_quiz`
--
ALTER TABLE `question_quiz`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `topic`
--
ALTER TABLE `topic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `topic_vocabulary`
--
ALTER TABLE `topic_vocabulary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vocabulary`
--
ALTER TABLE `vocabulary`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `question_quiz`
--
ALTER TABLE `question_quiz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `topic`
--
ALTER TABLE `topic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;

--
-- AUTO_INCREMENT for table `topic_vocabulary`
--
ALTER TABLE `topic_vocabulary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vocabulary`
--
ALTER TABLE `vocabulary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
