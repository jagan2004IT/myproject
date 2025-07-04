<?php
// Include the database connection
include('db_connection.php');  // Ensure the path to the connection is correct

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['lost_item_id']) && isset($_POST['status'])) {
    $lost_item_id = $_POST['lost_item_id'];
    $status = $_POST['status'];

    // Update query for the status of the lost item
    $update_query = "UPDATE lost_items SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param('si', $status, $lost_item_id);

    if ($stmt->execute()) {
        echo '<script>alert("Status updated successfully."); window.location.href="dashboard.php";</script>';
    } else {
        echo '<script>alert("Failed to update status."); window.location.href="dashboard.php";</script>';
    }
}
?>
