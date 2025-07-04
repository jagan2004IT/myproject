<?php
session_start();
include 'db_connection.php';

$request_id = $_GET['request_id'];

// Fetch the maintenance request details
$query = "SELECT * FROM maintenance_requests WHERE id = '$request_id'";
$result = $conn->query($query);
$request = $result->fetch_assoc();
?>

<div class="container mt-5">
    <h3 class="text-center mb-4">Pay for Maintenance Request</h3>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h5>Request Details:</h5>
                    <p><strong>Type:</strong> <?= $request['request_type'] ?></p>
                    <p><strong>Description:</strong> <?= $request['description'] ?></p>
                    <p><strong>Priority:</strong> <?= $request['priority'] ?></p>
                    <h5>Total Amount: $50</h5>
                    <form action="process_payment.php" method="POST">
                        <input type="hidden" name="request_id" value="<?= $request_id ?>">
                        <input type="hidden" name="amount" value="50">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">Pay $50</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
