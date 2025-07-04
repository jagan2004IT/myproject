<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'community_management', port:3307);

// Fetch all bookings
$bookings = $conn->query("SELECT bookings.id, users.username, facilities.name AS facility_name, bookings.booking_time, bookings.status
                          FROM bookings
                          JOIN users ON bookings.user_id = users.id
                          JOIN facilities ON bookings.facility_id = facilities.id
                          ORDER BY bookings.booking_time DESC");
?>
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Facility Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Manage Facility Bookings</h1>
        <div class="card p-4 mt-4">
            <h3>Bookings List</h3>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Facility</th>
                        <th>Booking Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $bookings->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['username'] ?></td>
                            <td><?= $row['facility_name'] ?></td>
                            <td><?= $row['booking_time'] ?></td>
                            <td><?= $row['status'] ?></td>
                            <td>
                                <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <button onclick="goBack()" class="back-button" right:50px>Back</button>
        </div>
    </div>
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
