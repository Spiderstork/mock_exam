<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Epicurean_Themes_aqutic";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>