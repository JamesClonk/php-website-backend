-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 30, 2013 at 11:15 AM
-- Server version: 5.5.33a-MariaDB-log
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `jc_backend`
--
CREATE DATABASE IF NOT EXISTS `jc_backend` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `jc_backend`;

-- --------------------------------------------------------

--
-- Table structure for table `dvd_actor_item`
--

DROP TABLE IF EXISTS `dvd_actor_item`;
CREATE TABLE IF NOT EXISTS `dvd_actor_item` (
  `item_id` int(11) NOT NULL DEFAULT '0',
  `people_id` int(11) NOT NULL DEFAULT '0',
  KEY `people_id` (`people_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dvd_comment`
--

DROP TABLE IF EXISTS `dvd_comment`;
CREATE TABLE IF NOT EXISTS `dvd_comment` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `author` text,
  `timestamp` date DEFAULT NULL,
  `ip` text,
  `external` text,
  UNIQUE KEY `comment_id` (`comment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `dvd_dbdate`
--

DROP TABLE IF EXISTS `dvd_dbdate`;
CREATE TABLE IF NOT EXISTS `dvd_dbdate` (
  `date_id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `description` text NOT NULL,
  PRIMARY KEY (`date_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `dvd_director_item`
--

DROP TABLE IF EXISTS `dvd_director_item`;
CREATE TABLE IF NOT EXISTS `dvd_director_item` (
  `item_id` int(11) NOT NULL DEFAULT '0',
  `people_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dvd_genre`
--

DROP TABLE IF EXISTS `dvd_genre`;
CREATE TABLE IF NOT EXISTS `dvd_genre` (
  `genre_id` int(11) NOT NULL AUTO_INCREMENT,
  `genre_name` text NOT NULL,
  UNIQUE KEY `genre_id` (`genre_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

-- --------------------------------------------------------

--
-- Table structure for table `dvd_genre_item`
--

DROP TABLE IF EXISTS `dvd_genre_item`;
CREATE TABLE IF NOT EXISTS `dvd_genre_item` (
  `item_id` int(11) NOT NULL DEFAULT '0',
  `genre_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dvd_item`
--

DROP TABLE IF EXISTS `dvd_item`;
CREATE TABLE IF NOT EXISTS `dvd_item` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_title` text,
  `item_alttitle` text,
  `item_year` int(11) DEFAULT NULL,
  `item_desc` text,
  `item_format` text,
  `item_length` int(11) DEFAULT NULL,
  `item_code` text,
  `item_fsk` int(11) DEFAULT NULL,
  `item_dvds` int(11) DEFAULT NULL,
  `item_rating` int(11) DEFAULT NULL,
  `item_pic` text,
  `item_type` text,
  UNIQUE KEY `item_id` (`item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=840 ;

-- --------------------------------------------------------

--
-- Table structure for table `dvd_language`
--

DROP TABLE IF EXISTS `dvd_language`;
CREATE TABLE IF NOT EXISTS `dvd_language` (
  `language_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_name` text NOT NULL,
  `country_name` text NOT NULL,
  `native_language_name` text NOT NULL,
  PRIMARY KEY (`language_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Table structure for table `dvd_language_item`
--

DROP TABLE IF EXISTS `dvd_language_item`;
CREATE TABLE IF NOT EXISTS `dvd_language_item` (
  `item_id` int(11) NOT NULL DEFAULT '0',
  `language_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dvd_people`
--

DROP TABLE IF EXISTS `dvd_people`;
CREATE TABLE IF NOT EXISTS `dvd_people` (
  `people_id` int(11) NOT NULL AUTO_INCREMENT,
  `people_name` text NOT NULL,
  UNIQUE KEY `people_id` (`people_id`),
  FULLTEXT KEY `people_name` (`people_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4099 ;

-- --------------------------------------------------------

--
-- Table structure for table `games_award`
--

DROP TABLE IF EXISTS `games_award`;
CREATE TABLE IF NOT EXISTS `games_award` (
  `award_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL DEFAULT '0',
  `award_desc` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`award_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=53 ;

-- --------------------------------------------------------

--
-- Table structure for table `games_company`
--

DROP TABLE IF EXISTS `games_company`;
CREATE TABLE IF NOT EXISTS `games_company` (
  `company_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` text COLLATE latin1_general_ci NOT NULL,
  UNIQUE KEY `company_id` (`company_id`),
  FULLTEXT KEY `company_name` (`company_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=140 ;

-- --------------------------------------------------------

--
-- Table structure for table `games_current`
--

DROP TABLE IF EXISTS `games_current`;
CREATE TABLE IF NOT EXISTS `games_current` (
  `item_id` int(11) NOT NULL DEFAULT '0',
  `item_status` int(11) NOT NULL DEFAULT '0',
  KEY `item_id` (`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `games_dbdate`
--

DROP TABLE IF EXISTS `games_dbdate`;
CREATE TABLE IF NOT EXISTS `games_dbdate` (
  `date_id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `description` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`date_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `games_developer_item`
--

DROP TABLE IF EXISTS `games_developer_item`;
CREATE TABLE IF NOT EXISTS `games_developer_item` (
  `item_id` int(11) NOT NULL DEFAULT '0',
  `company_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `games_genre`
--

DROP TABLE IF EXISTS `games_genre`;
CREATE TABLE IF NOT EXISTS `games_genre` (
  `genre_id` int(11) NOT NULL AUTO_INCREMENT,
  `genre_name` text COLLATE latin1_general_ci NOT NULL,
  UNIQUE KEY `genre_id` (`genre_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=45 ;

-- --------------------------------------------------------

--
-- Table structure for table `games_genre_item`
--

DROP TABLE IF EXISTS `games_genre_item`;
CREATE TABLE IF NOT EXISTS `games_genre_item` (
  `item_id` int(11) NOT NULL DEFAULT '0',
  `genre_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `games_item`
--

DROP TABLE IF EXISTS `games_item`;
CREATE TABLE IF NOT EXISTS `games_item` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_title` text COLLATE latin1_general_ci,
  `item_alttitle` text COLLATE latin1_general_ci,
  `item_release` date DEFAULT NULL,
  `item_desc` text COLLATE latin1_general_ci,
  `item_system` text COLLATE latin1_general_ci,
  `item_pegi` int(11) DEFAULT NULL,
  `item_rating` int(11) DEFAULT NULL,
  `item_pic` text COLLATE latin1_general_ci,
  `item_players` text COLLATE latin1_general_ci,
  `item_sound` text COLLATE latin1_general_ci,
  UNIQUE KEY `item_id` (`item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=373 ;

-- --------------------------------------------------------

--
-- Table structure for table `games_publisher_item`
--

DROP TABLE IF EXISTS `games_publisher_item`;
CREATE TABLE IF NOT EXISTS `games_publisher_item` (
  `item_id` int(11) NOT NULL DEFAULT '0',
  `company_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
