<?php
$sql = "CREATE TABLE IF NOT EXISTS menu (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255),
  about TEXT,
  special BOOLEAN DEFAULT FALSE,
  removed BOOLEAN DEFAULT FALSE,
  verticle_picture varchar(255),
  horozontial_picture varchar(255),
  price INT
)";

if ($conn->query($sql) === TRUE) {
    echo "Table menu created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}