<?php
session_start();

if ($_SESSION['admin_portal'] != 1) {
    header("Location: ../sign_in/sign_in.php");
    exit();
}else{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = (int)$_POST['edit_id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $table_portal = $_POST['table'];
        $food_portal = $_POST['food'];
        $admin_portal = $_POST['admin'];
        $banned = $_POST['banned'];
        echo "name: $name<br>";
        echo "email: $email<br>";

        echo "<form action='employe_portal.php' method='POST'>";
        echo "<input type='hidden' name='edit_id' value='$id'>";
        echo "<input type='text' name='name' value='$name'>";
        echo "<input type='email' name='email' value='$email'>";
        echo "<label><input name='table' type='checkbox' " . ($table_portal ? "checked" : "") . "> Table Portal</label>";
        echo "<label><input name='food' type='checkbox' " . ($food_portal ? "checked" : "") . "> Food Portal</label>";
        echo "<label><input name='admin' type='checkbox' " . ($admin_portal ? "checked" : "") . "> Admin Portal</label>";   
        echo "<label><input name='banned' type='checkbox' " . ($banned ? "checked" : "") . "> Banned</label>";
        echo "<button type='submit' name='edit'>Submit</button>";
        echo "</form>";
    }
}