-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 10, 2020 at 10:07 AM
-- Server version: 5.7.26
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cocktailer`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `c_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ingredient`
--

CREATE TABLE `ingredient` (
  `i_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `measurement` int(11) NOT NULL,
  `item` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ingredient`
--

INSERT INTO `ingredient` (`i_id`, `recipe_id`, `quantity`, `measurement`, `item`) VALUES
(92, 73, 1, 1, 'updated multi1'),
(93, 73, 2, 1, 'updated multi2'),
(94, 73, 3, 1, 'updated multi3'),
(95, 73, 4, 1, 'updated multi4'),
(96, 73, 5, 1, 'update multi5'),
(97, 73, 6, 1, 'update multi6'),
(98, 73, 7, 1, 'update multi7'),
(99, 73, 8, 1, 'update multi8'),
(100, 73, 9, 1, 'update multi9'),
(101, 73, 10, 1, 'update multi10'),
(102, 73, 11, 1, 'update multi11'),
(103, 73, 12, 1, 'update multi12'),
(104, 73, 13, 1, 'update multi13'),
(105, 73, 14, 1, 'update multi14'),
(106, 73, 15, 1, 'update multi15'),
(107, 74, 1, 1, 'vodka'),
(108, 74, 2, 2, 'rum'),
(111, 76, 1, 1, 'updated vodka'),
(112, 76, 2, 2, 'updated rum'),
(113, 77, 1, 1, 'milk'),
(114, 77, 2, 1, 'bailey'),
(115, 78, 1, 1, 'multi1'),
(116, 78, 1, 1, 'multi2'),
(249, 107, 1, 1, 'item 1'),
(250, 107, 1, 1, 'item 2'),
(251, 107, 1, 1, 'item 3'),
(252, 107, 1, 1, 'item 4'),
(253, 107, 5, 1, 'item 5'),
(254, 107, 6, 1, 'item 6'),
(255, 107, 7, 1, 'item 7'),
(256, 107, 8, 1, 'item 8'),
(257, 107, 9, 1, 'item 9'),
(258, 107, 10, 1, 'item 10'),
(259, 107, 11, 1, 'item 11'),
(260, 107, 12, 1, 'item 12'),
(261, 107, 13, 1, 'item 13'),
(262, 107, 14, 1, 'item 14'),
(263, 107, 15, 1, 'item 15'),
(264, 108, 1, 1, 'item 1'),
(265, 108, 1, 1, 'item 2'),
(266, 108, 1, 1, 'item 3'),
(267, 108, 1, 1, 'item 4'),
(268, 108, 5, 1, 'item 5'),
(269, 108, 6, 1, 'item 6'),
(270, 108, 7, 1, 'item 7'),
(271, 108, 8, 1, 'item 8'),
(272, 108, 9, 1, 'item 9'),
(273, 108, 10, 1, 'item 10'),
(274, 108, 11, 1, 'item 11'),
(275, 108, 12, 1, 'item 12'),
(276, 108, 13, 1, 'item 13'),
(277, 108, 14, 1, 'item 14'),
(278, 108, 15, 1, 'item 15'),
(279, 109, 1, 1, 'item 1'),
(280, 109, 1, 1, 'item 2'),
(281, 109, 1, 1, 'item 3'),
(282, 109, 1, 1, 'item 4'),
(283, 109, 5, 1, 'item 5'),
(284, 109, 6, 1, 'item 6'),
(285, 109, 7, 1, 'item 7'),
(286, 109, 8, 1, 'item 8'),
(287, 109, 9, 1, 'item 9'),
(288, 109, 10, 1, 'item 10'),
(289, 109, 11, 1, 'item 11'),
(290, 109, 12, 1, 'item 12'),
(291, 109, 13, 1, 'item 13'),
(292, 109, 14, 1, 'item 14'),
(293, 109, 15, 1, 'item 15');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `privilege` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`user_id`, `username`, `password`, `privilege`) VALUES
(1, 'a', '$2y$10$I8WHpg2TiIeJs4Qxp/o4YubAe3nbWS8Fzrhfubapirj4S/EBX3/S.', 2),
(4, 'admin', '$2y$10$GvIYKoNrjqELRKpdL85pXOx6AiaIrwBd1PiNPPOUHT4r6mGMrLVoe', 1),
(6, 'fred', '$2y$10$Ayf6b.sEuJibz2qBQuioRuHu7AsQEVwGGOc87lOOtjBSEhul3JC9m', 1),
(10, 'admin2', '$2y$10$1fS2baoL1iHjiERRY8HADeK3FqpxX0ziP8kgpFfRv0Gkj.pMyvdLK', 2),
(11, 'b', '$2y$10$SBDclcv7rZmAetuJHNJLOu5/PAVj6hGfSFp.9OOJ.2x8zK0BaOJN2', 2);

-- --------------------------------------------------------

--
-- Table structure for table `measurement`
--

CREATE TABLE `measurement` (
  `mea_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `measurement`
