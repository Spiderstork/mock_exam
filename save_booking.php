<?php
session_start();
include 'db/connect_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $time_slot_id = $_POST['time_slot_id'];
    $people_count = $_POST['people_count'];

    if ($date < date("Y-m-d")) {
        echo "Invalid date. Please select a future date.";
        echo '<button onclick="window.history.back()">Go Back</button>';
        exit;
    }
    if ($people_count <= 0) {
        echo "No table available for $people_count people";
        echo '<button onclick="window.history.back()">Go Back</button>';
        exit;
    }


    $stmt = $conn->prepare("
        SELECT id
        FROM table_
        WHERE id NOT IN (
        SELECT table_id
        FROM booking
        WHERE (arive_date =  ?
            AND timeslot_id = ?) and canceled IS NOT TRUE
        ) and max_seats >= ?;
    ");

    $stmt->bind_param("sii", $date, $time_slot_id, $people_count);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $table = $result->fetch_assoc();
        $table_id = $table['id'];

    } else {
        echo "No table available for $people_count people";
        echo '<button onclick="window.history.back()">Go Back</button>';
        exit;
    }
    echo "ham";

    $sql = "INSERT INTO booking (arive_date, timeslot_id, seats, table_id)
    values ('$date', '$time_slot_id', '$people_count', '$table_id')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['booking_id'] = $conn->insert_id;
        $_SESSION['timer_end'] = time() + 10*60; 
        header("Location: payment.php");
        exit();
    } else {
        echo "Error saving booking: " . $conn->error;
        echo '<button onclick="window.history.back()">Go Back</button>';
    }
    
} else {
}
?>