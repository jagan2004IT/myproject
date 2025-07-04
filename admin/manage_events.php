<?php
// Start session and check if the admin is logged in
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Include the database connection file
include('db_connection.php');

// Handle form submission for adding an event
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_name'], $_POST['event_date'], $_POST['event_description'])) {
    $event_name = $_POST['event_name'];
    $event_date = $_POST['event_date'];
    $event_description = $_POST['event_description'];

    // Add event to the database
    $stmt = $conn->prepare("INSERT INTO community_events (event_name, event_date, event_description) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $event_name, $event_date, $event_description);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_events.php"); // Refresh page after adding event
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Events</title>
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

</head>
<body>
<div class="container mt-5">
    <h3 class="text-center mb-4">Manage Community Events</h3>
    <div class="card">
        <div class="card-body">
            <!-- Form for adding events -->
            <form method="POST">
                <div class="mb-3">
                    <label for="event_name" class="form-label">Event Name</label>
                    <input type="text" class="form-control" id="event_name" name="event_name" required>
                </div>
                <div class="mb-3">
                    <label for="event_date" class="form-label">Event Date</label>
                    <input type="date" class="form-control" id="event_date" name="event_date" required>
                </div>
                <div class="mb-3">
                    <label for="event_description" class="form-label">Event Description</label>
                    <textarea class="form-control" id="event_description" name="event_description" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Add Event</button>
            </form>

            <!-- Display all events -->
            <h4 class="mt-4">Existing Events</h4>
            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch events from the database and display them
                    $result = $conn->query("SELECT * FROM community_events ORDER BY event_date ASC");
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>" . htmlspecialchars($row['event_name']) . "</td>
                            <td>" . htmlspecialchars($row['event_date']) . "</td>
                            <td>" . htmlspecialchars($row['event_description']) . "</td>
                            <td>
                                <a href='edit_event.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Edit</a>
                               <a href='delete_event.php?event_id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this event?\");'>Delete</a>
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
            <button onclick="goBack()" class="back-button" right:50px>Back</button>
        </div>
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
