<?php require_once 'controllers/seat_process.php'; ?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-8">
            <h2 class="section-title">Select Seats</h2>
            <div class="screen text-center text-white pt-1">SCREEN</div>
            <div class="seat-grid" style="grid-template-columns: repeat(10, 1fr);">
                <?php
                if ($seats_result->num_rows > 0) {
                    while ($seat = $seats_result->fetch_assoc()) {
                        $is_booked = in_array($seat['seat_id'], $booked_seats);
                        $status_class = $is_booked ? 'booked' : 'available';
                ?>
                        <div class="seat <?php echo $status_class; ?>"
                            data-id="<?php echo $seat['seat_id']; ?>"
                            data-price="<?php echo $seat['price']; ?>"
                            data-number="<?php echo $seat['seat_number']; ?>"
                            title="<?php echo $seat['seat_type']; ?> - ₹<?php echo $seat['price']; ?>">
                            <?php echo $seat['seat_number']; ?>
                        </div>
                        <?php
                    }
                } else {

                    $seat_count = 0;
                    $rows = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
                    $total_seats_limit = 100;

                    foreach ($rows as $row) {
                        for ($i = 1; $i <= 10; $i++) {
                            if ($seat_count >= $total_seats_limit) break;

                            $seat_number = $row . $i;
                            $seat_type = ($row == 'I' || $row == 'J') ? 'VIP' : (($row == 'G' || $row == 'H') ? 'Premium' : 'Regular');
                            $price = ($seat_type == 'VIP') ? 300 : (($seat_type == 'Premium') ? 200 : 150);

                            $conn->query("INSERT INTO seats (screen_id, seat_number, seat_type, price) VALUES ($screen_id, '$seat_number', '$seat_type', $price)");
                            $seat_count++;
                        }
                    }

                    $seats_result = $conn->query($seats_sql);
                    if ($seats_result->num_rows > 0) {
                        while ($seat = $seats_result->fetch_assoc()) {
                            $is_booked = in_array($seat['seat_id'], $booked_seats);
                            $status_class = $is_booked ? 'booked' : 'available';
                        ?>
                            <div class="seat <?php echo $status_class; ?>"
                                data-id="<?php echo $seat['seat_id']; ?>"
                                data-price="<?php echo $seat['price']; ?>"
                                data-number="<?php echo $seat['seat_number']; ?>"
                                title="<?php echo $seat['seat_type']; ?> - ₹<?php echo $seat['price']; ?>">
                                <?php echo $seat['seat_number']; ?>
                            </div>
                <?php
                        }
                    } else {
                        echo "<p class='text-center text-white'>Error generating seats. Please contact admin.</p>";
                    }
                }
                ?>
            </div>
            <div class="mt-4 d-flex justify-content-center gap-4">
                <div class="d-flex align-items-center">
                    <div class="seat available me-2"></div> Available
                </div>
                <div class="d-flex align-items-center">
                    <div class="seat selected me-2"></div> Selected
                </div>
                <div class="d-flex align-items-center">
                    <div class="seat booked me-2"></div> Booked
                </div>
            </div>
        </div>
        <div class="col-md-4 h-50">
            <div class="card">
                <div class="card-header d-flex justify-content-center align-items-center bg-danger text-white p-3">
                    <i class="fas fa-ticket me-3 fa-2xl"></i>
                    <h3 class="mb-0">Booking Summary</h3>
                </div>
                <div class="card-body">
                    <h5 class="text-white"><?php echo $show['title']; ?></h5>
                    <p class="text-white small">
                        <?php echo $show['theatre_name']; ?> | <?php echo $show['screen_name']; ?><br>
                        <?php echo date('D, d M Y', strtotime($show['show_date'])); ?> | <?php echo date('h:i A', strtotime($show['show_time'])); ?>
                    </p>
                    <hr>
                    <div id="selected-seats-display" class="text-white">
                        <p>No seats selected</p>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <h5 class="text-white">Total Amount:</h5>
                        <h5 id="total-price" class="text-white">₹0</h5>
                    </div>
                    <form action="booking_confirmation.php" method="POST" id="booking-form">
                        <input type="hidden" name="showtime_id" value="<?php echo $showtime_id; ?>">
                        <input type="hidden" name="selected_seats" id="selected_seats_input">
                        <input type="hidden" name="total_amount" id="total_amount_input">
                        <button type="submit" class="btn auth-btn w-100 mt-3" id="proceed-btn" disabled>Proceed to Payment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/seat.js"></script>

<?php require_once 'includes/footer.php'; ?>