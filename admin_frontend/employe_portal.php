<?php
session_start();

if ($_SESSION['admin_portal'] != 1) {
    header("Location: ../sign_in/sign_in.php");
    exit();
}else{
include '../db/connect_db.php';

function show(){
    global $conn;
    $sql = "SELECT * FROM employee ORDER BY banned ASC;";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($employee = $result->fetch_assoc()) {
            echo "Name: " . $employee['username'] . " | Email: " . $employee['email'] . " | Table: " . $employee['table_portal'] . " | menu: " . $employee['food_portal'] . " | Admin: " . $employee['admin_portal'] . " | Banned: " . $employee['banned'];

            echo '
                    <form action="employee_edit.php" method="POST" style="display:inline">
                        <input type="hidden" name="edit_id" value="' . htmlspecialchars($employee['id']) . '">
                        <input type="hidden" name="name" value="' . htmlspecialchars($employee['username']) . '">
                        <input type="hidden" name="email" value="' . htmlspecialchars($employee['email']) . '">
                        <input type="hidden" name="table" value="' . htmlspecialchars($employee['table_portal']) . '">
                        <input type="hidden" name="food" value="' . htmlspecialchars($employee['food_portal']) . '">
                        <input type="hidden" name="admin" value="' . htmlspecialchars($employee['admin_portal']) . '">
                        <input type="hidden" name="banned" value="' . htmlspecialchars($employee['banned']) . '">
                        <button type="submit">Edit</button>
                    </form>
                    <br>
                ';
        }
    } else {
        echo "<p style='color: red;'>No employees found.</p>";
    }
    echo "<button id='add_employee_button'>Add Employee</button>";
}

function edit($id, $name, $email, $table_portal, $food_portal, $admin_portal, $banned) {
    global $conn;

    $table_portal = $table_portal ? 1 : 0;
    $food_portal = $food_portal ? 1 : 0;
    $admin_portal = $admin_portal ? 1 : 0;
    $banned = $banned ? 1 : 0;

    $stmt = $conn->prepare("
        UPDATE employee 
        SET 
            username = ?, 
            email = ?, 
            table_portal = ?, 
            food_portal = ?, 
            admin_portal = ?, 
            banned = ?
        WHERE id = ?
    ");

    $stmt->bind_param(
        "ssiiiii",
        $name,
        $email,
        $table_portal,
        $food_portal,
        $admin_portal,
        $banned,
        $id
    );

    if (!$stmt->execute()) {
        echo "Error editing employee: " . $stmt->error;
    } else {
        echo "<p style='color: green;'>Employee updated successfully.</p><br>";
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['edit'])) {
        edit((int)$_POST['edit_id'], $_POST['name'], $_POST['email'], $_POST['table'] ?? 0, $_POST['food'] ?? 0, $_POST['admin'] ?? 0, $_POST['banned'] ?? 0);
    }
    if (isset($_POST['new_employee'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $table_portal = isset($_POST['table']) ? 1 : 0;
        $food_portal = isset($_POST['food']) ? 1 : 0;
        $admin_portal = isset($_POST['admin']) ? 1 : 0;
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO employee (username, email, table_portal, pass, food_portal, admin_portal) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssisii", $name, $email, $table_portal, $password, $food_portal, $admin_portal);

        if ($stmt->execute()) {
            echo "<p style='color: green;'>New employee added successfully.</p><br>";
        } else {
            echo "Error adding employee: " . $stmt->error;
        }
    }
}
show();
}
?>

<form id="new_employee_form" method="POST" style="display:none;">
    <input name="name" id="name" placeholder="Name">
    <input name="email" id="email" placeholder="Email">
    <label><input name="table" type="checkbox"> Table Portal</label>
    <label><input name="food" type="checkbox"> Food Portal</label>
    <label><input name="admin" type="checkbox"> Admin Portal</label>   
    <input name="password" id="password" placeholder="Password" type="password">
    <button name="new_employee" type="submit">Submit</button>
</form>

<script>
    document.getElementById('add_employee_button').addEventListener('click', function() {
        this.style.display = 'none';
        document.getElementById('new_employee_form').style.display = 'block';
    });
</script> 