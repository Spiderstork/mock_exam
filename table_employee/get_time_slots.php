<?php
include '../db/connect_db.php';

$arrive_date = $_GET['arrive_date'] ?? '';
if (!$arrive_date) {
    echo json_encode([]);
    exit;
}

$day_of_week = date('N', strtotime($arrive_date));

$sql = "SELECT id, start_time, end_time FROM time_slot WHERE day_of_week = ? AND removed = 0 ORDER BY start_time ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $day_of_week);
$stmt->execute();
$result = $stmt->get_result();
$time_slots = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($time_slots);
?>