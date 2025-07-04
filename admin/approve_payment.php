<?php
session_start();
include('db_connection.php');

// Admin validation (optional)


if (isset($_GET['payment_id'])) {
    $payment_id = $_GET['payment_id'];

    // Mark the payment as 'Paid'
    $update_query = "UPDATE rent_payments SET status = 'Paid' WHERE id = $payment_id";
    $conn->query($update_query);
    
    // Generate a receipt
    $receipt_number = 'REC-' . strtoupper(uniqid());
    $receipt_date = date('Y-m-d');
    $insert_receipt = "INSERT INTO rent_payment_receipts (payment_id, receipt_number, receipt_date) 
                       VALUES ($payment_id, '$receipt_number', '$receipt_date')";
    $conn->query($insert_receipt);
    
    header('Location: dashboard.php');
} else {
    echo 'Invalid payment ID.';
}
?>
