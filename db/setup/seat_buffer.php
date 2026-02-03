<?php
$sql = "CREATE TABLE IF NOT EXISTS seat_buffer (
  id INT PRIMARY KEY AUTO_INCREMENT,
  seats INT NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table seat_buffer created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}