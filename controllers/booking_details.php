<?php
require_once 'config/db.php';
require_once 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle Cancellation
if (isset($_POST['cancel_booking_id'])) {
    $booking_id = $conn->real_escape_string($_POST['cancel_booking_id']);

    // Verify ownership and time constraint
    $check_sql = "SELECT b.booking_id, s.show_date, s.show_time 
                  FROM bookings b 
                  JOIN showtimes s ON b.showtime_id = s.showtime_id 
                  WHERE b.booking_id = $booking_id AND b.user_id = $user_id AND b.status = 'confirmed'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        $booking = $check_result->fetch_assoc();
        $show_datetime = strtotime($booking['show_date'] . ' ' . $booking['show_time']);
        $current_time = time();

        if (($show_datetime - $current_time) > 7200) { // 2 hours in seconds
            $conn->begin_transaction();
            try {
                // Update booking status
                $update_sql = "UPDATE bookings SET status = 'cancelled' WHERE booking_id = $booking_id";
                $conn->query($update_sql);

                // Release seats (Optional: Depending on requirement, we might want to keep record in booked_seats but mark booking as cancelled. 
                // However, usually we want to free up seats. Let's delete from booked_seats or rely on join with bookings status)
                // The seat selection logic checks for 'confirmed' status, so updating status is enough.

                $conn->commit();
                $msg = "Booking cancelled successfully.";
                $msg_type = "success";
            } catch (Exception $e) {
                $conn->rollback();
                $msg = "Error cancelling booking.";
                $msg_type = "danger";
            }
        } else {
            $msg = "Cannot cancel booking less than 2 hours before showtime.";
            $msg_type = "warning";
        }
    }
}
