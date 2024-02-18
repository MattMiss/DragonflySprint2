-- phpMyAdmin SQL Dump
-- version 5.2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 28, 2014 at 11:13 AM
-- Server version: 10.2.44-MariaDB - MariaDB Server
-- PHP Version:  8.1.27

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- Database: `dragonfl_app_tracker`

-- Drop existing tables

DROP TABLE IF EXISTS applications;
DROP TABLE IF EXISTS  users;


-----------------------------------------------------------
-- Table structure for table `applications`

CREATE TABLE IF NOT EXISTS `applications` (
    `application_id` int(5) NOT NULL AUTO_INCREMENT,
    `jname` varchar(60) NOT NULL,
    `ename` varchar(60) NOT NULL,
    `jurl` varchar(500) NOT NULL,
    `jdescription` varchar(500) DEFAULT NULL,
    `adate` date NOT NULL,
    `astatus` varchar(30) NOT NULL,
    `fupdates` varchar(500) DEFAULT NULL,
    `followupdate` date NOT NULL,
    `is_deleted` bool NOT NULL DEFAULT false,
    PRIMARY KEY (`application_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=450215449;

-- Dumping data for table `advisor`

INSERT INTO `applications` (`jname`, `ename`, `jurl`, `jdescription`, `adate`, `astatus`, `fupdates`, `followupdate`) VALUES
                                                                                    ('Project Manager', 'Microsoft', 'www.microsoft.com', 'Oversee large projects', '2024-02-16', 'rejected', 'Was sent a rejection email', '2024-02-28'),
                                                                                    ('Senior Software Engineer', 'Apple', 'www.apple.com', 'Collaborate and write programs, train new employees', '2024-01-29', 'accepted', 'Received an offer', '2024-02-15'),
                                                                                    ('Junior Software Engineer', 'Google', 'www.google.com', 'Collaborate and write programs', '2024-02-04', 'need-to-apply', 'None', '2024-02-14'),
                                                                                    ('Programmer Analyst', 'Meta', 'www.meta.com', 'Test and maintain programs', '2024-02-10', 'interviewing', 'Got an interview', '2024-02-18');

----------------------------------------------------------
-- Table structure for table `users`

CREATE TABLE IF NOT EXISTS `users` (
    `user_id` int(6) NOT NULL AUTO_INCREMENT,
    `fname` varchar(30) NOT NULL,
    `lname` varchar(30) NOT NULL,
    `email` varchar(60) NOT NULL,
    `cohortNum` int(3) NOT NULL,
    `status` varchar(30) NOT NULL,
    `roles` varchar(500) DEFAULT NULL,
    `is_deleted` bool NOT NULL DEFAULT false,
    PRIMARY KEY (`user_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=450215449 ;

-- Dumping data for table `users`

INSERT INTO `users` (`fname`, `lname`, `email`, `cohortNum`, `status`, `roles`) VALUES
                                                       ('John', 'Brown', 'jbrown@student.greenriver.edu', '18', 'Seeking Internship', 'Anything'),
                                                       ('Ximena', 'Lopez', 'menalopez1999@gmail.com', '16', 'Seeking Job', 'QA Tester'),
                                                       ('Grayson', 'Choi', 'graysonc@yahoo.com', '19', 'Seeking Internship', 'Software Support'),
                                                       ('Dana', 'Felder','danafelder@gmail.com', '15', 'Not Actively Searching'),
                                                       ('Kris', 'Bartkowski', 'kbartkowski@student.greenriver.edu', '19', 'Not Actively Searching');

----------------------------------------------------------
-- Table structure for table `announcements`

CREATE TABLE IF NOT EXISTS `announcements` (
    `id` int(6) NOT NULL AUTO_INCREMENT,
    `title` varchar(60) NOT NULL,
    `job_type` varchar(30) NOT NULL,
    `location` varchar(100) NOT NULL,
    `ename` varchar(60) DEFAULT NULL,
    `additional_info` varchar(2000) DEFAULT NULL,
    `jurl` varchar(500) NOT NULL,
    `sent_to` varchar(60) NOT NULL,
    `date_created` date NOT NULL,
    `is_deleted` bool NOT NULL DEFAULT false,
    PRIMARY KEY (`application_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=450215449;

-- Dumping data for table `announcements`

INSERT INTO `announcements` (`title`, `job_type`, `location`, `ename`, `additional_info`, `jurl`, `sent_to`, `date_created`) VALUES
                                                                                                                          ('Partner Engineer, Android', 'job', 'Bellevue, WA', 'Meta', 'Partner Engineering is a highly technical team that works with our strategic partners to integrate Meta products into their mobile platforms, apps, devices as well as our VR/AR platforms. Partner Engineers bring deep technical knowledge of Android platforms to lead highly visible initiatives and launch impactful products with our strategic mobile partners.', 'https://www.metacareers.com/jobs/917060759860304', 'matt.w.miss@gmail.com', '2024-02-17'),
                                                                                                                          ('Software Engineer 2', 'job', 'Redmond, WA', 'Microsoft', 'Design, implement, validate, and release software features to critical production components. Maintain scalable services with health monitoring to enable self-healing systems. Engage with teammates and partner teams to understand business needs to maximize impact. Provide technical, end-to-end ownership for projects on which you work. Innovate and Implement system to enable growth of scalable, critical, and global services. Drive our collaborative, inclusive and passionate team culture.', 'https://jobs.careers.microsoft.com/global/en/job/1672687', 'matt.w.miss@gmail.com', '2024-02-15')
