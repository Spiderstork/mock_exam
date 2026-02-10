<?php
$sql = "CREATE TABLE IF NOT EXISTS time_slot (
  id INT PRIMARY KEY AUTO_INCREMENT,
  day_id INT NOT NULL,
  day_of_week INT NOT NULL,
  start_time TIME NOT NULL,
  end_time TIME NOT NULL,
  removed BOOLEAN DEFAULT FALSE
)";

if ($conn->query($sql) === TRUE) {
    echo "Table time_slot created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}