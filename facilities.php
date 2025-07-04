<?php
// Include database connection
include 'db_connection.php';

// Fetch available facilities from the database
$query = "SELECT * FROM facilities";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facility Booking</title>
</head>
<body>
    <h1>Available Facilities</h1>
    <form action="book_facility.php" method="POST">
        <label for="facility">Select Facility</label>
        <select name="facility_id" id="facility" required>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
            <?php } ?>
        </select>

        <label for="booking_date">Booking Date</label>
        <input type="date" name="booking_date" required>

        <label for="start_time">Start Time</label>
        <input type="time" name="start_time" required>

        <label for="end_time">End Time</label>
        <input type="time" name="end_time" required>

        <button type="submit" name="submit_booking">Book Facility</button>
    </form>
</body>
</html>
