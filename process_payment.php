<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $request_id = $_POST['request_id'];
    $amount = $_POST['amount'];
    $status = 'Success'; // Assume successful payment for now

    // Insert the payment into the payments table
    $query = "INSERT INTO payments (user_id, maintenance_request_id, amount, status, payment_date)
              VALUES ('$user_id', '$request_id', '$amount', '$status', NOW())";

    if ($conn->query($query)) {
        // Update the maintenance request payment status
        $updateQuery = "UPDATE maintenance_requests SET payment_status = 'Paid' WHERE id = '$request_id'";
        $conn->query($updateQuery);

        // Redirect to the dashboard page
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
