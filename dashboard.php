<?php

session_start();

 // This will print the entire session array

include 'db_connection.php'; // Include your database connection



if (isset($_POST['submit_booking'])) {
    $facility_id = $_POST['facility_id'];
    $booking_date = $_POST['booking_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $user_id = $_SESSION['user_id']; // Assuming user is logged in and user_id is stored in session

    // Insert booking into the database
    $bookingQuery = "INSERT INTO bookings (facility_id, user_id, booking_date, start_time, end_time, status) 
                     VALUES ('$facility_id', '$user_id', '$booking_date', '$start_time', '$end_time', 'pending')";
    if ($conn->query($bookingQuery)) {
        echo "<p class='text-center text-success'>Booking request submitted successfully.</p>";
    } else {
        echo "<p class='text-center text-danger'>Error: " . $conn->error . "</p>";
    }
}

$month = 12;
$year = 2024;
$start_date = "{$year}-{$month}-01";
$end_date = "{$year}-{$month}-31";

// Query to get community events for December 2024
$eventQuery = "SELECT * FROM community_events WHERE event_date BETWEEN '$start_date' AND '$end_date' ORDER BY event_date";
$eventResult = $conn->query($eventQuery);

// Store events in an array by date
$events = [];
while ($row = $eventResult->fetch_assoc()) {
    $events[$row['event_date']][] = $row;
}


$user_id = $_SESSION['user_id'];

// Fetch user details (if needed)
$current_month = date('F Y');

// Fetch rent payment details for the current month
$query = "SELECT * FROM rent_payments WHERE user_id = $user_id AND month = '$current_month'";
$result = $conn->query($query);
$payment = $result->fetch_assoc();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f8f9fa;
        }

      /* Carousel Images */
.carousel-item img {
    width: 100%;
    height: 600px;
    object-fit: cover;
}

.skyblue-header {
    background-color:rgb(11, 186, 255); /* Sky Blue */
    color: white;
    text-align: center;
}


/* Welcome Section - Positioned over the Carousel */
.welcome-section {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    color: white;
    text-align: center;
    background: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
    z-index: 1; /* Ensure it sits on top of the carousel */
}

.welcome-section h1 {
    font-size: 3rem;
    font-weight: bold;
}

