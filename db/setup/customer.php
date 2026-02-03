<?php
$sql = "CREATE TABLE IF NOT EXISTS customer(
  id INT PRIMARY KEY AUTO_INCREMENT,
  booking_name VARCHAR(100) NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table customer created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}