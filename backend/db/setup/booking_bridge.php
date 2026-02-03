<?php
$sql = "CREATE TABLE IF NOT EXISTS booking_bridge(
  user_id INT NOT NULL,
  booking_id INT NOT NULL,
  employee_id INT 
)";

if ($conn->query($sql) === TRUE) {
    echo "Table booking_bridge created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}