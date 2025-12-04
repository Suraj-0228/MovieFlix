<?php require_once 'controllers/manage_theaters_process.php'; ?>

<div class="container-fluid">
    <div class="admin-header">
        <div>
            <h2 class="admin-title">Manage Theatres</h2>
            <p class="text-white mt-2">Add, Edit, or Remove Theatres and Screens.</p>
        </div>
        <button class="btn auth-btn" data-bs-toggle="modal" data-bs-target="#theatreModal" onclick="resetTheatreForm()">
            <i class="fas fa-plus me-2"></i>Add New Theatre
        </button>
    </div>
    <div class="admin-table-card">
        <div class="table-responsive">
            <table class="table custom-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Screens</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($theatres->num_rows > 0): ?>
                        <?php while ($row = $theatres->fetch_assoc()): ?>
                            <tr>
                                <td><span class="text-white">#<?php echo $row['theatre_id']; ?></span></td>
                                <td class="fw-bold"><?php echo $row['name']; ?></td>
                                <td>
                                    <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                    <?php echo $row['location'] . ', ' . $row['city']; ?>
                                </td>
                                <td>
                                    <span class="badge bg-secondary"><?php echo $row['total_screens']; ?> Screens</span>
                                    <button class="btn btn-sm text-white text-decoration-none ms-2" onclick="addScreen(<?php echo $row['theatre_id']; ?>)">
                                        <i class="fas fa-plus-circle"></i> Add Screen
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary me-1" onclick='editTheatre(<?php echo json_encode($row); ?>)'>
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a href="?delete_theatre=<?php echo $row['theatre_id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are You Sure!! You want to Delete this Theatre??')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No theatres found.</td>
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

</div>
</div>

<!-- Theatre Modal -->
<div class="modal fade" id="theatreModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="theatreModalTitle">Add New Theatre</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <input type="hidden" name="save_theatre" value="1">
                    <input type="hidden" name="theatre_id" id="theatre_id">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control bg-white text-dark" name="name" id="name" placeholder="Enter Theatre Name">
                        <p class="text-danger fw-semibold small mt-1 error-msg"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Location</label>
                        <input type="text" class="form-control bg-white text-dark" name="location" id="location" placeholder="Enter Theatre Location">
                        <p class="text-danger fw-semibold small mt-1 error-msg"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">City</label>
                        <input type="text" class="form-control bg-white text-dark" name="city" id="city" placeholder="Enter Theatre City">
                        <p class="text-danger fw-semibold small mt-1 error-msg"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Total Screens</label>
                        <input type="number" class="form-control bg-white text-dark" name="total_screens" id="total_screens" placeholder="Enter Total Screens">
                        <p class="text-danger fw-semibold small mt-1 error-msg"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn auth-btn">Save Theatre</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Screen Modal -->
<div class="modal fade" id="screenModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Screen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <input type="hidden" name="save_screen" value="1">
                    <input type="hidden" name="screen_theatre_id" id="screen_theatre_id">
                    <div class="mb-3">
                        <label class="form-label">Screen Name</label>
                        <input type="text" class="form-control" name="screen_name" placeholder="e.g. Screen 1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Total Seats</label>
                        <input type="number" class="form-control" name="total_seats" value="100" required>
                        <small class="text-muted">Seats will be auto-generated based on this number.</small>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">VIP Price</label>
                            <input type="number" class="form-control" name="vip_price" id="vip_price" value="300" required>
                            <p class="text-danger small mt-1 error-msg"></p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Premium Price</label>
                            <input type="number" class="form-control" name="premium_price" id="premium_price" value="200" required>
                            <p class="text-danger small mt-1 error-msg"></p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Regular Price</label>
                            <input type="number" class="form-control" name="regular_price" id="regular_price" value="150" required>
                            <p class="text-danger small mt-1 error-msg"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Screen</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/theaters.js"></script>
<script src="assets/js/theatre_validation.js"></script>
</body>

</html>