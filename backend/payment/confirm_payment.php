<?php
session_start();
include '../validate_details.php';
include '../reapting.php';
include '../../db/connect_db.php';

$card_number = sanitize_input($_POST['card_number']);
$exp_month = sanitize_input($_POST['expiry_month']);
$exp_year = sanitize_input($_POST['expiry_year']);
$cvv = sanitize_input($_POST['cvv']);

$booking_name = sanitize_input($_POST['booking_name']);
$email = sanitize_input($_POST['email']);

$validator = new validate_details($card_number, $exp_month, $exp_year, $cvv, $email);
if (!$validator->validate_card_number()) {
    die("Invalid card number. Please go back and try again.");
}
if (!$validator->validate_expiry()) {
    die("Invalid expiry date. Please go back and try again.");
}
if (!$validator->validate_cvv()) {
    die("Invalid CVV. Please go back and try again.");
}
if (!$validator->validate_email()) {  
    die("Invalid email address. Please go back and try again.");
} 


// 1. Check if customer already exists
$stmt = $conn->prepare("SELECT id FROM customer WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // Customer exists
    $customer_id = $row['id'];

    // Optionally update booking name
    $stmt = $conn->prepare("UPDATE customer SET booking_name = ? WHERE id = ?");
    $stmt->bind_param("si", $booking_name, $customer_id);
    $stmt->execute();

    echo "Existing customer reused.<br>";

} else {
    // Customer does not exist → insert
    $stmt = $conn->prepare("INSERT INTO customer (booking_name, email) VALUES (?, ?)");
    $stmt->bind_param("ss", $booking_name, $email);

    if ($stmt->execute()) {
        $customer_id = $conn->insert_id;
        echo "Customer record created successfully.<br>";
    } else {
        die("Error creating customer record: " . $stmt->error);
    }
}

if (!isset($_SESSION['booking_id'])) {
    die("No booking ID in session.");
}

$booking_id = $_SESSION['booking_id'];

$stmt = $conn->prepare("
    INSERT INTO booking_bridge (booking_id, user_id)
    VALUES (?, ?)
");

$stmt->bind_param("ii", $booking_id, $customer_id);

if ($stmt->execute()) {
    echo "Booking and customer linked successfully";
} else {
    echo "Error linking booking and customer: " . $stmt->error;
}
