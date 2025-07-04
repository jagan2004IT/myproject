<?php
session_start();
include('db_connection.php');

// Get the current user_id from the session
$user_id = $_SESSION['user_id'];

// Get the current month
$current_month = date('F Y');

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    
    // Insert the dummy payment
    $query = "INSERT INTO rent_payments (user_id, payment_type, amount, due_date, status, month) 
              VALUES ($user_id, 'Rent', $amount, CURDATE(), 'Pending', '$current_month')";
    $conn->query($query);
    
    header('Location: dashboard.php');
}

?>

<div class="container mt-4">
    <h2>Set Payment for <?= $current_month; ?></h2>
    <form method="POST">
        <div class="form-group">
            <label>Amount</label>
            <input type="number" class="form-control" name="amount" required>
        </div>
        <button type="submit" class="btn btn-primary">Set Payment</button>
    </form>
</div>
