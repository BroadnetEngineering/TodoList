SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `todos`
--
CREATE DATABASE IF NOT EXISTS `todos` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
USE `todos`;

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

DROP TABLE IF EXISTS `item`;
CREATE TABLE `item` (
  `order` tinyint(3) UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_bin NOT NULL,
  `completed` tinyint(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;