<?php
include "../db/connect_db.php";

function show() {
    global $conn;
    $sql = "SELECT * FROM table_ WHERE removed IS NOT TRUE";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($table = $result->fetch_assoc()) {
            $table_id = $table['id'];
            $seats = $table['max_seats'];

            echo "<div id=\"$table_id\">";
            echo "Table: $table_id | Seats: $seats";
            echo "</div>";
        }
    }
}


function add($amount) {
    global $conn;
    $sql = "INSERT INTO table_ (max_seats) VALUES ('$amount')";
    if ($conn->query($sql) !== TRUE) {
        echo "Error saving table: " . $conn->error;
    }
}


// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $amount = $_POST['amount'];
    add($amount);
}
show();
?>

<form method="POST">
    <input name="amount" id="amount">
    <button type="submit">Submit</button>
</form>
