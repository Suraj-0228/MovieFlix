<?php require_once 'controllers/manage_movies_process.php'; ?>

<div class="container-fluid">
    <div class="admin-header">
        <div>
            <h2 class="admin-title">Manage Movies</h2>
            <p class="text-white mt-2">Add, Edit, or Remove Movies from the MovieFlix.</p>
        </div>
        <button class="btn auth-btn" data-bs-toggle="modal" data-bs-target="#movieModal" onclick="resetForm()">
            <i class="fas fa-plus me-2"></i>Add New Movie
        </button>
    </div>
    <div class="admin-table-card">
        <div class="table-responsive">
            <table class="table custom-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Poster</th>
                        <th>Title</th>
                        <th>Genre</th>
                        <th>Language</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($movies->num_rows > 0): ?>
                        <?php while ($row = $movies->fetch_assoc()): ?>
                            <tr>
                                <td><span class="text-white">#<?php echo $row['movie_id']; ?></span></td>
                                <td>
                                    <img src="<?php echo $row['poster_url']; ?>" width="40" height="60" style="object-fit: cover; border-radius: 4px;">
                                </td>
                                <td class="fw-bold"><?php echo $row['title']; ?></td>
                                <td><?php echo $row['genre']; ?></td>
                                <td><?php echo $row['language']; ?></td>
                                <td>
                                    <span class="badge bg-<?php echo ($row['status'] == 'now_showing') ? 'success' : (($row['status'] == 'coming_soon') ? 'warning' : 'secondary'); ?>">
                                        <?php echo str_replace('_', ' ', ucfirst($row['status'])); ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary me-1" onclick='editMovie(<?php echo json_encode($row); ?>)'>
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a href="?delete=<?php echo $row['movie_id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are You Sure!! You want to Delete this Movie??')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No movies found.</td>
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

<!-- Movie Modal -->
<div class="modal fade" id="movieModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add New Movie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <input type="hidden" name="movie_id" id="movie_id">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" id="title">
                            <p class="text-danger small mt-1 error-msg"></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Genre</label>
                            <input type="text" class="form-control" name="genre" id="genre">
                            <p class="text-danger small mt-1 error-msg"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Language</label>
                            <select class="form-select" name="language" id="language">
                                <option value="English">English</option>
                                <option value="Hindi">Hindi</option>
                                <option value="Tamil">Tamil</option>
                                <option value="Telugu">Telugu</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Duration (min)</label>
                            <input type="number" class="form-control" name="duration" id="duration">
                            <p class="text-danger small mt-1 error-msg"></p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Rating (0-10)</label>
                            <input type="number" step="0.1" class="form-control" name="rating" id="rating">
                            <p class="text-danger small mt-1 error-msg"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Release Date</label>
                            <input type="date" class="form-control" name="release_date" id="release_date">
                            <p class="text-danger small mt-1 error-msg"></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status" id="status">
                                <option value="now_showing">Now Showing</option>
                                <option value="coming_soon">Coming Soon</option>
                                <option value="archived">Archived</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Poster URL</label>
                        <input type="url" class="form-control" name="poster_url" id="poster_url">
                        <p class="text-danger small mt-1 error-msg"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                        <p class="text-danger small mt-1 error-msg"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn auth-btn">Save Movie</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/movies.js"></script>
<script src="assets/js/movie_validation.js"></script>
</body>

</html>