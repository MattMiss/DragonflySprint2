<?php

global $location;
global $pageTitle;

$themeLoc = $location . 'js/themescript.js';
$styleLoc = $location . 'styles/styles.css';
$favIconLoc = $location . 'images/icons/favicon.ico';

echo "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>$pageTitle</title>
            <!-- Load theme from localstorage -->
            <script src='$themeLoc'></script>
            <!-- Site Icon -->
            <link rel='icon' href='$favIconLoc'>
            <!-- Latest compiled and minified CSS -->
            <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet'>
            <!-- Font Awesome -->
            <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css'>
            <link rel='stylesheet' href='$styleLoc'>
            <!-- Latest compiled JavaScript -->
            <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js'></script>
        </head>
        <body>";