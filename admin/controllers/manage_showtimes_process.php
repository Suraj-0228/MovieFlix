<?php
require_once '../config/db.php';
require_once 'admin_header.php';

$msg = "";
$msg_type = "";

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $conn->real_escape_string($_GET['delete']);
    if ($conn->query("DELETE FROM showtimes WHERE showtime_id = $id")) {
        $msg = "Showtime deleted successfully!";
        $msg_type = "success";
    } else {
        $msg = "Error deleting showtime: " . $conn->error;
        $msg_type = "danger";
    }
}

// Handle Add/Edit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $movie_id = $conn->real_escape_string($_POST['movie_id']);
    $screen_id = $conn->real_escape_string($_POST['screen_id']);
    $show_date = $conn->real_escape_string($_POST['show_date']);
    $show_time = $conn->real_escape_string($_POST['show_time']);

    if (isset($_POST['showtime_id']) && !empty($_POST['showtime_id'])) {
        // Update
        $id = $conn->real_escape_string($_POST['showtime_id']);
        $sql = "UPDATE showtimes SET movie_id=$movie_id, screen_id=$screen_id, show_date='$show_date', show_time='$show_time' WHERE showtime_id=$id";
        if ($conn->query($sql)) {
            $msg = "Showtime updated successfully!";
            $msg_type = "success";
        } else {
            $msg = "Error updating showtime: " . $conn->error;
            $msg_type = "danger";
        }
    } else {
        // Add
        $sql = "INSERT INTO showtimes (movie_id, screen_id, show_date, show_time) VALUES ($movie_id, $screen_id, '$show_date', '$show_time')";
        if ($conn->query($sql)) {
            $msg = "Showtime added successfully!";
            $msg_type = "success";
        } else {
            $msg = "Error adding showtime: " . $conn->error;
            $msg_type = "danger";
        }
    }
}

// Pagination Logic
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Get total count
$total_result = $conn->query("SELECT COUNT(*) as count FROM showtimes");
$total_rows = $total_result->fetch_assoc()['count'];
$total_pages = ceil($total_rows / $limit);

// Fetch Showtimes
$sql = "SELECT s.showtime_id, s.show_date, s.show_time, m.title, t.name as theatre_name, sc.screen_name, s.movie_id, s.screen_id 
        FROM showtimes s 
        JOIN movies m ON s.movie_id = m.movie_id 
        JOIN screens sc ON s.screen_id = sc.screen_id 
        JOIN theatres t ON sc.theatre_id = t.theatre_id 
        ORDER BY s.showtime_id ASC LIMIT $limit OFFSET $offset";
$showtimes = $conn->query($sql);

// Fetch Movies for Dropdown
$movies = $conn->query("SELECT movie_id, title FROM movies WHERE status = 'now_showing'");

// Fetch Screens for Dropdown
$screens = $conn->query("SELECT s.screen_id, s.screen_name, t.name as theatre_name FROM screens s JOIN theatres t ON s.theatre_id = t.theatre_id");
