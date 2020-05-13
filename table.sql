-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 13, 2020 at 08:10 AM
-- Server version: 5.7.26
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `todo`
--

-- --------------------------------------------------------

--
-- Table structure for table `todo_table`
--

CREATE TABLE `todo_table` (
  `id` int(11) NOT NULL,
  `text` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `todo_table`
--

INSERT INTO `todo_table` (`id`, `text`) VALUES
(1, 'item 1'),
(2, 'item 2'),
(3, 'item 3'),
(4, 'item 4');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `todo_table`
--
ALTER TABLE `todo_table`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `todo_table`
--
ALTER TABLE `todo_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
