<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar">
        <a class="navbar-brand" href="<?php echo SITE_URL; ?>"><?php echo SITE_NAME; ?></a>
        <div class="navbar-collapse">
            <ul class="navbar-nav">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item"><a class="nav-link" href="<?php echo SITE_URL; ?>/admin/dashboard.php">Admin Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo SITE_URL; ?>/service_provider/dashboard.php">Service Provider Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo SITE_URL; ?>/customer/dashboard.php">Customer Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>