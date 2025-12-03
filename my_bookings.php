<?php require_once 'controllers/booking_details.php'; ?>

<div class="container my-5">
    <h2 class="section-title mb-4">My Bookings</h2>

    <?php if (isset($msg)): ?>
        <div class="alert alert-<?php echo $msg_type; ?> alert-dismissible fade show" role="alert">
            <?php echo $msg; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php
    $limit = 8;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    $count_sql = "SELECT COUNT(*) as total FROM bookings WHERE user_id = $user_id";
    $count_result = $conn->query($count_sql);
    $total_bookings = $count_result->fetch_assoc()['total'];
    $total_pages = ceil($total_bookings / $limit);

    $sql = "SELECT b.booking_id, b.booking_date, b.total_amount, b.status, 
                   m.title, m.poster_url, t.name as theatre_name, sc.screen_name, s.show_date, s.show_time 
            FROM bookings b 
            JOIN showtimes s ON b.showtime_id = s.showtime_id 
            JOIN movies m ON s.movie_id = m.movie_id 
            JOIN screens sc ON s.screen_id = sc.screen_id 
            JOIN theatres t ON sc.theatre_id = t.theatre_id 
            WHERE b.user_id = $user_id 
            ORDER BY b.booking_date DESC 
            LIMIT $limit OFFSET $offset";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">';
        while ($row = $result->fetch_assoc()) {
            $show_datetime = strtotime($row['show_date'] . ' ' . $row['show_time']);
            $time_diff = $show_datetime - time();
            $is_upcoming = $time_diff > 0;
            $can_cancel = $time_diff > 7200 && $row['status'] == 'confirmed';
            $cancel_reason = "";
            if ($row['status'] != 'confirmed') {
                $cancel_reason = "Booking is " . $row['status'];
            } elseif ($time_diff <= 0) {
                $cancel_reason = "Show has already started/ended";
            } elseif ($time_diff <= 7200) {
                $cancel_reason = "Cannot cancel less than 2 hours before show";
            }

            $b_id = $row['booking_id'];
            $seat_sql = "SELECT s.seat_number FROM booked_seats bs JOIN seats s ON bs.seat_id = s.seat_id WHERE bs.booking_id = $b_id";
            $seat_result = $conn->query($seat_sql);
            $seats = [];
            while ($s_row = $seat_result->fetch_assoc()) {
                $seats[] = $s_row['seat_number'];
            }

    ?>
            <div class="col">
                <div class="card h-100 border-0 shadow-sm" style="background-color: #1f1f1f;">
                    <div class="position-relative">
                        <img src="<?php echo $row['poster_url']; ?>" class="card-img-top object-fit-cover" alt="<?php echo $row['title']; ?>" style="height: 300px;">
                        <span class="position-absolute top-0 end-0 badge bg-<?php echo ($row['status'] == 'confirmed') ? 'success' : 'danger'; ?> m-2">
                            <?php echo ucfirst($row['status']); ?>
                        </span>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-white text-truncate" title="<?php echo $row['title']; ?>"><?php echo $row['title']; ?></h5>
                        <p class="card-text small text-white mb-2">ID: #<?php echo $row['booking_id']; ?></p>
                        <div class="flex-grow-1">
                            <p class="card-text text-white-50 small mb-1">
                                <i class="fas fa-map-marker-alt me-2 text-primary"></i><?php echo $row['theatre_name']; ?>
                            </p>
                            <p class="card-text text-white-50 small mb-1">
                                <i class="far fa-calendar-alt me-2 text-primary"></i><?php echo date('d M, h:i A', strtotime($row['show_date'] . ' ' . $row['show_time'])); ?>
                            </p>
                            <p class="card-text text-white-50 small mb-1">
                                <i class="fas fa-chair me-2 text-primary"></i><?php echo implode(', ', $seats); ?>
                            </p>
                        </div>
                        <div class="mt-3 pt-3 border-top border-secondary">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-white-50 small">Total Amount</span>
                                <span class="text-white fw-bold fs-5">₹<?php echo $row['total_amount']; ?></span>
                            </div>
                            <?php if ($row['status'] == 'confirmed'): ?>
                                <?php if ($can_cancel): ?>
                                    <form method="POST" action="" onsubmit="return confirm('Are you sure you want to cancel this booking? This action cannot be undone.');">
                                        <input type="hidden" name="cancel_booking_id" value="<?php echo $row['booking_id']; ?>">
                                        <button type="submit" class="btn btn-outline-danger w-100">
                                            <i class="fas fa-times-circle me-2"></i>Cancel Booking
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <button class="btn btn-outline-secondary w-100" disabled title="<?php echo $cancel_reason; ?>">
                                        <i class="fas fa-ban me-2"></i>Cancel Unavailable
                                    </button>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
    <?php
        }
        echo '</div>';

        if ($total_pages > 1) {
            echo '<nav aria-label="Page navigation" class="mt-5">';
            echo '<ul class="pagination justify-content-center">';

            $prev_disabled = ($page <= 1) ? 'disabled' : '';
            $prev_page = $page - 1;
            echo '<li class="page-item ' . $prev_disabled . '">';
            echo '<a class="page-link bg-dark text-white border-secondary" href="?page=' . $prev_page . '">Previous</a>';
            echo '</li>';

            for ($i = 1; $i <= $total_pages; $i++) {
                $active = ($page == $i) ? 'active' : '';
                $bg_class = ($page == $i) ? 'bg-primary border-primary' : 'bg-dark border-secondary';
                echo '<li class="page-item ' . $active . '">';
                echo '<a class="page-link ' . $bg_class . ' text-white" href="?page=' . $i . '">' . $i . '</a>';
                echo '</li>';
            }

            $next_disabled = ($page >= $total_pages) ? 'disabled' : '';
            $next_page = $page + 1;
            echo '<li class="page-item ' . $next_disabled . '">';
            echo '<a class="page-link bg-dark text-white border-secondary" href="?page=' . $next_page . '">Next</a>';
            echo '</li>';

            echo '</ul>';
            echo '</nav>';
        }
    } else {
        echo "<div class='text-center py-5'><div class='display-1 text-muted mb-3'><i class='fas fa-ticket text-danger'></i></div><h3 class='text-white'>No bookings found</h3><p class='text-white'>It looks like you haven't booked any movies yet.</p><a href='movies.php' class='btn btn-primary mt-3'>Browse Movies</a></div>";
    }
    ?>
</div>

<?php require_once 'includes/footer.php'; ?>