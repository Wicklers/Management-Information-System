-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 02, 2015 at 01:31 PM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mis_schema`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
`id` int(2) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(100) NOT NULL,
  `privilege` varchar(10) NOT NULL DEFAULT 'admin',
  `mobile` bigint(20) NOT NULL,
  `blocked` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `approval`
--

CREATE TABLE IF NOT EXISTS `approval` (
`id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `course_code` varchar(10) NOT NULL,
  `course_dep` int(11) NOT NULL,
  `status_level` int(2) NOT NULL,
  `reject_msg` text NOT NULL,
  `approved_by` varchar(100) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `attendance_data`
--

CREATE TABLE IF NOT EXISTS `attendance_data` (
`id` bigint(20) NOT NULL,
  `scholar_no` varchar(15) NOT NULL,
  `course_code` varchar(11) NOT NULL,
  `classes_attended` int(5) NOT NULL,
  `classes_total` int(5) NOT NULL,
  `percentage` float NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `course_id` varchar(10) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `course_department` int(2) NOT NULL,
  `course_credit` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `courses_appointed`
--

CREATE TABLE IF NOT EXISTS `courses_appointed` (
`id` int(11) NOT NULL,
  `teacher_id` bigint(20) NOT NULL,
  `course_code` varchar(10) NOT NULL,
  `course_sem` int(2) NOT NULL,
  `course_dep` int(3) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=87 ;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `dept_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `grading_scale`
--

CREATE TABLE IF NOT EXISTS `grading_scale` (
`id` bigint(20) NOT NULL,
  `teacher_id` int(10) NOT NULL,
  `course_code` varchar(10) NOT NULL,
  `course_dep` int(11) NOT NULL,
  `gradescale` varchar(100) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `last_dates`
--

CREATE TABLE IF NOT EXISTS `last_dates` (
`id` int(11) NOT NULL,
  `exam_type` varchar(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `last_dates`
--

INSERT INTO `last_dates` (`id`, `exam_type`, `date`) VALUES
(1, 'ct1', '2015-02-10'),
(2, 'ct2', '2015-03-25'),
(3, 'ct3', '2015-04-25'),
(4, 'midsem', '2015-03-15'),
(5, 'endsem', '2015-05-20');

-- --------------------------------------------------------

--
-- Table structure for table `marks`
--

CREATE TABLE IF NOT EXISTS `marks` (
`id` bigint(20) NOT NULL,
  `sch_no` varchar(20) NOT NULL,
  `course_code` varchar(10) NOT NULL,
  `course_dep` int(11) NOT NULL,
  `ct1` float(3,1) NOT NULL DEFAULT '0.0',
  `ct2` float(3,1) NOT NULL DEFAULT '0.0',
  `ct3` float(3,1) NOT NULL DEFAULT '0.0',
  `sessional` float(3,1) DEFAULT NULL,
  `midsem` float(3,1) NOT NULL DEFAULT '0.0',
  `endsem` float(3,1) NOT NULL DEFAULT '0.0',
  `pointer` int(2) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `marks_load`
--

CREATE TABLE IF NOT EXISTS `marks_load` (
`id` bigint(20) NOT NULL,
  `sch_no` varchar(20) NOT NULL,
  `course_code` varchar(10) NOT NULL,
  `course_dep` int(11) NOT NULL,
  `ct1` float(3,1) NOT NULL DEFAULT '0.0',
  `ct2` float(3,1) NOT NULL DEFAULT '0.0',
  `ct3` float(3,1) NOT NULL DEFAULT '0.0',
  `sessional` float(3,1) DEFAULT NULL,
  `midsem` float(3,1) NOT NULL DEFAULT '0.0',
  `endsem` float(3,1) NOT NULL DEFAULT '0.0',
  `pointer` int(2) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `semester_session`
--

CREATE TABLE IF NOT EXISTS `semester_session` (
`id` int(11) NOT NULL,
  `session` int(11) NOT NULL,
  `type` varchar(10) NOT NULL,
  `result_published` int(2) NOT NULL DEFAULT '0',
  `student_registration` int(2) NOT NULL DEFAULT '0' COMMENT '0 means resgistration is not goign and 1 means registration going on',
  `starting_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `semester_session`
--

INSERT INTO `semester_session` (`id`, `session`, `type`, `result_published`, `student_registration`, `starting_timestamp`) VALUES
(1, 2015, 'even', 0, 0, '2014-12-31 18:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `sessional_formula`
--

CREATE TABLE IF NOT EXISTS `sessional_formula` (
`id` int(11) NOT NULL,
  `teacher_id` int(10) NOT NULL,
  `course_code` varchar(10) NOT NULL,
  `course_dep` int(11) NOT NULL,
  `formula` varchar(100) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `students_info`
--

CREATE TABLE IF NOT EXISTS `students_info` (
`id` bigint(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `scholar_no` varchar(15) NOT NULL,
  `name` varchar(100) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `category` varchar(5) NOT NULL,
  `programme` varchar(100) NOT NULL,
  `department` int(3) NOT NULL,
  `semester` int(2) NOT NULL,
  `session` varchar(20) NOT NULL,
  `mobile` bigint(20) NOT NULL,
  `mobile_verified` int(2) NOT NULL DEFAULT '0',
  `parents_mobile` bigint(20) NOT NULL,
  `courses` varchar(100) NOT NULL,
  `courses_load` varchar(100) DEFAULT NULL,
  `spi` float DEFAULT NULL,
  `total_score` float DEFAULT NULL,
  `total_max_score` float DEFAULT NULL,
  `cpi` float DEFAULT NULL,
  `home_address` text NOT NULL,
  `hostel_address` text NOT NULL,
  `payment_verified` int(2) DEFAULT '1',
  `blocked` int(2) NOT NULL,
  `approved` int(2) NOT NULL,
  `biography` text NOT NULL,
  `published` int(2) NOT NULL DEFAULT '0',
  `cv_link` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE IF NOT EXISTS `teachers` (
`teacher_id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `privilege` varchar(15) NOT NULL,
  `dept_id` int(2) DEFAULT NULL,
  `mobile` bigint(20) NOT NULL,
  `blocked` int(1) NOT NULL DEFAULT '0',
  `approved` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=147 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `approval`
--
ALTER TABLE `approval`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance_data`
--
ALTER TABLE `attendance_data`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
 ADD PRIMARY KEY (`course_id`), ADD UNIQUE KEY `course_name` (`course_name`);

--
-- Indexes for table `courses_appointed`
--
ALTER TABLE `courses_appointed`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
 ADD PRIMARY KEY (`dept_id`), ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `grading_scale`
--
ALTER TABLE `grading_scale`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `last_dates`
--
ALTER TABLE `last_dates`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `marks`
--
ALTER TABLE `marks`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `marks_load`
--
ALTER TABLE `marks_load`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `semester_session`
--
ALTER TABLE `semester_session`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessional_formula`
--
ALTER TABLE `sessional_formula`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students_info`
--
ALTER TABLE `students_info`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
 ADD PRIMARY KEY (`teacher_id`), ADD UNIQUE KEY `mobile` (`mobile`), ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
MODIFY `id` int(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `approval`
--
ALTER TABLE `approval`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `attendance_data`
--
ALTER TABLE `attendance_data`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `courses_appointed`
--
ALTER TABLE `courses_appointed`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=87;
--
-- AUTO_INCREMENT for table `grading_scale`
--
ALTER TABLE `grading_scale`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `last_dates`
--
ALTER TABLE `last_dates`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `marks`
--
ALTER TABLE `marks`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `marks_load`
--
ALTER TABLE `marks_load`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `semester_session`
--
ALTER TABLE `semester_session`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `sessional_formula`
--
ALTER TABLE `sessional_formula`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `students_info`
--
ALTER TABLE `students_info`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
MODIFY `teacher_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=147;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
