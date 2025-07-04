<?php
session_start();
include 'db_connection.php';
$user_id = $_SESSION['user_id'];

// Fetch user's bookings
$query = "SELECT b.*, f.name AS facility_name 
          FROM bookings b 
          JOIN facilities f ON b.facility_id = f.id 
          WHERE b.user_id = '$user_id'";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Bookings</title>
</head>
<body>
    <h1>Your Facility Bookings</h1>
    <table>
        <thead>
            <tr>
                <th>Facility</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['facility_name']; ?></td>
                    <td><?php echo $row['booking_date']; ?></td>
                    <td><?php echo $row['start_time']; ?></td>
                    <td><?php echo $row['end_time']; ?></td>
                    <td><?php echo ucfirst($row['status']); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