.welcome-section p {
    font-size: 1.2rem;
}

        .announcement-bar {
            background-color: #343a40;
            color: white;
            padding: 10px;
            font-size: 1.2em;
            position: relative;
            margin-top: 40px;
        }

        .announcement-bar img {
            width: 50px;
            height: 50px;
            margin-right: 15px;
            vertical-align: middle;
        }

        .news-feed-section {
            padding: 40px;
            background-color: #f1f1f1;
        }

        .news-feed-item {
            background-color: white;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .news-feed-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }

        .news-feed-title {
            font-size: 1.5em;
            margin-top: 15px;
        }

        .news-feed-description {
            font-size: 1.1em;
            color: #555;
            margin-top: 10px;
        }
      
        .card-img-container {
        height: auto; /* Let the image's height adjust dynamically */
        max-height: 200px; /* Optional: limit maximum height */
        overflow: hidden; /* Hide any overflow */
    }

    .announcement-image {
        width: 100%;
        object-fit: contain; /* Show full image without cropping */
    }

    /* Retain hover effects */
    .announcement-image:hover {
        transform: scale(1.1);
    }

    .announcement-card {
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .announcement-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .news-feed-item {
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .news-feed-item:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    /* Image styling */
    .news-feed-img {
        height: 200px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .news-feed-img:hover {
        transform: scale(1.1);
    }

    /* Title and description */
    .news-feed-title {
        font-size: 1.25rem;
        font-weight: 600;
    }

    .text-muted {
        font-size: 0.9rem;
    }
    .booking-container {
        max-width: 1313px;
        margin-left:20px;
        background-image: url('https://i.ibb.co/DzZyM1v/hotel.jpg');
        background-size: cover;
        background-position: center;
        padding: 30px;
        border-radius: 15px;
        color: white;
    }

    .booking-card {
        border-radius: 15px;
        background-color: rgba(0, 0, 0, 0.6); /* Transparent black background for card */
    }

    .booking-card-body {
        padding: 20px;
    }

    .booking-form-row {
        margin-top: 10px;
    }

    .booking-label {
        font-weight: 600;
        margin-bottom: 8px;
    }

    .booking-select,
    .booking-input {
        width: 100%;
        border-radius: 10px;
        height: 45px;
        padding: 10px;
        background-color: #f1f1f1;
        border: none;
    }

    .booking-btn {
        font-size: 16px;
        padding: 12px 30px;
        border-radius: 25px;
        background-color: #0069d9;
        color: white;
        border: none;
        transition: all 0.3s ease;
    }

    .booking-btn:hover {
        background-color: #0056b3;
        transform: translateY(-5px);
    }

    .booking-container h3 {
        color: white;
        font-weight: bold;
    }

    .booking-card-body {
        background-color: rgba(0, 0, 0, 0.6);
        border-radius: 15px;
    }

    .booking-btn:hover {
        background-color: #0056b3;
        border-color: #004085;
        transform: translateY(-5px);
    }


    .event {
    padding: 5px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #f8f9fa;
    font-size: 0.9rem;
}

.event-details {
    font-size: 0.8rem;
    color: #007bff;
}

.event:hover {
    background-color: #007bff;
    color: white;
    cursor: pointer;
}
/* Calendar Grid */
.calendar-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 15px;
}

/* Calendar Cell */
.calendar-cell {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 15px;
    transition: background-color 0.3s ease;
}

/* Highlighted Event Day */
.calendar-cell.event-day {
    background-color: #f4f4f4;
    border: 2px solid #ec7625;
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
}


.btn-primary {
    background-color: #00d3ff;
    border-color: #ec7625;
}
/* Event Card */
.day-card {
    background-color: white;
    padding: 10px;
    border-radius: 8px;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    text-align: center;
}

/* Event Details */
.event-details {
    margin-top: 10px;
    font-size: 14px;
    color: #333;
}

.event-name {
    font-weight: bold;
    color: #ec7625;
}

.event-desc {
    font-style: italic;
    color: #6c757d;
}

/* Calendar Header */
h4 {
    font-size: 24px;
    font-weight: bold;
    color: #333;
}

.text-muted {
    color: #6c757d !important;
}

/* Button */
.btn-lg {
    padding: 12px 24px;
    font-size: 18px;
    border-radius: 8px;
    transition: background-color 0.3s ease;
}


.btn-primary:hover {
    background-color: #d4611e;
    border-color: #d4611e;
}

/* Responsive Design */
@media (max-width: 768px) {
    .calendar-grid {
        grid-template-columns: repeat(7, 1fr);
    }
}


.card.shadow-lg.border-0.rounded-lg.mb-4 {
    margin-top: 73px;
}

.poll-container {
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .poll-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }
        .poll-description {
            font-size: 1rem;
            margin-top: 10px;
            color: #555;
        }
        .poll-question {
            font-size: 1.2rem;
            margin-top: 20px;
            color: #007bff;
        }
        .poll-actions {
            margin-top: 20px;
        }

.logout-button {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 15px 30px; /* Bigger button */
    font-size: 18px;
    font-weight: bold;
    background-color: #ff4d4d; /* Red color */
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    z-index: 1000;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease-in-out;
}

.logout-button:hover {
    background-color: #cc0000; /* Darker red on hover */
    transform: scale(1.1);
}
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
.logout-button {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 15px 30px; /* Bigger button */
    font-size: 18px;
    font-weight: bold;
    background-color: #ff4d4d; /* Red color */
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    z-index: 1000;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease-in-out;
}



    </style>
</head>
<body>
<div class="site-wrap">

<div class="site-navbar mt-4">
    <div class="container py-1">
      <div class="row align-items-center">
        <div class="col-8 col-md-8 col-lg-4">
          <h1 class="mb-0"><a href="index.php" class="text-white h2 mb-0"><strong>Apart<span class="text-primary">.</span></strong></a></h1>
        </div>
        <div class="col-4 col-md-4 col-lg-8">
          <nav class="site-navigation text-right text-md-right" role="navigation">
x
            <div class="d-inline-block d-lg-none ml-md-0 mr-auto py-3"><a href="#" class="site-menu-toggle js-menu-toggle text-white"><span class="icon-menu h3"></span></a></div>

            <ul class="site-menu js-clone-nav d-none d-lg-block">
              <li class="active">
                <a href="#">Home</a>
              </li>
              <li><a href="about.php">About</a></li>
              <li class="has-children">
                <a href="apartments.php">Apartments</a>
                <ul class="dropdown arrow-top">
                  <li><a href="#">Apartments</a></li>
                  <li class="has-children">
                    <a href="#">Rooms</a>
                    <ul class="dropdown">
                      <li><a href="#">Corner Rooms</a></li>
                      <li><a href="#">Balcony Rooms</a></li>
                      <li><a href="#">Sea view Rooms</a></li>
                    </ul>
                  </li>
                  <li class="has-children">
                    <a href="#">Suites</a>
                    <ul class="dropdown">
                      <li><a href="#">King Suite</a></li>
                      <li><a href="#">Premium Twin Bed</a></li>
                      <li><a href="#">Triple Bed</a></li>
                    </ul>
                  </li>
                  <li class="has-children">
                    <a href="#">Sub Menu</a>
                    <ul class="dropdown">
                      <li><a href="#">Menu One</a></li>
                      <li><a href="#">Menu Two</a></li>
                      <li><a href="#">Menu Three</a></li>
                    </ul>
                  </li>
                  <li class="has-children">
                    <a href="#">Laundry</a>
                    <ul class="dropdown">
                      <li><a href="#">For Kids</a></li>
                      <li><a href="#">For Adults</a></li>
                    </ul>
                  </li>
                </ul>
              </li>
              <li><a href="news.php">News</a></li>
              <li><a href="register.php">Register</a></li>
              <li><a href="login.php">Login</a></li>
              <li><a href="contact.php">Contact</a></li>
              <button onclick="logout()" class="logout-button">Logout</button>
            </ul>
          </nav>
        </div>

      </div>
    </div>
  </div>
</div>

<div class="site-mobile-menu">
<div class="site-mobile-menu-header">
<div class="site-mobile-menu-close mt-3">
  <span class="icon-close2 js-menu-toggle"></span>
</div>
</div>
<div class="site-mobile-menu-body"></div>
</div> <!-- .site-mobile-menu -->
<!-- Carousel Section -->
<div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="img1.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="img2.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="img3.jpeg" class="d-block w-100" alt="...">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<!-- Welcome Section -->
<div class="welcome-section">
    <h1>Welcome to the Community Dashboard</h1>
    
</div>

<!-- Announcement Bar Section -->
<div class="container mt-4">
    <h1 class="text-center mb-4">Announcements</h1>
    <div class="row g-3">
        <?php
        // Fetch announcements
$sql = "SELECT * FROM `announcements`";
$result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Construct the image path
                $imagePath = 'admin/' . $row['image_path'];
                ?>
                <div class="col-md-4">
                    <div class="card shadow-sm h-100 announcement-card">
                        <div class="card-img-container">
                            <img src="<?php echo $imagePath; ?>" class="card-img-top img-fluid announcement-image" alt="Announcement Image">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Announcement</h5>
                            <p class="card-text"><?php echo htmlspecialchars($row['content']); ?></p>
                            <p class="text-muted small">Posted on: <?php echo date('F j, Y, g:i a', strtotime($row['created_at'])); ?></p>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p class='text-center'>No announcements available.</p>";
        }
        ?>
    </div>
</div>




<!-- News Feed Section -->
<div class="container mt-5">
    <h3 class="text-center mb-4">Latest News Feed</h3>
    <div class="row g-4">
        <?php
        // Fetch rows from the 'news_feed' table ordered by creation date
        $query = "SELECT * FROM `news_feed` ORDER BY `created_at` DESC";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Use the image path directly from the database
                $imagePath = 'admin/' . $row['image_path'];
                $content = $row['content'];
                $createdAt = date('F j, Y, g:i a', strtotime($row['created_at']));
                ?>
                <div class="col-md-4">
                    <div class="card shadow-sm news-feed-item">
                        <img src="<?php echo $imagePath; ?>" class="card-img-top news-feed-img" alt="News Image" style="max-height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title news-feed-title"><?php echo htmlspecialchars($content); ?></h5>
                            <p class="text-muted small">Posted on: <?php echo $createdAt; ?></p>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p class='text-center'>No news available at the moment.</p>";
        }
        ?>
    </div>
