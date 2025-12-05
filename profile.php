<?php require_once 'controllers/profile_process.php'; ?>

<div class="container my-5 dark-theme">
    <div class="row g-4">
        <div class="col-lg-3">
            <div class="profile-sidebar">
                <div class="avatar-circle bg-danger">
                    <?php echo $initials; ?>
                </div>
                <h5 class="mb-1"><?php echo htmlspecialchars($user['name']); ?></h5>
                <p class="text-muted small mb-4"><?php echo htmlspecialchars($user['email']); ?></p>
                <div class="d-grid gap-2 sidebar-nav">
                    <a href="membership.php" class="bg-secondary text-white px-3 py-2 text-decoration-none rounded mb-1">
                        <i class="fas fa-ticket-alt"></i> Membership
                    </a>
                    <a href="account_settings.php" class="bg-secondary text-white px-3 py-2 text-decoration-none rounded mb-1">
                        <i class="fas fa-gear"></i> Account Settings
                    </a>
                    <a href="logout.php" class="auth-btn text-white px-3 py-2 text-decoration-none rounded mt-2">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="main-content-card">
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom border-secondary pb-3">
                    <h4 class="mb-0">MY PROFILE INFO</h4>
                    <button class="btn btn-success px-4" onclick="toggleEditMode()">
                        <i class="fas fa-edit me-1"></i> Edit Profile
                    </button>
                </div>
                <div id="view-mode">
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-user"></i> Full Name</span>
                        <span class="info-value"><?php echo htmlspecialchars($user['name']); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-user-tag"></i> Username</span>
                        <span class="info-value"><?php echo htmlspecialchars($username); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-envelope"></i> Email</span>
                        <span class="info-value"><?php echo htmlspecialchars($user['email']); ?></span>
                    </div>
                    <div class="info-row border-0">
                        <span class="info-label"><i class="fas fa-phone"></i> Phone</span>
                        <span class="info-value"><?php echo !empty($user['phone']) ? htmlspecialchars($user['phone']) : 'Not provided'; ?></span>
                    </div>
                </div>
                <div id="edit-mode" style="display: none;">
                    <form method="POST" action="">
                        <input type="hidden" name="update_profile" value="1">
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control bg-dark text-white border-secondary" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" class="form-control bg-dark text-white border-secondary" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>">
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-secondary" onclick="toggleEditMode()">Cancel</button>
                            <button type="submit" class="btn auth-btn">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="stat-card d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="text-primary mb-3"><i class="fas fa-ticket-alt me-2"></i>Total Bookings</h5>
                            <h6 class="mb-1">My Bookings</h6>
                            <p class="text-white small mb-0">Quickly access your past and upcoming movie tickets in one place.</p>
                        </div>
                        <div class="stat-count">
                            <?php echo $booking_stats['total_bookings']; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="stat-card">
                        <h5 class="text-danger mb-3"><i class="fas fa-headset me-2"></i>Contact/Support</h5>
                        <h6 class="mb-1">Help & Support</h6>
                        <p class="text-white small mb-0">Need assistance with a booking or payment? We're here to help.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/profile.js"></script>

<?php require_once 'includes/footer.php'; ?>