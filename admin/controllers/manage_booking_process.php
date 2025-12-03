<?php
require_once '../config/db.php';
require_once 'admin_header.php';

$msg = "";
$msg_type = "";

// Handle Delete Booking
if (isset($_GET['delete'])) {
    $id = $conn->real_escape_string($_GET['delete']);
    if ($conn->query("DELETE FROM bookings WHERE booking_id = $id")) {
        $msg = "Booking deleted successfully!";
        $msg_type = "success";
    } else {
        $msg = "Error deleting booking: " . $conn->error;
        $msg_type = "danger";
    }
}

// Pagination Logic
$limit = 8;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Get total count
$total_result = $conn->query("SELECT COUNT(*) as count FROM bookings");
$total_rows = $total_result->fetch_assoc()['count'];
$total_pages = ceil($total_rows / $limit);

// Fetch Bookings
$sql = "SELECT b.booking_id, b.booking_date, b.total_amount, b.status, 
               u.name as user_name, u.email, 
               m.title, t.name as theatre_name, sc.screen_name, s.show_date, s.show_time 
        FROM bookings b 
        JOIN users u ON b.user_id = u.user_id 
        JOIN showtimes s ON b.showtime_id = s.showtime_id 
        JOIN movies m ON s.movie_id = m.movie_id 
        JOIN screens sc ON s.screen_id = sc.screen_id 
        JOIN theatres t ON sc.theatre_id = t.theatre_id 
        ORDER BY b.booking_date DESC LIMIT $limit OFFSET $offset";
$bookings = $conn->query($sql);