</div>

<!-- Facility Booking Section -->
<div class="booking-container mt-5">
    <h3 class="text-center mb-4">Book a Facility</h3>
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="booking-card shadow-sm">
                <div class="booking-card-body">
                    <form action="book_facility.php" method="POST">
                        <div class="booking-form-row g-3">

                            <div class="col-md-12">
                                <label for="facility" class="booking-label">Select Facility</label>
                                <select name="facility_id" id="facility" class="booking-select" required>
                                    <?php
                                    // Fetch available facilities
                                    $facilityQuery = "SELECT * FROM facilities";
                                    $facilityResult = $conn->query($facilityQuery);
                                    if ($facilityResult->num_rows > 0) {
                                        while ($facility = $facilityResult->fetch_assoc()) {
                                            echo "<option value='" . $facility['id'] . "'>" . $facility['name'] . "</option>";
                                        }
                                    } else {
                                        echo "<option value=''>No facilities available</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label for="booking_date" class="booking-label">Booking Date</label>
                                <input type="date" name="booking_date" id="booking_date" class="booking-input" placeholder="e.g. Mar 11 2020" required>
                            </div>

                            <div class="col-md-12">
                                <label for="start_time" class="booking-label">Start Time</label>
                                <input type="time" name="start_time" id="start_time" class="booking-input" placeholder="e.g. 14:00" required>
                            </div>

                            <div class="col-md-12">
                                <label for="end_time" class="booking-label">End Time</label>
                                <input type="time" name="end_time" id="end_time" class="booking-input" placeholder="e.g. 14:00" required>
                            </div>

                            <div class="col-12 text-center mt-3">
                                <button type="submit" name="submit_booking" class="booking-btn px-5 py-2">Book Facility</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Display Booking Status -->
    <div class="mt-5">
        <h4 class="text-center mb-3">Your Booking Status</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Facility</th>
                    <th>Booking Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch user bookings
                $userId = 1; // Replace with the actual logged-in user ID
                $bookingQuery = "SELECT * FROM bookings WHERE user_id = $userId";
                $bookingResult = $conn->query($bookingQuery);

                if ($bookingResult->num_rows > 0) {
                    while ($booking = $bookingResult->fetch_assoc()) {
                        // Fetch facility name
                        $facilityQuery = "SELECT name FROM facilities WHERE id = " . $booking['facility_id'];
                        $facilityResult = $conn->query($facilityQuery);
                        $facility = $facilityResult->fetch_assoc();
                        ?>
                        <tr>
                            <td><?= $booking['id'] ?></td>
                            <td><?= $facility['name'] ?></td>
                            <td><?= $booking['booking_date'] ?></td>
                            <td><?= $booking['start_time'] ?></td>
                            <td><?= $booking['end_time'] ?></td>
                            <td><?= ucfirst($booking['status']) ?></td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>No bookings found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="container mt-5">
    <h3 class="text-center mb-4">Submit a Maintenance Request</h3>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-body">
                    <form action="submit_request.php" method="POST">
                        <div class="mb-3">
                            <label for="request_type" class="form-label">Request Type</label>
                            <select name="request_type" id="request_type" class="form-select" required>
                                <option value="Plumbing">Plumbing</option>
                                <option value="Electrical">Electrical</option>
                                <option value="Cleaning">Cleaning</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="priority" class="form-label">Priority</label>
                            <select name="priority" id="priority" class="form-select" required>
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                            </select>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Submit Request</button>
                        </div>
                    </form>
                    <br>
                    <br>
                    <div class="d-grid">
    <a href="view_requests.php" class="btn btn-primary btn-lg">View All Requests</a>
</div>

                </div>
            </div>
        </div>
    </div>
</div>






<div class="container mt-5">
    <h3 class="text-center mb-4">Community Calendar</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">
                <!-- Calendar Header -->
                <div class="col-12 text-center mb-4">
                    <h4>December 2024</h4>
                    <p class="text-muted">Upcoming Events and Activities</p>
                </div>
            </div>

            <!-- Calendar Grid -->
            <div class="calendar-grid row">
                <?php
                // Get the first day of the month (to calculate the starting day for the calendar)
                $first_day_of_month = date('w', strtotime($start_date)); // Get the weekday of the first day
                $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year); // Get the number of days in the month

                // Create the empty grid cells before the 1st
                for ($i = 0; $i < $first_day_of_month; $i++) {
                    echo "<div class='col calendar-cell'></div>";
                }

                // Loop through each day of the month
                for ($current_day = 1; $current_day <= $days_in_month; $current_day++) {
                    $current_date = "{$year}-{$month}-" . str_pad($current_day, 2, "0", STR_PAD_LEFT);
                    $event_html = "<strong>{$current_day}</strong>";

                    // Check if there are events for this day
                    $highlight_class = '';
                    if (isset($events[$current_date])) {
                        $highlight_class = 'event-day'; // Add a highlight class for event days
                        foreach ($events[$current_date] as $event) {
                            $event_html .= "<div class='event-details'>";
                            $event_html .= "<span class='event-name'>{$event['event_name']}</span><br>";
                            $event_html .= "<span class='event-desc'>{$event['event_description']}</span>";
                            $event_html .= "</div>";
                        }
                    }

                    // Display the day with events and highlight
                    echo "<div class='col calendar-cell {$highlight_class}'>
                            <div class='card day-card'>
                                <div class='card-body'>{$event_html}</div>
                            </div>
                          </div>";

                    // Create a new row after Saturday (7th day)
                    if (date('w', strtotime($current_date)) == 6) {
                        echo "</div><div class='calendar-grid row'>";
                    }
                }

                // Fill the remaining empty cells if needed
                $remaining_cells = 7 - ((date('w', strtotime($current_date)) + 1) % 7);
                for ($i = 0; $i < $remaining_cells; $i++) {
                    echo "<div class='col calendar-cell'></div>";
                }
                ?>
            </div>

            <!-- Button to view full calendar -->
            <div class="text-center mt-4">
                <a href="full_calendar.php" class="btn btn-primary btn-lg">View Full Calendar</a>
            </div>
        </div>
    </div>
</div>
<br>
<br>
<br>

<div class="d-grid">
    <a href="user_view_polls.php" class="btn btn-primary btn-lg">Go to Poll Dashboard to Vote</a>
</div>


<div class="container mt-4">
    <h2>Apartment Community Groups</h2>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Group 1: Gardening Enthusiasts</div>
                <div class="card-body">
                    <p>Join our group for gardening tips and ideas.</p>
                    <a href="https://chat.whatsapp.com/YourWhatsAppGroupLink" 
                       target="_blank" 
                       class="btn btn-success">Join WhatsApp Group</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Group 2: Pet Owners</div>
                <div class="card-body">
                    <p>Discuss pet care and events for pet owners.</p>
                    <a href="https://chat.whatsapp.com/YourWhatsAppGroupLink" 
                       target="_blank" 
                       class="btn btn-success">Join WhatsApp Group</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-4">
    <h2>Safety & Security</h2>
    <div class="row my-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Report Emergency</div>
                <div class="card-body">
                    <p>If you are facing an emergency, contact us immediately.</p>
                    <!-- Updated contact details -->
                    <a href="tel:+917708736654" class="btn btn-danger">Call Security</a>
                    <a href="mailto:indhujahitech044@gmail.com?subject=Emergency%20Contact&body=Please%20provide%20details%20of%20the%20emergency." class="btn btn-primary">Email Management</a>
                </div>
            </div>
        </div>
    </div>
</div>


    

    <!-- Tips for Sustainable Living -->
    <div class="row my-4">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-lg">
            <div class="card-header skyblue-header">
                    <h4>Tips for Sustainable Living</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <span class="badge bg-info">Tip 1</span> Turn off lights when not in use.
                        </li>
                        <li class="list-group-item">
                            <span class="badge bg-info">Tip 2</span> Use energy-efficient appliances and LED bulbs.
                        </li>
                        <li class="list-group-item">
                            <span class="badge bg-info">Tip 3</span> Reduce water heating temperatures to save energy.
                        </li>
                        <li class="list-group-item">
                            <span class="badge bg-info">Tip 4</span> Install solar panels for renewable energy.
                        </li>
                        <li class="list-group-item">
                            <span class="badge bg-info">Tip 5</span> Unplug devices when they are not being used.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

   
    <?php
// Assuming a check to identify if the user is a regular user
// Replace this with your actual authentication/authorization check logic
$is_user = true;

if ($is_user) {
    // User functionality
    // Fetch the current laundry status from the database
    $laundry_status = "available"; // This should be dynamically fetched from the database

    // Handle alert functionality
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // User wants to set an alert
        $user_id = 1; // Replace with actual user ID from session
        $alert_message = "User set an alert for laundry availability.";

        // Insert alert into database (you should modify this query based on your database structure)
        // $stmt = $conn->prepare("INSERT INTO laundry_alerts (user_id, alert_message) VALUES (?, ?)");
        // $stmt->bind_param("is", $user_id, $alert_message);
        // $stmt->execute();
        
        echo "<script>alert('You will be notified when the laundry is available!');</script>";
    }
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Laundry Facility Notifications</h2>
    
    <!-- Laundry Facility Status (Available/Occupied) -->
    <div class="row my-4">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-info text-white text-center">
                    <h4>Check Laundry Availability</h4>
                </div>
                <div class="card-body">
                    <p class="text-center">Check the current status of the laundry facility below.</p>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="facilityStatus">Facility Status:</label>
                            <select id="facilityStatus" class="form-select" disabled>
                                <option value="available" <?php echo $laundry_status == 'available' ? 'selected' : ''; ?>>Available</option>
                                <option value="occupied" <?php echo $laundry_status == 'occupied' ? 'selected' : ''; ?>>Occupied</option>
                            </select>
                        </div>
                    </div>

                    <?php if ($laundry_status == 'occupied') { ?>
                        <button class="btn btn-primary mt-3" onclick="setAlert()">Set Alert for Availability</button>
                    <?php } else { ?>
                        <p class="text-success mt-3">The laundry is currently available!</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

  

<?php
}
?>
<?php
// Assuming a check to identify if the user is a regular user
$is_user = true;

if ($is_user) {
    // Handle reporting a lost item
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['report_lost'])) {
        $user_id = 1; // Example, replace with session or actual user ID
        $lost_item_name = $_POST['item_name'];
        $lost_item_description = $_POST['item_description'];

        // Debugging output
        echo "Item Name: " . $lost_item_name;
        echo "Item Description: " . $lost_item_description;

        // Insert lost item into the database
        // Assuming $conn is the database connection
        $stmt = $conn->prepare("INSERT INTO lost_items (user_id, item_name, item_description, status) VALUES (?, ?, ?, 'reported')");
        if ($stmt === false) {
            die('Error in preparing the statement: ' . $conn->error);
        }

        $stmt->bind_param("iss", $user_id, $lost_item_name, $lost_item_description);
        
        if ($stmt->execute()) {
            echo "Lost item reported successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    // Handle search for found items
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search_found'])) {
        $search_query = $_POST['search_query'];

        // Search found items based on the query
        $stmt = $conn->prepare("SELECT * FROM found_items WHERE item_name LIKE ?");
        $stmt->bind_param("s", $search_query);
        $stmt->execute();
        $result = $stmt->get_result();

        echo "<h4>Found Items:</h4>";
        while ($row = $result->fetch_assoc()) {
            echo "<p>" . $row['item_name'] . " - " . $row['item_description'] . "</p>";
        }
    }

    // Fetch lost items from the database
    $stmt = $conn->prepare("SELECT * FROM lost_items WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $lost_items_result = $stmt->get_result();
}
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Lost & Found</h2>
    
    <!-- Report Lost Item -->
    <div class="row my-4">
    <div class="col-md-12">
    <div class="card shadow-lg border-0 rounded-lg">
    <div class="card-header" style="background-color:#00b5ff; color: white; text-align: center;">

                <h4>Report Lost Item</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="itemName">Item Name:</label>
                        <input type="text" id="itemName" name="item_name" class="form-control" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="itemDescription">Item Description:</label>
                        <textarea id="itemDescription" name="item_description" class="form-control" rows="3" required></textarea>
                    </div>
                    <button class="btn btn-primary mt-3" type="submit" name="report_lost">Report Lost Item</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Lost Items Reported by the User -->
<div class="row my-4">
    <div class="col-md-12">
    <div class="card shadow-lg border-0 rounded-lg">
    <div class="card-header" style="background-color:#00b5ff; color: white; text-align: center;">

                <h4>Your Reported Lost Items</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Description</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($lost_item = $lost_items_result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($lost_item['item_name']); ?></td>
                                <td><?php echo htmlspecialchars($lost_item['item_description']); ?></td>
                                <td><?php echo htmlspecialchars($lost_item['status']); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

    <!-- Search Found Items -->
 





    <?php
// Assuming you have already established a database connection and started the session

// Handle feedback submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_feedback'])) {
    // Ensure session has started and user is logged in
    // Make sure the session is started
    if (!isset($_SESSION['user_id'])) {
        echo '<div class="alert alert-danger">You must be logged in to submit feedback.</div>';
        exit;
    }
    
    // Get the user ID from the session and the feedback content from the form
    $user_id = $_SESSION['user_id'];
    $feedback_content = $_POST['feedback_content'];

    // Prepare and execute the insert query
    $stmt = $conn->prepare("INSERT INTO feedback (user_id, feedback_content) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $feedback_content);
    
    if ($stmt->execute()) {
        echo '<div class="alert alert-success">Feedback submitted successfully!</div>';
    } else {
        echo '<div class="alert alert-danger">Error submitting feedback: ' . $stmt->error . '</div>';
    }
}
?>







<div class="container mt-4">
    <h2>Welcome, <?= $_SESSION['username']; ?>!</h2>
    <h4>Current Month: <?= $current_month; ?></h4>

    <div class="card shadow-sm">
        <div class="card-header">Payment Details</div>
        <div class="card-body">
            <?php if ($payment): ?>
                <p>Payment Amount: <?= $payment['amount']; ?></p>
                <p>Status: 
                    <span class="<?= $payment['status'] === 'Pending' ? 'text-warning' : 'text-success'; ?>">
                        <?= $payment['status']; ?>
                    </span>
                </p>

                <?php if ($payment['status'] === 'Pending'): ?>
                    <p>Your payment is awaiting admin approval.</p>
                <?php endif; ?>
            <?php else: ?>
                <p>No payment details found for this month. Please set up your payment.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Only show the Set Up Payment button if no payment is set or payment is still Pending -->
    <?php if (!$payment || $payment['status'] === 'Pending'): ?>
        <a href="set_payment.php" class="btn btn-primary mt-3">Set Up Payment</a>
    <?php endif; ?>
</div>

   

<!-- Feedback Section Container -->
<div class="container mt-5">
    <h2 class="text-center mb-4">Submit Your Feedback</h2>

    <!-- Feedback Form -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-info text-white text-center">
                    <h4>We Value Your Feedback</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="feedbackContent">Your Feedback</label>
                            <textarea id="feedbackContent" name="feedback_content" class="form-control" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="submit_feedback" style="margin-top:10px;">Submit Feedback</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-lg border-0 rounded-lg mb-4">
    <div class="card-header bg-info text-white text-center">
        <h4>Energy Consumption Stats</h4>
    </div>
    <div class="card-body">
        <canvas id="energyChart" style="max-height: 400px; width: 100%;"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Example hardcoded data
    const labels = ["2024-12-01", "2024-12-02", "2024-12-03"];
    const data = [150, 200, 250];

    // Create the chart
    const ctx = document.getElementById('energyChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Energy Consumption (kWh)',
                data: data,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Date'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Consumption (kWh)'
                    }
                }
            }
        }
    });
</script>
<script>
function logout() {
    // Optional: Clear session storage or local storage if needed
    sessionStorage.clear(); 
    localStorage.clear();

    // Redirect to login page
    window.location.href = "login.php";
}
</script>
<script>
    let lastScrollTop = 0;
const logoutButton = document.querySelector('.logout-button');

window.addEventListener('scroll', function() {
    let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    
    if (scrollTop > lastScrollTop) {
        // Scrolling down
        logoutButton.classList.add('hidden');
    } else {
        // Scrolling up
        logoutButton.classList.remove('hidden');
    }
    
    lastScrollTop = scrollTop;
});

</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
