<?php
include "db/connect_db.php";

$day = isset($_GET['day']) ? intval($_GET['day']) : -1;

if ($day >= 0) {
    $sql = "SELECT * FROM time_slot WHERE day_of_week = ? AND removed = 0 ORDER BY start_time ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $day);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($time = $result->fetch_assoc()) {
            $time_id = $time['id'];
            $start = $time['start_time'];
            $end = strtotime($time['end_time']);

            echo "<div id='time_slot_$time_id' 
                    class='time_slot' 
                    data-time-id='$time_id' 
                    data-start-time='$start' 
                    data-end-time='" . date('H:i:s', $end) . "'>";
            echo date('H:i', strtotime($start)) . " - " . date('H:i', $end);
            echo "</div>";
        }

        echo "</div>";
} else {
    echo "Invalid day parameter.";
}
}
?>

<style>
        .time_slot_box{
            background: #020617;
            color: white;
            padding: 20px;
            border-radius: 8px;
            max-width: 280px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;

            display: flex;      
            flex-wrap: wrap;   
            gap : 10px;   
            align-items: flex-start;     
            justify-content: flex-start;  
        }
        .time_slot{
            background: #020617;
            border: none;
            color: white;
            padding: 10px 15px;
            margin: 5px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            max-width: 100px;     
            text-align: center;
            text: bold;
        }
        .time_slot:hover {
        background: #1e293b;
        }

        .selected_time_slot {
            background: #2563eb;
            border: none;
            color: white;
            padding: 10px 15px;
            margin: 5px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            max-width: 100px;     
            text-align: center;
            text: bold;
        }
</style>