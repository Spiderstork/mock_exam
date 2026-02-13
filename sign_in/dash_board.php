<?php
session_start();
if (!isset($_SESSION['employee_id'])) {
    header("Location: ../sign_in/sign_in.php");
    exit();
} else {
    if ($_SESSION['admin_portal'] == 1) {
        echo "<button onclick=\"window.location.href='../admin_frontend/employe_portal.php'\">Employee Portal</button>";
        echo "<button onclick=\"window.location.href='../admin_frontend/open_hours.php'\">Opening Hours</button>";
    } else if ($_SESSION['table_portal'] == 1) {
    } else if ($_SESSION['food_portal'] == 1) {
    } else {
        echo "You do not have access to any portals.";
    }
}