<?php require_once 'controllers/dashboard_process.php'; ?>

<div class="container-fluid">
    <div class="admin-header">
        <h2 class="admin-title">Dashboard Overview</h2>
        <div class="text-white-50">Welcome Back, Admin!!</div>
    </div>
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-details">
                    <h3><?php echo $movies_count; ?></h3>
                    <p>Total Movies</p>
                </div>
                <div class="stat-icon primary">
                    <i class="fas fa-film"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-details">
                    <h3><?php echo $theatres_count; ?></h3>
                    <p>Total Theatres</p>
                </div>
                <div class="stat-icon danger">
                    <i class="fas fa-building"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-details">
                    <h3><?php echo $bookings_count; ?></h3>
                    <p>Total Bookings</p>
                </div>
                <div class="stat-icon success">
                    <i class="fas fa-ticket-alt"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-details">
                    <h3><?php echo $users_count; ?></h3>
                    <p>Total Users</p>
                </div>
                <div class="stat-icon warning">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="admin-table-card">
        <h5 class="text-white mb-4">Recent Bookings</h5>
        <div class="table-responsive">
            <table class="table custom-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Movie</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($recent_bookings->num_rows > 0) {
                        while ($row = $recent_bookings->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td><span class='badge bg-secondary'>#" . $row['booking_id'] . "</span></td>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['title'] . "</td>";
                            echo "<td><span class='text-danger'>₹" . $row['total_amount'] . "</span></td>";
                            echo "<td>" . date('d M Y, h:i A', strtotime($row['booking_date'])) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center text-muted py-4'>No bookings found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
            <nav aria-label="Page navigation" class="mt-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                        <a class="page-link bg-dark text-white border-secondary" href="?page=<?php echo $page - 1; ?>">Previous</a>
                    </li>
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                            <a class="page-link <?php echo ($page == $i) ? 'bg-danger border-danger' : 'bg-dark text-white border-secondary'; ?>" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                        <a class="page-link bg-dark text-white border-secondary" href="?page=<?php echo $page + 1; ?>">Next</a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</div>

</div> <!-- End of admin-content -->
</div> <!-- End of admin-container -->

</body>

</html>