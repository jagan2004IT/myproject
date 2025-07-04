<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'community_management', port:3307);

// Add Announcement
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $announcement = $conn->real_escape_string($_POST['announcement']);
    $imagePath = null;

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/'; // Ensure this directory exists and is writable
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $imagePath = $uploadDir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO announcements (content, image_path) VALUES (?, ?)");
    $stmt->bind_param('ss', $announcement, $imagePath);
    $stmt->execute();
}

// Delete Announcement
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    // Retrieve the image path
    $result = $conn->query("SELECT image_path FROM announcements WHERE id = $id");
    if ($row = $result->fetch_assoc()) {
        $imagePath = $row['image_path'];
        if (file_exists($imagePath)) {
            unlink($imagePath); // Delete the image file
        }
    }

    // Delete the announcement
    $conn->query("DELETE FROM announcements WHERE id = $id");
}

// Edit Announcement
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $id = intval($_POST['id']);
    $content = $conn->real_escape_string($_POST['content']);
    $conn->query("UPDATE announcements SET content = '$content' WHERE id = $id");
}

// Fetch Announcements
$result = $conn->query("SELECT * FROM announcements");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Announcements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Manage Announcements</h1>
        
        <!-- Add Announcement Form -->
        <div class="card p-4 mt-4">
            <h3>Add Announcement</h3>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <textarea class="form-control" name="announcement" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Upload Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
                <button type="submit" name="add" class="btn btn-primary">Add</button>
            </form>
        </div>

        <!-- Announcements List -->
        <div class="card p-4 mt-4">
            <h3>Announcements List</h3>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Announcement</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td>
                                <?php if (!empty($row['image_path'])): ?>
                                    <img src="<?= $row['image_path'] ?>" alt="Announcement Image" style="max-width: 100px; max-height: 100px;">
                                <?php else: ?>
                                    No Image
                                <?php endif; ?>
                            </td>
                            <td>
                                <form method="POST" class="d-flex">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <input type="text" name="content" class="form-control me-2" value="<?= $row['content'] ?>" required>
                                    <button type="submit" name="edit" class="btn btn-warning btn-sm">Save</button>
                                </form>
                            </td>
                            <td>
                                <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
