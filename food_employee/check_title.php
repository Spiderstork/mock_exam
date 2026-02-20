<?php
session_start();
if ($_SESSION['admin_portal'] != 1 & $_SESSION["food_portal"] != 1) {
    header("Location: ../sign_in/sign_in.php");
    exit();
}
