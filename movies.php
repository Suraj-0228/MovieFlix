<?php require_once 'controllers/movies_process.php'; ?>

<div class="container my-5">
    <h2 class="section-title">Movies</h2>

    <!-- Filters -->
    <div class="filter-container mb-5 p-4">
        <form method="GET" action="" class="row g-3">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-dark border-secondary text-white"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control bg-dark border-secondary text-white" name="search" placeholder="Search movies..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-select bg-dark border-secondary text-white" name="genre">
                    <option value="">All Genres</option>
                    <option value="Action" <?php echo (isset($_GET['genre']) && $_GET['genre'] == 'Action') ? 'selected' : ''; ?>>Action</option>
                    <option value="Sci-Fi" <?php echo (isset($_GET['genre']) && $_GET['genre'] == 'Sci-Fi') ? 'selected' : ''; ?>>Sci-Fi</option>
                    <option value="Drama" <?php echo (isset($_GET['genre']) && $_GET['genre'] == 'Drama') ? 'selected' : ''; ?>>Drama</option>
                    <option value="Comedy" <?php echo (isset($_GET['genre']) && $_GET['genre'] == 'Comedy') ? 'selected' : ''; ?>>Comedy</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select bg-dark border-secondary text-white" name="language">
                    <option value="">All Languages</option>
                    <option value="English" <?php echo (isset($_GET['language']) && $_GET['language'] == 'English') ? 'selected' : ''; ?>>English</option>
                    <option value="Hindi" <?php echo (isset($_GET['language']) && $_GET['language'] == 'Hindi') ? 'selected' : ''; ?>>Hindi</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn auth-btn w-100">Filter</button>
            </div>
        </form>
    </div>

    <!-- Movies Grid -->
    <div class="row">
        <?php
        $limit = 8;
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $count_sql = "SELECT COUNT(*) as total FROM movies $where_sql";
        $count_result = $conn->query($count_sql);
        $total_movies = $count_result->fetch_assoc()['total'];
        $total_pages = ceil($total_movies / $limit);

        $sql = "SELECT * FROM movies $where_sql LIMIT $limit OFFSET $offset";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
        ?>
                <div class="col-md-3 mb-4">
                    <div class="card movie-card h-100">
                        <a href="movie_details.php?id=<?php echo $row['movie_id']; ?>">
                            <img src="<?php echo $row['poster_url']; ?>" class="card-img-top" alt="<?php echo $row['title']; ?>">
                        </a>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo $row['title']; ?></h5>
                            <p class="card-text small">
                                <?php echo $row['genre']; ?> | <?php echo $row['duration']; ?> min
                            </p>
                            <div class="mb-2">
                                <span class="badge bg-warning text-dark"><i class="fas fa-star"></i> <?php echo $row['rating']; ?></span>
                                <span class="badge bg-secondary"><?php echo $row['language']; ?></span>
                            </div>
                            <a href="movie_details.php?id=<?php echo $row['movie_id']; ?>" class="btn auth-btn mt-auto w-100">Book Now</a>
                        </div>
                    </div>
                </div>
        <?php
            }
        } else {
            echo "<div class='col-12'><p class='text-center'>No movies found matching your criteria.</p></div>";
        }
        ?>
    </div>

    <!-- Pagination Controls -->
    <?php if ($total_pages > 1): ?>
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php if ($page <= 1) {
                                            echo 'disabled';
                                        } ?>">
                    <a class="page-link" href="<?php if ($page > 1) {
                                                    echo "?page=" . ($page - 1);
                                                } else {
                                                    echo "#";
                                                }
                                                if (isset($_GET['search'])) echo "&search=" . $_GET['search'];
                                                if (isset($_GET['genre'])) echo "&genre=" . $_GET['genre'];
                                                if (isset($_GET['language'])) echo "&language=" . $_GET['language'];
                                                ?>">Previous</a>
                </li>
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php if ($page == $i) {
                                                echo 'active';
                                            } ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>
                   <?php
                    if (isset($_GET['search'])) echo "&search=" . $_GET['search'];
                    if (isset($_GET['genre'])) echo "&genre=" . $_GET['genre'];
                    if (isset($_GET['language'])) echo "&language=" . $_GET['language'];
                    ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?php if ($page >= $total_pages) {
                                            echo 'disabled';
                                        } ?>">
                    <a class="page-link" href="<?php if ($page < $total_pages) {
                                                    echo "?page=" . ($page + 1);
                                                } else {
                                                    echo "#";
                                                }
                                                if (isset($_GET['search'])) echo "&search=" . $_GET['search'];
                                                if (isset($_GET['genre'])) echo "&genre=" . $_GET['genre'];
                                                if (isset($_GET['language'])) echo "&language=" . $_GET['language'];
                                                ?>">Next</a>
                </li>
            </ul>
        </nav>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>