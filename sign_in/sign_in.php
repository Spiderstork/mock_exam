<?php
include '../db/connect_db.php';

echo "<form method='POST'>
    <input name='email' id='email' placeholder='Email' required>
    <input name='password' id='password' placeholder='Password' type='password' required>
    <button id='sign_in' type='submit'>Sign In</button>
</form>";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM employee WHERE email = ? and banned = 0";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $employee = $result->fetch_assoc();

        if (password_verify($password, $employee['pass'])) {
            session_start();
            $_SESSION['employee_id'] = $employee['id'];
            $_SESSION['table_portal'] = $employee['table_portal'];
            $_SESSION['food_portal'] = $employee['food_portal'];
            $_SESSION['admin_portal'] = $employee['admin_portal'];
            echo "Welcome, " . htmlspecialchars($employee['username']) . "!";
            header("Location: dash_board.php");
            exit();
        } else {
            echo "Invalid email or password.";
        }
    } else {
        echo "Invalid email or password.";
    }
}
