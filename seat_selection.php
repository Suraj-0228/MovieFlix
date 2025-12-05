<?php require_once 'controllers/seat_process.php'; ?>

<div class="container my-5 seat-selection-container">
    <div class="row g-5">
        <!-- Left Column: Seat Grid -->
        <div class="col-lg-8">
            <h2 class="section-title text-center mb-5 display-5 fw-bold">Select Your Seats</h2>
            
            <!-- Cinema Screen Visual -->
            <div class="cinema-screen-container">
                <div class="cinema-screen"></div>
            </div>

            <!-- Seat Grid -->
            <div class="seat-grid-container">
                <div class="seat-grid" style="grid-template-columns: repeat(10, 1fr);">
                    <?php
                    // Helper function to check booking status
                    function isBooked($seat_id, $booked_seats) {
                        return in_array($seat_id, $booked_seats);
                    }

                    if ($seats_result->num_rows > 0) {
                        while ($seat = $seats_result->fetch_assoc()) {
                            $is_booked = isBooked($seat['seat_id'], $booked_seats);
                            $status_class = $is_booked ? 'booked' : 'available';
                            
                            // Determine seat type class based on DB OR Row Letter (Visual Override)
                            $row = substr($seat['seat_number'], 0, 1);
                            $type_class = 'regular';
                            
                            // Check DB Type first
                            if (stripos($seat['seat_type'], 'Premium') !== false) {
                                $type_class = 'premium';
                            } elseif (stripos($seat['seat_type'], 'VIP') !== false) {
                                $type_class = 'vip';
                            } 
                            // Fallback/Enforce based on Row (Standardize the visual)
                            if ($row == 'I' || $row == 'J') {
                                $type_class = 'vip';
                            } elseif ($row == 'G' || $row == 'H') {
                                $type_class = 'premium';
                            }
                    ?>
                            <div class="seat <?php echo $status_class; ?> <?php echo $type_class; ?>"
                                data-id="<?php echo $seat['seat_id']; ?>"
                                data-price="<?php echo $seat['price']; ?>"
                                data-number="<?php echo $seat['seat_number']; ?>"
                                title="<?php echo $seat['seat_type']; ?> - ₹<?php echo $seat['price']; ?>">
                                <?php echo $seat['seat_number']; ?>
                            </div>
                    <?php
                        }
                    } else {
                        // Fallback/Demo Logic if DB is empty (should normally be populated)
                        echo "<p class='text-white text-center col-12'>No seats found for this screen.</p>";
                    }
                    ?>
                </div>
            </div>

            <!-- Legend -->
            <div class="d-flex justify-content-center">
                <div class="seat-legend">
                    <div class="legend-item">
                        <div class="seat available regular"  style="width:20px; height:20px; cursor:default;"></div>
                        <span>Regular (₹150)</span>
                    </div>
                    <div class="legend-item">
                        <div class="seat available premium"  style="width:20px; height:20px; cursor:default;"></div>
                        <span>Premium (₹200)</span>
                    </div>
                    <div class="legend-item">
                        <div class="seat available vip"  style="width:20px; height:20px; cursor:default;"></div>
                        <span>VIP (₹300)</span>
                    </div>
                    <div class="legend-item">
                        <div class="seat selected"  style="width:20px; height:20px; cursor:default;"></div>
                        <span>Selected</span>
                    </div>
                    <div class="legend-item">
                        <div class="seat booked"  style="width:20px; height:20px; cursor:default;"></div>
                        <span>Booked</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Booking Summary -->
        <div class="col-lg-4">
            <div class="card bg-dark border-secondary shadow-lg sticky-top" style="top: 100px; z-index: 1000;">
                <div class="card-header bg-danger text-white p-3 text-center">
                    <h5 class="mb-0"><i class="fas fa-ticket-alt me-2"></i>Booking Summary</h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">                        
                        <div>
                            <h5 class="text-white mb-1"><?php echo $show['title']; ?></h5>
                        </div>
                        <span class="badge bg-secondary"><?php echo $show['screen_name']; ?></span>
                    </div>

                    <div class="mb-3 text-white-50 small">
                        <div class="d-flex justify-content-between mb-1">
                            <span><i class="fas fa-map-marker-alt me-2"></i>Location</span>
                            <span class="text-white"><?php echo $show['theatre_name']; ?></span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span><i class="far fa-calendar-alt me-2"></i>Showtime</span>
                            <span class="text-white"><?php echo date('D, d M | h:i A', strtotime($show['show_date'] . ' ' . $show['show_time'])); ?></span>
                        </div>
                    </div>

                    <hr class="border-secondary">

                    <div class="mb-3">
                        <label class="text-white-50 mb-2 small">Selected Seats</label>
                        <div id="selected-seats-display" class="d-flex flex-wrap gap-2 text-white">
                            <span class="text-secondary fst-italic">No Seats Selected!!</span>
                        </div>
                    </div>

                    <hr class="border-secondary">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="h5 text-white mb-0">Total Amount</span>
                        <span class="h3 text-danger mb-0 fw-bold" id="total-price">₹0</span>
                    </div>

                    <form action="booking_confirmation.php" method="POST" id="booking-form">
                        <input type="hidden" name="showtime_id" value="<?php echo $showtime_id; ?>">
                        <input type="hidden" name="selected_seats" id="selected_seats_input">
                        <input type="hidden" name="total_amount" id="total_amount_input">
                        
                        <button type="submit" class="btn auth-btn rounded-3 w-100 py-3 fw-semibold shadow-lg" id="proceed-btn" disabled>
                            Proceed to Payment <i class="fas fa-chevron-right ms-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/seat.js"></script>

<?php require_once 'includes/footer.php'; ?>