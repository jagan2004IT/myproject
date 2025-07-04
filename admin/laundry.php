<?php
// Assuming there's a check to identify if the user is an admin
$is_admin = true;

if ($is_admin) {
    // Connect to your database (replace with your actual connection details)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "community_management"; // Replace with your database name

    $conn = new mysqli($servername, $username, $password, $dbname, port:3307);

    // Check if connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch the list of users from the database
    $sql = "SELECT id, username FROM users";
    $result = $conn->query($sql);

    // Prepare the array of users
    $users = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Handle form submission to set alerts
        $user_id = $_POST['user_id'];
        $alert_message = $_POST['alert_message'];

        // Insert the alert into the laundry_alerts table
        $stmt = $conn->prepare("INSERT INTO laundry_alerts (user_id, alert_message) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $alert_message);
        $stmt->execute();
        $stmt->close();

        echo "Alert set successfully!";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laundry Facility Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS (optional) -->
    <style>
        body {
            margin: 50px;
            font-family: Arial, sans-serif;
        }

        .container {
            background-color: #f9f9f9;
            padding: 30px;
            border-radius: 10px;
        }

        .card {
            border-radius: 10px;
            border: 1px solid #e0e0e0;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .card-header {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        .card-header.bg-warning {
            background-color: #ff9800;
        }

        .card-header.bg-info {
            background-color: #17a2b8;
        }

        table th, table td {
            text-align: center;
        }

        .shadow-lg {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .text-center {
            text-align: center;
        }

        .rounded-lg {
            border-radius: 10px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Laundry Facility Management</h2>

    <!-- Display Users to Set Alerts -->
    <div class="row my-4">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-warning text-white text-center">
                    <h4>Set Alerts for Users</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="user_id">Select User:</label>
                                <select id="user_id" name="user_id" class="form-select" required>
                                    <?php foreach ($users as $user) { ?>
                                        <option value="<?= $user['id'] ?>"><?= $user['username'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="alertMessage">Alert Message:</label>
                                <input type="text" id="alertMessage" name="alert_message" class="form-control" placeholder="Set Alert for User" required>
                            </div>
                        </div>
                        <button class="btn btn-primary mt-3" type="submit">Set Alert</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Display All Alerts for Users -->
    <div class="row my-4">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-info text-white text-center">
                    <h4>Current Alerts for Users</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Alert Message</th>
                                <th>Alert Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Fetch all alerts from the database
                            $sql = "SELECT la.alert_message, la.alert_date, u.username
                                    FROM laundry_alerts la
                                    JOIN users u ON la.user_id = u.id";
                            $alerts_result = $conn->query($sql);
                            if ($alerts_result->num_rows > 0) {
                                while ($alert = $alerts_result->fetch_assoc()) {
                                    echo "<tr>
                                            <td>" . $alert['username'] . "</td>
                                            <td>" . $alert['alert_message'] . "</td>
                                            <td>" . $alert['alert_date'] . "</td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3' class='text-center'>No alerts found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Exit to Home Screen -->
    <div class="row my-4">
        <div class="col-md-12 text-center">
            <a href="dashboard.php" class="btn btn-secondary btn-lg px-5 py-3 rounded-pill shadow-sm">Exit to Home Screen</a>
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
    $conn->close(); // Close the database connection
}
?>
