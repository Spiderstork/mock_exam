<?php

include "check_title.php";
include '../db/connect_db.php';
// Fetch all active bookings
$sql = "
SELECT *, booking.id AS edit_id
FROM booking
INNER JOIN booking_bridge ON booking.id = booking_bridge.booking_id
INNER JOIN customer ON booking_bridge.user_id = customer.id
INNER JOIN time_slot ON booking.timeslot_id = time_slot.id
INNER JOIN table_ ON booking.table_id = table_.id
ORDER BY arive_date ASC, start_time ASC
";

$result = $conn->query($sql);

$date = null;

while ($row = $result->fetch_assoc()) {
    if (!$row["arived"] == 1){
        echo '</div>';
    }

    if ($date != $row["arive_date"]) {
        echo "<h3>" . htmlspecialchars($row["arive_date"]) . "</h3>";
        $date = $row["arive_date"];
    }
    if ($row["canceled"] == 1){
        echo '<div style="color: red;">';
    }
    if ($row["arived"] == 1){
        echo '<div style="color: green;">';
    }
    echo "NAME: " . htmlspecialchars($row["booking_name"]) . 
         " | TIME: " . htmlspecialchars($row["start_time"]) . 
         " - " . htmlspecialchars($row["end_time"]). 
         " | SEATS: " . htmlspecialchars($row["seats"]). 
         " | TABLE: " . htmlspecialchars($row["table_id"]);

    // Edit button posts to booking_edit.php
    echo '
        <form action="booking_edit.php" method="POST" style="display:inline-block;margin:5px;">
            <input type="hidden" name="edit_id" value="' . htmlspecialchars($row['edit_id']) . '">
            <input type="hidden" name="booking_name" value="' . htmlspecialchars($row['booking_name']) .'">
            <input type="hidden" name="email" value="' . htmlspecialchars($row['email']) . '">
            <input type="hidden" name="arrive_date" value="' . htmlspecialchars($row['arive_date']) . '">
            <input type="hidden" name="seats" value="' . htmlspecialchars($row['seats']) . '">
            <input type="hidden" name="max_seats" value="' . htmlspecialchars($row['max_seats']) . '">
            <input type="hidden" name="timeslot_id" value="' . htmlspecialchars($row['timeslot_id']) . '">
            <input type="hidden" name="start_time" value="' . htmlspecialchars($row['start_time']) . '">
            <input type="hidden" name="end_time" value="' . htmlspecialchars($row['end_time']) . '">
            <input type="hidden" name="canceled" value="' . htmlspecialchars($row['canceled']) . '">
            <button type="submit">Edit</button>
        </form>
    ';
    echo '
        <form action="arrived.php" method="POST" style="display:inline-block;margin:5px;">
            <input type="hidden" name="edit_id" value="' . htmlspecialchars($row['edit_id']) . '">
            <input type="hidden" name="arrived" value="1">
            <button type="submit">arrived</button>
        </form>
    ';
    if ($row["canceled"] == 1){
        echo 'canceld</div>';
    }
    echo"<br>";
}
?>