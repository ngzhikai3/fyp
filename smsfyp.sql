-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 28, 2023 at 02:04 PM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smsfyp`
--

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
CREATE TABLE IF NOT EXISTS `course` (
  `course_id` int(255) NOT NULL AUTO_INCREMENT,
  `course_name` varchar(128) NOT NULL,
  `lecture_id` int(255) DEFAULT NULL,
  PRIMARY KEY (`course_id`),
  KEY `lecture_id` (`lecture_id`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `course_name`, `lecture_id`) VALUES
(1, 'Software Requirements Engineering', 1),
(2, 'Software Quality Assurance', 2),
(3, 'Formal Method', 3),
(4, 'Human Computer Interaction', 4),
(5, 'University Relation Program', 5),
(6, 'Final Project II', 6),
(7, 'Bahasa Kebangsaan A', 7),
(8, 'Penghayatan Etika dan Peradaban', 8),
(9, 'Falsafah dan Isu Semasa', 9),
(10, 'Java Application Development', 10),
(11, 'Web Design', 11),
(12, 'Calculus', 12),
(13, 'E-Commerce', 13),
(14, 'Computer Architecture & Organization', 14),
(15, 'Community Service', 15),
(16, 'Web Application Development', 16),
(17, 'Mobile Application Development', 17),
(18, 'Software Engineering', 18),
(19, 'Research Methodology', 19),
(20, 'Artificial Intelligence', 20),
(21, 'Final Project I', 21),
(22, 'Discrete Mathematics', 22),
(23, 'Advanced Mathematics', 23),
(24, 'System Analysis & Design', 24),
(25, 'Introduction to Security Techniques', 25),
(26, 'Confucianism and Modern Society', 26),
(27, 'Security In Computing', 27),
(28, 'Algorithms And Data Structures', 28),
(29, 'System Administration', 29),
(30, 'Network Security', 30),
(31, 'Introduction to Android Programming', 31),
(32, 'Malaysian Studies 2', 5),
(33, 'Basketball', 3),
(34, 'Introduction to Statistics', 1),
(35, 'Creative Thinking', 5),
(36, 'Networking', 10),
(37, 'Introduction To Operating Systems', 6),
(38, 'PC Maintenance', 7),
(39, 'Database Concepts', 8),
(40, 'Introduction of Forensic and Techniques', 1),
(41, 'Introduction to Information Technology', 9),
(42, 'IT Ethics', 3),
(43, 'Mathematics', 4),
(44, 'Programming Concepts', 2),
(45, 'Advance Chinese Language', 6),
(47, 'NBA', 1),
(52, 'Swimming', 1),
(53, 'FYP', 1),
(58, 'Software Requirements Engineering', 1);

-- --------------------------------------------------------

--
-- Table structure for table `lecture`
--

DROP TABLE IF EXISTS `lecture`;
CREATE TABLE IF NOT EXISTS `lecture` (
  `lecture_id` int(255) NOT NULL AUTO_INCREMENT,
  `lecture_firstname` text NOT NULL,
  `lecture_lastname` text NOT NULL,
  `lecture_password` varchar(50) NOT NULL,
  `lecture_email` varchar(128) NOT NULL,
  `lecture_phone` varchar(11) NOT NULL,
  `lecture_gender` varchar(30) NOT NULL,
  `user_type` varchar(50) NOT NULL,
  `lecture_entrytime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`lecture_id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lecture`
--

