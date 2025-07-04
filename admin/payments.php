<?php
session_start();
include('db_connection.php');

// Get all rent payments (all statuses)
$query = "SELECT * FROM rent_payments";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Apart &mdash; Rent Payment Management</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,700,900|Oswald:400,700"> 
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-pzjw8f+ua7Kw1TIq0ZfvwL1+Hb6pQm+Jb6+1zXnAxdbVQ5E+YlY9ImJQnxt55dZ3" crossorigin="anonymous">
    <style>
      body {
        font-family: 'Nunito Sans', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f8f9fa;
      }
      .container-fluid {
        padding: 30px;
      }
      h2 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 2rem;
        color: #343a40;
      }
      .table {
        width: 100%;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      }
      .table th, .table td {
        text-align: center;
        vertical-align: middle;
      }
      .btn {
        border-radius: 4px;
      }
      .btn-success {
        background-color: #28a745;
        border-color: #28a745;
      }
      .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
      }
      .btn-info {
        background-color: #17a2b8;
        border-color: #17a2b8;
      }
      .btn:hover {
        opacity: 0.8;
      }
    </style>
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

    <div class="container-fluid">
      <h2>All Rent Payments</h2>
      <?php if ($result->num_rows > 0): ?>
          <table class="table table-striped">
              <thead class="thead-dark">
                  <tr>
                      <th>User</th>
                      <th>Amount</th>
                      <th>Due Date</th>
                      <th>Status</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody>
                  <?php while ($row = $result->fetch_assoc()): ?>
                      <tr>
                          <td><?= $row['user_id']; ?></td>
                          <td><?= $row['amount']; ?></td>
                          <td><?= $row['due_date']; ?></td>
                          <td><?= $row['status']; ?></td>
                          <td>
                              <?php if ($row['status'] == 'Pending'): ?>
                                  <!-- If payment is Pending, show Approve button -->
                                  <a href="approve_payment.php?payment_id=<?= $row['id']; ?>" class="btn btn-success">Approve</a>
                              <?php elseif ($row['status'] == 'Completed'): ?>
                                  <!-- If payment is Completed, show Completed label -->
                                  <span class="btn btn-secondary">Completed</span>
                              <?php else: ?>
                                  <!-- If payment status is something else, show default label -->
                                  <span class="btn btn-info"><?= $row['status']; ?></span>
                              <?php endif; ?>
                          </td>
                      </tr>
                  <?php endwhile; ?>
              </tbody>
          </table>
          <button onclick="goBack()" class="back-button" right:50px>Back</button>
      <?php else: ?>
          <p class="text-center">No payments found.</p>
      <?php endif; ?>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy+M6gD8DStQF90I2YkzhoPau9pQ8F3d2y6NT3cF" crossorigin="anonymous"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0ZfvwL1+Hb6pQm+Jb6+1zXnAxdbVQ5E+YlY9ImJQnxt55dZ3" crossorigin="anonymous"></script>
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
