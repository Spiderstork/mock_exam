<?php
session_start();

if ($_SESSION['admin_portal'] != 1) {
    header("Location: ../sign_in/sign_in.php");
    exit();
}else{
    include "../db/connect_db.php";

    function show() {
        global $conn;
        $sql = "SELECT * FROM table_ WHERE removed IS NOT TRUE";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($table = $result->fetch_assoc()) {
                $table_id = $table['id'];
                $seats = $table['max_seats'];

                echo "<div>";
                echo "Table: $table_id | Seats: $seats";

                echo "
                    <form method='POST' style='display:inline'>
                        <input type='hidden' name='remove_id' value='$table_id'>
                        <button type='submit'>Remove</button>
                    </form>
                ";
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
    function remove($id) {
        global $conn;
        $sql = "UPDATE table_ SET removed = TRUE WHERE id = '$id'";
        if ($conn->query($sql) !== TRUE) {
            echo "Error removing table: " . $conn->error;
        }
    }


    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST['amount'])) {
            add((int)$_POST['amount']);
        }

        if (isset($_POST['remove_id'])) {
            remove((int)$_POST['remove_id']);
        }
    }
    show();
}
?>

<form method="POST">
    <input name="amount" id="amount">
    <button type="submit">Submit</button>
</form>
