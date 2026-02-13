<?php
session_start();

if (!isset($_SESSION['employee_id'])) {
    header("Location: ../sign_in/sign_in.php");
    exit();
}else{
    include '../db/connect_db.php';

    echo "<form  method='POST'>
        <input name='last_password' id='last_password' placeholder='Current Password' type='password' required>
        <input name='password' id='password' placeholder='New Password' type='password' required>
        <input name='confirm_password' id='confirm_password' placeholder='Confirm Password' type='password' required>
        <button id='edit_password' type='submit'>Change Password</button>
    </form>";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $last_password = $_POST['last_password'];
        $id = $_SESSION['employee_id'];
        
        $sql = "SELECT pass FROM employee WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $employee = $result->fetch_assoc();

        if ($result->num_rows === 0) {
            echo "User not found.";
            exit;
        }

        if (!password_verify($last_password, $employee['pass'])) {
            echo "Incorrect current password.";
            exit();
        }

        if ($_POST['password'] !== $_POST['confirm_password']) {
            echo "Passwords do not match.";
            exit();
        }

        $new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $sql = "UPDATE employee SET pass = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $new_password, $id);

        if ($stmt->execute()) {
            echo "<p style='color: green;'>Password updated successfully.</p>";
        } else {
            echo "Error updating password: " . $conn->error;
        }
    }
}