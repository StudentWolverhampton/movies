<?php
// config.php

// Define the database connection variables
define("DB_SERVER", "localhost");  // Your database server (localhost for most hosts)
define("DB_USERNAME", "2332829");  // Your database username
define("DB_PASSWORD", "ogbudatop1hvhboy1337$");  // Your database password
define("DB_NAME", "db2332829");  // Your database name

// Create a connection to the database
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
