<?php require_once 'controllers/booking_process.php'; ?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
            <div class="card shadow-sm border-0" style="background-color: #222;">
                <div class="card-header d-flex justify-content-center align-items-center bg-danger text-white p-3">
                    <i class="fas fa-ticket me-3 fa-2xl"></i>
                    <h3 class="mb-0">Booking Summary</h3>
                </div>
                <div class="card-body text-white">
                    <h5 class="card-title text-primary mb-3"><?php echo $show['title']; ?></h5>
                    <p class="small mb-3 text-white">
                        <i class="fas fa-map-marker-alt me-2 mb-2"></i><?php echo $show['theatre_name']; ?> | <?php echo $show['screen_name']; ?><br>
                        <i class="far fa-calendar-alt me-2 mb-2"></i><?php echo date('D, d M Y', strtotime($show['show_date'])); ?> | <?php echo date('h:i A', strtotime($show['show_time'])); ?>
                    </p>
                    <hr class="border-secondary">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Seats:</span>
                        <span><?php echo implode(', ', $seat_numbers); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tickets (<?php echo count($selected_seats); ?>):</span>
                        <span>₹<?php echo $total_amount; ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Convenience Fee:</span>
                        <span id="convenience-fee">₹0</span>
                    </div>
                    <hr class="border-secondary">
                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Total Payable:</span>
                        <span id="total-payable" class="text-white">₹<?php echo $total_amount; ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 order-md-1">
            <div class=" shadow-lg border-0" style="background-color: #1f1f1f;">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h3 class="mb-0 text-white">Select Payment Method</h3>
                </div>
                <div class="card-body p-4">
                    <?php if (isset($error_message)): ?>
                        <div class="alert alert-danger"><?php echo $error_message; ?></div>
                    <?php endif; ?>
                    <form method="POST" action="" id="payment-form">
                        <input type="hidden" name="showtime_id" value="<?php echo $showtime_id; ?>">
                        <input type="hidden" name="base_amount" id="base_amount" value="<?php echo $total_amount; ?>">
                        <input type="hidden" name="total_amount" id="final_total_amount" value="<?php echo $total_amount; ?>">
                        <input type="hidden" name="selected_seats_final" value="<?php echo base64_encode($selected_seats_json); ?>">
                        <input type="hidden" name="confirm_booking" value="1">
                        <input type="hidden" name="payment_method" id="payment_method" value="card">
                        <ul class="nav mb-4 border-bottom-0" id="paymentTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active text-white bg-transparent border-0 border-bottom border-danger border-2 rounded-0" id="tab-card" data-bs-toggle="tab" data-bs-target="#pills-card" type="button" role="tab" onclick="updatePaymentMethod('card')"><i class="fas fa-credit-card me-2"></i>Card (2% Fee)</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link text-muted bg-transparent border-0 rounded-0" id="tab-upi"
                                    data-bs-toggle="tab" data-bs-target="#pills-upi"
                                    type="button" role="tab" onclick="updatePaymentMethod('upi')">
                                    <i class="fas fa-mobile-alt me-2"></i>UPI (No Fee)</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link text-muted bg-transparent border-0 rounded-0" id="tab-cash" data-bs-toggle="tab" data-bs-target="#pills-cash" type="button" role="tab" onclick="updatePaymentMethod('cash')"><i class="fas fa-money-bill-wave me-2"></i>Cash (No Fee)</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-card" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label text-white">Card Number</label>
                                        <input type="text" class="form-control bg-white text-dark" id="card_number" placeholder="XXXX XXXX XXXX XXXX" maxlength="19">
                                        <p class="text-danger fw-semibold small mt-1 error-msg"></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-white">Expiry Date</label>
                                        <input type="text" class="form-control bg-white text-dark" id="card_expiry" placeholder="MM/YY" maxlength="5">
                                        <p class="text-danger fw-semibold small mt-1 error-msg"></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-white">CVV</label>
                                        <input type="password" class="form-control bg-white text-dark" id="card_cvv" placeholder="1234" maxlength="4">
                                        <p class="text-danger fw-semibold small mt-1 error-msg"></p>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label text-white">Card Holder Name</label>
                                        <input type="text" class="form-control bg-white text-dark" id="card_name" placeholder="Name on Card">
                                        <p class="text-danger fw-semibold small mt-1 error-msg"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-upi" role="tabpanel">
                                <div class="mb-3">
                                    <label class="form-label text-white">UPI ID</label>
                                    <input type="text" class="form-control bg-white text-dark" id="upi_id" placeholder="username@bank">
                                    <p class="text-danger small mt-1 error-msg"></p>
                                    <div class="form-text text-danger">Enter your VPA (Virtual Payment Address)</div>
                                </div>
                                <div class="mb-3">
                                    <p class="text-white mb-2">Scan the QR code using your preferred UPI app to complete the payment.</p>
                                </div>
                                <div class="mb-3 d-flex justify-content-center">
                                    <img src="assets/images/upi_scanner.jpg" alt="UPI Payment" class="upi-img">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-cash" role="tabpanel">
                                <div class="alert alert-info bg-dark border-secondary text-white">
                                    <i class="fas fa-info-circle me-2"></i>Please pay the amount at the counter to confirm your tickets.
                                </div>
                            </div>
                        </div>
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn auth-btn" id="pay-button">Pay ₹<?php echo $total_amount; ?></button>
                            <a href="seat_selection.php?id=<?php echo $showtime_id; ?>" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
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
            fee = Math.round(baseAmount * 0.05); // 5% fee
        }

        const total = baseAmount + fee;

        document.getElementById('convenience-fee').textContent = '₹' + fee;
        document.getElementById('total-payable').textContent = '₹' + total;
        document.getElementById('final_total_amount').value = total;
        document.getElementById('pay-button').textContent = 'Pay ₹' + total;
    }

    updatePaymentMethod('card');
</script>
<script src="assets/js/payment_validation.js"></script>

<?php require_once 'includes/footer.php'; ?>