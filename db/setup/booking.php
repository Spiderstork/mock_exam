<?php
$sql = "CREATE TABLE IF NOT EXISTS booking(
  id INT PRIMARY KEY AUTO_INCREMENT,
  timeslot INT NOT NULL,
  booked_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  arived BOOLEAN DEFAULT FALSE,
  canceled BOOLEAN DEFAULT FALSE,
  seats INT NOT NULL,
  table_id INT NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table booking created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}