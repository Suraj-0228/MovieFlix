<?php
require_once 'controllers/settings_process.php';
require_once 'includes/header.php';

// Fetch user data for sidebar
if (isset($_SESSION['user_id'])) {
    $conn = new mysqli("localhost", "root", "", "movieflix_db");
    $stmt = $conn->prepare("SELECT name, email, phone FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $initials = strtoupper(substr($user['name'], 0, 1));
}
?>

<div class="container my-5 dark-theme">
    <div class="row g-4">
        <div class="col-lg-12">
            <div class="d-flex flex-column text-center mb-4 border-bottom border-secondary pb-3 position-relative">
                <div class="position-absolute start-0 top-50 translate-middle-y">
                    <a href="profile.php" class="btn btn-outline-light rounded-circle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
                <h2 class="mb-0 text-white"><i class="fas fa-user-cog me-3 text-primary"></i>Account Settings</h2>
                <p class="text-white-50 mb-0">Manage Your Security Preferences and Account Details Here.</p>
            </div>

            <?php if (!empty($success_message)): ?>
                <div class="alert alert-success border-0 bg-success bg-opacity-10 text-success mb-4 rounded-3">
                    <i class="fas fa-check-circle me-2"></i><?php echo $success_message; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger mb-4 rounded-3">
                    <i class="fas fa-exclamation-circle me-2"></i><?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            <div class="glass-card mb-5">
                <div class="d-flex align-items-center mb-4 border-bottom border-secondary pb-3">
                    <h4 class="mb-0 text-white"><i class="fas fa-lock me-3 text-gradient"></i>Change Password</h4>
                </div>
                
                <form method="POST" action="">
                    <div class="mb-4">
                        <label class="form-label text-white-50 small text-uppercase fw-bold ls-1">Current Password</label>
                        <input type="password" class="form-control bg-white text-dark border-secondary py-2" name="current_password" required placeholder="Enter Current Password">
                    </div>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label text-white-50 small text-uppercase fw-bold ls-1">New Password</label>
                            <input type="password" class="form-control bg-white text-dark border-secondary py-2" name="new_password" required minlength="6" placeholder="Min 6 Characters">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-white-50 small text-uppercase fw-bold ls-1">Confirm New Password</label>
                            <input type="password" class="form-control bg-white text-dark border-secondary py-2" name="confirm_password" required minlength="6" placeholder="Re-Enter New Password">
                        </div>
                    </div>
                    <div class="text-end mt-4">
                        <button type="submit" name="change_password" class="btn auth-btn rounded-pill px-5 fw-bold shadow-lg">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
            <div class="glass-card border border-danger border-opacity-25" style="background: rgba(220, 53, 69, 0.05);">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-4">
                    <div>
                        <h5 class="text-danger mb-2 fw-bold"><i class="fas fa-exclamation-triangle me-2"></i>Danger Zone!!</h5>
                        <p class="text-white-50 mb-0">Permanently Delete Your Account and All Associated Data. This Action Cannot Be Undone.</p>
                    </div>
                    <button type="button" class="btn auth-btn rounded-pill px-4" onclick="confirmDelete()">
                        Delete Account
                    </button>
                </div>
            </div>
            <form id="delete-form" method="POST" action="" style="display: none;">
                <input type="hidden" name="delete_account" value="1">
            </form>
        </div>
    </div>
</div>

<script>
function confirmDelete() {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be Able to Revert This! All Your Bookings and Data will be Permanently Deleted.",
        icon: 'warning',
        background: '#1f1f1f',
        color: '#fff',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form').submit();
        }
    })
}
</script>

<?php require_once 'includes/footer.php'; ?>
