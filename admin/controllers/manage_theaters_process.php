<?php
require_once '../config/db.php';
require_once 'admin_header.php';

$msg = "";
$msg_type = "";

// Handle Delete Theatre
if (isset($_GET['delete_theatre'])) {
    $id = $conn->real_escape_string($_GET['delete_theatre']);
    if ($conn->query("DELETE FROM theatres WHERE theatre_id = $id")) {
        $msg = "Theatre deleted successfully!";
        $msg_type = "success";
    } else {
        $msg = "Error deleting theatre: " . $conn->error;
        $msg_type = "danger";
    }
}

// Handle Add/Edit Theatre
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_theatre'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $location = $conn->real_escape_string($_POST['location']);
    $city = $conn->real_escape_string($_POST['city']);
    $total_screens = $conn->real_escape_string($_POST['total_screens']);

    if (isset($_POST['theatre_id']) && !empty($_POST['theatre_id'])) {
        // Update
        $id = $conn->real_escape_string($_POST['theatre_id']);
        $sql = "UPDATE theatres SET name='$name', location='$location', city='$city', total_screens='$total_screens' WHERE theatre_id=$id";
        if ($conn->query($sql)) {
            $msg = "Theatre updated successfully!";
            $msg_type = "success";
        } else {
            $msg = "Error updating theatre: " . $conn->error;
            $msg_type = "danger";
        }
    } else {
        // Add
        $sql = "INSERT INTO theatres (name, location, city, total_screens) VALUES ('$name', '$location', '$city', '$total_screens')";
        if ($conn->query($sql)) {
            $msg = "Theatre added successfully!";
            $msg_type = "success";
        } else {
            $msg = "Error adding theatre: " . $conn->error;
            $msg_type = "danger";
        }
    }
}

// Handle Add Screen
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_screen'])) {
    $theatre_id = $conn->real_escape_string($_POST['screen_theatre_id']);
    $screen_name = $conn->real_escape_string($_POST['screen_name']);
    $total_seats = $conn->real_escape_string($_POST['total_seats']);

    $vip_price = isset($_POST['vip_price']) ? $conn->real_escape_string($_POST['vip_price']) : 300;
    $premium_price = isset($_POST['premium_price']) ? $conn->real_escape_string($_POST['premium_price']) : 200;
    $regular_price = isset($_POST['regular_price']) ? $conn->real_escape_string($_POST['regular_price']) : 150;

    $sql = "INSERT INTO screens (theatre_id, screen_name, total_seats) VALUES ($theatre_id, '$screen_name', $total_seats)";
    if ($conn->query($sql)) {
        // Auto-generate seats for this screen
        $screen_id = $conn->insert_id;
        $seat_count = 0;
        $rows = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];

        foreach ($rows as $row) {
            for ($i = 1; $i <= 10; $i++) {
                if ($seat_count >= $total_seats) break;

                $seat_number = $row . $i;
                $seat_type = ($row == 'I' || $row == 'J') ? 'VIP' : (($row == 'G' || $row == 'H') ? 'Premium' : 'Regular');
                $price = ($seat_type == 'VIP') ? $vip_price : (($seat_type == 'Premium') ? $premium_price : $regular_price);

                $conn->query("INSERT INTO seats (screen_id, seat_number, seat_type, price) VALUES ($screen_id, '$seat_number', '$seat_type', $price)");
                $seat_count++;
            }
        }

        $msg = "Screen and seats added successfully!";
        $msg_type = "success";
    } else {
        $msg = "Error adding screen: " . $conn->error;
        $msg_type = "danger";
    }
}

// Pagination Logic
$limit = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Get total count
$total_result = $conn->query("SELECT COUNT(*) as count FROM theatres");
$total_rows = $total_result->fetch_assoc()['count'];
$total_pages = ceil($total_rows / $limit);

// Fetch Theatres with Limit
$theatres = $conn->query("SELECT * FROM theatres ORDER BY theatre_id ASC LIMIT $limit OFFSET $offset");
