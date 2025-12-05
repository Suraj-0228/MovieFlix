<?php require_once 'controllers/booking_process.php'; ?>

<div class="container my-5">
    <div class="row g-5">
        <!-- Left Column: Payment Options -->
        <div class="col-md-8">
            <h3 class="mb-4 text-white">Select Payment Method</h3>
            
            <form method="POST" action="" id="payment-form">
                <!-- Hidden Fields Required for Processing -->
                <input type="hidden" name="confirm_booking" value="1">
                <input type="hidden" name="showtime_id" value="<?php echo $showtime_id; ?>">
                <input type="hidden" name="selected_seats_final" value="<?php echo base64_encode(json_encode($selected_seats)); ?>">
                <input type="hidden" name="total_amount" id="final_total_amount" value="<?php echo $total_amount; ?>">
                <input type="hidden" name="payment_method" id="payment_method" value="card">

                <div class="card border-secondary">
                    <div class="card-header border-secondary p-0">
                        <ul class="nav nav-tabs border-0" id="paymentTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active text-white bg-transparent border-0 border-bottom border-danger border-3 rounded-0 py-3 px-4" id="tab-card" data-bs-toggle="tab" data-bs-target="#pills-card" type="button" role="tab" onclick="updatePaymentMethod('card')">
                                    <i class="fas fa-credit-card me-2"></i>Card
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link text-muted bg-transparent border-0 rounded-0 py-3 px-4" id="tab-upi" data-bs-toggle="tab" data-bs-target="#pills-upi" type="button" role="tab" onclick="updatePaymentMethod('upi')">
                                    <i class="fas fa-mobile-alt me-2"></i>UPI
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link text-muted bg-transparent border-0 rounded-0 py-3 px-4" id="tab-cash" data-bs-toggle="tab" data-bs-target="#pills-cash" type="button" role="tab" onclick="updatePaymentMethod('cash')">
                                    <i class="fas fa-money-bill-wave me-2"></i>Cash
                                </button>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="card-body p-4">
                        <div class="tab-content" id="pills-tabContent">
                            <!-- Card Payment -->
                            <div class="tab-pane fade show active" id="pills-card" role="tabpanel">
                                <div class="alert alert-dark border border-secondary mb-4">
                                    <i class="fas fa-info-circle me-2 text-info"></i>A 5% Convenience Fee Applies to Card Payments!!
                                </div>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label text-white-50">Card Number</label>
                                        <input type="text" class="form-control bg-white text-black border-secondary" id="card_number" placeholder="0000 0000 0000 0000" maxlength="19">
                                        <p class="text-danger small mt-1 error-msg"></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-white-50">Expiry Date</label>
                                        <input type="text" class="form-control bg-white text-black border-secondary" id="card_expiry" placeholder="MM/YY" maxlength="5">
                                        <p class="text-danger small mt-1 error-msg"></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-white-50">CVV</label>
                                        <input type="password" class="form-control bg-white text-black border-secondary" id="card_cvv" placeholder="123" maxlength="4">
                                        <p class="text-danger small mt-1 error-msg"></p>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label text-white-50">Card Holder Name</label>
                                        <input type="text" class="form-control bg-white text-black border-secondary" id="card_name" placeholder="Name on Card">
                                        <p class="text-danger small mt-1 error-msg"></p>
                                    </div>
                                </div>
                            </div>

                            <!-- UPI Payment -->
                            <div class="tab-pane fade" id="pills-upi" role="tabpanel">
                                <div class="alert alert-dark bg-opacity-10 border-secondary mb-4">
                                    <i class="fas fa-info-circle me-2 text-info"></i>A 2% Convenience Fee Applies to UPI Payments!!
                                </div>
                                <div class="mb-4">
                                    <label class="form-label text-white-50">UPI ID</label>
                                    <input type="text" class="form-control bg-white text-black border-secondary" id="upi_id" placeholder="username@upi">
                                    <p class="text-danger small mt-1 error-msg"></p>
                                </div>
                                <div class="text-center p-3 bg-white rounded" style="max-width: 250px; margin: 0 auto;">
                                    <img src="assets/images/upi_scanner.jpg" alt="UPI QR Code" class="img-fluid">
                                    <p class="text-dark small mt-2 mb-0">Scan to Pay</p>
                                </div>
                            </div>

                            <!-- Cash Payment -->
                            <div class="tab-pane fade" id="pills-cash" role="tabpanel">
                                <div class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="fas fa-store fa-3x text-warning"></i>
                                    </div>
                                    <h5 class="text-white">Pay at Counter</h5>
                                    <p class="text-white-50">Please, Pay the Amount at the Ticket Counter to Confirm Your Seats!!</p>
                                    <div class="alert alert-warning d-inline-block mt-2">
                                        <i class="fas fa-exclamation-triangle me-2"></i>Seats will Be Reserved for 15 Minutes Only.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pay Button -->
                        <div class="d-grid gap-2 mt-4 pt-4 border-top border-secondary">
                            <button type="submit" class="btn auth-btn btn-lg fw-bold" id="pay-button">Pay ₹<?php echo $total_amount; ?></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Right Column: Booking Summary -->
        <div class="col-md-4">
            <div class="card bg-dark border-secondary shadow-lg sticky-top" style="top: 100px; z-index: 1000;">
                <div class="card-header bg-danger text-white p-3 text-center">
                    <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Booking Summary</h5>
                </div>
                <div class="card-body p-4">
                    <h4 class="text-white mb-1"><?php echo $show['title']; ?></h4>
                    <p class="text-white-50 small mb-4"><?php echo $show['theatre_name']; ?> | <?php echo $show['screen_name']; ?></p>

                    <div class="d-flex justify-content-between mb-3 text-white-50">
                        <span><i class="far fa-calendar me-2"></i>Date</span>
                        <span class="text-white"><?php echo date('D, d M', strtotime($show['show_date'])); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 text-white-50">
                        <span><i class="far fa-clock me-2"></i>Time</span>
                        <span class="text-white"><?php echo date('h:i A', strtotime($show['show_time'])); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 text-white-50">
                        <span><i class="fas fa-chair me-2"></i>Seats (<?php echo count($selected_seats); ?>)</span>
                        <span class="text-white text-end" style="max-width: 150px;"><?php echo implode(', ', $seat_numbers); ?></span>
                    </div>

                    <hr class="border-secondary my-4">

                    <div class="d-flex justify-content-between mb-2 text-white-50">
                        <span>Ticket Price</span>
                        <span class="text-white">₹<?php echo $total_amount; ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 text-white-50">
                        <span>Convenience Fee</span>
                        <span class="text-white" id="convenience-fee">₹0</span>
                    </div>

                    <hr class="border-secondary my-3">

                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h5 text-white mb-0">Total:</span>
                        <span class="h4 text-danger mb-0 fw-bold" id="total-payable">₹<?php echo $total_amount; ?></span>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-secondary p-3 text-center">
                    <a href="seat_selection.php?id=<?php echo $showtime_id; ?>" class="text-white-50 text-decoration-none small hover-text-white">
                        <i class="fas fa-arrow-left me-1"></i>Change Seats
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const baseAmount = <?php echo $total_amount; ?>;

    function updatePaymentMethod(method) {
        document.getElementById('payment_method').value = method;
        calculateTotal(method);

        // Update Tab Styles
        document.querySelectorAll('.nav-link').forEach(btn => {
            btn.classList.remove('active', 'text-white', 'border-bottom', 'border-danger', 'border-2');
            btn.classList.add('text-muted');
        });
        const activeBtn = document.getElementById('tab-' + method);
        if (activeBtn) {
            activeBtn.classList.add('active', 'text-white', 'border-bottom', 'border-danger', 'border-2');
            activeBtn.classList.remove('text-muted');
        }
    }

    function calculateTotal(method) {
        let fee = 0;
        if (method === 'card') {
            fee = Math.round(baseAmount * 0.42); // 5% fee
        } else if (method === 'upi') {
            fee = Math.round(baseAmount * 0.12); // 2% fee
        }

        const total = baseAmount + fee;

        document.getElementById('convenience-fee').textContent = '₹' + fee;
        document.getElementById('total-payable').textContent = '₹' + total;
        document.getElementById('final_total_amount').value = total;
        document.getElementById('pay-button').textContent = 'Pay ₹' + total;
    }

    updatePaymentMethod('card');
</script>
<script>
    <?php if (isset($error_message)): ?>
        Swal.fire({
            icon: 'error',
            title: 'Booking Failed',
            text: '<?php echo $error_message; ?>',
            background: '#1f1f1f',
            color: '#fff',
            confirmButtonColor: '#e50914'
        });
    <?php endif; ?>
</script>
<script src="assets/js/payment_validation.js"></script>

<?php require_once 'includes/footer.php'; ?>