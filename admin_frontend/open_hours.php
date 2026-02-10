<?php
include "../db/connect_db.php";
 function show() {
    global $conn;

    $sql = "SELECT * FROM opening_hours";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($day = $result->fetch_assoc()) {
            $start_time = $day['open_time'];
            $end_time = $day['close_time'];
            $closed = $day['is_closed'];
            $day_of_week_num = $day['day_of_week'];
            $day_id = $day['id'];

            $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday","Sunday"];
            $day_of_week = $days[$day_of_week_num-1];

            echo "<div>";
            echo "Day: $day_of_week | Open: $start_time | Close: $end_time | Closed: " . ($closed ? "Yes" : "No");

            echo '
                <form action="edit_opening_hours.php" method="POST" style="display:inline">
                    <input type="hidden" name="edit_id" value="' . htmlspecialchars($day_id) . '">
                    <input type="hidden" name="day_of_week" value="' . htmlspecialchars($day_of_week) . '">
                    <input type="hidden" name="open_time" value="' . htmlspecialchars($start_time) . '">
                    <input type="hidden" name="close_time" value="' . htmlspecialchars($end_time) . '">
                    <input type="hidden" name="closed" value="' . htmlspecialchars($closed) . '">
                    <button type="submit">Edit</button>
                </form>
            ';
        }
    }
}
function edit($id, $open_time, $close_time, $is_closed) {
    global $conn;

    $is_closed = $is_closed ? 1 : 0; 

    $sql = "UPDATE opening_hours 
            SET open_time = '$open_time', 
                close_time = '$close_time', 
                is_closed = $is_closed 
            WHERE id = '$id'";

    if ($conn->query($sql) !== TRUE) {
        echo "Error editing opening hours: " . $conn->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['edit'])) {
        edit((int)$_POST['edit_id'], $_POST['open_time'], $_POST['close_time'], $_POST['closed'] ?? false);
    }
}
show();
?>
