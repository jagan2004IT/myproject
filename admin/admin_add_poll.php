<?php
// Include the database connection file
include 'db_connection.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get poll details from the form
    $poll_title = mysqli_real_escape_string($conn, $_POST['poll_title']);
    $poll_description = mysqli_real_escape_string($conn, $_POST['poll_description']);

    // Insert the poll into the polls table
    $query = "INSERT INTO polls (poll_title, poll_description) VALUES ('$poll_title', '$poll_description')";
    if (mysqli_query($conn, $query)) {
        // Fetch the last inserted poll ID
        $poll_id = mysqli_insert_id($conn);

        // Add questions for the poll
        $question_count = $_POST['question_count']; // Get the number of questions
        for ($i = 1; $i <= $question_count; $i++) {
            $question_text = mysqli_real_escape_string($conn, $_POST['question_' . $i]);
            $query = "INSERT INTO poll_questions (poll_id, question_text) VALUES ('$poll_id', '$question_text')";
            mysqli_query($conn, $query);
        }

        // Redirect to the poll management page after success
        header('Location: admin_manage_polls.php');
    } else {
        die("Error: " . mysqli_error($conn));
    }
}
?>
