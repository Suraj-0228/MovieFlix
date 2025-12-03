<?php
require_once 'config/db.php';
require_once 'includes/header.php';

if (!isset($_GET['id'])) {
    header("Location: movies.php");
    exit();
}

$movie_id = $conn->real_escape_string($_GET['id']);
$sql = "SELECT * FROM movies WHERE movie_id = $movie_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "<div class='container my-5 text-center'><h2>Movie not found!</h2><a href='movies.php' class='btn btn-primary mt-3'>Back to Movies</a></div>";
    require_once 'includes/footer.php';
    exit();
}

$movie = $result->fetch_assoc();
