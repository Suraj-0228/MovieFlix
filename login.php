<?php require_once 'controllers/login_process.php'; ?>

<div class="auth-wrapper">
    <div class="container d-flex justify-content-center">
        <div class="auth-card">
            <div class="text-center mb-4">
                <i class="fas fa-film fa-3x text-danger mb-3"></i>
                <h2 class="auth-title">Welcome Back</h2>
                <p class="auth-subtitle">Login to continue your cinematic journey</p>
            </div>
            <!-- Alerts replaced by SweetAlert -->
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
                    <a href="#" class="text-danger text-decoration-none small">Forgot Password?</a>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn auth-btn btn-auth">Login</button>
                </div>
                <div class="text-center mt-4">
                    <p class="text-white mb-0">Don't have an account? <a href="register.php" class="text-danger fw-bold text-decoration-none">Register here</a></p>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    <?php if ($error): ?>
        Swal.fire({
            icon: 'error',
            title: 'Login Failed',
            text: '<?php echo $error; ?>',
            background: '#1f1f1f',
            color: '#fff',
            confirmButtonColor: '#e50914'
        });
    <?php endif; ?>

    <?php if (isset($login_success) && $login_success): ?>
        Swal.fire({
            icon: 'success',
            title: 'Welcome Back!',
            text: 'Login Successful. Redirecting To...',
            background: '#1f1f1f',
            color: '#fff',
            confirmButtonColor: '#e50914',
            timer: 2000,
            showConfirmButton: false
        }).then(() => {
            window.location.href = '<?php echo $redirect_url; ?>';
        });
    <?php endif; ?>

    <?php if ($success_msg): ?>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '<?php echo $success_msg; ?>',
            background: '#1f1f1f',
            color: '#fff',
            confirmButtonColor: '#e50914'
        });
    <?php endif; ?>

    // Check for registration success parameter
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('registration') === 'success') {
        Swal.fire({
            icon: 'success',
            title: 'Registration Successful',
            text: 'You can Now Login to Your Account.',
            background: '#1f1f1f',
            color: '#fff',
            confirmButtonColor: '#e50914'
        });
    }
</script>
<script src="assets/js/login.js"></script>
<script src="assets/js/validation.js"></script>

<?php require_once 'includes/footer.php'; ?>