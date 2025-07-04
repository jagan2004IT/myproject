<?php
// Include the database connection file
include 'db_connection.php'; // This will define $conn

// Get all polls
$query = "SELECT * FROM polls";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Polls</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h3 class="text-center mb-4">View Polls and Responses</h3>

    <?php while ($poll = mysqli_fetch_assoc($result)): ?>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title"><?php echo $poll['poll_title']; ?></h5>
                <p class="card-text"><?php echo $poll['poll_description']; ?></p>
                <a href="view_poll_responses.php?poll_id=<?php echo $poll['poll_id']; ?>" class="btn btn-info">View Responses</a>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
