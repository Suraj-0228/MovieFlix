<?php require_once 'controllers/details_process.php'; ?>

<!-- Hero Section with blurred background -->
<div class="my-5">
    <div class="container">
        <div class="movie-details-container border-1 shadow-lg">
            <div class="row align-items-center">
                <div class="col-md-4 text-center">
                    <img src="<?php echo $movie['poster_url']; ?>" class="img-fluid movie-poster-large" alt="<?php echo $movie['title']; ?>">
                </div>
                <div class="col-md-8">
                    <h1 class="display-4 fw-bold mb-2"><?php echo $movie['title']; ?></h1>
                    <div class="mb-4 mt-3">
                        <span class="badge-custom me-2"><i class="fas fa-star me-1"></i><?php echo $movie['rating']; ?>/10</span>
                        <span class="badge bg-secondary me-2 p-2"><?php echo $movie['language']; ?></span>
                        <span class="badge bg-dark border border-secondary me-2 p-2"><?php echo $movie['duration']; ?> min</span>
                        <span class="badge bg-dark border border-secondary p-2"><?php echo $movie['genre']; ?></span>
                    </div>
                    <h4 class="text-white mb-3 border-bottom border-secondary pb-2">Synopsis</h4>
                    <p class="lead text-white-50 mb-4"><?php echo $movie['description']; ?></p>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="p-3 rounded bg-dark bg-opacity-50 border border-secondary h-100">
                                <h5 class="text-white mb-3"><i class="fas fa-users me-2"></i>Cast & Crew</h5>
                                <ul class="list-unstyled text-white mb-0">
                                    <li class="mb-2"><strong class="text-white">Director:</strong> Rohit Shetty</li>
                                    <li><strong class="text-white">Cast:</strong> Ajay Devgn, Kareena Kapoor, Arjun Kapoor</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded bg-dark bg-opacity-50 border border-secondary h-100">
                                <h5 class="text-white mb-3"><i class="fas fa-info-circle me-2"></i>Movie Info</h5>
                                <ul class="list-unstyled text-white mb-0">
                                    <li class="mb-2"><strong class="text-white">Release Date:</strong> <?php echo date('d M Y', strtotime($movie['release_date'])); ?></li>
                                    <li><strong class="text-white">Status:</strong> <span class="badge bg-success"><?php echo ucfirst(str_replace('_', ' ', $movie['status'])); ?></span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container my-5" id="showtimes">
    <h3 class="section-title">Available Showtimes</h3>
    <div class="row">
        <?php
        $today = date('Y-m-d');
        $show_sql = "SELECT s.showtime_id, s.show_time, s.show_date, t.name as theatre_name, sc.screen_name 
                     FROM showtimes s 
                     JOIN screens sc ON s.screen_id = sc.screen_id 
                     JOIN theatres t ON sc.theatre_id = t.theatre_id 
                     WHERE s.movie_id = $movie_id AND s.show_date >= '$today' 
                     ORDER BY s.show_date, s.show_time";
        $show_result = $conn->query($show_sql);

        if ($show_result->num_rows > 0) {
            while ($show = $show_result->fetch_assoc()) {
                $formatted_date = date('D, d M', strtotime($show['show_date']));
                $formatted_time = date('h:i A', strtotime($show['show_time']));
        ?>
                <div class="col-md-4 mb-4">
                    <div class="card showtime-card h-100">
                        <div class="card-body">
                            <h5 class="card-title text-white"><?php echo $show['theatre_name']; ?></h5>
                            <p class="card-text text-muted small mb-3"><?php echo $show['screen_name']; ?></p>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="text-white">
                                    <i class="far fa-calendar-alt text-primary me-2"></i><?php echo $formatted_date; ?>
                                </div>
                                <div class="text-white">
                                    <i class="far fa-clock text-primary me-2"></i><?php echo $formatted_time; ?>
                                </div>
                            </div>
                            <a href="seat_selection.php?id=<?php echo $show['showtime_id']; ?>" class="btn auth-btn w-100">Select Seats</a>
                        </div>
                    </div>
                </div>
        <?php
            }
        } else {
            echo "<div class='col-12'><div class='alert alert-secondary text-center'>No showtimes available for this movie yet. Check back soon!</div></div>";
        }
        ?>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>