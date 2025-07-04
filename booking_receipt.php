<?php
session_start();
include 'db_connection.php';

// Assuming booking ID is passed in URL
if (isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];

    // Fetch booking details from the database
    $query = "SELECT b.*, f.name AS facility_name, u.username 
              FROM bookings b 
              JOIN facilities f ON b.facility_id = f.id
              JOIN users u ON b.user_id = u.id
              WHERE b.id = '$booking_id'";

    $result = $conn->query($query);
    $booking = $result->fetch_assoc();

    if ($booking) {
        echo "
        <div class='receipt-container'>
            <h3>Your Booking Request has been Submitted!</h3>
            <p><strong>Booking ID:</strong> $booking_id</p>
            <p><strong>Facility:</strong> {$booking['facility_name']}</p>
            <p><strong>Booking Date:</strong> {$booking['booking_date']}</p>
            <p><strong>Start Time:</strong> {$booking['start_time']}</p>
            <p><strong>End Time:</strong> {$booking['end_time']}</p>
            <p>Status: <strong>Pending</strong></p>

            <div class='receipt-actions'>
                <a href='download_receipt.php?booking_id=$booking_id' class='btn btn-primary'>Download Receipt</a>
                <a href='dashboard.php' class='btn btn-secondary'>Back to Dashboard</a>
            </div>
        </div>
        ";
    }
}
?>
