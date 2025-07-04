<?php
include('db_connection.php'); // Ensure database connection is correct

// Check if form is submitted to update the status
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['lost_item_id']) && isset($_POST['status'])) {
    $lost_item_id = $_POST['lost_item_id'];
    $status = $_POST['status'];

    $update_query = "UPDATE lost_items SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param('si', $status, $lost_item_id);
    
    if ($stmt->execute()) {
        echo '<script>alert("Status updated successfully."); window.location.href="admin_page.php";</script>';
    } else {
        echo '<script>alert("Failed to update status."); window.location.href="admin_page.php";</script>';
    }
}

$is_admin = true;

if ($is_admin) {
    // Fetch lost and found items
    $lost_items_query = "SELECT * FROM lost_items";
    $found_items_query = "SELECT * FROM found_items";

    $lost_items = $conn->query($lost_items_query);
    $found_items = $conn->query($found_items_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Lost & Found</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
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
    <h2 class="text-center mb-4">Admin - Lost & Found Management</h2>

    <!-- Lost Items Table -->
    <div class="row my-4">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-warning text-white text-center">
                    <h4>Lost Items</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($lost_item = $lost_items->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $lost_item['item_name']; ?></td>
                                    <td><?php echo $lost_item['item_description']; ?></td>
                                    <td><?php echo $lost_item['status']; ?></td>
                                    <td>
                                        <?php if ($lost_item['status'] != 'claimed') { ?>
                                            <button class="btn btn-warning" data-toggle="modal" data-target="#editLostItemModal<?php echo $lost_item['id']; ?>">Edit Status</button>
                                        <?php } ?>
                                    </td>
                                </tr>

                                <!-- Edit Lost Item Status Modal -->
                                <div class="modal fade" id="editLostItemModal<?php echo $lost_item['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editLostItemModalLabel<?php echo $lost_item['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editLostItemModalLabel<?php echo $lost_item['id']; ?>">Edit Lost Item Status</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="">
                                                    <input type="hidden" name="lost_item_id" value="<?php echo $lost_item['id']; ?>">
                                                    <div class="form-group">
                                                        <label for="status<?php echo $lost_item['id']; ?>">Status</label>
                                                        <select name="status" class="form-control" required>
                                                            <option value="reported" <?php if ($lost_item['status'] == 'reported') echo 'selected'; ?>>Reported</option>
                                                            <option value="claimed" <?php if ($lost_item['status'] == 'claimed') echo 'selected'; ?>>Claimed</option>
                                                            <option value="not_found" <?php if ($lost_item['status'] == 'not_found') echo 'selected'; ?>>Not Found</option>
                                                        </select>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Update Status</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
<button onclick="goBack()" class="back-button" right:50px>Back</button>
<!-- Bootstrap JS & jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> <!-- Use full jQuery version -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
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
<?php
}
?>
