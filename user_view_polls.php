<?php
// Include the database connection
include 'db_connection.php';

// Assume user_id is stored in session (you need to handle user login and sessions)
session_start();
$user_id = $_SESSION['user_id']; // User ID from session

// Fetch all polls from the polls table
$query = "SELECT * FROM polls";
$result = mysqli_query($conn, $query);

// Check if the query executed successfully
if (!$result) {
    die("Error fetching polls: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Polls Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h3 class="text-center mb-4">Polls Dashboard</h3>

    <!-- Loop through and display all polls -->
    <div class="list-group">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="list-group-item">
                <h5><?php echo htmlspecialchars($row['poll_title']); ?></h5>
                <p><?php echo nl2br(htmlspecialchars($row['poll_description'])); ?></p>

                <!-- Fetch and display the poll questions related to this poll -->
                <?php
                $poll_id = $row['poll_id'];

                // Check if the user has already submitted a response for this poll
                $check_submission_query = "SELECT * FROM poll_responses WHERE user_id = $user_id AND poll_id = $poll_id";
                $check_submission_result = mysqli_query($conn, $check_submission_query);

                if (mysqli_num_rows($check_submission_result) > 0) {
                    // User has already submitted a response, show the poll status
                    echo "<h6>Your Responses:</h6>";
                    $questions_query = "SELECT * FROM poll_questions WHERE poll_id = $poll_id";
                    $questions_result = mysqli_query($conn, $questions_query);

                    if ($questions_result && mysqli_num_rows($questions_result) > 0) {
                        while ($question = mysqli_fetch_assoc($questions_result)) {
                            echo "<div class='mb-3'>";
                            echo "<label>" . htmlspecialchars($question['question_text']) . "</label>";

                            // Get the user's response
                            $response_query = "SELECT response FROM poll_responses WHERE user_id = $user_id AND poll_id = $poll_id AND question_id = " . $question['question_id'];
                            $response_result = mysqli_query($conn, $response_query);
                            $response = mysqli_fetch_assoc($response_result)['response'];

                            // Display the user's response
                            echo "<p><strong>Your response: " . htmlspecialchars($response) . "</strong></p>";

                            // Get the total count of 'Yes' responses for this question
                            $yes_count_query = "SELECT COUNT(*) as yes_count FROM poll_responses WHERE question_id = " . $question['question_id'] . " AND response = 'yes'";
                            $yes_count_result = mysqli_query($conn, $yes_count_query);
                            $yes_count = mysqli_fetch_assoc($yes_count_result)['yes_count'];

                            // Get the total count of responses for this question
                            $total_count_query = "SELECT COUNT(*) as total_count FROM poll_responses WHERE question_id = " . $question['question_id'];
                            $total_count_result = mysqli_query($conn, $total_count_query);
                            $total_count = mysqli_fetch_assoc($total_count_result)['total_count'];

                            // Calculate the percentage of 'Yes' responses
                            if ($total_count > 0) {
                                $yes_percentage = ($yes_count / $total_count) * 100;
                            } else {
                                $yes_percentage = 0;
                            }

                            // Display the 'Yes' percentage
                            echo "<p><strong>'Yes' responses: " . number_format($yes_percentage, 2) . "%</strong></p>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>No questions available for this poll.</p>";
                    }
                } else {
                    // User has not submitted their response, show the poll questions with form
                    echo "<form action='submit_poll_response.php' method='POST'>";
                    echo "<input type='hidden' name='poll_id' value='$poll_id'>";

                    $questions_query = "SELECT * FROM poll_questions WHERE poll_id = $poll_id";
                    $questions_result = mysqli_query($conn, $questions_query);

                    if ($questions_result && mysqli_num_rows($questions_result) > 0) {
                        while ($question = mysqli_fetch_assoc($questions_result)) {
                            echo "<div class='mb-3'>";
                            echo "<label>" . htmlspecialchars($question['question_text']) . "</label>";
                            echo "<select class='form-control' name='response[" . $question['question_id'] . "]' required>";
                            echo "<option value='yes'>Yes</option>";
                            echo "<option value='no'>No</option>";
                            echo "</select>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>No questions available for this poll.</p>";
                    }

                    echo "<button type='submit' class='btn btn-primary mt-2'>Submit Response</button>";
                    echo "</form>";
                }
                ?>
            </div>
        <?php } ?>
    </div>
</div>


<br>
<br>

<div class="d-grid">
    <a href="dashboard.php" class="btn btn-primary btn-lg">back to dashboard </a>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
