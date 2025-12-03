<?php
require_once 'config/db.php';
require_once 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initial display of confirmation page
    if (isset($_POST['selected_seats']) && isset($_POST['showtime_id'])) {
        $showtime_id = $conn->real_escape_string($_POST['showtime_id']);
        $selected_seats_json = $_POST['selected_seats'];
        $selected_seats = json_decode($selected_seats_json);
        $total_amount = $conn->real_escape_string($_POST['total_amount']);

        if (empty($selected_seats)) {
            header("Location: movies.php");
            exit();
        }

        // Fetch show details
        $sql = "SELECT s.showtime_id, s.show_time, s.show_date, m.title, t.name as theatre_name, sc.screen_name 
                FROM showtimes s 
                JOIN movies m ON s.movie_id = m.movie_id 
                JOIN screens sc ON s.screen_id = sc.screen_id 
                JOIN theatres t ON sc.theatre_id = t.theatre_id 
                WHERE s.showtime_id = $showtime_id";
        $result = $conn->query($sql);
        $show = $result->fetch_assoc();

        // Fetch seat numbers for display
        $seat_ids = implode(',', $selected_seats);
        $seat_sql = "SELECT seat_number FROM seats WHERE seat_id IN ($seat_ids)";
        $seat_result = $conn->query($seat_sql);
        $seat_numbers = [];
        while ($row = $seat_result->fetch_assoc()) {
            $seat_numbers[] = $row['seat_number'];
        }
    }
    // Final confirmation processing
    elseif (isset($_POST['confirm_booking'])) {
        $user_id = $_SESSION['user_id'];
        $showtime_id = $conn->real_escape_string($_POST['showtime_id']);
        $total_amount = $conn->real_escape_string($_POST['total_amount']);
        $selected_seats = json_decode(base64_decode($_POST['selected_seats_final']));

        if (empty($selected_seats) || !is_array($selected_seats)) {
            throw new Exception("Invalid seat selection!");
        }

        // Fetch show details for re-display in case of error or success message context
        $sql = "SELECT s.showtime_id, s.show_time, s.show_date, m.title, t.name as theatre_name, sc.screen_name 
                FROM showtimes s 
                JOIN movies m ON s.movie_id = m.movie_id 
                JOIN screens sc ON s.screen_id = sc.screen_id 
                JOIN theatres t ON sc.theatre_id = t.theatre_id 
                WHERE s.showtime_id = $showtime_id";
        $result = $conn->query($sql);
        $show = $result->fetch_assoc();

        // Fetch seat numbers for display
        $seat_ids = implode(',', $selected_seats);
        $seat_sql = "SELECT seat_number FROM seats WHERE seat_id IN ($seat_ids)";
        $seat_result = $conn->query($seat_sql);
        $seat_numbers = [];
        while ($row = $seat_result->fetch_assoc()) {
            $seat_numbers[] = $row['seat_number'];
        }

        // Start transaction
        $conn->begin_transaction();

        try {
            // Insert Booking
            $booking_sql = "INSERT INTO bookings (user_id, showtime_id, total_amount, status) VALUES ($user_id, $showtime_id, $total_amount, 'confirmed')";
            if (!$conn->query($booking_sql)) {
                throw new Exception("Booking insertion failed: " . $conn->error);
            }
            $booking_id = $conn->insert_id;

            // Insert Booked Seats
            foreach ($selected_seats as $seat_id) {
                $seat_id = $conn->real_escape_string($seat_id);
                // Check if already booked (Double booking prevention)
                $check_sql = "SELECT * FROM booked_seats bs JOIN bookings b ON bs.booking_id = b.booking_id WHERE b.showtime_id = $showtime_id AND bs.seat_id = $seat_id AND b.status = 'confirmed'";
                $check_result = $conn->query($check_sql);
                if ($check_result->num_rows > 0) {
                    throw new Exception("One or more seats already booked!");
                }

                $booked_seat_sql = "INSERT INTO booked_seats (booking_id, seat_id) VALUES ($booking_id, $seat_id)";
                if (!$conn->query($booked_seat_sql)) {
                    throw new Exception("Seat booking failed: " . $conn->error);
                }
            }

            $conn->commit();
            $success_message = "Booking confirmed! Your Booking ID is #$booking_id";
            // Redirect to My Bookings or show success
            echo "<script>alert('$success_message'); window.location.href='my_bookings.php';</script>";
            exit();
        } catch (Exception $e) {
            $conn->rollback();
            $error_message = $e->getMessage();
        }
    } else {
        header("Location: movies.php");
        exit();
    }
} else {
    header("Location: movies.php");
    exit();
}
