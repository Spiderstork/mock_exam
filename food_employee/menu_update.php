<?php
include '../db/connect_db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id = (int)$_POST['edit_id'];
    $name = $_POST['name'];
    $about = $_POST['about'];
    $price = $_POST['price'];

    $special = isset($_POST['special']) ? 1 : 0;
    $removed = isset($_POST['removed']) ? 1 : 0;

    $old_vertical = $_POST['old_vertical'];
    $old_horizontal = $_POST['old_horizontal'];

    $upload_dir = dirname(__DIR__) . '/uploads/';

    /* =========================
       HANDLE VERTICAL IMAGE
    ==========================*/
    $vertical_name = $old_vertical;

    if (!empty($_FILES['verticle_picture']['name']) &&
        $_FILES['verticle_picture']['error'] === 0) {

        $vertical_name =
            time() . '_' .
            // Extract the original filename and replace whitespace characters
            // with underscores to create a safer file name for storage
            preg_replace('/\s+/', '_', basename($_FILES['verticle_picture']['name']));

        move_uploaded_file(
            $_FILES['verticle_picture']['tmp_name'],
            $upload_dir . $vertical_name
        );

        // delete old image
        if ($old_vertical && file_exists($upload_dir.$old_vertical)) {
            unlink($upload_dir.$old_vertical);
        }
    }

    /* =========================
       HANDLE HORIZONTAL IMAGE
    ==========================*/
    $horizontal_name = $old_horizontal;

    if (!empty($_FILES['horozontial_picture']['name']) &&
        $_FILES['horozontial_picture']['error'] === 0) {

        $horizontal_name =
            time() . '_' .
            // Replace all whitespace characters in the filename with underscores
            // to prevent issues with spaces in file paths and URLs
            preg_replace('/\s+/', '_', basename($_FILES['verticle_picture']['name']));

        move_uploaded_file(
            $_FILES['horozontial_picture']['tmp_name'],
            $upload_dir . $horizontal_name
        );

        if ($old_horizontal && file_exists($upload_dir.$old_horizontal)) {
            unlink($upload_dir.$old_horizontal);
        }
    }

    /* =========================
       UPDATE DATABASE
    ==========================*/
    $stmt = $conn->prepare("
        UPDATE menu
        SET
            item_name=?,
            about=?,
            price=?,
            special=?,
            removed=?,
            verticle_picture=?,
            horozontial_picture=?
        WHERE id=?
    ");

    $stmt->bind_param(
        "sssiissi",
        $name,
        $about,
        $price,
        $special,
        $removed,
        $vertical_name,
        $horizontal_name,
        $id
    );

    if ($stmt->execute()) {
        header("Location: menu.php?updated=1");
        exit;
    } else {
        echo "Update failed: " . $stmt->error;
    }
}
?>