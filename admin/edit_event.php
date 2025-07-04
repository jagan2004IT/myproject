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
if (isset($_GET['id'])) {
    $event_id = $_GET['id'];

    // Fetch the event details from the database
    $stmt = $conn->prepare("SELECT * FROM community_events WHERE id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $event = $result->fetch_assoc();

    if (!$event) {
        // If no event found, redirect to manage events page
        header("Location: manage_events.php?msg=Event not found");
        exit();
    }

    // Handle form submission for updating the event
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_name'], $_POST['event_date'], $_POST['event_description'])) {
        $event_name = $_POST['event_name'];
        $event_date = $_POST['event_date'];
        $event_description = $_POST['event_description'];

        // Update the event in the database
        $update_stmt = $conn->prepare("UPDATE community_events SET event_name = ?, event_date = ?, event_description = ? WHERE id = ?");
        $update_stmt->bind_param("sssi", $event_name, $event_date, $event_description, $event_id);

        if ($update_stmt->execute()) {
            // Redirect to manage events page after successful update
            header("Location: manage_events.php?msg=Event updated successfully");
            exit();
        } else {
            // Show error message if update fails
            echo "Error: " . $update_stmt->error;
        }

        $update_stmt->close();
    }

    $stmt->close();
} else {
    // Redirect if no event ID is provided
    header("Location: manage_events.php?msg=No event ID provided");
    exit();
}

$conn->close();
?>

<!-- HTML Form to Edit Event -->
<div class="container mt-5">
    <h3 class="text-center mb-4">Edit Event</h3>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="edit_event.php?id=<?php echo $event_id; ?>">
                <div class="form-group">
                    <label for="event_name">Event Name</label>
                    <input type="text" class="form-control" id="event_name" name="event_name" value="<?php echo htmlspecialchars($event['event_name']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="event_date">Event Date</label>
                    <input type="date" class="form-control" id="event_date" name="event_date" value="<?php echo $event['event_date']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="event_description">Event Description</label>
                    <textarea class="form-control" id="event_description" name="event_description" rows="4" required><?php echo htmlspecialchars($event['event_description']); ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update Event</button>
            </form>
        </div>
    </div>
</div>
