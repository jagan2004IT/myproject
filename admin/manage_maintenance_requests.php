<?php
// Start session
session_start();
include('db_connection.php');

// Debugging: Check if session variable is set
// var_dump($_SESSION); // This will show the session data. Remove this after debugging.

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: index.php"); // Redirect to login page if not logged in
    exit();
}

// Fetch all maintenance requests
$query = "SELECT mr.id, mr.user_id, mr.request_type, mr.description, mr.priority, mr.status, mr.payment_status, mr.created_at, 
                 u.username AS user_name 
          FROM maintenance_requests AS mr
          JOIN users AS u ON mr.user_id = u.id
          ORDER BY mr.created_at DESC";
$result = $conn->query($query);

// Handle status update (approve or mark as completed)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_id']) && isset($_POST['new_status'])) {
    $request_id = $_POST['request_id'];
    $new_status = $_POST['new_status'];

    $updateQuery = "UPDATE maintenance_requests SET status = '$new_status' WHERE id = '$request_id'";
    if ($conn->query($updateQuery)) {
        echo "<script>alert('Status updated successfully!'); window.location.href='manage_maintenance_requests.php';</script>";
    } else {
        echo "Error updating status: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .back-button {
    position: fixed;
    bottom: 20px;
    right: 20px;
    padding: 15px 25px; /* Increased padding for bigger button */
    font-size: 18px; /* Larger font */
    font-weight: bold;
    background-color: #ff5722; /* Custom background color (Orange) */
    color: white;
    border: none;
    border-radius: 50px; /* Rounded corners */
    cursor: pointer;
    z-index: 1000;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); /* Add shadow */
    transition: all 0.3s ease;
}

.back-button:hover {
    background-color: #e64a19; /* Darker shade on hover */
    transform: scale(1.05); /* Slight zoom effect */
}
    </style>

    <title>Manage Maintenance Requests</title>
</head>
<body>
<div class="container mt-5">
    <h3 class="text-center mb-4">Manage Maintenance Requests</h3>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Request Type</th>
                    <th>Description</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Payment Status</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $counter = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>" . $counter++ . "</td>
                            <td>" . htmlspecialchars($row['user_name']) . "</td>
                            <td>" . htmlspecialchars($row['request_type']) . "</td>
                            <td>" . htmlspecialchars($row['description']) . "</td>
                            <td>" . htmlspecialchars($row['priority']) . "</td>
                            <td>" . htmlspecialchars($row['status']) . "</td>
                            <td>" . htmlspecialchars($row['payment_status']) . "</td>
                            <td>" . htmlspecialchars($row['created_at']) . "</td>
                            <td>
                                <form method='POST' class='d-inline'>
                                    <input type='hidden' name='request_id' value='" . $row['id'] . "'>
                                    <select name='new_status' class='form-select mb-2'>
                                        <option value='Pending'" . ($row['status'] === 'Pending' ? ' selected' : '') . ">Pending</option>
                                        <option value='In Progress'" . ($row['status'] === 'In Progress' ? ' selected' : '') . ">In Progress</option>
                                        <option value='Completed'" . ($row['status'] === 'Completed' ? ' selected' : '') . ">Completed</option>
                                    </select>
                                    <button type='submit' class='btn btn-success btn-sm'>Update</button>
                                </form>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='9' class='text-center'>No maintenance requests found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</div>
<button onclick="goBack()" class="back-button" right:50px>Back</button>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
      function goBack() {
    if (document.referrer) {
        window.history.back(); // Go to previous page if available
    } else {
        window.location.href = "dashboard.php"; // Redirect to home if no history
    }
  }

    </script>
</body>
</html>
