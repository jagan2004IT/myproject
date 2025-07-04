<?php
session_start();
include('db_connection.php'); // Include your DB connection file

// Get the current user_id from the session
$user_id = $_SESSION['user_id'];

// Fetch pending payments for the user
$query = "SELECT * FROM rent_payments WHERE user_id = $user_id AND status = 'Pending'";
$result = $conn->query($query);

?>
<div class="container mt-4">
    <h2>Pending Rent Payments</h2>
    <?php if ($result->num_rows > 0): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Payment Type</th>
                    <th>Amount</th>
                    <th>Due Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['payment_type']; ?></td>
                        <td><?= $row['amount']; ?></td>
                        <td><?= $row['due_date']; ?></td>
                        <td><?= $row['status']; ?></td>
                        <td><a href="confirm_payment.php?payment_id=<?= $row['id']; ?>" class="btn btn-success">Confirm Payment</a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No pending payments found.</p>
    <?php endif; ?>
</div>
