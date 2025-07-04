<?php
session_start();
include 'db_connection.php';

// Fetch all bookings for admin view
$query = "SELECT b.*, f.name AS facility_name, u.username 
          FROM bookings b 
          JOIN facilities f ON b.facility_id = f.id
          JOIN users u ON b.user_id = u.id";
$result = $conn->query($query);

// Handle booking approval or cancellation
if (isset($_GET['id'])) {
    $bookingId = $_GET['id'];
    $action = isset($_GET['action']) ? $_GET['action'] : '';

    if ($action == 'approve') {
        $updateQuery = "UPDATE bookings SET status = 'approved' WHERE id = '$bookingId'";
        if ($conn->query($updateQuery)) {
            echo "<p class='text-center text-success'>Booking approved successfully.</p>";
        } else {
            echo "<p class='text-center text-danger'>Error: " . $conn->error . "</p>";
        }
    } elseif ($action == 'cancel') {
        $updateQuery = "UPDATE bookings SET status = 'canceled' WHERE id = '$bookingId'";
        if ($conn->query($updateQuery)) {
            echo "<p class='text-center text-success'>Booking canceled successfully.</p>";
        } else {
            echo "<p class='text-center text-danger'>Error: " . $conn->error . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings</title>
    <style>
        /* You can add your custom styles here */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .text-center {
            text-align: center;
        }
        .text-success {
            color: green;
        }
        .text-danger {
            color: red;
        }
    </style>
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

</head>
<body>
    <h1 class="text-center">Manage Facility Bookings</h1>
    <a href="add_facility.php">Add New Facility</a>

    <table>
        <thead>
            <tr>
                <th>Facility</th>
                <th>User</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['facility_name']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['booking_date']; ?></td>
                    <td><?php echo $row['start_time']; ?></td>
                    <td><?php echo $row['end_time']; ?></td>
                    <td><?php echo ucfirst($row['status']); ?></td>
                    <td>
                        <?php if ($row['status'] != 'approved') { ?>
                            <a href="?id=<?php echo $row['id']; ?>&action=approve">Approve</a> |
                        <?php } ?>
                        <?php if ($row['status'] != 'canceled') { ?>
                            <a href="?id=<?php echo $row['id']; ?>&action=cancel">Cancel</a>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <button onclick="goBack()" class="back-button" right:50px>Back</button>
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
