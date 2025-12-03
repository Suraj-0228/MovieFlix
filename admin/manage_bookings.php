<?php require_once 'controllers/manage_booking_process.php'; ?>

<div class="container-fluid">
    <div class="admin-header">
        <div>
            <h2 class="admin-title">Manage Bookings</h2>
            <p class="text-white mt-2">View and Manage all User Bookings.</p>
        </div>
    </div>
    <div class="admin-table-card">
        <div class="table-responsive">
            <table class="table custom-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Movie</th>
                        <th>Theatre</th>
                        <th>Showtime</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($bookings->num_rows > 0): ?>
                        <?php while ($row = $bookings->fetch_assoc()): ?>
                            <tr>
                                <td><span class="text-white">#<?php echo $row['booking_id']; ?></span></td>
                                <td>
                                    <div class="fw-bold"><?php echo $row['user_name']; ?></div>
                                    <small class="text-muted"><?php echo $row['email']; ?></small>
                                </td>
                                <td class="fw-bold"><?php echo $row['title']; ?></td>
                                <td>
                                    <?php echo $row['theatre_name']; ?> <br>
                                    <small class="text-muted"><?php echo $row['screen_name']; ?></small>
                                </td>
                                <td>
                                    <div class="text-white"><?php echo date('d M Y', strtotime($row['show_date'])); ?></div>
                                    <small class="text-primary"><?php echo date('h:i A', strtotime($row['show_time'])); ?></small>
                                </td>
                                <td><span class="text-success fw-bold">₹<?php echo $row['total_amount']; ?></span></td>
                                <td><?php echo date('d M Y h:i A', strtotime($row['booking_date'])); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo ($row['status'] == 'confirmed') ? 'success' : 'danger'; ?>">
                                        <?php echo ucfirst($row['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="?delete=<?php echo $row['booking_id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are You Sure!! You want to Delete this Booking??')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted">No bookings found.</td>
                        </tr>
                    <?php endif; ?>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>