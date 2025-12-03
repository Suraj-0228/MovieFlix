<?php
require_once 'config/db.php';
require_once 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: movies.php");
    exit();
}

$showtime_id = $conn->real_escape_string($_GET['id']);

// Fetch showtime details
$sql = "SELECT s.showtime_id, s.show_time, s.show_date, m.title, m.poster_url, t.name as theatre_name, sc.screen_name, sc.screen_id 
        FROM showtimes s 
        JOIN movies m ON s.movie_id = m.movie_id 
        JOIN screens sc ON s.screen_id = sc.screen_id 
        JOIN theatres t ON sc.theatre_id = t.theatre_id 
        WHERE s.showtime_id = $showtime_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "<div class='container my-5'><h2>Showtime not found!</h2></div>";
    require_once 'footer.php';
    exit();
}

$show = $result->fetch_assoc();
$screen_id = $show['screen_id'];

// Fetch seats for this screen
$seats_sql = "SELECT * FROM seats WHERE screen_id = $screen_id ORDER BY seat_id";
$seats_result = $conn->query($seats_sql);

// Fetch booked seats for this showtime
$booked_sql = "SELECT seat_id FROM booked_seats bs JOIN bookings b ON bs.booking_id = b.booking_id WHERE b.showtime_id = $showtime_id AND b.status = 'confirmed'";
$booked_result = $conn->query($booked_sql);
$booked_seats = [];
while ($row = $booked_result->fetch_assoc()) {
    $booked_seats[] = $row['seat_id'];
}
