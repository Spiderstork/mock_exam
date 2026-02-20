<?php
include "check_title.php";
include '../db/connect_db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['edit'])) {
        edit((int)$_POST['edit_id'], $_POST['name'], $_POST['email'], $_POST['table'] ?? 0, $_POST['food'] ?? 0, $_POST['admin'] ?? 0, $_POST['banned'] ?? 0);
    }
    if (isset($_POST['new_item'])) {
        $name = $_POST['name'];
        $about= $_POST['about'];
        $price= $_POST['price'];
        $special = isset($_POST['special']) ? 1 : 0;
        $verticle_picture = $_POST['verticle_picture'];
        $horozontial_picture= $_POST['horozontial_picture'];
        $verticle = $_FILES['verticle_picture'];
        move_uploaded_file($verticle['tmp_name'], 'uploads/' . $verticle['name']);
        $horozontial_picture = $_FILES['verticle_picture'];
        move_uploaded_file($horozontial_picture['tmp_name'], 'uploads/' . $horozontial_picture['name']);

        $stmt = $conn->prepare("INSERT INTO menu (username, email, table_portal, pass, food_portal, admin_portal) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssisii", $name, $email, $table_portal, $password, $food_portal, $admin_portal);

        if ($stmt->execute()) {
            echo "<p style='color: green;'>New employee added successfully.</p><br>";
        } else {
            echo "Error adding employee: " . $stmt->error;
        }
    }
}
$sql = "
SELECT * FROM menu
";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
while ($row = $result->fetch_assoc()) {
    echo $row;
}}else{
    echo "no items yet";
}
?>
<br>
<button id='add_item_button'>Add item</button>
<form id="new_item_form" method="POST" enctype="multipart/form-data" style="display:none;">
    <input name="name" id="name" placeholder="Name">
    <input name="about" id="about" placeholder="about">
    <input name="price" id="price" placeholder="price">
    <label><input name="special" type="checkbox"> Special</label>
    <input name="verticle_picture" id="verticle_picture" type="file" accept="image/*">
    <input name="horozontial_picture" id="horozontial_picture" type="file" accept="image/*">
    <button name="new_item" type="submit">Submit</button>
</form>

<script>
    document.getElementById('add_item_button').addEventListener('click', function() {
        this.style.display = 'none';
        document.getElementById('new_item_form').style.display = 'block';
    });
</script> 