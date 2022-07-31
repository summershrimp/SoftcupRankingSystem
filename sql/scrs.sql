-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 02, 2017 at 01:55 PM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scrs`
--

-- --------------------------------------------------------

--
-- Table structure for table `sc_collects`
--

DROP TABLE IF EXISTS `sc_collects`;
CREATE TABLE `sc_collects` (
  `collect_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `score` decimal(3,1) NOT NULL DEFAULT '0.0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sc_confirms`
--

DROP TABLE IF EXISTS `sc_confirms`;
CREATE TABLE `sc_confirms` (
  `confirm_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `is_rated` tinyint(1) NOT NULL DEFAULT '0',
  `is_confirmed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sc_feedbacks`
--

DROP TABLE IF EXISTS `sc_feedbacks`;
CREATE TABLE `sc_feedbacks` (
  `feedback_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sc_items`
--

DROP TABLE IF EXISTS `sc_items`;
CREATE TABLE `sc_items` (
  `item_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `itemname` varchar(64) NOT NULL,
  `maxscore` int(11) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `disp` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sc_roles`
--

DROP TABLE IF EXISTS `sc_roles`;
CREATE TABLE `sc_roles` (
  `role_id` int(11) NOT NULL,
  `rolename` varchar(64) NOT NULL,
  `balance` int(11) NOT NULL DEFAULT '1',
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sc_schools`
--

DROP TABLE IF EXISTS `sc_schools`;
CREATE TABLE `sc_schools` (
  `school_id` int(11) NOT NULL,
  `schoolname` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sc_teams`
--

DROP TABLE IF EXISTS `sc_teams`;
CREATE TABLE `sc_teams` (
  `team_id` int(11) NOT NULL,
  `team_no` varchar(8) NOT NULL DEFAULT '0',
  `teamname` varchar(64) NOT NULL,
  `comment` text NOT NULL,
  `topic_id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sc_topics`
--

DROP TABLE IF EXISTS `sc_topics`;
CREATE TABLE `sc_topics` (
  `topic_id` int(11) NOT NULL,
  `topicname` varchar(64) NOT NULL,
  `comment` text NOT NULL,
  `disp` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sc_users`
--

DROP TABLE IF EXISTS `sc_users`;
CREATE TABLE `sc_users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `salt` smallint(4) DEFAULT NULL,
  `role_id` int(11) NOT NULL DEFAULT '2',
  `isadmin` tinyint(1) NOT NULL DEFAULT '0',
  `sex` int(2) DEFAULT NULL,
  `realname` varchar(32) DEFAULT NULL,
  `phone` varchar(16) DEFAULT NULL,
  `comment` text NOT NULL,
  `school_id` int(11) NOT NULL DEFAULT '-1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sc_user_privileges`
--

DROP TABLE IF EXISTS `sc_user_privileges`;
CREATE TABLE `sc_user_privileges` (
  `priv_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sc_collects`
--
ALTER TABLE `sc_collects`
  ADD PRIMARY KEY (`collect_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `topic_id` (`topic_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `team_id` (`team_id`);

--
-- Indexes for table `sc_confirms`
--
ALTER TABLE `sc_confirms`
  ADD PRIMARY KEY (`confirm_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `topic_id` (`topic_id`),
  ADD KEY `team_id` (`team_id`),
  ADD KEY `is_rated` (`is_rated`),
  ADD KEY `is_confirmed` (`is_confirmed`);

--
-- Indexes for table `sc_feedbacks`
--
ALTER TABLE `sc_feedbacks`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `team_id` (`team_id`);

--
-- Indexes for table `sc_items`
--
ALTER TABLE `sc_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `topic_id` (`topic_id`),
  ADD KEY `disp` (`disp`);

--
-- Indexes for table `sc_roles`
--
ALTER TABLE `sc_roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `sc_schools`
--
ALTER TABLE `sc_schools`
  ADD PRIMARY KEY (`school_id`);

--
-- Indexes for table `sc_teams`
--
ALTER TABLE `sc_teams`
  ADD PRIMARY KEY (`team_id`),
  ADD KEY `topic_id` (`topic_id`),
  ADD KEY `team_no` (`team_no`),
  ADD KEY `school_id` (`school_id`) USING BTREE;

--
-- Indexes for table `sc_topics`
--
ALTER TABLE `sc_topics`
  ADD PRIMARY KEY (`topic_id`),
  ADD KEY `disp` (`disp`);

--
-- Indexes for table `sc_users`
--
ALTER TABLE `sc_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `isadmin` (`isadmin`);

--
-- Indexes for table `sc_user_privileges`
--
ALTER TABLE `sc_user_privileges`
  ADD PRIMARY KEY (`priv_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `topic_id` (`topic_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sc_collects`
--
ALTER TABLE `sc_collects`
  MODIFY `collect_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sc_confirms`
--
ALTER TABLE `sc_confirms`
  MODIFY `confirm_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sc_feedbacks`
--
ALTER TABLE `sc_feedbacks`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sc_items`
--
ALTER TABLE `sc_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sc_roles`
--
ALTER TABLE `sc_roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sc_schools`
--
ALTER TABLE `sc_schools`
  MODIFY `school_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sc_teams`
--
ALTER TABLE `sc_teams`
  MODIFY `team_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sc_topics`
--
ALTER TABLE `sc_topics`
  MODIFY `topic_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sc_users`
--
ALTER TABLE `sc_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sc_user_privileges`
--
ALTER TABLE `sc_user_privileges`
  MODIFY `priv_id` int(11) NOT NULL AUTO_INCREMENT;

INSERT INTO `sc_users` ( `username`, `password`, `salt`, `role_id`, `isadmin`, `sex`, `realname`, `phone`, `comment`, `school_id`) VALUES
( 'admin', '21232f297a57a5a743894a0e4a801fc3', NULL, 1, 1, 0, 'admin', '', '', -1);
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
