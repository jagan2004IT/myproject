<?php
session_start();
include('db_connection.php'); // Include your DB connection file

if (isset($_GET['payment_id'])) {
    $payment_id = $_GET['payment_id'];

    // Fetch payment details
    $query = "SELECT * FROM rent_payments WHERE id = $payment_id";
    $result = $conn->query($query);
    $payment = $result->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Mark the payment as 'Paid'
        $update_query = "UPDATE rent_payments SET status = 'Paid' WHERE id = $payment_id";
        $conn->query($update_query);

        // Generate a receipt
        $receipt_number = 'REC-' . strtoupper(uniqid());
        $receipt_date = date('Y-m-d');
        $insert_receipt = "INSERT INTO rent_payment_receipts (payment_id, receipt_number, receipt_date) 
                           VALUES ($payment_id, '$receipt_number', '$receipt_date')";
        $conn->query($insert_receipt);

        header('Location: view_rent_payments.php');
    }
} else {
    echo 'Invalid payment ID.';
}
?>

<div class="container mt-4">
    <h2>Confirm and Process Payment</h2>
    <?php if ($payment): ?>
        <form method="POST">
            <div class="form-group">
                <label>Payment Type</label>
                <input type="text" class="form-control" value="<?= $payment['payment_type']; ?>" disabled>
            </div>
            <div class="form-group">
                <label>Amount</label>
                <input type="text" class="form-control" value="<?= $payment['amount']; ?>" disabled>
            </div>
            <div class="form-group">
                <label>Due Date</label>
                <input type="text" class="form-control" value="<?= $payment['due_date']; ?>" disabled>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Confirm Payment</button>
        </form>
    <?php else: ?>
        <p>Payment not found.</p>
    <?php endif; ?>
</div>
