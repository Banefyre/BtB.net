-- phpMyAdmin SQL Dump
-- version 4.1.9
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Apr 12, 2014 at 12:47 PM
-- Server version: 5.5.36
-- PHP Version: 5.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `game`
--
CREATE DATABASE IF NOT EXISTS `game` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `game`;

-- --------------------------------------------------------

--
-- Table structure for table `faction`
--

CREATE TABLE IF NOT EXISTS `faction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `faction`
--

INSERT INTO `faction` (`id`, `name`) VALUES
(1, 'Human'),
(2, 'Chaos'),
(3, 'Alien');

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE IF NOT EXISTS `game` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `max_players` int(11) NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `game`
--

INSERT INTO `game` (`id`, `name`, `max_players`) VALUES
(1, 'game1', 2),
(10, 'test42', 2),
(11, 'test42wsd', 2),
(12, 'testlol', 2);

-- --------------------------------------------------------

--
-- Table structure for table `games_faction`
--

CREATE TABLE IF NOT EXISTS `games_faction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_game` int(11) NOT NULL,
  `id_faction` int(11) NOT NULL,
  `selected` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `games_faction`
--

INSERT INTO `games_faction` (`id`, `id_game`, `id_faction`, `selected`) VALUES
(3, 1, 3, 1),
(4, 1, 1, 1),
(5, 1, 2, 0),
(6, 0, 1, 0),
(7, 0, 2, 0),
(8, 0, 3, 0),
(9, 11, 1, 0),
(10, 11, 2, 0),
(11, 11, 3, 0),
(12, 12, 1, 0),
(13, 12, 2, 0),
(14, 12, 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `games_players`
--

CREATE TABLE IF NOT EXISTS `games_players` (
  `id_game` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `games_players`
--

INSERT INTO `games_players` (`id_game`, `id_user`) VALUES
(1, 2),
(1, 1),
(10, 3),
(10, 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login`, `password`) VALUES
(1, 'nope', 'perdu'),
(2, 'fail', 'ilost'),
(3, 'moi', 'toto'),
(4, 'toto', 'moi');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
