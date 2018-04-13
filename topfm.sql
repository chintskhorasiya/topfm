-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 13, 2018 at 04:04 PM
-- Server version: 5.5.58-0ubuntu0.14.04.1
-- PHP Version: 5.6.33-1+ubuntu14.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `topfm`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE IF NOT EXISTS `blogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `short_content` text NOT NULL,
  `content` longtext CHARACTER SET utf8 NOT NULL,
  `images` text,
  `status` int(2) NOT NULL DEFAULT '0' COMMENT '0:Draft,1:Published,2:Deleted',
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `slug`, `short_content`, `content`, `images`, `status`, `user_id`, `created`, `modified`) VALUES
(1, 'Lorem Ipsum is simply dummy', 'lorem-ipsum-blog-1', 'Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy.', '<p>Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy.Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy.Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy.Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy.Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy.Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy.Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy.Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy.Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy.Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy.Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy.</p>\r\n<p>vvvLorem Ipsum is simply dummy. Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy.Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy.Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy.Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy.Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy.Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy.Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy. Lorem Ipsum is simply dummy.</p>', 'Krishi.jpg', 1, 1, '2018-04-13 14:58:37', '2018-04-13 14:58:37'),
(2, 'sdfd', 'dsfsdf', 'dfsdfsdf', '<p>dfsdfsdf</p>', '25017055_132139314144997_7144875845780242432_n.jpg', 2, 1, '2018-04-13 14:59:19', '2018-04-13 14:59:23'),
(3, 'asdasdas', 'dasd', 'asdasd', '<p>asdasdas</p>', 'zjHl2lgef9cYrQL0JFa.png', 2, 1, '2018-04-13 14:59:35', '2018-04-13 14:59:40');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0:Draft,1:Published,2:Deleted',
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `title`, `slug`, `user_id`, `status`, `created`, `modified`) VALUES
(1, 'sdfsdfkjn', 'dkjfnfkgjnd', 1, 0, '2018-04-12 10:37:32', '2018-04-12 10:37:32'),
(2, 'fgdfg', 'dfgdgfggf', 1, 0, '2018-04-12 10:24:28', '2018-04-12 10:24:28'),
(3, 'Ahmedabad', 'ahmedabad', 1, 1, '2018-04-12 10:37:58', '2018-04-12 10:37:58'),
(4, 'Surat', 'surat', 1, 1, '2018-04-12 10:38:39', '2018-04-12 10:38:39');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `content` longtext CHARACTER SET utf8 NOT NULL,
  `images` text,
  `status` int(2) NOT NULL DEFAULT '0' COMMENT '0:Draft,1:Published,2:Deleted',
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `subtitle`, `slug`, `content`, `images`, `status`, `user_id`, `created`, `modified`) VALUES
(1, 'You are my life', 'Music - Arturo Chiritto', 'You-are-my-life', '<p>You are my life</p>\r\n<p>Music - Arturo Chiritto</p>', 'banner1.jpg', 1, 1, '2018-04-13 12:40:42', '2018-04-13 12:40:42'),
(2, 'lfmslkdf', 'sdfdklmdflgm', 'fkmdflkgm', '<p>fkmldkmfgldfmgldf</p>\r\n<p>dfgklmdfgkl</p>\r\n<p>fdgkldfgldflgmdlfkgmldfmg</p>', 'Krishi.jpg', 0, 1, '2018-04-13 12:58:17', '2018-04-13 12:58:17');

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE IF NOT EXISTS `galleries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `content` longtext CHARACTER SET utf8 NOT NULL,
  `images` text,
  `status` int(2) NOT NULL DEFAULT '0' COMMENT '0:Draft,1:Published,2:Deleted',
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`id`, `title`, `slug`, `content`, `images`, `status`, `user_id`, `created`, `modified`) VALUES
(1, 'test', 'test', '<p>dkjfnkjfnks</p>\r\n<p>sflksdlfmsldfmlsdmf</p>', 'fnfgj.jpg,d_joint_703.jpg', 1, 1, '2018-04-12 10:50:47', '2018-04-12 10:50:47');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `content` longtext NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0:Draft,1:Published,2:Deleted',
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `slug`, `content`, `user_id`, `status`, `created`, `modified`) VALUES
(1, 'about us', 'about-us', '<p>sdkfnsdkfnskdfnkn</p>\r\n<p>sdfsdnfkjsdnfknskdfnksndfksdn</p>', 1, 1, '2018-04-11 18:30:50', '2018-04-11 18:30:50'),
(2, 'contact us', 'contact-us', '<p>contact us content</p>', 1, 1, '2018-04-12 10:19:11', '2018-04-12 10:19:11');

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE IF NOT EXISTS `programs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `facebook_link` varchar(255) DEFAULT NULL,
  `twitter_link` varchar(255) DEFAULT NULL,
  `program_time` varchar(150) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(3) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`id`, `title`, `slug`, `content`, `facebook_link`, `twitter_link`, `program_time`, `user_id`, `status`, `created`, `modified`) VALUES
(1, 'hhgdf', 'fdg', '<p>sdflsdlkfmsldmflsdm</p>\r\n<p>sdflsdflsdlkfmsdklmflsdmfl</p>\r\n<p>sfnsdfkjsndkjfnskjdfnksdnfknsdkfjnsdkfn</p>', 'sfsdf', 'sdfsdfdsf', '8 - 9', 1, 2, '2018-04-12 12:12:32', '2018-04-12 12:30:30'),
(2, 'gfdfgdfg', 'fdgdfgdfg', '<p>dfgfhfghfghjhghj</p>', 'facebook.com/ddkfjndk', 'twitter.com/kjsdnfkdn', '8:00 to 9:00', 1, 2, '2018-04-12 12:28:29', '2018-04-12 12:30:36'),
(3, 'Gaano ka Swags', 'gaano-ka-swags', '<p>Gaano ka Swags...</p>\r\n<p>Gaano ka Swags...</p>\r\n<p>Gaano ka Swags...</p>\r\n<p>Gaano ka Swags...</p>\r\n<p>Gaano ka Swags...</p>', 'facebook.com/ddkfjndk', 'twitter.com/kjsdnfkdn', '8:00 to 9:00', 1, 1, '2018-04-12 12:31:19', '2018-04-12 12:31:19');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `content` longtext CHARACTER SET utf8 NOT NULL,
  `images` text,
  `status` int(2) NOT NULL DEFAULT '0' COMMENT '0:Draft,1:Published,2:Deleted',
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `title`, `slug`, `content`, `images`, `status`, `user_id`, `created`, `modified`) VALUES
(1, 'Babubali1', 'baahubali-review1', '<p>This movie was Epic. Yes This movie was Epic This movie was Epic. Yes This movie was Epic.reviewsThis movie was Epic. Yes This movie was Epic.reviewsThis movie was Epic. Yes This movie was Epic.reviewsThis movie was Epic. Yes This movie was Epic.reviewsThis movie was Epic. Yes This movie was Epic.reviewsThis movie was Epic. Yes This movie was Epic.reviewsThis movie was Epic. Yes This movie was Epic.reviewsThis movie was Epic. Yes This movie was Epic.reviewsThis movie was Epic. Yes This movie was Epic.reviewsThis movie was Epic. Yes This movie was Epic.reviewsThis movie was Epic. Yes This movie was Epic.reviewsThis movie was Epic. Yes This movie was Epic.reviewsThis movie was Epic. Yes This movie was Epic.reviewsThis movie was Epic. Yes This movie was Epic.reviewsThis movie was Epic. Yes This movie was Epic.reviewsThis movie was Epic. Yes This movie was Epic.reviewsThis movie was Epic. Yes This movie was Epic.reviewsThis movie was Epic. Yes This movie was Epic.reviewsThis movie was Epic. Yes This movie was Epic.reviewsThis movie was Epic. Yes This movie was Epic.reviewsThis movie was Epic. Yes This movie was Epic.reviewsThis movie was Epic. Yes This movie was Epic.reviewsThis movie was Epic. Yes This movie was Epic.reviewsThis movie was Epic. Yes This movie was Epic.reviews</p>\r\n<p>&nbsp;</p>\r\n<p>This movie was Epic. Yes This movie was Epic.reviewsThis movie was Epic. Yes This movie was Epic.reviewsThis movie was Epic. Yes This movie was Epic.reviewsThis movie was Epic. Yes This movie was Epic.reviewsThis movie was Epic. Yes This movie was Epic.reviewsThis movie was Epic. Yes This movie was Epic.reviewsThis movie was Epic. Yes This movie was Epic.reviewsThis movie was Epic. Yes This movie was Epic.reviewsThis movie was Epic. Yes This movie was Epic.reviewsThis movie was Epic. Yes This movie was Epic.reviews11111</p>', '20225774_317331188714749_7763899870015913984_n.jpg', 1, 1, '2018-04-13 13:52:52', '2018-04-13 13:52:52');

-- --------------------------------------------------------

--
-- Table structure for table `rjs`
--

CREATE TABLE IF NOT EXISTS `rjs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `content` longtext CHARACTER SET utf8 NOT NULL,
  `images` text,
  `facebook_link` varchar(255) DEFAULT NULL,
  `twitter_link` varchar(255) DEFAULT NULL,
  `instagram_link` varchar(255) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT '0' COMMENT '0:Draft,1:Published,2:Deleted',
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `rjs`
--

