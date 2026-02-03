<?php
$sql = "CREATE TABLE IF NOT EXISTS time_slot (
  id INT PRIMARY KEY AUTO_INCREMENT,
  date_ DATE NOT NULL,
  start_time TIME NOT NULL,
  end_time TIME NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table time_slot created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}