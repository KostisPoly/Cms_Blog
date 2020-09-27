-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2020 at 09:40 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(3) NOT NULL,
  `cat_title` varchar(255) COLLATE utf8_bin NOT NULL,
  `cat_parent_cat` int(3) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_title`, `cat_parent_cat`) VALUES
(1, 'Football', 0),
(2, 'Basketball', 0),
(3, 'Sports', 0),
(4, 'Life', 0),
(5, 'Esports', 0),
(6, 'Bet', 0),
(7, 'Superleague', 1),
(8, 'Champions League', 1),
(9, 'Europa League', 1),
(10, 'Premier League', 1),
(11, 'NBA', 2),
(12, 'Euro League', 2),
(13, 'Basket League', 2),
(14, 'Dota 2', 5),
(15, 'Trending', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cms_online_users`
--

CREATE TABLE `cms_online_users` (
  `id` int(11) NOT NULL,
  `cou_session` varchar(255) COLLATE utf8_bin NOT NULL,
  `cou_time` datetime NOT NULL DEFAULT current_timestamp(),
  `cou_user` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `com_id` int(3) NOT NULL,
  `com_post_id` int(3) NOT NULL,
  `com_author` varchar(255) COLLATE utf8_bin NOT NULL,
  `com_email` varchar(255) COLLATE utf8_bin NOT NULL,
  `com_content` text COLLATE utf8_bin NOT NULL,
  `com_status` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT 'draft',
  `com_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(3) NOT NULL,
  `post_category` int(11) NOT NULL,
  `post_title` varchar(255) COLLATE utf8_bin NOT NULL,
  `post_author` varchar(255) COLLATE utf8_bin NOT NULL,
  `post_date` date NOT NULL,
  `post_image` text COLLATE utf8_bin NOT NULL,
  `post_content` text COLLATE utf8_bin NOT NULL,
  `post_tags` varchar(255) COLLATE utf8_bin NOT NULL,
  `post_comments` int(11) NOT NULL DEFAULT 0,
  `post_status` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT 'draft'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `social`
--

CREATE TABLE `social` (
  `so_id` int(11) NOT NULL,
  `so_title` varchar(255) COLLATE utf8_bin NOT NULL,
  `so_followers` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `social`
--

INSERT INTO `social` (`so_id`, `so_title`, `so_followers`) VALUES
(1, 'facebook', 22000),
(2, 'twitter', 35200),
(3, 'instagram', 29600),
(4, 'twitch', 11900),
(5, 'pinterest', 7350),
(6, 'tumblr', 14750);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `us_id` int(11) NOT NULL,
  `us_username` varchar(255) COLLATE utf8_bin NOT NULL,
  `us_password` varchar(255) COLLATE utf8_bin NOT NULL,
  `us_firstname` varchar(255) COLLATE utf8_bin NOT NULL,
  `us_lastname` varchar(255) COLLATE utf8_bin NOT NULL,
  `us_email` varchar(255) COLLATE utf8_bin NOT NULL,
  `us_role` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT 'draft',
  `us_isadmin` smallint(6) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`us_id`, `us_username`, `us_password`, `us_firstname`, `us_lastname`, `us_email`, `us_role`, `us_isadmin`) VALUES
(1, 'Admin', '$2y$10$GReqHDUGuZ/Cw5alMkWsUOl/.IKnjuEWWx7k/mZV/tTBijnDtrnPq', 'ADMIN', 'Admin', 'admin@admin.com', 'administrator', 1)

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `cms_online_users`
--
ALTER TABLE `cms_online_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`com_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `social`
--
ALTER TABLE `social`
  ADD PRIMARY KEY (`so_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`us_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `cms_online_users`
--
ALTER TABLE `cms_online_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `com_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `social`
--
ALTER TABLE `social`
  MODIFY `so_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `us_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
