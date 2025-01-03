<?php
require_once('../config/index.php');
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>Admin Dashboard</h2>
    <a href="manage_users.php">Manage Users</a>
    <a href="delete_services.php">Delete Services</a>

</body>
</html>