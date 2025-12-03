<?php
require_once '../config/db.php';
require_once 'admin_header.php';

// Fetch Statistics
$movies_count = $conn->query("SELECT COUNT(*) as count FROM movies")->fetch_assoc()['count'];
$theatres_count = $conn->query("SELECT COUNT(*) as count FROM theatres")->fetch_assoc()['count'];
$bookings_count = $conn->query("SELECT COUNT(*) as count FROM bookings")->fetch_assoc()['count'];
$users_count = $conn->query("SELECT COUNT(*) as count FROM users WHERE role='user'")->fetch_assoc()['count'];

// Recent Bookings Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 8;
$offset = ($page - 1) * $limit;
$total_pages = ceil($bookings_count / $limit);

$recent_bookings_sql = "SELECT b.booking_id, u.name, m.title, b.total_amount, b.booking_date 
                        FROM bookings b 
                        JOIN users u ON b.user_id = u.user_id 
                        JOIN showtimes s ON b.showtime_id = s.showtime_id 
                        JOIN movies m ON s.movie_id = m.movie_id 
                        ORDER BY b.booking_date DESC LIMIT $limit OFFSET $offset";
$recent_bookings = $conn->query($recent_bookings_sql);
