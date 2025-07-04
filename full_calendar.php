<?php
// Include the database connection file
include 'db_connection.php'; // This will define $conn

// Get the current month and year, or retrieve from URL parameters
$month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');
$month_start = "{$month}-01";
$year = date('Y', strtotime($month_start));
$month_num = date('m', strtotime($month_start));

// Get events from the 'community_events' table
$query = "SELECT * FROM community_events WHERE event_date BETWEEN '{$year}-01-01' AND '{$year}-12-31' ORDER BY event_date";
$events_result = mysqli_query($conn, $query); // Use $conn here
$events = [];

while ($event = mysqli_fetch_assoc($events_result)) {
    $events[$event['event_date']][] = [
        'event_name' => $event['event_name'],
        'event_description' => $event['event_description']
    ];
}

// Calculate next and previous months
$next_month = date('Y-m', strtotime("+1 month", strtotime($month_start)));
$prev_month = date('Y-m', strtotime("-1 month", strtotime($month_start)));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Calendar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Add custom styles for the calendar */
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            grid-gap: 10px;
            margin-top: 20px;
        }

        .calendar-cell {
            text-align: center;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .calendar-cell.event-day {
            background-color: #f0ad4e;
            color: white;
        }

        .day-card {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .event-details {
            margin-top: 10px;
            font-size: 12px;
            color: #333;
        }

        .event-name {
            font-weight: bold;
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

<div class="container mt-5">
    <h3 class="text-center mb-4">Community Calendar</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">
                <!-- Calendar Header -->
                <div class="col-12 text-center mb-4">
                    <h4><?php echo date('F Y', strtotime($month_start)); ?></h4>
                    <p class="text-muted">Upcoming Events and Activities</p>
                </div>
            </div>

            <!-- Calendar Grid -->
            <div class="calendar-grid">
                <?php
                // Get the first day of the month (to calculate the starting day for the calendar)
                $first_day_of_month = date('w', strtotime($month_start)); // Get the weekday of the first day
                $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month_num, $year); // Get the number of days in the month

                // Create the empty grid cells before the 1st
                for ($i = 0; $i < $first_day_of_month; $i++) {
                    echo "<div class='calendar-cell'></div>";
                }

                // Loop through each day of the month
                for ($current_day = 1; $current_day <= $days_in_month; $current_day++) {
                    $current_date = "{$year}-{$month_num}-" . str_pad($current_day, 2, "0", STR_PAD_LEFT);
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
                    echo "<div class='calendar-cell {$highlight_class}'>
                            <div class='card day-card'>
                                <div class='card-body'>{$event_html}</div>
                            </div>
                          </div>";

                    // Create a new row after Saturday (7th day)
                    if (date('w', strtotime($current_date)) == 6) {
                        echo "</div><div class='calendar-grid'>";
                    }
                }

                // Fill the remaining empty cells if needed
                $remaining_cells = 7 - ((date('w', strtotime($current_date)) + 1) % 7);
                for ($i = 0; $i < $remaining_cells; $i++) {
                    echo "<div class='calendar-cell'></div>";
                }
                ?>
            </div>

            <!-- Button to view full calendar -->
            <div class="text-center mt-4">
                <a href="full_calendar.php?month=<?php echo $next_month; ?>" class="btn btn-primary">Next Month</a>
                <a href="full_calendar.php?month=<?php echo $prev_month; ?>" class="btn btn-primary">Previous Month</a>
                <button onclick="goBack()" class="back-button" right:50px>Back</button>
            </div>
        </div>
    </div>
</div>
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
