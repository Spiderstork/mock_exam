<?php
include "check_title.php";
include '../db/connect_db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST['edit'])) {
        edit((int)$_POST['edit_id'], $_POST['name'], $_POST['email'], $_POST['table'] ?? 0, $_POST['food'] ?? 0, $_POST['admin'] ?? 0, $_POST['banned'] ?? 0);
    }

    if (isset($_POST['new_item'])) {
        $name = $_POST['name'];
        $about = $_POST['about'];
        $price = $_POST['price'];
        $special = isset($_POST['special']) ? 1 : 0;
        $removed = 0;

        $verticle = $_FILES['verticle_picture'];
        $horozontial = $_FILES['horozontial_picture'];

        // Prepare upload folder
        $upload_dir = dirname(__DIR__) . '/uploads/'; // parent directory
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

        // Sanitize file names
        $verticle_name = time() . '_' . preg_replace('/\s+/', '_', basename($verticle['name']));
        $horozontial_name = time() . '_' . preg_replace('/\s+/', '_', basename($horozontial['name']));

        // Validate upload
        if ($verticle['error'] === 0 && $horozontial['error'] === 0) {
            move_uploaded_file($verticle['tmp_name'], $upload_dir . $verticle_name);
            move_uploaded_file($horozontial['tmp_name'], $upload_dir . $horozontial_name);
        } else {
            echo "File upload error!";
            exit;
        }

        // Insert into database
        $stmt = $conn->prepare("INSERT INTO menu (item_name, about, special, removed, horozontial_picture, verticle_picture, price) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiisss", $name, $about, $special, $removed, $horozontial_name, $verticle_name, $price);

        if ($stmt->execute()) {
            echo "<p style='color: green;'>New menu item added successfully.</p><br>";
        } else {
            echo "Error adding menu item: " . $stmt->error;
        }
    }
}

// Display menu items
$sql = "SELECT * FROM menu";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<pre>";
        print_r($row);
        echo "</pre>";
        echo "ID: " . $row['id'] . 
        " | Name: " . $row['item_name'] . 
        " | Price: " . $row['price'] . 

        $vertical = $row['verticle_picture'] ?? '';
        $horozontial = $row['horozontial_picture'] ?? '';

        if ($vertical) {
            echo "<img src='../uploads/$vertical' alt='Vertical Image'>";
        }else{echo "fail to load verticle";}
        if ($horozontial) {
            echo "<img src='../uploads/$horozontial' alt='Vertical Image'>";
        }else{echo "fail to load horizontal";}
        }
} else {
    echo "No items yet";
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