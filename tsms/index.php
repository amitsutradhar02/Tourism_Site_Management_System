<?php
require_once('config/index.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include('includes/header.php'); ?>

    <div class="container">
        <h1>Welcome to <?php echo SITE_NAME; ?></h1>
        <p>Discover amazing destinations, book tickets, and find perfect accommodations.</p>

        <h2>Featured Services</h2>
        <div class="row">
            <div class="col">
                <div class="card">
                    <img src="assets/images/bus.jpg" class="card-img-top" alt="Bus Services">
                    <div class="card-body">
                        <h5 class="card-title">Bus Services</h5>
                        <p class="card-text">Explore our extensive bus services for your travel needs.</p>
                        <a href="customer/view_services.php" class="btn btn-primary">View Services</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <img src="assets/images/train.jpg" class="card-img-top" alt="Train Services">
                    <div class="card-body">
                        <h5 class="card-title">Train Services</h5>
                        <p class="card-text">Book your train tickets easily and securely.</p>
                        <a href="customer/view_services.php" class="btn btn-primary">View Services</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <img src="assets/images/plane.jpg" class="card-img-top" alt="Plane Services">
                    <div class="card-body">
                        <h5 class="card-title">Plane Services</h5>
                        <p class="card-text">Find the best deals on flights to your favorite destinations.</p>
                        <a href="customer/view_services.php" class="btn btn-primary">View Services</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <img src="assets/images/hotel.jpg" class="card-img-top" alt="Hotel Services">
                    <div class="card-body">
                        <h5 class="card-title">Hotel Services</h5>
                        <p class="card-text">Find the perfect accommodation for your stay.</p>
                        <a href="customer/view_services.php" class="btn btn-primary">View Services</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>

</body>
</html>