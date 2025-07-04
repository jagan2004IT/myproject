<?php
// Include the database connection file
include 'db_connection.php'; // This will define $conn

// Fetch the poll details based on poll_id
if (isset($_GET['poll_id'])) {
    $poll_id = $_GET['poll_id'];
    $query = "SELECT * FROM polls WHERE poll_id = $poll_id";
    $result = mysqli_query($conn, $query);
    $poll = mysqli_fetch_assoc($result);

    if (!$poll) {
        die("Poll not found.");
    }
}

// Update poll when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $poll_title = $_POST['poll_title'];
    $poll_description = $_POST['poll_description'];
    $poll_question = $_POST['poll_question']; // Add the poll question

    $update_query = "UPDATE polls SET poll_title='$poll_title', poll_description='$poll_description', question='$poll_question' WHERE poll_id=$poll_id";
    
    if (mysqli_query($conn, $update_query)) {
        echo "<p class='text-center text-success'>Poll updated successfully!</p>";
    } else {
        echo "<p class='text-center text-danger'>Error: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Poll</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h3 class="text-center mb-4">Edit Poll</h3>
    <form method="POST" action="admin_edit_poll.php?poll_id=<?php echo $poll['poll_id']; ?>">
        <div class="mb-3">
            <label for="poll_title" class="form-label">Poll Title</label>
            <input type="text" class="form-control" id="poll_title" name="poll_title" value="<?php echo $poll['poll_title']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="poll_question" class="form-label">Poll Question</label>
            <input type="text" class="form-control" id="poll_question" name="poll_question" value="<?php echo $poll['question']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="poll_description" class="form-label">Poll Description</label>
            <textarea class="form-control" id="poll_description" name="poll_description" rows="4" required><?php echo $poll['poll_description']; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Poll</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
