<?php
include "head.html";
include "db/connect_db.php";

$sql = "SELECT * FROM menu WHERE removed = 0 LIMIT 10";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {

    echo "<div class='carousel rounded-box'>";

    while ($row = $result->fetch_assoc()) {

        echo "
        <div class='carousel-item flex flex-col items-center p-4'>
            <img
                src='uploads/" . htmlspecialchars($row['verticle_picture']) . "'
                alt='" . htmlspecialchars($row['item_name']) . "'
                class='w-64 h-80 object-cover rounded-lg'
            />

            <h2 class='font-bold mt-2'>
                " . htmlspecialchars($row['item_name']) . "
            </h2>
        </div>
        ";
    }

    echo "</div>";

} else {
    echo "No menu items available.";
}
?>