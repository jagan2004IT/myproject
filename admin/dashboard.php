<?php
// Start session
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: index.php"); // Redirect to login page if not logged in
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .list-group {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .list-group-item {
            font-size: 1.1rem;
            font-weight: 500;
            color: #343a40;
            border: none;
            padding: 15px 20px;
            transition: all 0.3s ease;
        }
        .list-group-item:hover {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            padding-left: 25px;
        }
        .list-group-item.active {
            background-color: #0056b3;
            color: white;
            font-weight: bold;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h1 {
            color: #343a40;
        }
    </style>
    <style>
        .logout-button {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 15px 30px; /* Bigger button */
    font-size: 18px;
    font-weight: bold;
    background-color: #ff4d4d; /* Red color */
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    z-index: 1000;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease-in-out;
}

.logout-button:hover {
    background-color: #cc0000; /* Darker red on hover */
    transform: scale(1.1);
}
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
.logout-button {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 15px 30px; /* Bigger button */
    font-size: 18px;
    font-weight: bold;
    background-color: #ff4d4d; /* Red color */
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    z-index: 1000;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease-in-out;
}

    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Admin Dashboard</h1>
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="list-group">
                    <a href="manage_announcements.php" class="list-group-item list-group-item-action">Manage Announcements</a>
                    <a href="news_feeds.php" class="list-group-item list-group-item-action">News Feed </a>
                    <a href="admin_bookings.php" class="list-group-item list-group-item-action">Manage Facilities</a>
                    <a href="manage_maintenance_requests.php" class="list-group-item list-group-item-action">Manage Maintenance Requests</a>
                    <!-- <a href="manage_payments.php" class="list-group-item list-group-item-action">Manage Payments</a> -->

                    <a href="payments.php" class="list-group-item list-group-item-action">Payments</a>
                    <a href="manage_events.php" class="list-group-item list-group-item-action">Manage Community Calendar</a>
                    <a href="admin_manage_polls.php" class="list-group-item list-group-item-action">Manage Polls & Feedback</a>
                    <a href="laundry.php" class="list-group-item list-group-item-action">Laundry notifications</a>
                    <a href="lost.php" class="list-group-item list-group-item-action">Lost notifications</a>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card p-4">
                    <h3>Welcome to the Admin Dashboard</h3>
                    <p>Select an option from the sidebar to manage the respective section.</p>
                </div>
            </div>
        </div>
        <a href="logout.php" class="btn btn-danger mt-3">Logout</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
