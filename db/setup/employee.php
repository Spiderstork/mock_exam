<?php
$sql = "CREATE TABLE IF NOT EXISTS employee (
  id INT PRIMARY KEY AUTO_INCREMENT,
  username varchar(50),
  email varchar(100) unique,
  pass varchar(255),
  table_portal boolean DEFAULT FALSE,
  food_portal boolean DEFAULT FALSE,
  admin_portal boolean DEFAULT FALSE,
  banned boolean DEFAULT FALSE
)";

if ($conn->query($sql) === TRUE) {
    echo "Table employee created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}