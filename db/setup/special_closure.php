<?php
$sql = "CREATE TABLE IF NOT EXISTS special_closure (
  id INT PRIMARY KEY AUTO_INCREMENT,
  date_ DATE NOT NULL,
  reason VARCHAR(255),
  closed BOOLEAN DEFAULT FALSE
)";

if ($conn->query($sql) === TRUE) {
    echo "Table special_closure created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}