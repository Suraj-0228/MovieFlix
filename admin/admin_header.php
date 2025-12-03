<?php
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params(0);
    session_start();
}

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - MovieFlix</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="bg-dark text-white">

    <div class="admin-container">
        <!-- Sidebar -->
        <div class="admin-sidebar">
            <a href="dashboard.php" class="admin-brand">
                <i class="fas fa-film me-2"></i>MovieFlix
            </a>
            <nav class="admin-nav">
                <a href="dashboard.php" class="admin-nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a href="manage_movies.php" class="admin-nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'movies.php' ? 'active' : ''; ?>">
                    <i class="fas fa-film"></i> Manage Movies
                </a>
                <a href="manage_theatres.php" class="admin-nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'theatres.php' ? 'active' : ''; ?>">
                    <i class="fas fa-building"></i> Manage Theatres
                </a>
                <a href="manage_showtimes.php" class="admin-nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'showtimes.php' ? 'active' : ''; ?>">
                    <i class="fas fa-clock"></i> Manage Showtimes
                </a>
                <a href="manage_bookings.php" class="admin-nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'bookings.php' ? 'active' : ''; ?>">
                    <i class="fas fa-ticket-alt"></i> Manage Bookings
                </a>
                <a href="manage_users.php" class="admin-nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'manage_users.php' ? 'active' : ''; ?>">
                    <i class="fas fa-users"></i> Manage Users
                </a>
                <div class="mt-auto">
                    <a href="../logout.php" class="admin-nav-item text-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </nav>
        </div>

        <!-- Main Content Wrapper -->
        <div class="admin-content">