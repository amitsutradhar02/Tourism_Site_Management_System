<?php
require_once('config/index.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $role = $_POST['role'];
    $stmt->bind_param("ssss", $username, $email, $password, $role);
    $stmt->execute();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <form method="POST" action="">
        <h2>Register</h2>
        <input type="text" name="username" required placeholder="Username">
        <input type="email" name="email" required placeholder="Email">
        <input type="password" name="password" required placeholder="Password">
        <select name="role" required>
            <option value="service_provider">Service Provider</option>
            <option value="customer">Customer</option>
        </select>
        <button type="submit">Register</button>
    </form>
</body>
</html>