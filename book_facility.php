<?php
session_start();
include 'db_connection.php';

// Check if form is submitted
if (isset($_POST['submit_booking'])) {
    $facility_id = $_POST['facility_id'];
    $booking_date = $_POST['booking_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $user_id = $_SESSION['user_id']; // Assume user ID is stored in session

    // Insert booking into database
    $query = "INSERT INTO bookings (facility_id, user_id, booking_date, start_time, end_time, status) 
              VALUES ('$facility_id', '$user_id', '$booking_date', '$start_time', '$end_time', 'pending')";
    
    if ($conn->query($query)) {
        // Get the inserted booking ID for receipt
        $booking_id = $conn->insert_id;
        
        // Fetch booking details
        $facility_query = "SELECT name FROM facilities WHERE id = '$facility_id'";
        $facility_result = $conn->query($facility_query);
        $facility_name = $facility_result->fetch_assoc()['name'];

        // Show receipt confirmation
        echo "
        <div class='receipt-container'>
            <h3>Your Booking Request has been Submitted!</h3>
            <p><strong>Booking ID:</strong> $booking_id</p>
            <p><strong>Facility:</strong> $facility_name</p>
            <p><strong>Booking Date:</strong> $booking_date</p>
            <p><strong>Start Time:</strong> $start_time</p>
            <p><strong>End Time:</strong> $end_time</p>
            <p>Status: <strong>Pending</strong></p>

            <div class='receipt-actions'>
                <a href='download_receipt.php?booking_id=$booking_id' class='btn btn-primary'>Download Receipt</a>
                <a href='dashboard.php' class='btn btn-secondary'>Back to Dashboard</a>
            </div>
        </div>
        ";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
