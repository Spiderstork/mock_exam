<?php
include "check_title.php";
include '../db/connect_db.php';
    var_dump($_POST);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['arrived'])) {


    $edit_id      = (int)$_POST['edit_id'];

    // Update the booking to mark it as arrived
    $sql = "UPDATE booking SET arived = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $edit_id);
    if ($stmt->execute()) {
        echo "<p style='color: green;'>Booking marked as arrived.</p><br>";
    } else {
        echo "Error updating booking: " . $stmt->error;
    }
    header("Location: booking.php");
}