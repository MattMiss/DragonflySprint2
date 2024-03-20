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
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS announcements;

-- --------------------------------------------------------
-- Table structure for table `users`

CREATE TABLE IF NOT EXISTS `users` (
    `user_id` int(6) NOT NULL AUTO_INCREMENT,
    `permission` boolean NOT NULL DEFAULT false,
    `fname` varchar(30) NOT NULL,
    `lname` varchar(30) NOT NULL,
    `email` varchar(60) NOT NULL,
    `password` varchar(255) NOT NULL,
    `cohortNum` int(3) NOT NULL,
    `status` varchar(30) NOT NULL,
    `roles` varchar(500) DEFAULT NULL,
    `is_deleted` boolean NOT NULL DEFAULT false,
    PRIMARY KEY (`user_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- Dumping data for table `users`
-- !!!! Please change admin value after you use this sql dump. !!!!
-- ADMIN pass is admin123

INSERT INTO `users` (`user_id`, `permission`, `fname`, `lname`, `email`, `password`, `cohortNum`, `status`, `roles`)
    VALUES
        ('0', '1', 'admin', 'admin', 'admin@admin', '$2y$10$aWN31xFtkrVKY8LE0HMB5eAN/9CahamKZ825zwlPTqWNTv14NVYOa', '0', 'admin', 'admin');


-- John pass is abc123456
-- Ximena pass is password1
-- Grayson pass is pass1234
-- Dana pass is qwerty123
-- Kris pass is aaaa1111

INSERT INTO `users` (`permission`, `fname`, `lname`, `email`, `password`, `cohortNum`, `status`, `roles`)
    VALUES
        ('0', 'John', 'Brown', 'jbrown1236@student.greenriver.edu', '$2y$10$hQ3TWIvBzwmTWoUIYrNCNOy/99QbhEquUVxm2h6meNV461d9VBINy', '18', 'Seeking Internship', 'Anything'),
        ('0', 'Ximena', 'Lopez', 'menalopez1999@student.greenriver.edu', '$2y$10$byK16/DXeniGvaCpd20FHOtxDEDYdFSGMLP4O.Hey/T/IKXAs2qe2', '16', 'Seeking Job', 'QA Tester'),
        ('0', 'Grayson', 'Choi', 'graysonc21@student.greenriver.edu', '$2y$10$YnWFWrwblNssw9uWvM3ae.Dh4jHs3NPBhSCjED8q9dEUiHxhITtR.', '19', 'Seeking Internship', 'Software Support'),
        ('0', 'Dana', 'Felder','danafelder456@student.greenriver.edu', '$2y$10$TvLDYguHnv5KaYPg.mdjC.YwPR.kgY6ak7kZMpRAtj2N.cKQ0pmUi', '15', 'Not Actively Searching', 'Nothing'),
        ('0', 'Kris', 'Bartkowski', 'kbartkowskireal2@student.greenriver.edu', '$2y$10$rPGG7eNTquozushAj6tl3e0xvF9yrgqMJ2u5UKcTWdLh8.JMC8DEy', '19', 'Not Actively Searching', 'Nothing');

-- ---------------------------------------------------------
-- Table structure for table `applications`

CREATE TABLE IF NOT EXISTS `applications` (
    `application_id` int(5) NOT NULL AUTO_INCREMENT,
    `user_id` int(6) NOT NULL,
    `jname` varchar(60) NOT NULL,
    `ename` varchar(60) NOT NULL,
    `jurl` varchar(500) NOT NULL,
    `jdescription` varchar(500) DEFAULT NULL,
    `adate` date NOT NULL,
    `astatus` varchar(30) NOT NULL,
    `fupdates` varchar(500) DEFAULT NULL,
    `followupdate` date NOT NULL,
    `is_deleted` boolean NOT NULL DEFAULT false,
    PRIMARY KEY (`application_id`),
    FOREIGN KEY (`user_id`) REFERENCES users(`user_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- Dumping data for table `applications`

INSERT INTO `applications` (`user_id`,`jname`, `ename`, `jurl`, `jdescription`, `adate`, `astatus`, `fupdates`, `followupdate`)
VALUES
    ('1', 'Project Manager', 'Microsoft', 'www.microsoft.com', 'Oversee large projects', '2024-02-16', 'rejected', 'Was sent a rejection email', '2024-02-28'),
    ('4', 'Senior Software Engineer', 'Apple', 'www.apple.com', 'Collaborate and write programs, train new employees', '2024-01-29', 'accepted', 'Received an offer', '2024-02-15'),
    ('2', 'Junior Software Engineer', 'Google', 'www.google.com', 'Collaborate and write programs', '2024-02-04', 'need-to-apply', 'None', '2024-02-14'),
    ('3', 'Programmer Analyst', 'Meta', 'www.meta.com', 'Test and maintain programs', '2024-02-10', 'interviewing', 'Got an interview', '2024-02-18'),
    ('4', 'Summer Internship', 'Costco', 'https://phf.tbe.taleo.net/phf02/ats/careers/v2/jobSearch?act=redirectCwsV2&cws=41&org=COSTCO', 'The International IT team leverages modern enterprise programming languages, frameworks, and infrastructure to build innovative solutions for supporting Costco''s business internationally in countries outside of the USA.', '2024-03-07', 'applied', 'waiting for a response', '2024-03-21');

-- --------------------------------------------------------
-- Table structure for table `announcements`

CREATE TABLE IF NOT EXISTS `announcements` (
    `announcement_id` int(6) NOT NULL AUTO_INCREMENT,
    `title` varchar(60) NOT NULL,
    `job_type` varchar(30) NOT NULL,
    `location` varchar(100) NOT NULL,
    `ename` varchar(60) DEFAULT NULL,
    `additional_info` varchar(2000) DEFAULT NULL,
    `jurl` varchar(500) NOT NULL,
    `sent_to` varchar(60) NOT NULL,
    `date_created` date NOT NULL,
    `is_deleted` boolean NOT NULL DEFAULT false,
    PRIMARY KEY (`announcement_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- Dumping data for table `announcements`

INSERT INTO `announcements` (`title`, `job_type`, `location`, `ename`, `additional_info`, `jurl`, `sent_to`, `date_created`)
    VALUES
        ('Partner Engineer, Android', 'job', 'Bellevue, WA', 'Meta', 'Partner Engineering is a highly technical team that works with our strategic partners to integrate Meta products into their mobile platforms, apps, devices as well as our VR/AR platforms. Partner Engineers bring deep technical knowledge of Android platforms to lead highly visible initiatives and launch impactful products with our strategic mobile partners.', 'https://www.metacareers.com/jobs/917060759860304', '', '2024-02-17'),
        ('Software Engineer 2', 'job', 'Redmond, WA', 'Microsoft', 'Design, implement, validate, and release software features to critical production components. Maintain scalable services with health monitoring to enable self-healing systems. Engage with teammates and partner teams to understand business needs to maximize impact. Provide technical, end-to-end ownership for projects on which you work. Innovate and Implement system to enable growth of scalable, critical, and global services. Drive our collaborative, inclusive and passionate team culture.', 'https://jobs.careers.microsoft.com/global/en/job/1672687', '', '2024-02-15'),
        ('Incubation Senior Gameplay Engineer', 'job', 'Hybrid / Bungie-Approved Remote Locations', 'Bungie', '', 'https://careers.bungie.com/jobs/5087300/incubation-senior-gameplay-engineer', '', '2024-03-02'),
        ('Software Dev', 'internship', 'Redmond, WA', 'Costco', '', 'https://www.costco.com/', '', '2024-03-01'),
        ('IT Support', 'internship', 'Seattle, WA', 'REI', 'REI is united around discovering, building, and celebrating better ways of working in this world, all so that our employees and members can find and pursue a love of the outdoors. As a co-op, we are committed to becoming a fully inclusive, antiracist, multicultural organization. When you work for the co-op, you do your best work with the support to live your best life. And you play a part in shaping the future of the outdoors, for people and our planet.', 'https://www.rei.jobs/careers-home', '', '2024-02-13');
