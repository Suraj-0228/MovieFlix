<?php
require_once 'config/db.php';
require_once 'includes/header.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    $sql = "SELECT user_id, name, role FROM users WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['user_name'] = $row['name'];
        $_SESSION['role'] = $row['role'];

        // Remember Me Logic
        if (isset($_POST['remember'])) {
            setcookie('user_login', $row['user_id'], time() + (86400 * 30), "/"); // 30 Days
        } else {
            setcookie('user_login', '', time() - 3600, "/"); // Clear if not checked
        }

        if ($row['role'] == 'admin') {
            header("Location: admin/dashboard.php");
        } else {
            header("Location: index.php");
        }
        exit();
    } else {
        $error = "Invalid email or password!";
    }
}

$success_msg = '';
if (isset($_GET['registration']) && $_GET['registration'] == 'success') {
    $success_msg = "Registration successful! Please login.";
}
