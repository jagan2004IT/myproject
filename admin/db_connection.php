<?php
// Database connection configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "community_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, port:3307);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Uncomment this line for debugging purposes
// echo "Connected successfully";
?>
