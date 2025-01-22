-- phpMyAdmin SQL Dump
-- version 5.2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 20, 2025 at 11:13 AM
-- Server version: 10.2.44-MariaDB - MariaDB Server
-- PHP Version: 8.1.27

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- Database: `dragonfl_app_tracker`

-- --------------------------------------------------------
-- Drop existing tables
-- --------------------------------------------------------
DROP TABLE IF EXISTS `applications`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `announcements`;

-- --------------------------------------------------------
-- Table structure for table `users`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(6) NOT NULL AUTO_INCREMENT,
  `permission` boolean NOT NULL DEFAULT false,
  `fname` varchar(30) NOT NULL,
  `lname` varchar(30) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(255) NOT NULL,
  `cohortNum` int(4) NOT NULL,
  `status` varchar(30) NOT NULL,
  `roles` varchar(500) DEFAULT NULL,
  `is_deleted` boolean NOT NULL DEFAULT false,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- --------------------------------------------------------
-- Insert data for `users`
-- --------------------------------------------------------

-- !!! Please change admin value after you use this sql dump. !!!
-- ADMIN password is currently hashed for "admin123" in this example
INSERT INTO `users` 
  (`user_id`, `permission`, `fname`, `lname`, `email`, `password`, `cohortNum`, `status`, `roles`)
VALUES
  -- Admin user (user_id=0)
  (0, 1, 'admin', 'admin', 'admin@admin', '$2y$10$aWN31xFtkrVKY8LE0HMB5eAN/9CahamKZ825zwlPTqWNTv14NVYOa', 0, 'admin', 'admin');

-- 8 additional users, with example password hashes
-- (Replace with your own password hashes if desired)

-- Alice Anderson pass is abc123456
-- Bob  Brown pass is password1
-- Matt Miss pass is pass1234
-- Diana Doe pass is qwerty123
-- Evan Evans pass is aaaa1111
-- Fiona Frost pass is qwerty123
-- George Grant pass is abc123456
-- Hannah Hall pass is password1

-- Alice (cohortNum=2022)
INSERT INTO `users`
  (`permission`, `fname`, `lname`, `email`, `password`, `cohortNum`, `status`, `roles`)
VALUES
  (0, 'Alice', 'Anderson', 'alice2022@example.com',
   '$2y$10$hQ3TWIvBzwmTWoUIYrNCNOy/99QbhEquUVxm2h6meNV461d9VBINy',
   2022, 'Seeking Job', 'Front-End Developer');

-- Bob (cohortNum=2022)
INSERT INTO `users`
  (`permission`, `fname`, `lname`, `email`, `password`, `cohortNum`, `status`, `roles`)
VALUES
  (0, 'Bob', 'Brown', 'bob2022@example.com',
   '$2y$10$byK16/DXeniGvaCpd20FHOtxDEDYdFSGMLP4O.Hey/T/IKXAs2qe2',
   2022, 'Seeking Internship', 'Back-End Developer');

-- Matt (cohortNum=2023)
INSERT INTO `users`
  (`permission`, `fname`, `lname`, `email`, `password`, `cohortNum`, `status`, `roles`)
VALUES
  (0, 'Matt', 'Miss', 'matt.w.miss@gmail.com',
   '$2y$10$YnWFWrwblNssw9uWvM3ae.Dh4jHs3NPBhSCjED8q9dEUiHxhITtR.',
   2023, 'Not Actively Searching', 'Full-Stack Developer');

-- Diana (cohortNum=2023)
INSERT INTO `users`
  (`permission`, `fname`, `lname`, `email`, `password`, `cohortNum`, `status`, `roles`)
VALUES
  (0, 'Diana', 'Doe', 'diana2023@example.com',
   '$2y$10$TvLDYguHnv5KaYPg.mdjC.YwPR.kgY6ak7kZMpRAtj2N.cKQ0pmUi',
   2023, 'Seeking Job', 'Mobile Developer');

-- Evan (cohortNum=2025)
INSERT INTO `users`
  (`permission`, `fname`, `lname`, `email`, `password`, `cohortNum`, `status`, `roles`)
