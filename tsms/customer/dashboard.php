<?php
require_once('../config/index.php');
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>Customer Dashboard</h2>
    <a href="view_services.php">View Services</a>
    <a href="bookings.php">My Bookings</a>
</body>
</html>