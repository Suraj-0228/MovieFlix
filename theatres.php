<?php
require_once 'config/db.php';
require_once 'includes/header.php';

// Fetch Theatres
$sql = "SELECT * FROM theatres";
$result = $conn->query($sql);
?>

<!-- Page Header -->
<div class="page-header">
    <div class="container">
        <h1 class="page-title">Our Theatres</h1>
        <p class="page-subtitle">Experience the best cinema at our premium locations across the city.</p>
    </div>
</div>

<div class="container mb-5">
    <div class="row">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
        ?>
                <div class="col-md-4 mb-4">
                    <div class="theatre-card">
                        <div class="theatre-body">
                            <h5 class="theatre-name"><?php echo $row['name']; ?></h5>
                            <div class="theatre-info">
                                <i class="fas fa-map-marker-alt"></i>
                                <span><?php echo $row['location']; ?>, <?php echo $row['city']; ?></span>
                            </div>
                            <div class="theatre-info">
                                <i class="fas fa-tv"></i>
                                <span><?php echo $row['total_screens']; ?> Screens</span>
                            </div>
                            <a href="movies.php" class="btn auth-btn w-100 mt-3">View Movies</a>
                        </div>
                    </div>
                </div>
        <?php
            }
        } else {
            echo "<div class='col-12 text-center text-white'><p>No theatres found.</p></div>";
        }
        ?>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>