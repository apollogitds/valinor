<?php
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = 'root';
$dbName = 'valinor';
$connection = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
if (mysqli_connect_errno()) {
    die("Database connection failed: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
} else {
    # echo "Connection = success!\n" . mysqli_get_host_info($connection) . "<br />";
}
mysqli_query($connection, "SET NAMES utf8");
