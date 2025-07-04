<?php
include 'db_connection.php';
require('fpdf.php');
// Ensure you have the FPDF library

if (isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];

    // Fetch booking details from database
    $query = "SELECT b.*, f.name AS facility_name, u.username 
              FROM bookings b 
              JOIN facilities f ON b.facility_id = f.id
              JOIN users u ON b.user_id = u.id
              WHERE b.id = '$booking_id'";
    
    $result = $conn->query($query);
    $booking = $result->fetch_assoc();

    if ($booking) {
        // Create a new PDF instance
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(40, 10, 'Booking Receipt');
        $pdf->Ln(10);

        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(40, 10, "Booking ID: " . $booking['id']);
        $pdf->Ln();
        $pdf->Cell(40, 10, "Facility: " . $booking['facility_name']);
        $pdf->Ln();
        $pdf->Cell(40, 10, "Booking Date: " . $booking['booking_date']);
        $pdf->Ln();
        $pdf->Cell(40, 10, "Start Time: " . $booking['start_time']);
        $pdf->Ln();
        $pdf->Cell(40, 10, "End Time: " . $booking['end_time']);
        $pdf->Ln();
        $pdf->Cell(40, 10, "Status: " . ucfirst($booking['status']));

        // Output PDF to browser
        $pdf->Output('D', 'Booking_Receipt_' . $booking_id . '.pdf');
    }
}
?>
