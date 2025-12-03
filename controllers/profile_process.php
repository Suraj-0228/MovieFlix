<?php
require_once 'config/db.php';
require_once 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$msg = "";
$msg_type = "";

// Handle Profile Update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $phone = $conn->real_escape_string($_POST['phone']);

    $sql = "UPDATE users SET name = '$name', phone = '$phone' WHERE user_id = $user_id";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['user_name'] = $name; // Update session name
        header("Location: profile.php?status=success");
        exit();
    } else {
        $error = urlencode($conn->error);
        header("Location: profile.php?status=error&message=$error");
        exit();
    }
}

// Handle Messages
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'success') {
        $msg = "Profile updated successfully!";
        $msg_type = "success";
    } elseif ($_GET['status'] == 'error') {
        $msg = "Error updating profile: " . (isset($_GET['message']) ? htmlspecialchars($_GET['message']) : 'Unknown error');
        $msg_type = "danger";
    }
}

// Fetch User Details
$sql = "SELECT * FROM users WHERE user_id = $user_id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

// Derive Username from Email
$username = "@" . explode('@', $user['email'])[0];

// Fetch Booking Stats
$booking_sql = "SELECT COUNT(*) as total_bookings FROM bookings WHERE user_id = $user_id";
$booking_result = $conn->query($booking_sql);
$booking_stats = $booking_result->fetch_assoc();

// Get Initials
$initials = strtoupper(substr($user['name'], 0, 1));