INSERT INTO `lecture` (`lecture_id`, `lecture_firstname`, `lecture_lastname`, `lecture_password`, `lecture_email`, `lecture_phone`, `lecture_gender`, `user_type`, `lecture_entrytime`) VALUES
(1, 'Lebron', 'James', '74ba550c7af8a887987484fb67fa4481', 'james@gmail.com', '012-2233223', 'male', 'lecture', '2023-06-09 05:24:58'),
(2, 'John', 'Smith', '55deb7fd23a25aa863fb912ff7fc21d8', 'johnsmith@gmail.com', '1234567891', 'male', 'lecture', '2023-06-15 05:16:56'),
(3, 'Emily', 'Johnson', '55deb7fd23a25aa863fb912ff7fc21d8', 'emilyjohnson@gmail.com', '1234567892', 'female', 'lecture', '2023-06-15 05:16:56'),
(4, 'Michael', 'Williams', '55deb7fd23a25aa863fb912ff7fc21d8', 'michaelwilliams@gmail.com', '1234567893', 'male', 'lecture', '2023-06-15 05:16:56'),
(5, 'Olivia', 'Brown', '55deb7fd23a25aa863fb912ff7fc21d8', 'oliviabrown@gmail.com', '019-2235623', 'female', 'lecture', '2023-06-15 05:16:56'),
(6, 'David', 'Jones', '55deb7fd23a25aa863fb912ff7fc21d8', 'davidjones@gmail.com', '1234567895', 'male', 'lecture', '2023-06-15 05:16:56'),
(7, 'Emma', 'Davis', '55deb7fd23a25aa863fb912ff7fc21d8', 'emmadavis@gmail.com', '1234567896', 'female', 'lecture', '2023-06-15 05:16:56'),
(8, 'Daniel', 'Taylor', '55deb7fd23a25aa863fb912ff7fc21d8', 'danieltaylor@gmail.com', '1234567897', 'male', 'lecture', '2023-06-15 05:16:56'),
(9, 'Sophia', 'Anderson', '55deb7fd23a25aa863fb912ff7fc21d8', 'sophiaanderson@gmail.com', '1234567898', 'female', 'lecture', '2023-06-15 05:16:56'),
(10, 'Joseph', 'Martinez', '55deb7fd23a25aa863fb912ff7fc21d8', 'josephmartinez@gmail.com', '1234567899', 'male', 'lecture', '2023-06-15 05:16:56'),
(11, 'Abigail', 'Harris', '55deb7fd23a25aa863fb912ff7fc21d8', 'abigailharris@gmail.com', '1234567810', 'female', 'lecture', '2023-06-15 05:16:56'),
(12, 'Alexander', 'Clark', '55deb7fd23a25aa863fb912ff7fc21d8', 'alexanderclark@gmail.com', '1234567811', 'male', 'lecture', '2023-06-15 05:16:56'),
(13, 'Mia', 'Lewis', '55deb7fd23a25aa863fb912ff7fc21d8', 'mialewis@gmail.com', '1234567812', 'female', 'lecture', '2023-06-15 05:16:56'),
(14, 'William', 'Lee', '55deb7fd23a25aa863fb912ff7fc21d8', 'williamlee@gmail.com', '1234567813', 'male', 'lecture', '2023-06-15 05:16:56'),
(15, 'Samantha', 'Walker', '55deb7fd23a25aa863fb912ff7fc21d8', 'samanthawalker@gmail.com', '1234567814', 'female', 'lecture', '2023-06-15 05:16:56'),
(16, 'James', 'Hall', '55deb7fd23a25aa863fb912ff7fc21d8', 'jameshall@gmail.com', '1234567815', 'male', 'lecture', '2023-06-15 05:16:56'),
(17, 'Ava', 'Turner', '55deb7fd23a25aa863fb912ff7fc21d8', 'avaturner@gmail.com', '1234567816', 'female', 'lecture', '2023-06-15 05:16:56'),
(18, 'Benjamin', 'Adams', '55deb7fd23a25aa863fb912ff7fc21d8', 'benjaminadams@gmail.com', '1234567817', 'male', 'lecture', '2023-06-15 05:16:56'),
(19, 'Charlotte', 'Nelson', '55deb7fd23a25aa863fb912ff7fc21d8', 'charlottenelson@gmail.com', '1234567818', 'female', 'lecture', '2023-06-15 05:16:56'),
(20, 'Henry', 'Roberts', '55deb7fd23a25aa863fb912ff7fc21d8', 'henryroberts@gmail.com', '1234567819', 'male', 'lecture', '2023-06-15 05:16:56'),
(21, 'Grace', 'Parker', '55deb7fd23a25aa863fb912ff7fc21d8', 'graceparker@gmail.com', '1234567820', 'female', 'lecture', '2023-06-15 05:16:56'),
(22, 'Josephine', 'Cook', '55deb7fd23a25aa863fb912ff7fc21d8', 'josephinecook@gmail.com', '1234567821', 'female', 'lecture', '2023-06-15 05:16:56'),
(23, 'Andrew', 'Hill', '55deb7fd23a25aa863fb912ff7fc21d8', 'andrewhill@gmail.com', '1234567822', 'male', 'lecture', '2023-06-15 05:16:56'),
(24, 'Madison', 'Bell', '55deb7fd23a25aa863fb912ff7fc21d8', 'madisonbell@gmail.com', '1234567823', 'female', 'lecture', '2023-06-15 05:16:56'),
(25, 'Samuel', 'Murphy', '55deb7fd23a25aa863fb912ff7fc21d8', 'samuelmurphy@gmail.com', '1234567824', 'male', 'lecture', '2023-06-15 05:16:56'),
(26, 'Lily', 'Russell', '55deb7fd23a25aa863fb912ff7fc21d8', 'lilyrussell@gmail.com', '1234567825', 'female', 'lecture', '2023-06-15 05:16:56'),
(27, 'Gabriel', 'Ward', '55deb7fd23a25aa863fb912ff7fc21d8', 'gabrielward@gmail.com', '1234567826', 'male', 'lecture', '2023-06-15 05:16:56'),
(28, 'Victoria', 'Reed', '55deb7fd23a25aa863fb912ff7fc21d8', 'victoriareed@gmail.com', '1234567827', 'female', 'lecture', '2023-06-15 05:16:56'),
(29, 'Daniel', 'Baker', '55deb7fd23a25aa863fb912ff7fc21d8', 'danielbaker@gmail.com', '1234567828', 'male', 'lecture', '2023-06-15 05:16:56'),
(30, 'Elizabeth', 'Ross', '55deb7fd23a25aa863fb912ff7fc21d8', 'elizabethross@gmail.com', '1234567829', 'female', 'lecture', '2023-06-15 05:16:56'),
(31, 'Christopher', 'Young', '55deb7fd23a25aa863fb912ff7fc21d8', 'christopheryoung@gmail.com', '1234567830', 'male', 'lecture', '2023-06-15 05:16:56'),
(41, 'kobe', 'bryant', 'a2c8fd0b5e739b537dde8ec1f5bdbd32', 'kobe@gmail.com', '012-2233223', 'male', 'lecture', '2023-08-28 13:57:12');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;
CREATE TABLE IF NOT EXISTS `login` (
  `login_id` int(255) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('lecture','student','admin') NOT NULL,
  `student_id` int(255) DEFAULT NULL,
  `lecture_id` int(255) DEFAULT NULL,
  PRIMARY KEY (`login_id`),
  KEY `student_id` (`student_id`),
  KEY `lecture_id` (`lecture_id`)
) ENGINE=MyISAM AUTO_INCREMENT=83 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`login_id`, `email`, `password`, `role`, `student_id`, `lecture_id`) VALUES
(2, 'nzk333@gmail.com', '46bd1900310444984c95cc516282ccd6', 'student', 1, NULL),
(3, 'student@gmail.com', '5e5545d38a68148a2d5bd5ec9a89e327', 'student', 5, NULL),
(4, 'johnsmith@gmail.com', 'cb6f3b8fa1aa7248aee240f594448a39', 'student', 6, NULL),
(5, 'emilyjohnson@gmail.com', '29e1448ae02b6fd112fcf3618e1be9f5', 'student', 7, NULL),
(6, 'michaelwilliams@gmail.com', '56cf01f6edfe9598b5e23407fe290990', 'student', 8, NULL),
(7, 'oliviabrown@gmail.com', '5a6fdf1ec2d9b64595817887becd660d', 'student', 9, NULL),
(8, 'davidjones@gmail.com', '7de3522a8f56f78416a49e059c49b8cb', 'student', 10, NULL),
(9, 'emmadavis@gmail.com', 'b964e183e33538b187f4d2639adef60b', 'student', 11, NULL),
(10, 'danieltaylor@gmail.com', 'b5ea8985533defbf1d08d5ed2ac8fe9b', 'student', 12, NULL),
(11, 'sophiaanderson@gmail.com', '79fc98c9ebcefe5acf01bc9802b4af1d', 'student', 13, NULL),
(12, 'josephmartinez@gmail.com', 'bd9fa9edbeff8f0b88a6f26ce7665953', 'student', 14, NULL),
(13, 'abigailharris@gmail.com', 'febcf5d50405afe0551157a979a9f8d2', 'student', 15, NULL),
(14, 'alexanderclark@gmail.com', '97d8795d14e54ac8fc20b234ba60b4c0', 'student', 16, NULL),
(15, 'mialewis@gmail.com', '3fcc0899ef33a5524ceab4369a26e133', 'student', 17, NULL),
(16, 'williamlee@gmail.com', '76fecaab54ba086590f6d4e92226845f', 'student', 18, NULL),
(17, 'samanthawalker@gmail.com', '3a94b56756cbdc170e32adf925b55f7f', 'student', 19, NULL),
(18, 'jameshall@gmail.com', '9ba36afc4e560bf811caefc0c7fddddf', 'student', 20, NULL),
(19, 'avaturner@gmail.com', '2fae28fca40592dd2389f5e92b0867ca', 'student', 21, NULL),
(20, 'benjaminadams@gmail.com', '800bdc04a642d07c6e240bd3dd3a24a6', 'student', 22, NULL),
(21, 'charlottenelson@gmail.com', 'e07c910b862c57bfea19c9038adcdaf7', 'student', 23, NULL),
(22, 'henryroberts@gmail.com', '9f876785ec5425a0511339bed7230c2a', 'student', 24, NULL),
(23, 'graceparker@gmail.com', '8ff861bcfd87bd85e9b207ea74cb6596', 'student', 25, NULL),
(24, 'josephinecook@gmail.com', '50b492a6d1bd208cb114fb48810b0d23', 'student', 26, NULL),
(25, 'andrewhill@gmail.com', '47fab60bdcd2ffce91447d19fe9ce7f1', 'student', 27, NULL),
(26, 'madisonbell@gmail.com', '92650a76658b197794086f7d5517706c', 'student', 28, NULL),
(27, 'samuelmurphy@gmail.com', 'e6fb448feb2fa877aab63b3713027775', 'student', 29, NULL),
(28, 'lilyrussell@gmail.com', 'd8c1dcd6042ae6b1c58b552b7b045a15', 'student', 30, NULL),
(29, 'gabrielward@gmail.com', '267c7114096454a2c64044fded697434', 'student', 31, NULL),
(30, 'victoriareed@gmail.com', 'ae1c6a778347ad3a62c82a44b785cffe', 'student', 32, NULL),
(31, 'danielbaker@gmail.com', 'd7a5b8bcb37838d43e11ed8c1e09c51b', 'student', 33, NULL),
(32, 'elizabethross@gmail.com', 'baae88f95fd94f89d4e55f87b7f8b4ff', 'student', 34, NULL),
(33, 'christopheryoung@gmail.com', '722dbdbcdb464911233308733930b2fb', 'student', 35, NULL),
(34, 'Create@gmail.com', '7ad64826b33f0ce5132aa6d622c712c1', 'student', 36, NULL),
(35, 'james@gmail.com', '74ba550c7af8a887987484fb67fa4481', 'lecture', NULL, 1),
(36, 'johnsmith@gmail.com', '55deb7fd23a25aa863fb912ff7fc21d8', 'lecture', NULL, 2),
(37, 'emilyjohnson@gmail.com', '55deb7fd23a25aa863fb912ff7fc21d8', 'lecture', NULL, 3),
(38, 'michaelwilliams@gmail.com', '55deb7fd23a25aa863fb912ff7fc21d8', 'lecture', NULL, 4),
(39, 'oliviabrown@gmail.com', '55deb7fd23a25aa863fb912ff7fc21d8', 'lecture', NULL, 5),
(40, 'davidjones@gmail.com', '55deb7fd23a25aa863fb912ff7fc21d8', 'lecture', NULL, 6),
(41, 'emmadavis@gmail.com', '55deb7fd23a25aa863fb912ff7fc21d8', 'lecture', NULL, 7),
(42, 'danieltaylor@gmail.com', '55deb7fd23a25aa863fb912ff7fc21d8', 'lecture', NULL, 8),
(43, 'sophiaanderson@gmail.com', '55deb7fd23a25aa863fb912ff7fc21d8', 'lecture', NULL, 9),
(44, 'josephmartinez@gmail.com', '55deb7fd23a25aa863fb912ff7fc21d8', 'lecture', NULL, 10),
(45, 'abigailharris@gmail.com', '55deb7fd23a25aa863fb912ff7fc21d8', 'lecture', NULL, 11),
(46, 'alexanderclark@gmail.com', '55deb7fd23a25aa863fb912ff7fc21d8', 'lecture', NULL, 12),
(47, 'mialewis@gmail.com', '55deb7fd23a25aa863fb912ff7fc21d8', 'lecture', NULL, 13),
(48, 'williamlee@gmail.com', '55deb7fd23a25aa863fb912ff7fc21d8', 'lecture', NULL, 14),
(49, 'samanthawalker@gmail.com', '55deb7fd23a25aa863fb912ff7fc21d8', 'lecture', NULL, 15),
(50, 'jameshall@gmail.com', '55deb7fd23a25aa863fb912ff7fc21d8', 'lecture', NULL, 16),
(51, 'avaturner@gmail.com', '55deb7fd23a25aa863fb912ff7fc21d8', 'lecture', NULL, 17),
(52, 'benjaminadams@gmail.com', '55deb7fd23a25aa863fb912ff7fc21d8', 'lecture', NULL, 18),
(53, 'charlottenelson@gmail.com', '55deb7fd23a25aa863fb912ff7fc21d8', 'lecture', NULL, 19),
(54, 'henryroberts@gmail.com', '55deb7fd23a25aa863fb912ff7fc21d8', 'lecture', NULL, 20),
(55, 'graceparker@gmail.com', '55deb7fd23a25aa863fb912ff7fc21d8', 'lecture', NULL, 21),
(56, 'josephinecook@gmail.com', '55deb7fd23a25aa863fb912ff7fc21d8', 'lecture', NULL, 22),
(57, 'andrewhill@gmail.com', '55deb7fd23a25aa863fb912ff7fc21d8', 'lecture', NULL, 23),
(58, 'madisonbell@gmail.com', '55deb7fd23a25aa863fb912ff7fc21d8', 'lecture', NULL, 24),
(59, 'samuelmurphy@gmail.com', '55deb7fd23a25aa863fb912ff7fc21d8', 'lecture', NULL, 25),
(60, 'lilyrussell@gmail.com', '55deb7fd23a25aa863fb912ff7fc21d8', 'lecture', NULL, 26),
(61, 'gabrielward@gmail.com', '55deb7fd23a25aa863fb912ff7fc21d8', 'lecture', NULL, 27),
(62, 'victoriareed@gmail.com', '55deb7fd23a25aa863fb912ff7fc21d8', 'lecture', NULL, 28),
(63, 'danielbaker@gmail.com', '55deb7fd23a25aa863fb912ff7fc21d8', 'lecture', NULL, 29),
(64, 'elizabethross@gmail.com', '55deb7fd23a25aa863fb912ff7fc21d8', 'lecture', NULL, 30),
(65, 'christopheryoung@gmail.com', '55deb7fd23a25aa863fb912ff7fc21d8', 'lecture', NULL, 31),
(0, 'admin@gmail.com', '0192023a7bbd73250516f069df18b500', 'admin', NULL, NULL),
(80, 'kobe@gmail.com', 'a2c8fd0b5e739b537dde8ec1f5bdbd32', 'lecture', NULL, 41),
(82, 'gigi@gmail.com', 'd91ec1d45535ebf3d8f6882217d10676', 'student', 44, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `student_id` int(255) NOT NULL AUTO_INCREMENT,
  `student_firstname` text NOT NULL,
  `student_lastname` text NOT NULL,
  `student_password` varchar(50) NOT NULL,
  `student_email` varchar(128) NOT NULL,
  `student_phone` varchar(11) NOT NULL,
  `student_gender` varchar(30) NOT NULL,
  `date_of_birth` date NOT NULL,
  `user_type` varchar(50) NOT NULL,
  `student_entrytime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`student_id`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `student_firstname`, `student_lastname`, `student_password`, `student_email`, `student_phone`, `student_gender`, `date_of_birth`, `user_type`, `student_entrytime`) VALUES
(1, 'NG', 'ZHI KAI', '46bd1900310444984c95cc516282ccd6', 'nzk333@gmail.com', '017-6557328', 'male', '2002-03-08', 'student', '2023-06-08 08:40:24'),
(5, 'Student', 'Studenta', '5e5545d38a68148a2d5bd5ec9a89e327', 'student@gmail.com', '017-6587123', 'female', '1999-03-31', 'student', '2023-06-08 16:31:39'),
(6, 'John', 'Smith', 'cb6f3b8fa1aa7248aee240f594448a39', 'johnsmith@gmail.com', '1234567891', 'male', '2000-01-01', 'student', '2023-06-15 05:50:38'),
(7, 'Emily', 'Johnson', '29e1448ae02b6fd112fcf3618e1be9f5', 'emilyjohnson@gmail.com', '1234567892', 'female', '2000-02-01', 'student', '2023-06-15 05:50:38'),
(8, 'Michael', 'Williams', '56cf01f6edfe9598b5e23407fe290990', 'michaelwilliams@gmail.com', '1234567893', 'male', '2000-03-01', 'student', '2023-06-15 05:50:38'),
(9, 'Olivia', 'Brown', '5a6fdf1ec2d9b64595817887becd660d', 'oliviabrown@gmail.com', '1234567894', 'female', '2000-04-01', 'student', '2023-06-15 05:50:38'),
(10, 'David', 'Jones', '7de3522a8f56f78416a49e059c49b8cb', 'davidjones@gmail.com', '1234567895', 'male', '2000-05-01', 'student', '2023-06-15 05:50:38'),
(11, 'Emma', 'Davis', 'b964e183e33538b187f4d2639adef60b', 'emmadavis@gmail.com', '1234567896', 'female', '2000-06-01', 'student', '2023-06-15 05:50:38'),
(12, 'Daniel', 'Taylor', 'b5ea8985533defbf1d08d5ed2ac8fe9b', 'danieltaylor@gmail.com', '1234567897', 'male', '2000-07-01', 'student', '2023-06-15 05:50:38'),
(13, 'Sophia', 'Anderson', '79fc98c9ebcefe5acf01bc9802b4af1d', 'sophiaanderson@gmail.com', '1234567898', 'female', '2000-08-01', 'student', '2023-06-15 05:50:38'),
(14, 'Joseph', 'Martinez', 'bd9fa9edbeff8f0b88a6f26ce7665953', 'josephmartinez@gmail.com', '1234567899', 'male', '2000-09-01', 'student', '2023-06-15 05:50:38'),
(15, 'Abigail', 'Harris', 'febcf5d50405afe0551157a979a9f8d2', 'abigailharris@gmail.com', '1234567810', 'female', '2000-10-01', 'student', '2023-06-15 05:50:38'),
(16, 'Alexander', 'Clark', '97d8795d14e54ac8fc20b234ba60b4c0', 'alexanderclark@gmail.com', '1234567811', 'male', '2000-11-01', 'student', '2023-06-15 05:50:38'),
(17, 'Mia', 'Lewis', '3fcc0899ef33a5524ceab4369a26e133', 'mialewis@gmail.com', '1234567812', 'female', '2000-12-01', 'student', '2023-06-15 05:50:38'),
(18, 'William', 'Lee', '76fecaab54ba086590f6d4e92226845f', 'williamlee@gmail.com', '1234567813', 'male', '2001-01-01', 'student', '2023-06-15 05:50:38'),
(19, 'Samantha', 'Walker', '3a94b56756cbdc170e32adf925b55f7f', 'samanthawalker@gmail.com', '1234567814', 'female', '2001-02-01', 'student', '2023-06-15 05:50:38'),
(20, 'James', 'Hall', '9ba36afc4e560bf811caefc0c7fddddf', 'jameshall@gmail.com', '1234567815', 'male', '2001-03-01', 'student', '2023-06-15 05:50:38'),
(21, 'Ava', 'Turner', '2fae28fca40592dd2389f5e92b0867ca', 'avaturner@gmail.com', '1234567816', 'female', '2001-04-01', 'student', '2023-06-15 05:50:38'),
(22, 'Benjamin', 'Adams', '800bdc04a642d07c6e240bd3dd3a24a6', 'benjaminadams@gmail.com', '1234567817', 'male', '2001-05-01', 'student', '2023-06-15 05:50:38'),
(23, 'Charlotte', 'Nelson', 'e07c910b862c57bfea19c9038adcdaf7', 'charlottenelson@gmail.com', '1234567818', 'female', '2001-06-01', 'student', '2023-06-15 05:50:38'),
(24, 'Henry', 'Roberts', '9f876785ec5425a0511339bed7230c2a', 'henryroberts@gmail.com', '1234567819', 'male', '2001-07-01', 'student', '2023-06-15 05:50:38'),
(25, 'Grace', 'Parker', '8ff861bcfd87bd85e9b207ea74cb6596', 'graceparker@gmail.com', '1234567820', 'female', '2001-08-01', 'student', '2023-06-15 05:50:38'),
(26, 'Josephine', 'Cook', '50b492a6d1bd208cb114fb48810b0d23', 'josephinecook@gmail.com', '1234567821', 'female', '2001-09-01', 'student', '2023-06-15 05:50:38'),
(27, 'Andrew', 'Hill', '47fab60bdcd2ffce91447d19fe9ce7f1', 'andrewhill@gmail.com', '1234567822', 'male', '2001-10-01', 'student', '2023-06-15 05:50:38'),
(28, 'Madison', 'Bell', '92650a76658b197794086f7d5517706c', 'madisonbell@gmail.com', '1234567823', 'female', '2001-11-01', 'student', '2023-06-15 05:50:38'),
(29, 'Samuel', 'Murphy', 'e6fb448feb2fa877aab63b3713027775', 'samuelmurphy@gmail.com', '1234567824', 'male', '2001-12-01', 'student', '2023-06-15 05:50:38'),
(30, 'Lily', 'Russell', 'd8c1dcd6042ae6b1c58b552b7b045a15', 'lilyrussell@gmail.com', '1234567825', 'female', '2002-01-01', 'student', '2023-06-15 05:50:38'),
(31, 'Gabriel', 'Ward', '267c7114096454a2c64044fded697434', 'gabrielward@gmail.com', '1234567826', 'male', '2002-02-01', 'student', '2023-06-15 05:50:38'),
(32, 'Victoria', 'Reed', 'ae1c6a778347ad3a62c82a44b785cffe', 'victoriareed@gmail.com', '1234567827', 'female', '2002-03-01', 'student', '2023-06-15 05:50:38'),
(33, 'Daniel', 'Baker', 'd7a5b8bcb37838d43e11ed8c1e09c51b', 'danielbaker@gmail.com', '1234567828', 'male', '2002-04-01', 'student', '2023-06-15 05:50:38'),
(34, 'Elizabeth', 'Ross', 'baae88f95fd94f89d4e55f87b7f8b4ff', 'elizabethross@gmail.com', '1234567829', 'female', '2002-05-01', 'student', '2023-06-15 05:50:38'),
(35, 'Christopher', 'Young', '722dbdbcdb464911233308733930b2fb', 'christopheryoung@gmail.com', '1234567830', 'male', '2002-06-01', 'student', '2023-06-15 05:50:38'),
(44, 'gi', 'gi', 'd91ec1d45535ebf3d8f6882217d10676', 'gigi@gmail.com', '017-6587123', 'female', '1999-11-11', 'student', '2023-08-28 14:02:54');

-- --------------------------------------------------------

--
-- Table structure for table `student_course`
--

DROP TABLE IF EXISTS `student_course`;
CREATE TABLE IF NOT EXISTS `student_course` (
  `student_course_id` int(255) NOT NULL AUTO_INCREMENT,
  `student_id` int(255) DEFAULT NULL,
  `course_id` int(255) DEFAULT NULL,
  `lecture_id` int(11) DEFAULT NULL,
  `grade` varchar(2) DEFAULT NULL,
  `join_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`student_course_id`),
  KEY `student_id` (`student_id`),
  KEY `course_id` (`course_id`),
  KEY `lecture_id` (`lecture_id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_course`
--

INSERT INTO `student_course` (`student_course_id`, `student_id`, `course_id`, `lecture_id`, `grade`, `join_date`) VALUES
(1, 1, 3, 3, NULL, '2023-06-18 12:15:55'),
(2, 1, 19, 19, NULL, '2023-06-18 12:16:01'),
(3, 1, 6, 6, NULL, '2023-06-18 12:44:19'),
(4, 1, 1, 1, 'B', '2023-06-18 15:13:57'),
(5, 1, 21, 21, NULL, '2023-06-21 11:11:07'),
(10, 1, 40, 1, 'B', '2023-07-07 07:35:33'),
(9, 37, 34, 1, 'B', '2023-06-21 11:17:08'),
(11, 1, 34, 1, 'B', '2023-07-07 07:35:42'),
(12, 1, 16, 16, NULL, '2023-07-22 10:34:03'),
(13, 1, 52, 1, 'A+', '2023-07-24 14:38:42'),
(14, 1, 53, 1, 'B+', '2023-08-01 14:07:57'),
(15, 5, 1, 1, 'A+', '2023-08-13 10:36:15'),
(16, 6, 1, 1, 'B+', '2023-08-13 10:36:15'),
(17, 7, 1, 1, 'C+', '2023-08-13 10:36:15'),
(18, 8, 1, 1, 'C-', '2023-08-13 10:36:15'),
(19, 9, 1, 1, 'F', '2023-08-13 10:36:15'),
(20, 5, 1, 1, 'A+', '2023-08-13 10:36:18'),
(21, 6, 1, 1, 'B+', '2023-08-13 10:36:18'),
(22, 7, 1, 1, 'C+', '2023-08-13 10:36:18'),
(23, 8, 1, 1, 'C-', '2023-08-13 10:36:18'),
(24, 9, 1, 1, 'F', '2023-08-13 10:36:18'),
(25, 1, 2, 2, NULL, '2023-08-13 10:45:42'),
(26, 4, 53, 1, NULL, '2023-08-21 13:47:48'),
(27, 5, 53, 1, 'A+', '2023-08-21 13:47:48'),
(28, 4, 53, 1, NULL, '2023-08-21 13:47:50'),
(29, 5, 53, 1, 'A+', '2023-08-21 13:47:50'),
(35, 41, 1, 1, NULL, '2023-08-25 01:05:31'),
(36, 41, 34, 1, NULL, '2023-08-25 01:05:36'),
(37, 41, 47, 1, NULL, '2023-08-25 01:05:41');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
