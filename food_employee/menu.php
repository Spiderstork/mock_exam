<style>
.menu-card {
    border: 1px solid #e0e0e0;
    border-radius: 14px;
    padding: 18px;
    margin: 20px 0;
    background: #ffffff;
    box-shadow: 0 6px 18px rgba(0,0,0,0.06);
    font-family: Arial, sans-serif;
}

.menu-title {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 6px;
}

.menu-basic {
    color: #555;
    margin-bottom: 10px;
}

.menu-row {
    display: flex;
    justify-content: space-between; 
    align-items: center;
}

.menu-basic span {
    margin-right: 15px;
}

details summary {
    cursor: pointer;
    font-weight: bold;
    color: #007bff;
    margin-top: 8px;
}

details summary:hover {
    text-decoration: underline;
}

.menu-about {
    margin-top: 10px;
    color: #444;
}

.menu-images img {
    margin: 12px 12px 0 0;
    border-radius: 10px;
    border: 1px solid #ddd;
}
</style>
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

        $vertical = $row['verticle_picture'] ?? '';
        $horizontal = $row['horozontial_picture'] ?? '';
        ?>

        <div class="menu-card">
            <div class="menu-row">
                <div>
                    <div class="menu-title">
                        <?php echo htmlspecialchars($row['item_name']); ?>
                    </div>

                    <div class="menu-basic">
                        <span><strong>ID:</strong> <?php echo $row['id']; ?></span>
                        <span><strong>Price:</strong> $<?php echo $row['price']; ?></span>
                        <span><strong>Special:</strong> <?php echo $row['special'] ? 'Yes' : 'No'; ?></span>
                    </div>
                </div>

            <form action="menu_edit.php" method="POST" style="display:inline">
                <input type="hidden" name="edit_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                <input type="hidden" name="name" value="<?php echo htmlspecialchars($row['item_name']); ?>">
                <input type="hidden" name="price" value="<?php echo htmlspecialchars($row['price']); ?>">
                <input type="hidden" name="special" value="<?php echo htmlspecialchars($row['special']); ?>">
                <input type="hidden" name="removed" value="<?php echo htmlspecialchars($row['removed']); ?>">
                <input type="hidden" name="about" value="<?php echo htmlspecialchars($row['about']); ?>">
                <input type="hidden" name="vertical" value="<?php echo htmlspecialchars($vertical); ?>">
                <input type="hidden" name="horizontal" value="<?php echo htmlspecialchars($horizontal); ?>">
                <button type="submit">Edit</button>
            </form>
            </div>

            <details>
                <summary>View Details</summary>

                <div class="menu-about">
                    <strong>About:</strong><br>
                    <?php echo htmlspecialchars($row['about']); ?>
                </div>

                <div class="menu-images">
                    <?php if ($vertical): ?>
                        <img width="320" height="320"
                             src="../uploads/<?php echo htmlspecialchars($vertical); ?>"
                             alt="Vertical Image">
                    <?php endif; ?>

                    <?php if ($horizontal): ?>
                        <img width="320" height="320"
                             src="../uploads/<?php echo htmlspecialchars($horizontal); ?>"
                             alt="Horizontal Image">
                    <?php endif; ?>
                </div>
            </details>

        </div>

    <?php }
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