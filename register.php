<?php require_once 'controllers/register_process.php'; ?>

<div class="auth-wrapper">
    <div class="container d-flex justify-content-center">
        <div class="auth-card">
            <div class="text-center mb-4">
                <i class="fas fa-user-plus fa-3x text-danger mb-3"></i>
                <h2 class="auth-title">Create Account</h2>
                <p class="auth-subtitle">Join MovieFlix and start booking your tickets</p>
            </div>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="name" class="form-label text-white-50">Full Name</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white text-dark"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control bg-white text-dark" id="name" name="name" placeholder="Enter your full name">
                    </div>
                    <p class="text-danger fw-semibold small mt-1 error-msg"></p>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label text-white-50">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white text-dark"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control bg-white text-dark" id="email" name="email" placeholder="name@example.com">
                    </div>
                    <p class="text-danger fw-semibold small mt-1 error-msg"></p>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label text-white-50">Phone Number</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white text-dark"><i class="fas fa-phone"></i></span>
                        <input type="tel" class="form-control bg-white text-dark" id="phone" name="phone" placeholder="Enter your phone number">
                    </div>
                    <p class="text-danger fw-semibold small mt-1 error-msg"></p>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label text-white-50">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white text-dark"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control bg-white text-dark" id="password" name="password" placeholder="Create a password">
                        <button class="btn btn-outline-secondary bg-white text-dark border-start-0" type="button" id="togglePassword" style="border-color: #ced4da;">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <p class="text-danger fw-semibold small mt-1 error-msg"></p>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-auth">Register</button>
                </div>
                <div class="text-center mt-4">
                    <p class="text-white-50 mb-0">Already have an account? <a href="login.php" class="text-primary fw-bold text-decoration-none">Login here</a></p>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="assets/js/login.js"></script>
<script src="assets/js/validation.js"></script>

<?php require_once 'includes/footer.php'; ?>