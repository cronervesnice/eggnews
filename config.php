<?php
// Database configuration
$db_host = "localhost";      // e.g., "localhost"
$db_user = "egg";
$db_password = "Password";
$db_name = "realnews";

// Establish a database connection
$mysqli = new mysqli($db_host, $db_user, $db_password, $db_name);

// Check the connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

