<?php
session_start();

if ($_SESSION['admin_portal'] != 1) {
    header("Location: ../sign_in/sign_in.php");
    exit();
}else{
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $id = (int)$_POST['edit_id'];
        $day_of_week = $_POST['day_of_week'];
        $open_time = $_POST['open_time'];
        $close_time = $_POST['close_time'];
        $closed = $_POST['closed'] ? 1 : 0;

        echo "id: $id<br>";
        echo "day_of_week: $day_of_week<br>";

        echo "<form action='open_hours.php' method='POST'>";
        echo "<input type='hidden' name='edit_id' value='$id'>";
        echo "<input type='time' name='open_time' value='$open_time'>";
        echo "<input type='time' name='close_time' value='$close_time'>";
        echo "<input name= 'closed' type='checkbox' " . ($closed ? "checked" : "") . "> closed";
        echo "<button type='submit' name='edit'>Submit</button>";
        echo "</form>";
    }
}