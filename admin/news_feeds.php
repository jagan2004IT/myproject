<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'community_management', port:3307);

// Add News
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $newsContent = $conn->real_escape_string($_POST['news_content']);
    $imagePath = null;

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/'; // Absolute path

        // Ensure the directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Check the file upload and move it to the correct directory
        $imagePath = $uploadDir . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            echo "File uploaded successfully.";  // Optional for debugging
        } else {
            echo "File upload failed.";  // Optional for debugging
        }
    } else {
        echo "No file uploaded or upload error.";  // Optional for debugging
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO news_feed (content, image_path) VALUES (?, ?)");
    $stmt->bind_param('ss', $newsContent, $imagePath);
    $stmt->execute();
}

// Delete News
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    // Retrieve the image path
    $result = $conn->query("SELECT image_path FROM news_feed WHERE id = $id");
    if ($row = $result->fetch_assoc()) {
        $imagePath = $row['image_path'];
        if (file_exists($imagePath)) {
            unlink($imagePath); // Delete the image file
        }
    }

    // Delete the news
    $conn->query("DELETE FROM news_feed WHERE id = $id");
}

// Edit News
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $id = intval($_POST['id']);
    $content = $conn->real_escape_string($_POST['content']);
    $conn->query("UPDATE news_feed SET content = '$content' WHERE id = $id");
}

// Fetch News Feed
$result = $conn->query("SELECT * FROM news_feed");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage News Feed</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <h1 class="text-center">Manage News Feed</h1>
        
        <!-- Add News Form -->
        <div class="card p-4 mt-4">
            <h3>Add News</h3>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <textarea class="form-control" name="news_content" rows="3" required placeholder="Enter news content"></textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Upload Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
                <button type="submit" name="add" class="btn btn-primary">Add</button>
            </form>
        </div>

        <!-- News Feed List -->
        <div class="card p-4 mt-4">
            <h3>News Feed List</h3>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>News Content</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td>
                                <?php if (!empty($row['image_path'])): ?>
                                    <img src="<?= $row['image_path'] ?>" alt="News Image" style="max-width: 100px; max-height: 100px;">
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
