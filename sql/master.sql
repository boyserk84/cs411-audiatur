-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 29, 2010 at 01:01 AM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `audiatur`
--
CREATE DATABASE `audiatur` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `audiatur`;

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE IF NOT EXISTS `albums` (
 `artist_id` int(11) NOT NULL,
 `album_name` varchar(128) NOT NULL,
 `release_date` date NOT NULL,
 PRIMARY KEY (`artist_id`,`album_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`artist_id`, `album_name`, `release_date`) VALUES
(1, 'Paranoid', '1971-01-17');

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE IF NOT EXISTS `artists` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `name` varchar(256) NOT NULL,
 `description` text NOT NULL,
 `founded_in` year(4) NOT NULL,
 `logo` text,
 PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`id`, `name`, `description`, `founded_in`, `logo`) VALUES
(1, 'Black Sabbath', 'Black Sabbath has been credited with being one of the originators of the heavy metal genre. Over the last 40 years, they have gone through many singers and band members, with the only constant member being Tony Iommi.', 1968, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `artists_playing_genres`
--

CREATE TABLE IF NOT EXISTS `artists_playing_genres` (
 `artist_id` int(11) NOT NULL,
 `genre_name` varchar(64) NOT NULL,
 PRIMARY KEY (`artist_id`,`genre_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `artists_playing_genres`
--

INSERT INTO `artists_playing_genres` (`artist_id`, `genre_name`) VALUES
(1, 'Heavy Metal');

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE IF NOT EXISTS `genres` (
 `name` varchar(64) NOT NULL,
 `sub_genre_name` varchar(64) DEFAULT NULL,
 `description` text NOT NULL,
 PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`name`, `sub_genre_name`, `description`) VALUES
('Heavy Metal', NULL, '\\m/');

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE IF NOT EXISTS `songs` (
 `song_name` varchar(128) NOT NULL,
 `album_name` varchar(128) NOT NULL,
 `artist_id` int(11) NOT NULL,
 `duration` time NOT NULL,
 PRIMARY KEY (`song_name`,`album_name`,`artist_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`song_name`, `album_name`, `artist_id`, `duration`) VALUES
('War Pigs', 'Paranoid', 1, '00:07:55'),
('Paranoid', 'Paranoid', 1, '00:02:47'),
('Planet Caravan', 'Paranoid', 1, '00:04:30'),
('Iron Man', 'Paranoid', 1, '00:05:58');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
 `user_id` int(11) NOT NULL AUTO_INCREMENT,
 `user_name` varchar(64) NOT NULL,
 `password` varchar(64) NOT NULL,
 `email` varchar(128) NOT NULL,
 PRIMARY KEY (`user_id`),
 UNIQUE KEY `user_name` (`user_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `password`, `email`) VALUES
(1, 'tnubel', 'e7e4aff559041bb6d91cc1ef43292fc5', 'tnubel@sbcglobal.net');

-- --------------------------------------------------------

--
-- Table structure for table `users_liking_albums`
--

CREATE TABLE IF NOT EXISTS `users_liking_albums` (
 `user_id` int(11) NOT NULL,
 `album_name` varchar(64) NOT NULL,
 `artist_id` int(11) NOT NULL,
 `rating` int(11) NOT NULL,
 PRIMARY KEY (`user_id`,`album_name`,`artist_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_liking_albums`
--


-- --------------------------------------------------------

--
-- Table structure for table `users_liking_artists`
--

CREATE TABLE IF NOT EXISTS `users_liking_artists` (
 `user_id` int(11) NOT NULL,
 `artist_id` int(11) NOT NULL,
 `rating` int(11) NOT NULL,
 PRIMARY KEY (`user_id`,`artist_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_liking_artists`
--


-- --------------------------------------------------------

--
-- Table structure for table `users_liking_genres`
--

CREATE TABLE IF NOT EXISTS `users_liking_genres` (
 `user_id` int(11) NOT NULL,
 `genre_name` varchar(64) NOT NULL,
 PRIMARY KEY (`user_id`,`genre_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_liking_genres`
--


-- --------------------------------------------------------

--
-- Table structure for table `users_liking_songs`
--

CREATE TABLE IF NOT EXISTS `users_liking_songs` (
 `user_id` int(11) NOT NULL,
 `song_name` varchar(128) NOT NULL,
 `album_name` varchar(128) NOT NULL,
 `artist_id` int(11) NOT NULL,
 `rating` int(11) NOT NULL,
 PRIMARY KEY (`user_id`,`song_name`,`album_name`,`artist_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_liking_songs`
--

