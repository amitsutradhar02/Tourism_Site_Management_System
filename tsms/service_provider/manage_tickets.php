<?php
require_once('../config/index.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'service_provider') {
    header("Location: ../login.php");
    exit();
}

//Ticket Creation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'create') {
    $service_type = $_POST['service_type'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $availability = $_POST['availability'];
    $seller_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO tickets (service_type, description, price, availability, seller_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiii", $service_type, $description, $price, $availability, $seller_id);
    $stmt->execute();
}

// Find Tickets
$result = $conn->query("SELECT * FROM tickets WHERE seller_id = " . $_SESSION['user_id']);


// Delete Ticket
if (isset($_GET['delete'])) {
    $ticket_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM tickets WHERE ticket_id = ?");
    $stmt->bind_param("i", $ticket_id);
    $stmt->execute();
    header("Location: manage_tickets.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Tickets</title>
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
    <h2>Manage Tickets</h2>
    <form method="POST" action="">
        <input type="hidden" name="action" value="create">
        <select name="service_type" required>
            <option value="bus">Bus</option>
            <option value="train">Train</option>
            <option value="plane">Plane</option>
        </select>
        <textarea name="description" placeholder="Description" required></textarea>
        <input type="number" name="price" placeholder="Price" required>
        <input type="number" name="availability" placeholder="Availability" required>
        <button type="submit">Add Ticket</button>
    </form>

    
    <h3>Existing Tickets</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Service Type</th>
            <th>Description</th>
            <th>Price</th>
            <th>Availability</th>
            <th>Actions</th>
        </tr>
        <?php while ($ticket = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $ticket['ticket_id']; ?></td>
            <td><?php echo $ticket['service_type']; ?></td>
            <td><?php echo $ticket['description']; ?></td>
            <td><?php echo $ticket['price']; ?></td>
            <td><?php echo $ticket['availability']; ?></td>
            <td>
                <a href="?delete=<?php echo $ticket['ticket_id']; ?>">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <?php if (isset($ticket)): ?>
    <h3>Edit Ticket</h3>
    <form method="POST" action="">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="ticket_id" value="<?php echo $ticket['ticket_id']; ?>">
        <select name="service_type" required>
            <option value="bus" <?php echo $ticket['service_type'] == 'bus' ? 'selected' : ''; ?>>Bus</option>
            <option value="train" <?php echo $ticket['service_type'] == 'train' ? 'selected' : ''; ?>>Train</option>
            <option value="plane" <?php echo $ticket['service_type'] == 'plane' ? 'selected' : ''; ?>>Plane</option>
        </select>
        <textarea name="description" required><?php echo $ticket['description']; ?></textarea>
        <input type="number" name="price" value="<?php echo $ticket['price']; ?>" required>
        <input type="number" name="availability" value="<?php echo $ticket['availability']; ?>" required>
        <button type="submit">Update Ticket</button>
    </form>
    <?php endif; ?>
</body>
</html>