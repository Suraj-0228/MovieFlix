<?php
require_once 'config/db.php';
require_once 'includes/header.php';
?>

<!-- Hero Section -->
<div class="hero-section" style="background-image: url('https://image.tmdb.org/t/p/original/s16H6tpK2utvwDtzZ8Qy4qm5Emw.jpg');">
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="hero-content text-center">
            <h1 class="hero-title animate-fade-in">Welcome to MovieFlix</h1>
            <p class="hero-subtitle lead text-white-50 mb-4 mx-auto">
                Your ultimate destination for the latest blockbusters. Experience the magic of cinema with our state-of-the-art screens, immersive sound systems, and premium seating. Book your tickets now and dive into a world of unparalleled entertainment!
            </p>
            <a href="movies.php" class="btn auth-btn btn-lg hero-btn animate-fade-in" style="animation-delay: 0.2s;">Browse Movies</a>
        </div>
    </div>
</div>

<!-- Now Showing Section -->
<div class="container my-5">
    <div class="section-title">
        <h2>Now Showing</h2>
    </div>
    <div class="row">
        <?php
        $sql = "SELECT * FROM movies WHERE status = 'now_showing' LIMIT 4";
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
                            <a href="movie_details.php?id=<?php echo $row['movie_id']; ?>" class="btn auth-btn book-btn mt-auto w-100">Book Now</a>
                        </div>
                    </div>
                </div>
        <?php
            }
        } else {
            echo "<p class='text-center'>No movies currently showing.</p>";
        }
        ?>
    </div>
    <div class="text-center mt-3">
        <a href="movies.php" class="btn view-btn">View All Movies</a>
    </div>
</div>

<!-- Coming Soon Section -->
<div class="container my-5">
    <div class="section-title">
        <h2>Coming Soon</h2>
    </div>
    <div class="row">
        <?php
        $sql = "SELECT * FROM movies WHERE status = 'coming_soon' LIMIT 4";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
        ?>
                <div class="col-md-3 mb-4">
                    <div class="card movie-card h-100">
                        <img src="<?php echo $row['poster_url']; ?>" class="card-img-top" alt="<?php echo $row['title']; ?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo $row['title']; ?></h5>
                            <p class="card-text small">
                                <?php echo $row['genre']; ?>
                            </p>
                            <div class="mb-2">
                                <span class="badge bg-info text-white">Coming Soon</span>
                            </div>
                            <a href="#" class="btn btn-secondary mt-auto w-100 disabled">Coming Soon</a>
                        </div>
                    </div>
                </div>
        <?php
            }
        } else {
            echo "<p class='text-center'>No upcoming movies found.</p>";
        }
        ?>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>