<?php
require_once('../config/index.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: ../login.php");
    exit();
}

$tickets = $conn->query("SELECT * FROM tickets");
$hotels = $conn->query("SELECT * FROM hotels");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Services</title>
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
            color: green;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>Available Services</h2>

    <h3>Tickets</h3>
    <table>
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th>ID</th>
                <th>Service Type</th>
                <th>Description</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($ticket = $tickets->fetch_assoc()): ?>
            <tr>
                <td><?php echo $ticket['ticket_id']; ?></td>
                <td><?php echo $ticket['service_type']; ?></td>
                <td><?php echo $ticket['description']; ?></td>
                <td><?php echo $ticket['price']; ?></td>
                <td>
                    <a href="book.php?ticket_id=<?php echo $ticket['ticket_id']; ?>">Book</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <h3>Hotels</h3>
    <table>
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($hotel = $hotels->fetch_assoc()): ?>
            <tr>
                <td><?php echo $hotel['hotel_id']; ?></td>
                <td><?php echo $hotel['name']; ?></td>
                <td><?php echo $hotel['description']; ?></td>
                <td><?php echo $hotel['price']; ?></td>
                <td>
                    <a href="book.php?hotel_id=<?php echo $hotel['hotel_id']; ?>">Book</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
