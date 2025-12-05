<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$success_message = '';
$error_message = '';

// Handle Password Change
if (isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (strlen($new_password) < 6) {
        $error_message = "New password must be at least 6 characters long.";
    } elseif ($new_password !== $confirm_password) {
        $error_message = "New passwords do not match.";
    } else {
        // Verify current password
        $sql = "SELECT password FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (password_verify($current_password, $user['password'])) {
            // Update password
            $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $update_sql = "UPDATE users SET password = ? WHERE user_id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("si", $new_password_hash, $user_id);
            
            if ($update_stmt->execute()) {
                $success_message = "Password updated successfully!";
            } else {
                $error_message = "Error updating password. Please try again.";
            }
        } else {
            $error_message = "Incorrect current password.";
        }
    }
}

// Handle Account Deletion
if (isset($_POST['delete_account'])) {
    // Delete user (Bookings will be kept or deleted based on FK constraints, usually kept for records or cascaded)
    // Assuming simple delete for now or we could flag as deleted. Here we strictly delete.
    
    $delete_sql = "DELETE FROM users WHERE user_id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("i", $user_id);
    
    if ($delete_stmt->execute()) {
        session_destroy();
        header('Location: index.php?msg=account_deleted');
        exit();
    } else {
        $error_message = "Error deleting account. Please contact support.";
    }
}
?>
