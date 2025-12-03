<?php
require_once '../config/db.php';
require_once 'admin_header.php';

$msg = "";
$msg_type = "";

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $conn->real_escape_string($_GET['delete']);
    if ($conn->query("DELETE FROM movies WHERE movie_id = $id")) {
        $msg = "Movie deleted successfully!";
        $msg_type = "success";
    } else {
        $msg = "Error deleting movie: " . $conn->error;
        $msg_type = "danger";
    }
}

// Handle Add/Edit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $genre = $conn->real_escape_string($_POST['genre']);
    $language = $conn->real_escape_string($_POST['language']);
    $duration = $conn->real_escape_string($_POST['duration']);
    $rating = $conn->real_escape_string($_POST['rating']);
    $release_date = $conn->real_escape_string($_POST['release_date']);
    $poster_url = $conn->real_escape_string($_POST['poster_url']);
    $status = $conn->real_escape_string($_POST['status']);

    if (isset($_POST['movie_id']) && !empty($_POST['movie_id'])) {
        // Update
        $id = $conn->real_escape_string($_POST['movie_id']);
        $sql = "UPDATE movies SET title='$title', description='$description', genre='$genre', language='$language', duration='$duration', rating='$rating', release_date='$release_date', poster_url='$poster_url', status='$status' WHERE movie_id=$id";
        if ($conn->query($sql)) {
            $msg = "Movie updated successfully!";
            $msg_type = "success";
        } else {
            $msg = "Error updating movie: " . $conn->error;
            $msg_type = "danger";
        }
    } else {
        // Add
        $sql = "INSERT INTO movies (title, description, genre, language, duration, rating, release_date, poster_url, status) VALUES ('$title', '$description', '$genre', '$language', '$duration', '$rating', '$release_date', '$poster_url', '$status')";
        if ($conn->query($sql)) {
            $msg = "Movie added successfully!";
            $msg_type = "success";
        } else {
            $msg = "Error adding movie: " . $conn->error;
            $msg_type = "danger";
        }
    }
}

// Pagination Logic
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Get total count
$total_result = $conn->query("SELECT COUNT(*) as count FROM movies");
$total_rows = $total_result->fetch_assoc()['count'];
$total_pages = ceil($total_rows / $limit);

// Fetch Movies with Limit
$movies = $conn->query("SELECT * FROM movies ORDER BY movie_id ASC LIMIT $limit OFFSET $offset");
