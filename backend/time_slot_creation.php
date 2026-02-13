<?php
include '../db/connect_db.php';
function create_time_slots(){
    global $conn;
    // Slot duration in seconds (1.5 hours)
    $slot_duration = 90 * 60;

    // Array to hold all slots
    $all_slots = [];

    $sql = "UPDATE time_slot SET removed = 1"; 
    $result = $conn->query($sql);
    if (!$result) {
        echo "Error updating time slots: " . $conn->error;
        return;
    }


    // Fetch all open days
    $sql = "SELECT * FROM opening_hours WHERE is_closed IS NOT TRUE";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($day = $result->fetch_assoc()) {
            $day_id = $day['id'];
            $day_of_week = $day['day_of_week'];
            $open_time = strtotime($day['open_time']);
            $close_time = strtotime($day['close_time']);

            $slot_start = $open_time;

            while ($slot_start < $close_time) {
                $slot_end = $slot_start + $slot_duration;
                if ($slot_end > $close_time) {
                    $slot_end = $close_time;
                }

                $all_slots[] = [
                    'day_id' => $day_id,
                    'day_of_week' => $day_of_week,
                    'start_time' => date('H:i:s', $slot_start),
                    'end_time' => date('H:i:s', $slot_end),
                ];

                $slot_start = $slot_end;
            }
        }
    }

    $insert_sql = $conn->prepare("INSERT INTO time_slot (day_id, day_of_week, start_time, end_time, removed) VALUES (?, ?, ?, ?, 0)");
    foreach ($all_slots as $slot) {
        $insert_sql->bind_param(
            "iiss",
            $slot['day_id'],
            $slot['day_of_week'],
            $slot['start_time'],
            $slot['end_time']
        );
        if (!$insert_sql->execute()) {
            echo "Error inserting slot: " . $insert_sql->error;
        }
    }
echo "<p style='color: green;'>Time slots created/updated successfully.</p>";
}
?>