-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2020 at 01:50 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `it210cinema`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(10) UNSIGNED NOT NULL,
  `writer_name` varchar(64) NOT NULL,
  `writer_email` varchar(64) NOT NULL,
  `writer_phone` varchar(64) NOT NULL,
  `subject` varchar(64) NOT NULL,
  `message_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `writer_name`, `writer_email`, `writer_phone`, `subject`, `message_text`) VALUES
(1, 'Nikola', 'nikniknik@gmail.com', '604816515', 'Testtest', 'TestTestTest'),
(3, 'Test', 'testtest@test.com', '1156651561516', 'Test2', 'teadfwadawfwadwad'),
(6, 'Nikola', 'test2@test.com', '1156651561516', 'Testtest', 'teadwadwawa');

-- --------------------------------------------------------

--
-- Table structure for table `movie`
--

CREATE TABLE `movie` (
  `movie_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `genre` varchar(64) NOT NULL,
  `main_actor` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `movie`
--

INSERT INTO `movie` (`movie_id`, `name`, `genre`, `main_actor`) VALUES
(1, 'Doolittle', 'Comedy', 'Robert Downey Jr.'),
(2, 'Gretel & Hansel', 'Mystery', 'Sophia Lillis'),
(3, 'Fantasy Island', 'Adventure', 'Michael Peña'),
(4, 'No Time to Die', 'Action', 'Daniel Craig'),
(5, 'Mulan', 'Action', 'Yifei Liu'),
(6, 'Sonic', 'Adventure', 'Ben Schwartz'),
(7, 'The Way Back', 'Drama', 'Ben Affleck'),
(8, 'Black Panther', 'Action', 'Chadwick Boseman');

-- --------------------------------------------------------

--
-- Table structure for table `projection`
--

CREATE TABLE `projection` (
  `projection_id` int(10) UNSIGNED NOT NULL,
  `movie_id` int(10) NOT NULL,
  `time` time NOT NULL,
  `seats` int(10) UNSIGNED NOT NULL,
  `ticket_price` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `projection`
--

INSERT INTO `projection` (`projection_id`, `movie_id`, `time`, `seats`, `ticket_price`) VALUES
(1, 1, '20:00:00', 44, 3),
(2, 1, '18:00:00', 23, 3),
(3, 1, '15:00:00', 33, 3),
(4, 2, '15:00:00', 43, 4),
(5, 2, '17:00:00', 28, 4),
(6, 2, '21:00:00', 52, 4),
(7, 3, '20:00:00', 45, 3),
(8, 3, '18:00:00', 61, 3),
(9, 3, '22:30:00', 26, 3),
(10, 4, '21:30:00', 43, 4),
(11, 4, '12:15:00', 18, 4),
(12, 4, '17:30:00', 55, 4),
(13, 5, '15:00:00', 27, 3),
(14, 5, '16:30:00', 23, 3),
(15, 6, '20:15:00', 56, 3),
(16, 6, '12:00:00', 25, 3),
(17, 7, '21:30:00', 50, 4),
(18, 7, '19:30:00', 22, 4),
(19, 7, '23:00:00', 41, 4),
(20, 8, '18:15:00', 22, 3),
(21, 8, '10:30:00', 12, 3),
(22, 8, '21:20:00', 25, 3);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `role_name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role_name`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `ticket_id` int(11) NOT NULL,
  `projection_id` int(11) UNSIGNED NOT NULL,
  `movie_id` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`ticket_id`, `projection_id`, `movie_id`, `user_id`) VALUES
(18, 1, 1, 1),
(19, 1, 1, 1),
(20, 9, 3, 1),
(21, 9, 3, 1),
(22, 2, 1, 5),
(23, 2, 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(256) NOT NULL,
  `email` varchar(64) NOT NULL,
  `date_created` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Test users';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `date_created`) VALUES
(1, 'root', '$2y$10$ARapIL/CsnIWGqY3lzGMlOKblgKkskzxGgD0QencrenI4P3K.eoZS', 'root@mail.com', '2020-04-21'),
(2, 'admin', '$2y$10$YWPW.jvCmpNIwix0.tcQDejtEW2TElLajNCy8FyvA7DQyLOQWGGMy', 'admin@mail.com', '2020-04-21'),
(3, 'test', '$2y$10$eq5r8T5HKNFCIM4R7LACPuVIeb7A9G23p2by/Daz4LARZn/6DGmji', 'test1@test.com', '2020-04-28'),
(5, 'nikola', '$2y$10$wHI5th44y6YEiIBB7acGjuJJP76XFkHdx1bgS1c3/5oODmOelrEei', 'nikollanik17@gmail.com', '2020-05-05'),
(8, 'test21', '$2y$10$gXC.neDUSdnfTVbtaqDLb.7tKsF.gRL6nSerxyUfJ0jdi8myHPuI.', 'test21@test.com', '2020-05-26'),
(9, 'test222', '$2y$10$Ar6sJc7Z3UXsaE6aJpy24eyrw66idb8MnQ0xjb/KQ52ZOE7RLTagy', 'test222@gmail.com', '2020-05-28');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `user_role_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`user_role_id`, `user_id`, `role_id`) VALUES
(1, 2, 1),
(2, 5, 2),
(3, 2, 2),
(4, 5, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`movie_id`);

--
-- Indexes for table `projection`
--
ALTER TABLE `projection`
  ADD PRIMARY KEY (`projection_id`),
  ADD KEY `movie_id_pr_fk` (`movie_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`) USING BTREE,
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `movie_id_fk` (`projection_id`),
  ADD KEY `user_fk` (`user_id`),
  ADD KEY `movie_id_fkk` (`movie_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username_index` (`username`,`email`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`user_role_id`),
  ADD KEY `user_id_fk` (`user_id`),
  ADD KEY `role_id_fk` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `movie`
--
ALTER TABLE `movie`
  MODIFY `movie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `projection`
--
ALTER TABLE `projection`
  MODIFY `projection_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `user_role_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `projection`
--
ALTER TABLE `projection`
  ADD CONSTRAINT `movie_id_pr_fk` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`movie_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `movie_id_fkk` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`movie_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `projection_id_fk` FOREIGN KEY (`projection_id`) REFERENCES `projection` (`projection_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `role_id_fk` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
