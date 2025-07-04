<?php
// Include the database connection file
include 'db_connection.php'; // This will define $conn

// Fetch all polls from the database
$query = "SELECT * FROM polls";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error: " . mysqli_error($conn)); // Handle query execution error
}

// Check if there are any rows returned
if (mysqli_num_rows($result) == 0) {
    echo "No polls found.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Polls</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <h3 class="text-center mb-4">Manage Polls</h3>

    <!-- Button to open the Add Poll modal -->
    <button class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#addPollModal">Add New Poll</button>

    <!-- Table to display existing polls -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Poll ID</th>
                <th>Poll Title</th>
                <th>Poll Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['poll_id']; ?></td>
                    <td><?php echo $row['poll_title']; ?></td>
                    <td><?php echo $row['poll_description']; ?></td>
                    <td>
                        <a href="admin_edit_poll.php?poll_id=<?php echo $row['poll_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="admin_delete_poll.php?poll_id=<?php echo $row['poll_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this poll?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Add New Poll Modal -->
<div class="modal fade" id="addPollModal" tabindex="-1" aria-labelledby="addPollModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addPollModalLabel">Add New Poll</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="admin_add_poll.php" method="POST">
          <div class="mb-3">
            <label for="poll_title" class="form-label">Poll Title</label>
            <input type="text" class="form-control" id="poll_title" name="poll_title" required>
          </div>
          <div class="mb-3">
            <label for="poll_description" class="form-label">Poll Description</label>
            <textarea class="form-control" id="poll_description" name="poll_description" rows="4" required></textarea>
          </div>

          <div id="questions">
            <div class="mb-3">
              <label for="question_1" class="form-label">Question 1</label>
              <input type="text" class="form-control" id="question_1" name="question_1" required>
            </div>
          </div>

          <div class="mb-3">
            <button type="button" class="btn btn-secondary" onclick="addQuestion()">Add Another Question</button>
          </div>

          <input type="hidden" name="question_count" id="question_count" value="1">
          <button type="submit" class="btn btn-primary">Add Poll</button>
        </form>
      </div>
    </div>
  </div>
</div>
<button onclick="goBack()" class="back-button" right:50px>Back</button>
<script>
  function addQuestion() {
    var questionCount = document.getElementById('question_count').value;
    questionCount++;

    // Add new question field dynamically
    var newQuestion = document.createElement('div');
    newQuestion.classList.add('mb-3');
    newQuestion.innerHTML = `
      <label for="question_${questionCount}" class="form-label">Question ${questionCount}</label>
      <input type="text" class="form-control" id="question_${questionCount}" name="question_${questionCount}" required>
    `;

    document.getElementById('questions').appendChild(newQuestion);

    // Update question count
    document.getElementById('question_count').value = questionCount;
  }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
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
