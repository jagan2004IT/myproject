<?php
session_start();
include 'db_connection.php';

// Check if booking ID is provided
if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];

    // Update booking status to 'confirmed'
    $query = "UPDATE bookings SET status = 'confirmed' WHERE id = '$booking_id'";
    if ($conn->query($query)) {
        echo "Booking approved successfully.";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
