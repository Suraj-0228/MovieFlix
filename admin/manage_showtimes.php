<?php require_once 'controllers/manage_showtimes_process.php'; ?>

<div class="container-fluid">
    <div class="admin-header">
        <div>
            <h2 class="admin-title">Manage Showtimes</h2>
            <p class="text-white mt-2">Schedule Movies for different Screens and Times.</p>
        </div>
        <button class="btn auth-btn" data-bs-toggle="modal" data-bs-target="#showtimeModal" onclick="resetForm()">
            <i class="fas fa-plus me-2"></i>Add New Showtime
        </button>
    </div>
    <div class="admin-table-card">
        <div class="table-responsive">
            <table class="table custom-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Movie</th>
                        <th>Theatre (Screen)</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($showtimes->num_rows > 0): ?>
                        <?php while ($row = $showtimes->fetch_assoc()): ?>
                            <tr>
                                <td><span class="text-white">#<?php echo $row['showtime_id']; ?></span></td>
                                <td class="fw-bold"><?php echo $row['title']; ?></td>
                                <td>
                                    <i class="fas fa-building text-warning me-2"></i>
                                    <?php echo $row['theatre_name']; ?> <span class="text-muted">(<?php echo $row['screen_name']; ?>)</span>
                                </td>
                                <td><?php echo date('d M Y', strtotime($row['show_date'])); ?></td>
                                <td><span class="badge bg-primary"><?php echo date('h:i A', strtotime($row['show_time'])); ?></span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary me-1" onclick='editShowtime(<?php echo json_encode($row); ?>)'>
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a href="?delete=<?php echo $row['showtime_id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this showtime?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No showtimes found.</td>
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

<!-- Showtime Modal -->
<div class="modal fade" id="showtimeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add New Showtime</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <input type="hidden" name="showtime_id" id="showtime_id">
                    <div class="mb-3">
                        <label class="form-label">Movie</label>
                        <select class="form-select" name="movie_id" id="movie_id">
                            <option value="">Select Movie</option>
                            <?php
                            $movies->data_seek(0);
                            while ($m = $movies->fetch_assoc()):
                            ?>
                                <option value="<?php echo $m['movie_id']; ?>"><?php echo $m['title']; ?></option>
                            <?php endwhile; ?>
                        </select>
                        <p class="text-danger fw-semibold small mt-1 error-msg"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Screen</label>
                        <select class="form-select" name="screen_id" id="screen_id">
                            <option value="">Select Screen</option>
                            <?php
                            $screens->data_seek(0);
                            while ($s = $screens->fetch_assoc()):
                            ?>
                                <option value="<?php echo $s['screen_id']; ?>"><?php echo $s['theatre_name'] . ' - ' . $s['screen_name']; ?></option>
                            <?php endwhile; ?>
                        </select>
                        <p class="text-danger fw-semibold small mt-1 error-msg"></p>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control" name="show_date" id="show_date" min="<?php echo date('Y-m-d'); ?>">
                            <p class="text-danger fw-semibold small mt-1 error-msg"></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Time</label>
                            <input type="time" class="form-control" name="show_time" id="show_time">
                            <p class="text-danger fw-semibold small mt-1 error-msg"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn auth-btn">Save Showtime</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/showtimes.js"></script>
<script src="assets/js/showtime_validation.js"></script>
</body>

</html>