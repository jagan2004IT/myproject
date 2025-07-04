<?php
session_start();
include 'db_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch maintenance requests for the logged-in user
$query = "SELECT id, request_type, description, priority, status, payment_status, created_at 
          FROM maintenance_requests 
          WHERE user_id = '$user_id' 
          ORDER BY created_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>My Maintenance Requests</title>
</head>
<body>
<div class="container mt-5">
    <h3 class="text-center mb-4">My Maintenance Requests</h3>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Request Type</th>
                    <th>Description</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Payment Status</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $counter = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>" . $counter++ . "</td>
                            <td>" . htmlspecialchars($row['request_type']) . "</td>
                            <td>" . htmlspecialchars($row['description']) . "</td>
                            <td>" . htmlspecialchars($row['priority']) . "</td>
                            <td>" . htmlspecialchars($row['status']) . "</td>
                            <td>" . htmlspecialchars($row['payment_status']) . "</td>
                            <td>" . htmlspecialchars($row['created_at']) . "</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>No maintenance requests found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center mt-4">
        <a href="dashboard.php" class="btn btn-secondary btn-lg">Back to Dashboard</a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
