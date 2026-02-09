<?php
session_start();
include 'db/connect_db.php';
    $booking_id = $_SESSION['booking_id'];

    // Update the booking status to 'cancelled'
    $stmt = $conn->prepare("
        UPDATE booking SET canceled = True WHERE id = ?
    ");

    $stmt->bind_param("i", $booking_id);
    if ($stmt->execute()) {
        echo "Booking cancelled successfully.";
    } else {
        echo "Error cancelling booking: " . $stmt->error;
    }

    $stmt->close();