--

INSERT INTO `measurement` (`mea_id`, `type`) VALUES
(1, 'ml'),
(2, 'dash(es)'),
(3, 'oz'),
(4, 'drop(s)'),
(5, 'cup(s)'),
(6, 'slice(s)'),
(7, 'fresh');

-- --------------------------------------------------------

--
-- Table structure for table `method`
--

CREATE TABLE `method` (
  `met_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `step` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `method`
--

INSERT INTO `method` (`met_id`, `recipe_id`, `step`) VALUES
(9, 73, 'update multiStep1'),
(10, 73, 'update multiStep2'),
(11, 73, 'update multiStep3'),
(12, 73, 'update multiStep4'),
(13, 73, 'update multiStep5'),
(14, 74, 'submitted by postman'),
(16, 76, ' updated submitted by postman'),
(17, 77, 'mix together'),
(18, 78, 'step1'),
(61, 107, 'step1 by user b'),
(62, 107, 'step2 by user b'),
(63, 107, 'step3 by user b'),
(64, 107, 'step4 by user b'),
(65, 107, 'step5 by user b'),
(66, 108, 'step1 by user b'),
(67, 108, 'step2 by user b'),
(68, 108, 'step3 by user b'),
(69, 108, 'step4 by user b'),
(70, 108, 'step5 by user b'),
(71, 109, 'step1 by user b'),
(72, 109, 'step2 by user b'),
(73, 109, 'step3 by user b'),
(74, 109, 'step4 by user b'),
(75, 109, 'step5 by user b');

-- --------------------------------------------------------

--
-- Table structure for table `recipe`
--

CREATE TABLE `recipe` (
  `recipe_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `imgUrl` varchar(2083) NOT NULL DEFAULT 'https://via.placeholder.com/150',
  `thumbsUp` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `recipe`
--

INSERT INTO `recipe` (`recipe_id`, `name`, `description`, `imgUrl`, `thumbsUp`, `user_id`) VALUES
(73, 'updated with admin15', 'updated15 crecipe by postman', 'https://via.placeholder.com/150', 0, 1),
(74, 'crecipe', 'crecipe by postman', 'https://via.placeholder.com/150', 100, 1),
(76, 'updated with admin', 'updated crecipe by postman', 'https://via.placeholder.com/150', 20, 1),
(77, 'create recipe', 'create recipe without login', 'https://via.placeholder.com/150', 0, 6),
(78, 'create recipe', 'created with empty url', 'https://via.placeholder.com/150', 0, 10),
(107, 'test script 1 created by user b', 'created 15 ingre and 5 step by user b', 'https://via.placeholder.com/150', 0, 11),
(108, 'test script 2 created by user b', 'created 15 ingre and 5 step by user b', 'https://via.placeholder.com/150', 0, 11),
(109, 'test script 3 created by user b', 'created 15 ingre and 5 step by user b', 'https://via.placeholder.com/150', 0, 11);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `recipe_id` (`recipe_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ingredient`
--
ALTER TABLE `ingredient`
  ADD PRIMARY KEY (`i_id`),
  ADD KEY `measurement` (`measurement`),
  ADD KEY `recipe_id` (`recipe_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `measurement`
--
ALTER TABLE `measurement`
  ADD PRIMARY KEY (`mea_id`);

--
-- Indexes for table `method`
--
ALTER TABLE `method`
  ADD PRIMARY KEY (`met_id`),
  ADD KEY `recipe_id` (`recipe_id`);

--
-- Indexes for table `recipe`
--
ALTER TABLE `recipe`
  ADD PRIMARY KEY (`recipe_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `ingredient`
--
ALTER TABLE `ingredient`
  MODIFY `i_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=294;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `measurement`
--
ALTER TABLE `measurement`
  MODIFY `mea_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `method`
--
ALTER TABLE `method`
  MODIFY `met_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `recipe`
--
ALTER TABLE `recipe`
  MODIFY `recipe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`recipe_id`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `login` (`user_id`);

--
-- Constraints for table `ingredient`
--
ALTER TABLE `ingredient`
  ADD CONSTRAINT `ingredient_ibfk_1` FOREIGN KEY (`measurement`) REFERENCES `measurement` (`mea_id`),
  ADD CONSTRAINT `ingredient_ibfk_2` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`recipe_id`);

--
-- Constraints for table `method`
--
ALTER TABLE `method`
  ADD CONSTRAINT `method_ibfk_1` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`recipe_id`);

--
-- Constraints for table `recipe`
--
ALTER TABLE `recipe`
  ADD CONSTRAINT `recipe_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `login` (`user_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
