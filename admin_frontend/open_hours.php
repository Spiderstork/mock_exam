<?php
session_start();

if ($_SESSION['admin_portal'] != 1) {
    header("Location: ../sign_in/sign_in.php");
    exit();
}else{
    include "../db/connect_db.php";
    include "../backend/time_slot_creation.php";

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
                SET open_time = ? , 
                    close_time = ? , 
                    is_closed = ? 
                WHERE id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssii", $open_time, $close_time, $is_closed, $id);

        if (!$stmt->execute()) {
            echo "Error editing opening hours: " . $stmt->error;
        }else { 
            create_time_slots();
        }
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST['edit'])) {
            edit((int)$_POST['edit_id'], $_POST['open_time'], $_POST['close_time'], $_POST['closed'] ?? false);
        }
    }
    show();
}
?>
