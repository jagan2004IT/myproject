<?php
// Include the database connection file
include 'db_connection.php'; // This will define $conn

// Check if the poll_id is set in the URL
if (isset($_GET['poll_id'])) {
    // Get the poll_id from the URL
    $poll_id = $_GET['poll_id'];

    // Prepare the DELETE query to remove the poll from the database
    $query = "DELETE FROM polls WHERE poll_id = $poll_id";

    // Execute the query
    if (mysqli_query($conn, $query)) {
        // Redirect to the admin dashboard or list of polls
        header("Location: dashboard.php?message=Poll deleted successfully");
        exit();
    } else {
        // Show an error message if the query fails
        echo "<p class='text-center text-danger'>Error deleting poll: " . mysqli_error($conn) . "</p>";
    }
} else {
    // If no poll_id is provided, show an error
    echo "<p class='text-center text-danger'>Poll ID is missing!</p>";
}
?>
