<?php
// Include the database connection file
include 'db_connection.php'; // This will define $conn

// Get poll_id from the URL
$poll_id = $_GET['poll_id'];

// Get responses for the specific poll
$query = "SELECT * FROM poll_responses WHERE poll_id = $poll_id";
$responses_result = mysqli_query($conn, $query);

// Get poll title
$poll_query = "SELECT poll_title FROM polls WHERE poll_id = $poll_id";
$poll_result = mysqli_query($conn, $poll_query);
$poll = mysqli_fetch_assoc($poll_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poll Responses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h3 class="text-center mb-4">Responses for Poll: <?php echo $poll['poll_title']; ?></h3>

    <?php while ($response = mysqli_fetch_assoc($responses_result)): ?>
        <div class="card mb-3">
            <div class="card-body">
                <p><strong>User ID:</strong> <?php echo $response['user_id']; ?></p>
                <p><strong>Response:</strong> <?php echo $response['response']; ?></p>
            </div>
        </div>
    <?php endwhile; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
