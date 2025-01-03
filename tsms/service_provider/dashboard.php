<?php
require_once('../config/index.php');
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'service_provider') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Service Provider Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>Service Provider Dashboard</h2>
    <a href="manage_tickets.php">Manage Tickets</a>
    <a href="manage_hotels.php">Manage Hotels</a>
</body>
</html>