VALUES
  (0, 'Evan', 'Evans', 'evan2025@example.com',
   '$2y$10$rPGG7eNTquozushAj6tl3e0xvF9yrgqMJ2u5UKcTWdLh8.JMC8DEy',
   2024, 'Seeking Internship', 'Data Scientist');

-- Fiona (cohortNum=2025)
INSERT INTO `users`
  (`permission`, `fname`, `lname`, `email`, `password`, `cohortNum`, `status`, `roles`)
VALUES
  (0, 'Fiona', 'Frost', 'fiona2025@example.com',
   '$2y$10$TvLDYguHnv5KaYPg.mdjC.YwPR.kgY6ak7kZMpRAtj2N.cKQ0pmUi',
   2024, 'Seeking Job', 'Machine Learning Eng');

-- George (cohortNum=2025)
INSERT INTO `users`
  (`permission`, `fname`, `lname`, `email`, `password`, `cohortNum`, `status`, `roles`)
VALUES
  (0, 'George', 'Grant', 'george2025@example.com',
   '$2y$10$hQ3TWIvBzwmTWoUIYrNCNOy/99QbhEquUVxm2h6meNV461d9VBINy',
   2025, 'Seeking Internship', 'DevOps Engineer');

-- Hannah (cohortNum=2025)
INSERT INTO `users`
  (`permission`, `fname`, `lname`, `email`, `password`, `cohortNum`, `status`, `roles`)
VALUES
  (0, 'Hannah', 'Hall', 'hannah2025@example.com',
   '$2y$10$byK16/DXeniGvaCpd20FHOtxDEDYdFSGMLP4O.Hey/T/IKXAs2qe2',
   2025, 'Not Actively Searching', 'QA Engineer');

-- --------------------------------------------------------
-- Table structure for table `applications`
-- --------------------------------------------------------
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
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- --------------------------------------------------------
-- Insert data for `applications`
-- 10 applications per user_id 1..8 (admin user_id=0 gets none here).
-- 'astatus' cycles through the 6 statuses: need-to-apply, applied, interviewing, rejected, accepted, inactive
-- 'adate' is in the past couple of months, 'followupdate' is ~10-20 days later.
-- --------------------------------------------------------

INSERT INTO `applications`
  (`user_id`, `jname`, `ename`, `jurl`, `jdescription`, `adate`, `astatus`, `fupdates`, `followupdate`)
