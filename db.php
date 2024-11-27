<?php
// Database connection details
$servername = "mi-linux.wlv.ac.uk";
$username = "2332829";
$password = "ogbudatop1hvhboy1337$";
$dbname = "db2332829";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
