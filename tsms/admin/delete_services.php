<?php
require_once('../config/index.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['delete_ticket'])) {
    $ticket_id = $_GET['delete_ticket'];

    $stmt = $conn->prepare("DELETE FROM tickets WHERE ticket_id = ?");
    $stmt->bind_param("i", $ticket_id);
    $stmt->execute();

    header("Location: delete_services.php");
    exit();
}

if (isset($_GET['delete_hotel'])) {
    $hotel_id = $_GET['delete_hotel'];

    $stmt = $conn->prepare("DELETE FROM hotels WHERE hotel_id = ?");
    $stmt->bind_param("i", $hotel_id);
    $stmt->execute();

    header("Location: delete_services.php");
    exit();
}

$tickets_result = $conn->query("SELECT * FROM tickets");

$hotels_result = $conn->query("SELECT * FROM hotels");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Services</title>
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
    <h2>Delete Tickets and Hotels</h2>
    <h3>Existing Tickets</h3>
    <table>
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th>Ticket ID</th>
                <th>Service Type</th>
                <th>Description</th>
                <th>Price</th>
                <th>Availability</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($ticket = $tickets_result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $ticket['ticket_id']; ?></td>
                <td><?php echo $ticket['service_type']; ?></td>
                <td><?php echo $ticket['description']; ?></td>
                <td><?php echo $ticket['price']; ?></td>
                <td><?php echo $ticket['availability']; ?></td>
                <td>
                    <a href="?delete_ticket=<?php echo $ticket['ticket_id']; ?>" onclick="return confirm('Are you sure you want to delete this ticket?');">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <h3>Existing Hotels</h3>
    <table>
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th>Hotel ID</th>
                <th>Hotel Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Availability</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($hotel = $hotels_result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $hotel['hotel_id']; ?></td>
                <td><?php echo $hotel['name']; ?></td>
                <td><?php echo $hotel['description']; ?></td>
                <td><?php echo $hotel['price']; ?></td>
                <td><?php echo $hotel['availability']; ?></td>
                <td>
                    <a href="?delete_hotel=<?php echo $hotel['hotel_id']; ?>" onclick="return confirm('Are you sure you want to delete this hotel?');">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</body>
</html>
