<?php require_once 'controllers/login_process.php'; ?>

<div class="auth-wrapper">
    <div class="container d-flex justify-content-center">
        <div class="auth-card">
            <div class="text-center mb-4">
                <i class="fas fa-film fa-3x text-danger mb-3"></i>
                <h2 class="auth-title">Welcome Back</h2>
                <p class="auth-subtitle">Login to continue your cinematic journey</p>
            </div>
            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i><?php echo $error; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if ($success_msg): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i><?php echo $success_msg; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="mb-4">
                    <label for="email" class="form-label text-white">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white text-dark"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control bg-white text-dark" id="email" name="email" placeholder="name@example.com">
                    </div>
                    <p class="text-danger fw-semibold small mt-1 error-msg"></p>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label text-white">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white text-dark"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control bg-white text-dark" id="password" name="password" placeholder="Enter your password">
                        <button class="btn btn-outline-secondary bg-white text-dark border-start-0" type="button" id="togglePassword" style="border-color: #ced4da;">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <p class="text-danger fw-semibold small mt-1 error-msg"></p>
                </div>
                <div class="mb-4 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input bg-dark border-secondary" id="remember" name="remember">
                        <label class="form-check-label text-white" for="remember">Remember me</label>
                    </div>
                    <a href="#" class="text-primary text-decoration-none small">Forgot Password?</a>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-auth">Login</button>
                </div>
                <div class="text-center mt-4">
                    <p class="text-white mb-0">Don't have an account? <a href="register.php" class="text-primary fw-bold text-decoration-none">Register here</a></p>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="assets/js/login.js"></script>
<script src="assets/js/validation.js"></script>

<?php require_once 'includes/footer.php'; ?>