<?php 
require_once 'includes/header.php'; 
?>

<!-- Add Membership CSS -->
<link rel="stylesheet" href="assets/css/membership.css">

<!-- Premium Hero Section -->
<div class="membership-hero">
    <div class="hero-glow"></div>
    <div class="container position-relative z-1">
        <span class="badge bg-danger mb-3 px-3 py-2 rounded-pill">MOVIEFLIX CLUB</span>
        <h1 class="display-2 fw-bold text-white mb-4">Elevate Your Cinema<br>Experience</h1>
        <p class="lead text-white-50 mb-5" style="max-width: 600px; margin: 0 auto;">Join the exclusive club of movie buffs. Save fees, get free tickets, and enjoy VIP treatment every time you visit.</p>
    </div>
</div>

<!-- Benefits Grid -->
<div class="container mb-5" style="margin-top: -60px; position: relative; z-index: 2;">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="benefit-icon-box">
                <i class="fas fa-ban benefit-icon"></i>
                <h4 class="text-white">Zero Convenience Fees</h4>
                <p class="text-white-50 small mb-0">Waived on every single ticket. Save up to ₹50 per transaction.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="benefit-icon-box">
                <i class="fas fa-ticket-alt benefit-icon"></i>
                <h4 class="text-white">Free Monthly Tickets</h4>
                <p class="text-white-50 small mb-0">Get complimentary tickets every month. Watch more for less.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="benefit-icon-box">
                <i class="fas fa-utensils benefit-icon"></i>
                <h4 class="text-white">F&B Discounts</h4>
                <p class="text-white-50 small mb-0">Flat discounts on Popcorn & Combos. No minimum spend.</p>
            </div>
        </div>
    </div>
</div>

<!-- Pricing Cards -->
<div class="container my-5 py-5">
    <div class="text-center mb-5">
        <h2 class="display-5 fw-bold text-white">Choose Your Plan</h2>
        <p class="text-white-50">Flexible options tailored for every movie lover</p>
    </div>
    
    <div class="row g-4 align-items-center justify-content-center">
        <!-- Star Plan -->
        <div class="col-lg-4 col-md-6">
            <div class="pricing-card">
                <div class="plan-name">Star</div>
                <div class="plan-price">₹199<span class="plan-duration">/3mo</span></div>
                <ul class="features-list">
                    <li><i class="fas fa-check check-icon"></i> 5 No-Fee Bookings</li>
                    <li><i class="fas fa-check check-icon"></i> 10% F&B Discount</li>
                    <li><i class="fas fa-check check-icon"></i> 2 Free Cancellations</li>
                    <li><i class="fas fa-times cross-icon"></i> Free Tickets</li>
                    <li><i class="fas fa-times cross-icon"></i> Premiere Access</li>
                </ul>
                <button class="btn btn-outline-light rounded-pill w-100 py-3 fw-bold">Join Club</button>
            </div>
        </div>

        <!-- Superstar Plan -->
        <div class="col-lg-4 col-md-6">
            <div class="pricing-card plan-gold">
                <div class="best-value-ribbon">POPULAR</div>
                <div class="plan-name">Superstar</div>
                <div class="plan-price">₹499<span class="plan-duration">/6mo</span></div>
                <p class="text-danger small fw-bold mb-4">SAVE ₹100 ANNUALLY</p>
                <ul class="features-list">
                    <li><i class="fas fa-check check-icon"></i> Unlimited No-Fee Bookings</li>
                    <li><i class="fas fa-check check-icon"></i> 20% F&B Discount</li>
                    <li><i class="fas fa-check check-icon"></i> Unlimited Cancellations</li>
                    <li><i class="fas fa-check check-icon"></i> 1 Free Weekday Ticket/mo</li>
                    <li><i class="fas fa-times cross-icon"></i> Premiere Access</li>
                </ul>
                <button class="btn auth-btn rounded-pill w-100 py-3 fw-bold shadow-lg">Join Club</button>
            </div>
        </div>

        <!-- Legend Plan -->
        <div class="col-lg-4 col-md-6">
            <div class="pricing-card plan-platinum">
                <div class="plan-name">Legend</div>
                <div class="plan-price">₹999<span class="plan-duration">/yr</span></div>
                <ul class="features-list">
                    <li><i class="fas fa-check check-icon"></i> Unlimited No-Fee Bookings</li>
                    <li><i class="fas fa-check check-icon"></i> Flat 30% F&B Discount</li>
                    <li><i class="fas fa-check check-icon"></i> Unlimited Cancellations</li>
                    <li><i class="fas fa-check check-icon"></i> 2 Free Any-Day Tickets/mo</li>
                    <li><i class="fas fa-check check-icon"></i> Exclusive Premiere Access</li>
                </ul>
                <button class="btn btn-outline-light rounded-pill w-100 py-3 fw-bold">Join Club</button>
            </div>
        </div>
    </div>
</div>

<!-- Comparison Table -->
<div class="container my-5 pb-5">
    <div class="comparison-section">
        <h3 class="text-white text-center mb-5">Compare Features</h3>
        <div class="table-responsive">
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Features</th>
                        <th>Star</th>
                        <th class="highlight-col">Superstar</th>
                        <th>Legend</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Convenience Fee Waiver</td>
                        <td>5 Bookings</td>
                        <td class="highlight-col">Unlimited</td>
                        <td>Unlimited</td>
                    </tr>
                    <tr>
                        <td>F&B Discount</td>
                        <td>10%</td>
                        <td class="highlight-col">20%</td>
                        <td>Flat 30%</td>
                    </tr>
                    <tr>
                        <td>Free Monthly Tickets</td>
                        <td>-</td>
                        <td class="highlight-col">1 (Weekday)</td>
                        <td>2 (Any Day)</td>
                    </tr>
                    <tr>
                        <td>Cancellation Policy</td>
                        <td>2 Free</td>
                        <td class="highlight-col">Unlimited</td>
                        <td>Unlimited</td>
                    </tr>
                    <tr>
                        <td>Birthday Special</td>
                        <td>-</td>
                        <td class="highlight-col">Free Popcorn</td>
                        <td>Free Ticket + Combo</td>
                    </tr>
                    <tr>
                        <td>Support Priority</td>
                        <td>Standard</td>
                        <td class="highlight-col">Priority</td>
                        <td>Dedicated Manager</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- FAQ Section -->
<div class="container my-5 mb-5 pb-5">
    <h2 class="text-center text-white mb-5">Common Questions</h2>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="accordion" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                            How do I redeem my free tickets?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                           Free tickets are credited to your account on the 1st of every month. You can select "Use Membership Credit" at checkout to redeem them. Unused tickets do not carry over.
                        </div>
                    </div>
                </div>
                <!-- ... more FAQs can be added if needed, keeping it concise ... -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                            Is the F&B discount applicable online?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Yes! The discount is automatically applied when you order food online or show your membership QR code at the counter.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
