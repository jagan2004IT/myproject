<?php
session_start();
include 'db_connection.php';

// Check if booking ID is provided
if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];

    // Update booking status to 'cancelled'
    $query = "UPDATE bookings SET status = 'cancelled' WHERE id = '$booking_id'";
    if ($conn->query($query)) {
        echo "Booking canceled successfully.";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
