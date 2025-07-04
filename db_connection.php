<?php
// Database connection configuration
$servername = "database-2.c94k8mya6u71.eu-north-1.rds.amazonaws.com";
$username = "root";
$password = "YrXax6MQbxR69SZvoB2x";
$dbname = "newschema";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Uncomment this line for debugging purposes
// echo "Connected successfully";
?>
