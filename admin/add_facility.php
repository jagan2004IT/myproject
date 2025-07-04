<?php
session_start();
include 'db_connection.php';

// Handle the form submission for adding a facility
if (isset($_POST['submit'])) {
    $facilityName = $_POST['facility_name'];
    $facilityDescription = $_POST['facility_description'];

    if (!empty($facilityName) && !empty($facilityDescription)) {
        // Insert new facility into the database
        $insertQuery = "INSERT INTO facilities (name, description) VALUES ('$facilityName', '$facilityDescription')";
        if ($conn->query($insertQuery) === TRUE) {
            echo "<p class='text-center text-success'>Facility added successfully.</p>";
        } else {
            echo "<p class='text-center text-danger'>Error: " . $conn->error . "</p>";
        }
    } else {
        echo "<p class='text-center text-danger'>Please fill in all fields.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Facility</title>
    <style>
        /* You can add your custom styles here */
        .form-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container input, .form-container textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }
        .form-container button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
        }
        .form-container button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1 class="text-center">Add New Facility</h1>
    <div class="form-container">
        <form method="POST">
            <label for="facility_name">Facility Name</label>
            <input type="text" name="facility_name" id="facility_name" required>

            <label for="facility_description">Facility Description</label>
            <textarea name="facility_description" id="facility_description" rows="4" required></textarea>

            <button type="submit" name="submit">Add Facility</button>
        </form>
    </div>
</body>
</html>
