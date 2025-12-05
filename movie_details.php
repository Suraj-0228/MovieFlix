<?php require_once 'controllers/details_process.php'; ?>

<!-- Hero Section -->
<div class="hero-section-premium">
    <div class="container hero-content-wrapper">
        <div class="row align-items-center">
            <!-- Poster Column -->
            <div class="col-lg-3 d-none d-lg-block">
                <img src="<?php echo $movie['poster_url']; ?>" alt="<?php echo $movie['title']; ?>" class="img-fluid poster-floating w-100">
            </div>
            
            <!-- Details Column -->
            <div class="col-lg-9">
                <div class="glass-card ms-lg-4">
                    <h1 class="display-3 fw-bold text-white mb-2" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);"><?php echo $movie['title']; ?></h1>
                    
                    <div class="d-flex flex-wrap align-items-center gap-3 mb-4 text-white-50">
                        <span class="badge bg-warning text-dark px-3 py-2 fs-6"><i class="fas fa-star me-1"></i><?php echo $movie['rating']; ?></span>
                        <span class="meta-badge rounded-pill"><i class="far fa-clock me-2"></i><?php echo $movie['duration']; ?> min</span>
                        <span class="meta-badge rounded-pill"><i class="fas fa-film me-2"></i><?php echo $movie['genre']; ?></span>
                        <span class="meta-badge rounded-pill text-uppercase"><?php echo $movie['language']; ?></span>
                    </div>
                    
                    <p class="lead text-white mb-4" style="line-height: 1.6; opacity: 0.9;">
                        <?php echo substr($movie['description'], 0, 200) . '...'; ?>
                    </p>
                    
                    <div class="d-flex flex-wrap gap-3">
                        <a href="#showtimes" class="btn auth-btn rounded-3 px-5 fw-bold">
                            <i class="fas fa-ticket-alt me-2"></i>Book Tickets
                        </a>
                        <a href="#trailer" class="btn btn-outline-light rounded-3 px-4" style="border-width: 2px;">
                            <i class="fas fa-play me-2"></i>Watch Trailer
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Details Section -->
<div class="container my-5">
    <div class="row g-5">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="mb-5">
                <h4 class="text-white mb-3 border-bottom border-secondary pb-2">Synopsis</h4>
                <p class="text-white-50 lead" style="font-size: 1.1rem; line-height: 1.8;"><?php echo $movie['description']; ?></p>
            </div>

            <!-- Cast & Crew (Full Width) -->
            <div class="p-4 rounded bg-dark bg-opacity-50 border border-secondary">
                <h5 class="text-white mb-4"><i class="fas fa-users me-2 text-danger"></i>Cast & Crew</h5>
                <ul class="list-unstyled text-white-50 mb-0 d-flex flex-wrap gap-5">
                    <li class="mb-2"><strong class="text-white d-block mb-1">Director</strong> Rohit Shetty</li>
                    <li class="mb-2"><strong class="text-white d-block mb-1">Cast</strong> Ajay Devgn, Kareena Kapoor, Arjun Kapoor</li>
                </ul>
            </div>
        </div>

        <!-- Sidebar (Trailers/More) -->
        <div class="col-lg-4">
            <!-- Trailer -->
            <?php if (!empty($movie['trailer_url'])): ?>
            <div id="trailer" class="trailer p-4 rounded mb-4" style="background-color: #1f1f1f; border: 1px solid rgba(255,255,255,0.1);">
                 <h5 class="text-white mb-4">Official Trailer</h5>
                 <div class="ratio ratio-16x9 rounded overflow-hidden">
                    <iframe src="<?php echo $movie['trailer_url']; ?>" title="YouTube video player" allowfullscreen></iframe>
                 </div>
            </div>
            <?php endif; ?>

            <!-- Movie Info (Moved to Sidebar) -->
            <div class="p-4 rounded" style="background-color: #1f1f1f; border: 1px solid rgba(255,255,255,0.1);">
                <h5 class="text-white mb-4"><i class="fas fa-info-circle me-2 text-danger"></i>Movie Info</h5>
                <ul class="list-unstyled text-white-50 mb-0">
                    <li class="mb-3 d-flex justify-content-between">
                        <span class="text-white">Release Date</span> 
                        <span><?php echo date('d M Y', strtotime($movie['release_date'])); ?></span>
                    </li>
                    <li class="d-flex justify-content-between align-items-center">
                        <span class="text-white">Status</span> 
                        <span class="badge bg-success"><?php echo ucfirst(str_replace('_', ' ', $movie['status'])); ?></span>
                    </li>
                </ul>
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