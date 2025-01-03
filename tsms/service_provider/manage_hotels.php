<?php
require_once('../config/index.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'service_provider') {
    header("Location: ../login.php");
    exit();
}

// Hotel Creation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'create') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $availability = $_POST['availability'];
    $owner_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO hotels (name, description, price, availability, owner_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiii", $name, $description, $price, $availability, $owner_id);
    $stmt->execute();
}

// Find Hotels
$result = $conn->query("SELECT * FROM hotels WHERE owner_id = " . $_SESSION['user_id']);


// Delete Hotel
if (isset($_GET['delete'])) {
    $hotel_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM hotels WHERE hotel_id = ?");
    $stmt->bind_param("i", $hotel_id);
    $stmt->execute();
    header("Location: manage_hotels.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Hotels</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f4f4f4;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        a {
            color: red;
            text-decoration: none;
            margin-right: 10px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>Manage Hotels</h2>
    <form method="POST" action="">
        <input type="hidden" name="action" value="create">
        <input type="text" name="name" placeholder="Hotel Name" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <input type="number" name="price" placeholder="Price" required>
        <input type="number" name="availability" placeholder="Availability" required>
        <button type="submit">Add Hotel</button>
    </form>

    <h3>Existing Hotels</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Availability</th>
            <th>Actions</th>
        </tr>
        <?php while ($hotel = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $hotel['hotel_id']; ?></td>
            <td><?php echo $hotel['name']; ?></td>
            <td><?php echo $hotel['description']; ?></td>
            <td><?php echo $hotel['price']; ?></td>
            <td><?php echo $hotel['availability']; ?></td>
            <td>
                <a href="?delete=<?php echo $hotel['hotel_id']; ?>">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <?php if (isset($hotel)): ?>
    <h3>Edit Hotel</h3>
    <form method="POST" action="">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="hotel_id" value="<?php echo $hotel['hotel_id']; ?>">
        <input type="text" name="name" value="<?php echo $hotel['name']; ?>" required>
        <textarea name="description" required><?php echo $hotel['description']; ?></textarea>
        <input type="number" name="price" value="<?php echo $hotel['price']; ?>" required>
        <input type="number" name="availability" value="<?php echo $hotel['availability']; ?>" required>
        <button type="submit">Update Hotel</button>
    </form>
    <?php endif; ?>
</body>
</html>