VALUES
  /* ---------------------------------------------------- */
  /* USER_ID = 1 : Alice, Front-End Developer            */
  /* ---------------------------------------------------- */
  (1, 'Front-End Developer I', 'Google',    'https://careers.google.com/job/frontend-001', 'Building UI components', '2025-01-15', 'need-to-apply', 'None yet', '2025-01-25'),
  (1, 'React Developer',       'Amazon',    'https://www.amazon.jobs/en/jobs/react-2022',  'Work on front-end for Amazon Shopping', '2025-01-03', 'applied', 'Submitted application', '2025-01-18'),
  (1, 'UI Engineer',           'Netflix',   'https://jobs.netflix.com/ui-456',             'Create dynamic UI for streaming platform', '2025-01-10', 'interviewing', 'Interview scheduled', '2025-01-20'),
  (1, 'Junior FE Engineer',    'Meta',      'https://www.metacareers.com/jobs/fe-789',     'Work on front-end frameworks for social media', '2025-01-09', 'rejected', 'Received rejection email', '2025-01-18'),
  (1, 'Web Dev Intern',        'IBM',       'https://ibm.com/employment/frontend-intern',  'Front-end internship role', '2025-12-28', 'accepted', 'Offer accepted', '2025-01-08'),
  (1, 'Frontend Angular Dev',  'Tesla',     'https://www.tesla.com/careers/angular-123',   'Develop Angular apps for Tesla site', '2025-12-28', 'inactive', 'Paused search on this job', '2025-01-10'),
  (1, 'Front-End Specialist',  'Oracle',    'https://oracle.com/jobs/fe-specialist',       'Optimize UI performance', '2025-01-01', 'need-to-apply', 'None yet', '2025-01-11'),
  (1, 'UI/UX Developer',       'Stripe',    'https://stripe.com/jobs/ui-001',             'UI & UX improvements for payment platform', '2025-01-02', 'applied', 'App submitted', '2025-01-13'),
  (1, 'React Native Eng',      'Microsoft', 'https://careers.microsoft.com/react-native',  'Mobile front-end dev role', '2025-01-01', 'interviewing', 'Phone screen done', '2025-01-14'),
  (1, 'Junior Front-End',      'Apple',     'https://apple.com/jobs/frontend-123',         'Assist with Apple.com UI updates', '2025-01-05', 'inactive', 'No follow-up yet', '2025-01-19'),

  /* ---------------------------------------------------- */
  /* USER_ID = 2 : Bob, Back-End Developer               */
  /* ---------------------------------------------------- */
  (2, 'Back-End Developer I',  'Google',    'https://careers.google.com/jobs/backend-001', 'Building server-side APIs', '2025-01-04', 'need-to-apply', 'Not applied yet', '2025-01-17'),
  (2, 'Java Services Eng',     'Amazon',    'https://amazon.jobs/en/jobs/java-002',        'Backend services for e-commerce', '2025-01-02', 'applied', 'App submitted', '2025-01-18'),
  (2, 'Node Engineer',         'Netflix',   'https://jobs.netflix.com/backend-node-003',   'Building Node.js microservices', '2025-01-04', 'interviewing', 'Technical interview soon', '2025-01-16'),
  (2, 'API Developer',         'Apple',     'https://apple.com/jobs/api-004',             'Develop internal APIs for Apple', '2025-01-02', 'rejected', 'Got a rejection', '2025-01-15'),
  (2, 'Database Engineer',     'Meta',      'https://www.metacareers.com/db-005',          'Maintain large-scale databases', '2025-01-04', 'accepted', 'Accepted offer', '2025-01-17'),
  (2, 'Backend Specialist',    'IBM',       'https://ibm.com/employment/backend-006',      'IBM Cloud microservices', '2024-12-28', 'inactive', 'Position closed? Not sure', '2025-01-08'),
  (2, 'PL/SQL Developer',      'Oracle',    'https://oracle.com/jobs/plsql-007',          'Work with Oracle DB solutions', '2024-12-20', 'need-to-apply', 'Not applied yet', '2025-01-09'),
  (2, 'GoLang Backend Eng',    'Stripe',    'https://stripe.com/jobs/golang-008',         'Go-based services for finance', '2024-12-26', 'applied', 'Submitted resume', '2025-01-11'),
  (2, 'Python DevOps',         'Microsoft', 'https://careers.microsoft.com/python-dev',    'Backend automation with Python', '2024-12-23', 'interviewing', 'Scheduled 2nd interview', '2025-01-07'),
  (2, 'Backend NodeJS Eng',    'Tesla',     'https://tesla.com/careers/node-009',         'NodeJS for Tesla internal tooling', '2024-12-22', 'rejected', 'No callback', '2025-01-06'),

  /* ---------------------------------------------------- */
  /* USER_ID = 3 : Charlie, Full-Stack Developer         */
  /* ---------------------------------------------------- */
  (3, 'Full-Stack Dev Intern', 'Google',    'https://careers.google.com/jobs/fs-001',    'Full-stack internship on GCP', '2024-12-20', 'need-to-apply', 'Checking details', '2025-01-05'),
  (3, 'Full-Stack Engineer',   'Amazon',    'https://amazon.jobs/en/jobs/fullstack-002', 'Work across front & back end', '2025-01-03', 'applied', 'Application in review', '2025-01-15'),
  (3, 'MERN Stack Dev',        'Netflix',   'https://jobs.netflix.com/mern-003',         'React + Node platform dev', '2025-01-05', 'interviewing', 'Phone screen completed', '2025-01-17'),
  (3, 'Full-Stack Cloud Eng',  'Apple',     'https://apple.com/jobs/fs-004',            'Front & back end in iCloud', '2025-01-02', 'rejected', 'Email received: rejected', '2025-01-18'),
  (3, 'React/Node Full-Stack', 'Meta',      'https://metacareers.com/react-node-005',    'Combine React and Node at scale', '2024-12-27', 'accepted', 'Offer accepted!', '2025-01-08'),
  (3, 'Full-Stack Specialist', 'IBM',       'https://ibm.com/employment/fs-006',         'IBM internal tools', '2024-12-28', 'inactive', 'They have not responded', '2025-01-10'),
  (3, 'Full-Stack Developer I','Oracle',    'https://oracle.com/jobs/fs-007',           'Maintain entire web app', '2025-01-05', 'need-to-apply', 'None yet', '2025-01-15'),
  (3, 'Node & React Engineer', 'Stripe',    'https://stripe.com/jobs/fs-008',           'Integrate Node/React for finance', '2024-12-29', 'applied', 'Form submitted', '2025-01-13'),
  (3, 'Full-Stack SDE',        'Microsoft', 'https://careers.microsoft.com/fs-009',      'Build Azure-based solutions', '2024-12-20', 'interviewing', 'Interview next week', '2025-01-06'),
  (3, 'Full-Stack Web Eng',    'Tesla',     'https://tesla.com/careers/fs-010',         'Front & back end for Tesla.com', '2025-01-03', 'rejected', 'Not selected', '2025-01-16'),

  /* ---------------------------------------------------- */
  /* USER_ID = 4 : Diana, Mobile Developer               */
  /* ---------------------------------------------------- */
  (4, 'Android Developer',     'Google',    'https://careers.google.com/android-001',    'Work on Android apps', '2025-01-02', 'need-to-apply', 'Reviewing requirements', '2025-01-17'),
  (4, 'iOS Developer',         'Amazon',    'https://amazon.jobs/en/jobs/ios-002',       'Work on iOS apps for Amazon', '2024-12-27', 'applied', 'Sent resume', '2025-01-05'),
  (4, 'React Native Eng',      'Netflix',   'https://jobs.netflix.com/mobile-003',       'Mobile front-end for streaming app', '2025-01-06', 'interviewing', 'Phone screen done', '2025-01-20'),
  (4, 'Swift Developer',       'Apple',     'https://apple.com/jobs/swift-004',         'Build Swift apps for iOS', '2025-01-01', 'rejected', 'Did not move forward', '2025-01-14'),
  (4, 'Mobile Specialist',     'Meta',      'https://metacareers.com/mobile-005',       'Work on cross-platform mobile solutions', '2024-12-29', 'accepted', 'Offer accepted', '2025-01-13'),
  (4, 'Xamarin Developer',     'Microsoft', 'https://careers.microsoft.com/xamarin-006','Develop cross-platform apps in C#', '2024-12-27', 'inactive', 'No further contact', '2025-01-09'),
  (4, 'Android/iOS Intern',    'IBM',       'https://ibm.com/employment/mobile-007',    'Intern for hybrid mobile dev', '2024-12-28', 'need-to-apply', 'Not applied yet', '2025-01-11'),
  (4, 'Mobile DevOps',         'Tesla',     'https://tesla.com/careers/mobile-008',      'Integrate mobile pipeline', '2024-12-24', 'applied', 'Submitted app form', '2025-01-07'),
  (4, 'Mobile QA Eng',         'Stripe',    'https://stripe.com/jobs/mobile-009',       'Mobile test frameworks', '2024-12-28', 'interviewing', 'Tech interview soon', '2025-01-12'),
  (4, 'Flutter Developer',     'Oracle',    'https://oracle.com/jobs/mobile-010',       'Using Flutter for cross-platform', '2025-01-02', 'rejected', 'Emailed rejection', '2025-01-14'),

  /* ---------------------------------------------------- */
  /* USER_ID = 5 : Evan, Data Scientist                  */
  /* ---------------------------------------------------- */
  (5, 'Data Scientist I',      'Google',    'https://careers.google.com/jobs/data-001', 'Build predictive models', '2025-01-01', 'need-to-apply', 'Reviewing skill match', '2025-01-17'),
  (5, 'Machine Learning Anlyst','Amazon',   'https://amazon.jobs/en/jobs/ml-002',       'Deploy ML for e-commerce', '2025-01-03', 'applied', 'Form submitted', '2025-01-18'),
  (5, 'Data Visualization Eng','Netflix',   'https://jobs.netflix.com/data-003',        'Visualize user data', '2025-01-05', 'interviewing', 'Phone screen done', '2025-01-15'),
  (5, 'Data Engineer',         'Apple',     'https://apple.com/jobs/data-004',          'ETL pipelines for iCloud data', '2025-01-06', 'rejected', 'Email said no', '2025-01-17'),
  (5, 'Statistical Analyst',   'Meta',      'https://metacareers.com/stats-005',        'Analyze large social data sets', '2025-01-09', 'accepted', 'Negotiated & accepted', '2025-01-18'),
  (5, 'Data Specialist',       'IBM',       'https://ibm.com/employment/data-006',      'Support IBM Cloud data solutions', '2024-12-24', 'inactive', 'Project paused', '2025-01-08'),
  (5, 'Big Data Engineer',     'Oracle',    'https://oracle.com/jobs/data-007',         'Manage big data clusters', '2024-12-28', 'need-to-apply', 'No action yet', '2025-01-09'),
  (5, 'ML Engineer',           'Stripe',    'https://stripe.com/jobs/ml-008',           'Payment fraud detection ML', '2025-01-02', 'applied', 'Resume sent', '2025-01-15'),
  (5, 'Python Data Scientist', 'Microsoft', 'https://careers.microsoft.com/data-009',    'Data analysis with Python', '2024-12-30', 'interviewing', '2nd interview soon', '2025-01-13'),
  (5, 'NLP Developer',         'Tesla',     'https://tesla.com/careers/nlp-010',        'Work on autopilot language tasks', '2024-12-31', 'rejected', 'Went with another candidate', '2025-01-14'),

  /* ---------------------------------------------------- */
  /* USER_ID = 6 : Fiona, Machine Learning Eng            */
  /* ---------------------------------------------------- */
  (6, 'ML Engineer Intern',    'Google',    'https://careers.google.com/jobs/ml-001',    'Intern with ML team', '2025-01-02', 'need-to-apply', 'No action yet', '2025-01-17'),
  (6, 'Deep Learning Specialist','Amazon',  'https://amazon.jobs/en/jobs/dl-002',        'Develop deep learning models', '2024-12-20', 'applied', 'Submitted CV', '2025-01-05'),
  (6, 'Computer Vision Eng',   'Netflix',   'https://jobs.netflix.com/cv-003',           'Image recognition pipelines', '2025-01-06', 'interviewing', 'Scheduled call', '2025-01-20'),
  (6, 'NLP Engineer',          'Apple',     'https://apple.com/jobs/nlp-004',           'Natural language for Siri', '2025-01-01', 'rejected', 'Email with no', '2025-01-14'),
  (6, 'AI Research Eng',       'Meta',      'https://metacareers.com/ai-005',           'Research new AI algorithms', '2024-12-30', 'accepted', 'Great offer', '2025-01-13'),
  (6, 'Machine Learning Dev',  'IBM',       'https://ibm.com/employment/ml-006',        'Develop ML solutions for Watson', '2024-12-28', 'inactive', 'Position hold', '2025-01-09'),
  (6, 'Autopilot ML Engineer', 'Tesla',     'https://tesla.com/careers/autopilot-007',  'ML for self-driving', '2024-12-30', 'need-to-apply', 'No application yet', '2025-01-11'),
  (6, 'AI Engineer',           'Microsoft', 'https://careers.microsoft.com/ai-008',      'Cloud-based AI on Azure', '2024-12-25', 'applied', 'CV accepted', '2025-01-07'),
  (6, 'Advanced ML Developer', 'Oracle',    'https://oracle.com/jobs/ml-009',           'Implement advanced ML for DB services', '2024-12-28', 'interviewing', 'Phone interview set', '2025-01-12'),
  (6, 'ML Engineer II',        'Stripe',    'https://stripe.com/jobs/ml-010',           'Advanced payment risk ML', '2025-01-02', 'rejected', 'No further contact', '2025-01-16'),

  /* ---------------------------------------------------- */
  /* USER_ID = 7 : George, DevOps Engineer                */
  /* ---------------------------------------------------- */
  (7, 'DevOps Engineer I',     'Google',    'https://careers.google.com/jobs/devops-001',  'Manage CI/CD for Google Cloud', '2025-01-11', 'need-to-apply', 'No steps yet', '2025-01-25'),
  (7, 'Cloud DevOps Specialist','Amazon',   'https://amazon.jobs/en/jobs/devops-002',       'AWS continuous integration', '2025-01-03', 'applied', 'Resume sent', '2025-01-18'),
  (7, 'Site Reliability Eng',  'Netflix',   'https://jobs.netflix.com/sre-003',            'SRE role on streaming platform', '2025-01-05', 'interviewing', 'First interview done', '2025-01-15'),
  (7, 'Infrastructure Eng',    'Apple',     'https://apple.com/jobs/infra-004',           'Manage iCloud infrastructure', '2025-01-06', 'rejected', 'Email rejection', '2025-01-17'),
  (7, 'DevOps Specialist',     'Meta',      'https://metacareers.com/devops-005',          'Meta config mgmt & automation', '2025-01-04', 'accepted', 'Signed offer', '2025-01-18'),
  (7, 'CI/CD Engineer',        'IBM',       'https://ibm.com/employment/cicd-006',         'Set up pipelines for IBM cloud', '2024-12-27', 'inactive', 'No final word', '2025-01-08'),
  (7, 'DevOps Automation Eng', 'Tesla',     'https://tesla.com/careers/devops-007',        'Automation for manufacturing tools', '2024-12-29', 'need-to-apply', 'Looking into it', '2025-01-10'),
  (7, 'SRE/DevOps',            'Microsoft', 'https://careers.microsoft.com/sre-008',       'Azure SRE + DevOps tasks', '2025-01-02', 'applied', 'Submitted online', '2025-01-15'),
  (7, 'DevOps Engineer II',    'Oracle',    'https://oracle.com/jobs/devops-009',          'Oracle Cloud deployments', '2024-12-31', 'interviewing', 'Phone interview soon', '2025-01-13'),
  (7, 'AWS DevOps Eng',        'Stripe',    'https://stripe.com/jobs/devops-010',          'AWS microservices for finance', '2024-12-24', 'rejected', 'No match found', '2025-01-06'),

  /* ---------------------------------------------------- */
  /* USER_ID = 8 : Hannah, QA Engineer                    */
  /* ---------------------------------------------------- */
  (8, 'QA Engineer I',         'Google',    'https://careers.google.com/jobs/qa-001',      'Perform QA on new services', '2025-01-02', 'need-to-apply', 'Pending', '2025-01-17'),
  (8, 'Automation QA Dev',     'Amazon',    'https://amazon.jobs/en/jobs/qa-002',          'Implement QA scripts for AWS', '2024-12-20', 'applied', 'Awaiting response', '2025-01-05'),
  (8, 'Test Engineer',         'Netflix',   'https://jobs.netflix.com/test-003',           'Testing streaming platform features', '2025-01-06', 'interviewing', 'Interview soon', '2025-01-20'),
  (8, 'iOS QA Analyst',        'Apple',     'https://apple.com/jobs/qa-004',              'QA for iOS apps', '2024-12-31', 'rejected', 'No offer', '2025-01-14'),
  (8, 'QA Automation Specialist','Meta',    'https://metacareers.com/qa-005',             'Meta QA frameworks', '2024-12-30', 'accepted', 'Accepted job', '2025-01-13'),
  (8, 'Test Automation Eng',   'IBM',       'https://ibm.com/employment/qa-006',           'Automate tests for IBM Cloud', '2024-12-26', 'inactive', 'Role on hold', '2025-01-09'),
  (8, 'SDET',                  'Tesla',     'https://tesla.com/careers/sdet-007',          'Software Dev in Test for cars', '2024-12-28', 'need-to-apply', 'Drafting application', '2025-01-11'),
  (8, 'QA Engineer II',        'Microsoft', 'https://careers.microsoft.com/qa-008',        'Manual & automated QA for Azure', '2024-12-22', 'applied', 'App sent in', '2025-01-07'),
  (8, 'Automation QA Eng',     'Oracle',    'https://oracle.com/jobs/qa-009',             'QA for Oracle products', '2024-12-28', 'interviewing', 'Scheduled second round', '2025-01-12'),
  (8, 'Quality Assurance Eng', 'Stripe',    'https://stripe.com/jobs/qa-010',             'Testing payment APIs', '2024-12-31', 'rejected', 'Heard back with no', '2025-01-14');


