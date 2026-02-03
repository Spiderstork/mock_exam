<?php
$sql = "CREATE TABLE IF NOT EXISTS opening_hours (
  id INT PRIMARY KEY AUTO_INCREMENT,
  day_of_week INT,   # 0=Sunday, 1=Monday ... 6=Saturday
  open_time time,
  close_time time,
  is_closed BOOLEAN DEFAULT FALSE
)";

if ($conn->query($sql) === TRUE) {
    echo "Table opening_hours created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}