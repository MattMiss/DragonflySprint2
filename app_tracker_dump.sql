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
    `is_deleted` boolean NOT NULL DEFAULT false,
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
    PRIMARY KEY (`user_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=450215449 ;

-- Dumping data for table `users`

INSERT INTO `users` (`fname`, `lname`, `email`, `cohortNum`, `status`, `roles`) VALUES
                                                       ('John', 'Brown', 'jbrown@student.greenriver.edu', '18', 'Seeking Internship', 'Anything'),
                                                       ('Ximena', 'Lopez', 'menalopez1999@gmail.com', '16', 'Seeking Job', 'QA Tester'),
                                                       ('Grayson', 'Choi', 'graysonc@yahoo.com', '19', 'Seeking Internship', 'Software Support'),
                                                       ('Dana', 'Felder','danafelder@gmail.com', '15', 'Not Actively Searching'),
                                                       ('Kris', 'Bartkowski', 'kbartkowski@student.greenriver.edu', '19', 'Not Actively Searching');
