<?php
include "check_title.php";
include '../db/connect_db.php';
    var_dump($_POST);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {

    echo "<pre>POST data:\n";
    print_r($_POST);
    echo "</pre>";

    $edit_id      = (int)$_POST['edit_id'];
    $booking_name = $_POST['booking_name'];
    $email        = $_POST['email'];
    $seats        = (int)$_POST['seats'];
    $arrive_date  = $_POST['arrive_date'];
    $canceled = isset($_POST['canceled']) ? 1 : 0;
    $timeslot_id  = (int)$_POST['timeslot_id'];

    $stmt = $conn->prepare("
        SELECT t.id 
        FROM table_ t
        WHERE t.max_seats >= ?
          AND t.id NOT IN (
              SELECT b.table_id
              FROM booking b
              WHERE b.arive_date = ?
                AND b.timeslot_id = ?
                AND b.id != ?
          )
        ORDER BY t.max_seats ASC
        LIMIT 1
    ");
    $stmt->bind_param("isii", $seats, $arrive_date, $timeslot_id, $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $table = $result->fetch_assoc();
        $new_table_id = $table['id'];

        $stmt = $conn->prepare("
            SELECT user_id 
            FROM booking_bridge 
            WHERE booking_id = ?
        ");
        $stmt->bind_param("i", $edit_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $bridge = $res->fetch_assoc();
        $customer_id = $bridge['user_id'] ?? null;

        if (!$customer_id) {
            echo "<p style='color:red;'>Customer not found for this booking!</p>";
            exit;
        }

        $updateBooking = $conn->prepare("
            UPDATE booking
            SET seats = ?, table_id = ?, arive_date = ?, timeslot_id = ?, canceled = ?
            WHERE id = ?
        ");
        $updateBooking->bind_param("iisiii", $seats, $new_table_id, $arrive_date, $timeslot_id,$canceled, $edit_id);
        $updateBooking->execute();

        $updateCustomer = $conn->prepare("
            UPDATE customer
            SET booking_name = ?, email = ?
            WHERE id = ?
        ");
        $updateCustomer->bind_param("ssi", $booking_name, $email, $customer_id);
        $updateCustomer->execute();

        echo "<p style='color:green;'>Booking and customer updated successfully!</p>";

        echo "<button  action='booking.php' >-></button>";
        exit();
    } else {
        echo "<p style='color:red;'>No available table for this timeslot and seat amount.</p>";
    }
}