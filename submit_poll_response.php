<?php
// Include the database connection
include 'db_connection.php'; 

// Ensure the user is logged in and has a session
session_start();
if (!isset($_SESSION['user_id'])) {
    die("You need to be logged in to vote.");
}

$user_id = $_SESSION['user_id']; // Assuming the user ID is stored in session
$poll_id = $_POST['poll_id']; // Poll ID from the form

// Iterate through each question and insert the responses into the database
if (isset($_POST['response']) && is_array($_POST['response'])) {
    foreach ($_POST['response'] as $question_id => $response) {
        $response = mysqli_real_escape_string($conn, $response); // Sanitize the response

        // Check if the user has already responded to this poll
        $response_check_query = "SELECT * FROM poll_responses WHERE user_id = $user_id AND poll_id = $poll_id AND question_id = $question_id";
        $response_check_result = mysqli_query($conn, $response_check_query);

        if (mysqli_num_rows($response_check_result) > 0) {
            // Update existing response if the user already answered
            $update_query = "UPDATE poll_responses SET response = '$response' WHERE user_id = $user_id AND poll_id = $poll_id AND question_id = $question_id";
            mysqli_query($conn, $update_query);
        } else {
            // Insert a new response if the user hasn't responded yet
            $insert_query = "INSERT INTO poll_responses (user_id, poll_id, question_id, response) VALUES ($user_id, $poll_id, $question_id, '$response')";
            mysqli_query($conn, $insert_query);
        }
    }

    // Redirect after successful submission
    header("Location: dashboard.php?poll_id=$poll_id"); // Redirect back to the poll dashboard
} else {
    echo "Please provide a response for all questions.";
}
?>
