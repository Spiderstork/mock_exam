<?php
$sql = "CREATE TABLE IF NOT EXISTS table_(
  id INT PRIMARY KEY AUTO_INCREMENT,
  max_seats INT NOT NULL,
  removed BOOLEAN DEFAULT FALSE
)";

if ($conn->query($sql) === TRUE) {
    echo "Table table_ created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}