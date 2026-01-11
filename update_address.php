<?php
// update_address.php
session_start();
include 'connect.php'; // Make sure this path is correct

if (!isset($_SESSION['user_email'])) {
    die("Unauthorized access");
}

// Handle address update form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_address'])) {
    // Validate and sanitize inputs
    $house_no = $conn->real_escape_string($_POST['house_no'] ?? '');
    $street = $conn->real_escape_string($_POST['street'] ?? '');
    $city = $conn->real_escape_string($_POST['city'] ?? '');
    $pin = $conn->real_escape_string($_POST['pin'] ?? '');
    $state = $conn->real_escape_string($_POST['state'] ?? '');
    $district = $conn->real_escape_string($_POST['district'] ?? '');
    $email = $_SESSION['user_email'];
    
    // Update address in database
    $stmt = $conn->prepare("UPDATE users SET 
        house_no = ?, 
        street = ?, 
        city = ?, 
        pin = ?, 
        state = ?, 
        district = ? 
        WHERE email = ?");
    
    $stmt->bind_param("sssssss", 
        $house_no, 
        $street, 
        $city, 
        $pin, 
        $state, 
        $district, 
        $email);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = 'Address updated successfully!';
    } else {
        $_SESSION['error'] = 'Error updating address!';
    }
    $stmt->close();
}

header("Location: index.php");
exit();
?>