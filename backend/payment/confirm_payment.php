<?php
include 'validate_details.php';
include '../reapting.php';
include '../db/connect_db.php';

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

$sql = "insert into customer (booking_name, email) 
values ('$booking_name', '$email')";

if ($conn->query($sql) === TRUE) {
    echo "Customer record created successfully";
} else {
    echo "Error creating customer record: " . $conn->error;
}

