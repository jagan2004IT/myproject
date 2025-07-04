<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $request_type = $_POST['request_type'];
    $description = $_POST['description'];
    $priority = $_POST['priority'];
    $status = 'Pending';
    $payment_status = 'Unpaid';

    $query = "INSERT INTO maintenance_requests (user_id, request_type, description, priority, status, payment_status, created_at) 
              VALUES ('$user_id', '$request_type', '$description', '$priority', '$status', '$payment_status', NOW())";

    if ($conn->query($query)) {
        $request_id = $conn->insert_id;
        header("Location: pay_request.php?request_id=$request_id");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