-- --------------------------------------------------------
-- Table structure for table `announcements`
-- --------------------------------------------------------
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

-- --------------------------------------------------------
-- Insert data for `announcements` (10 total)
-- --------------------------------------------------------
INSERT INTO `announcements`
  (`title`, `job_type`, `location`, `ename`, `additional_info`, `jurl`, `sent_to`, `date_created`)
VALUES
  ('New Full-Stack Roles',     'job',        'Seattle, WA', 'Amazon',
   'We have new full-stack developer openings at Amazon. Experience in JavaScript, Node, AWS required.',
   'https://www.amazon.jobs/en/jobs/fullstack-2025', '', '2025-01-21'),

  ('Summer Internships',       'internship', 'Redmond, WA', 'Microsoft',
   'Multiple summer internships available in cloud computing, AI, and QA at Microsoft.',
   'https://careers.microsoft.com/internship-apply', '', '2025-01-20'),

  ('Tech Fair Reminder',       'job',        'Bellevue, WA', 'Google',
   'Don’t forget the upcoming tech career fair next month. Google recruiters will be present.',
   'https://careers.google.com/events/techfair', '', '2025-01-19'),

  ('Mobile Development Intern','internship', 'Menlo Park, CA', 'Meta',
   'Meta offers mobile dev internships focusing on iOS, Android, or React Native. Competitive compensation.',
   'https://www.metacareers.com/internships', '', '2025-01-18'),

  ('Full-Time Engineering',    'job',        'San Francisco, CA', 'Stripe',
   'Stripe has multiple full-time engineering roles in payments, ML, and SRE.',
   'https://stripe.com/jobs/full-time', '', '2025-01-17'),

  ('Cloud Internship',         'internship', 'Austin, TX', 'IBM',
   'Learn to build and deploy in IBM Cloud as a summer intern. Great mentorship and career development.',
   'https://ibm.com/employment/internships', '', '2025-01-16'),

  ('Remote DevOps Positions',  'job',        'Remote', 'Oracle',
   'Oracle is hiring remote DevOps specialists to modernize deployment and operations for large customers.',
   'https://oracle.com/jobs/devops-remote', '', '2025-01-15'),

  ('Machine Learning Intern',  'internship', 'Remote', 'Tesla',
   'Work on autopilot data and develop ML solutions for EV systems. Remote internship with flexible hours.',
   'https://tesla.com/careers/ml-intern', '', '2025-01-14'),

  ('Interview Prep Workshop',  'job',        'Seattle, WA', 'General',
   'Join our workshop to learn best practices for technical interviewing, from phone screens to on-sites.',
   'http://example.com/interview-prep', '', '2025-01-13'),

  ('Spring Internships Closing','internship','Various', 'Multiple Companies',
   'Spring internship deadlines at major tech companies are fast approaching—apply soon!',
   'http://example.com/spring-internships', '', '2025-01-12');


-- Done!
