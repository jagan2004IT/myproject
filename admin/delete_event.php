<?php
// Start session and check if the admin is logged in
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Include the database connection file
require_once 'db_connection.php'; // Assuming db_connection.php is your connection file

// Check if the event ID is passed via GET request
if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    // Prepare and execute delete query
    $stmt = $conn->prepare("DELETE FROM community_events WHERE id = ?");
    $stmt->bind_param("i", $event_id);

    if ($stmt->execute()) {
        // Redirect back to the events management page after successful deletion
        header("Location: manage_events.php?msg=Event deleted successfully");
    } else {
        // Show error message if deletion fails
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    // Redirect if no event ID is provided
    header("Location: manage_events.php?msg=No event ID provided");
}

$conn->close();
?>
