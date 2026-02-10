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

$sql = "INSERT INTO opening_hours (day_of_week, open_time, close_time, is_closed) VALUES
    (1, '09:00:00', '17:00:00', FALSE),
    (2, '09:00:00', '17:00:00', FALSE),
    (3, '09:00:00', '17:00:00', FALSE),
    (4, '09:00:00', '17:00:00', FALSE),
    (5, '09:00:00', '17:00:00', FALSE),
    (6, '10:00:00', '16:00:00', FALSE),
    (7, '10:00:00', '16:00:00', TRUE)
    ";

if ($conn->query($sql) === TRUE) {
    echo "Table opening_hours created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}