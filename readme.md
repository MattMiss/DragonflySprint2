# Application Tracking Tool For Green River College

This project's final presentation was on March 19th, 2025 for Green River College's staff. 
Five two-week-long sprints were used in order to complete this project.

## Overview

This project was made to help Green River College students store their job applications in a collective manner. 
While helping students, it also helps the staff while having an admin view that can be used to track the recent applications of the students and send announcements of recent openings. 

## Authors

Jennifer McNiel, Mason Sain, Matthew Miss, Yadira Cervantes

## Using This Tool 

In order for this application to work, a database is needed. 
All that is needed for this is for the user to import the app_tracker_dump.sql in order to create the tables and have some dummy data.

The connection is through db_picker.php and is included in almost every page. 
In the file it points to, it needs to have a value called $cnxn through @mysqli_connect.

For Example, this could look like:

`$cnxn = @mysqli_connect($host, $user, $password, $database)`

## Full Description 

While being a project for a client, this was mostly used to learn new skills in specific coding languages. 
These languages are PHP, Javascript, HTML, SQL, and CSS. 
Bootstrap heavily helped with styling.

Some of the skills learned:

* Ability to create the ability to login 
* Connecting to a database through mysqli 
* Automatically filling an HTML table from a SQL database (javascript)
* How cookies & sessions work (dark mode, date, login)
* Redirecting through headers (php) 
* How to have dynamic dashboards for different types of users
* Creating dynamic error messages in forms (javascript)
* Ability to include nav bars (php)
* Creating forms that have meaningful fields (signup, application)
* Sending emails through code (php)
* Creating modals (bootstrap)
* Adjusting section sizes for mobile screens (css)
* Importance of a SQL dump page

