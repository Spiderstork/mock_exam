<?php
include "check_title.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = (int)$_POST['edit_id'];
    $name = htmlspecialchars($_POST['name']);
    $price = htmlspecialchars($_POST['price']);
    $special = $_POST['special'];
    $about = htmlspecialchars($_POST['about']);
    $vertical = $_POST['vertical'];
    $horizontal = $_POST['horizontal'];
    $removed = $_POST['removed'];
}
?>

<h2>Edit Menu Item</h2>

<form action="menu_update.php" method="POST" enctype="multipart/form-data">

    <input type="hidden" name="edit_id" value="<?php echo $id; ?>">
    <input type="hidden" name="old_vertical" value="<?php echo $vertical; ?>">
    <input type="hidden" name="old_horizontal" value="<?php echo $horizontal; ?>">

    <label>Name</label><br>
    <input type="text" name="name" value="<?php echo $name; ?>">
    <br><br>

    <label>Price</label><br>
    <input type="text" name="price" value="<?php echo $price; ?>">
    <br><br>

    <label>About</label><br>
    <input type="text" name="about" value="<?php echo $about; ?>">
    <br><br>

    <label>
        <input type="checkbox" name="special" <?php echo $special ? "checked" : ""; ?>>
        Special
    </label>
    <br>

    <label>
        <input type="checkbox" name="removed" <?php echo $removed ? "checked" : ""; ?>>
        Removed
    </label>

    <hr>

    <h3>Images</h3>

    <p>Current Vertical Image:</p>
    <?php if ($vertical): ?>
        <img src="../uploads/<?php echo $vertical; ?>" width="200"><br>
    <?php endif; ?>

    <label>Replace Vertical Image</label><br>
    <input type="file" name="verticle_picture" accept="image/*">

    <br><br>

    <p>Current Horizontal Image:</p>
    <?php if ($horizontal): ?>
        <img src="../uploads/<?php echo $horizontal; ?>" width="200"><br>
    <?php endif; ?>

    <label>Replace Horizontal Image</label><br>
    <input type="file" name="horozontial_picture" accept="image/*">

    <br><br>

    <button type="submit" name="edit">Save Changes</button>

</form>