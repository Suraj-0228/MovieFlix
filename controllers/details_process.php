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

// Convert YouTube URL to Embed URL
$trailer_url = $movie['trailer_url'];
$embed_url = "";
if (!empty($trailer_url)) {
    // Short URL (youtu.be)
    if (strpos($trailer_url, 'youtu.be') !== false) {
        $parts = explode('/', parse_url($trailer_url, PHP_URL_PATH));
        $video_id = end($parts);
        $embed_url = "https://www.youtube.com/embed/" . $video_id;
    } 
    // Long URL (youtube.com/watch?v=)
    elseif (strpos($trailer_url, 'youtube.com') !== false) {
        parse_str(parse_url($trailer_url, PHP_URL_QUERY), $params);
        if (isset($params['v'])) {
            $embed_url = "https://www.youtube.com/embed/" . $params['v'];
        }
    }
    // Fallback if already embed
    elseif (strpos($trailer_url, 'embed') !== false) {
        $embed_url = $trailer_url;
    }
}
// Update the array for the view
$movie['trailer_url'] = $embed_url;
