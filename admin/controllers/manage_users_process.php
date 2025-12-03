<?php
require_once '../config/db.php';
require_once 'admin_header.php';

$msg = "";
$msg_type = "";

// Handle Delete User
if (isset($_GET['delete_user'])) {
    $id = $conn->real_escape_string($_GET['delete_user']);

    // Prevent deleting self
    if ($id == $_SESSION['user_id']) {
        $msg = "You cannot delete your own account!";
        $msg_type = "danger";
    } else {
        if ($conn->query("DELETE FROM users WHERE user_id = $id")) {
            $msg = "User deleted successfully!";
            $msg_type = "success";
        } else {
            $msg = "Error deleting user: " . $conn->error;
            $msg_type = "danger";
        }
    }
}

// Pagination Logic
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Get total count
$total_result = $conn->query("SELECT COUNT(*) as count FROM users");
$total_rows = $total_result->fetch_assoc()['count'];
$total_pages = ceil($total_rows / $limit);

// Fetch Users
$users = $conn->query("SELECT * FROM users ORDER BY user_id DESC LIMIT $limit OFFSET $offset");