INSERT INTO `rjs` (`id`, `title`, `slug`, `content`, `images`, `facebook_link`, `twitter_link`, `instagram_link`, `status`, `user_id`, `created`, `modified`) VALUES
(1, 'Rj Sangram', 'rj-sangram', '<p>This is Rj Sangram Profile.</p>\r\n<p>This is Rj Sangram Profile.</p>\r\n<p>&nbsp;</p>\r\n<p>This is Rj Sangram Profile.</p>\r\n<p>This is Rj Sangram Profile.</p>\r\n<p>This is Rj Sangram Profile.</p>\r\n<p>This is Rj Sangram Profile.</p>', '1504950761.jpg', 'facebook.com/rj-sangram', 'twitter.com/rj-sangram', 'instagra', 1, 1, '2018-04-13 15:16:21', '2018-04-13 15:16:21'),
(2, 'fdgdfg', 'dfgdfg', '<p>dfgdfgdfg</p>', 'logo.png', 'dfgdfg', 'dfgdfg', 'dfgdfg', 2, 1, '2018-04-13 15:20:02', '2018-04-13 15:20:06');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE IF NOT EXISTS `schedules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `content` longtext CHARACTER SET utf8 NOT NULL,
  `images` text,
  `status` int(2) NOT NULL DEFAULT '0' COMMENT '0:Draft,1:Published,2:Deleted',
  `weekday` varchar(255) NOT NULL,
  `sch_time` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `title`, `slug`, `content`, `images`, `status`, `weekday`, `sch_time`, `user_id`, `created`, `modified`) VALUES
(1, 'Lorem ipsum dosk1', 'Lorem-ipsum-dosk1', '<p>Lorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum doskLorem ipsum dosk</p>', '25017055_132139314144997_7144875845780242432_n.jpg', 1, 'wednesday', '5:00 to 7:00', 1, '2018-04-13 12:24:15', '2018-04-13 12:24:15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_type` enum('admin','user') NOT NULL DEFAULT 'user',
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `encrypt_password` varchar(255) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `image_name` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0 for active, 1 for inactive, 2 for draft, 3 for delete',
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_type`, `name`, `email`, `username`, `password`, `encrypt_password`, `mobile`, `image_name`, `status`, `created_date`, `modified_date`) VALUES
(1, 'user', 'admin', 'admin@seawindsolution.com', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'MTIzNDU2', '9876543210', '1511516993nikon1v3samplephoto.jpg', 0, '2017-03-01 18:23:14', '2017-11-24 15:19:53');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE IF NOT EXISTS `videos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `content` longtext CHARACTER SET utf8 NOT NULL,
  `video` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '0' COMMENT '0:Draft,1:Published,2:Deleted',
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`id`, `title`, `slug`, `content`, `video`, `user_id`, `status`, `created`, `modified`) VALUES
(1, 'Video 1', 'video-1', '<p>This is video 1</p>', 'https://www.youtube.com/watch?v=n0hvKL6V3AI', 1, 1, '2018-04-13 15:47:14', '2018-04-13 15:47:14');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
