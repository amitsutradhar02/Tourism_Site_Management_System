<?php
require_once('../config/index.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'update') {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // for keeping the current password if I rmv it as blank
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, password = ?, role = ? WHERE user_id = ?");
        $stmt->bind_param("ssssi", $username, $email, $password, $role, $user_id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, role = ? WHERE user_id = ?");
        $stmt->bind_param("sssi", $username, $email, $role, $user_id);
    }
    $stmt->execute();
    header("Location: manage_users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        form {
            max-width: 400px;
            margin: 0 auto;
        }
        input[type="text"], input[type="email"], input[type="password"], select {
            padding: 8px;
            margin: 10px 0;
            width: 100%;
            border: 1px solid #ddd;
        }
        button {
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h2>Edit User</h2>

    <?php if (isset($user)): ?>
    <form method="POST" action="edit_user.php">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
        <input type="text" name="username" value="<?php echo $user['username']; ?>" required>
        <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
        <select name="role">
            <option value="service_provider" <?php echo $user['role'] == 'service_provider' ? 'selected' : ''; ?>>Service Provider</option>
            <option value="customer" <?php echo $user['role'] == 'customer' ? 'selected' : ''; ?>>Customer</option>
        </select>
        <input type="password" name="password" placeholder="New Password (Leave blank to keep current)">
        <button type="submit">Update User</button>
    </form>
    <?php else: ?>
    <p>User not found.</p>
    <?php endif; ?>

</body>
</html>
