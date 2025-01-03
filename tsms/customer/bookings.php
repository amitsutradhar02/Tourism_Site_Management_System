<?php
require_once('../config/index.php');

// Ensure the user is logged in as a customer
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: ../login.php");
    exit("You must be logged in as a customer.");
}

// Get the customer ID
$user_id = $_SESSION['user_id'];

// Handle cancellation request
if (isset($_GET['cancel_booking_id'], $_GET['type'])) {
    $cancel_booking_id = (int)$_GET['cancel_booking_id'];
    $type = $_GET['type'];

    if ($cancel_booking_id > 0 && in_array($type, ['ticket', 'hotel'])) {
        $column = ($type == 'ticket') ? 'ticket_id' : 'hotel_id';
        $check_query = "SELECT * FROM bookings WHERE booking_id = ? AND user_id = ? AND $column IS NOT NULL";
        $stmt = $conn->prepare($check_query);
        $stmt->bind_param("ii", $cancel_booking_id, $user_id);
        $stmt->execute();

        if ($stmt->get_result()->num_rows > 0) {
            $delete_query = "DELETE FROM bookings WHERE booking_id = ?";
            $stmt = $conn->prepare($delete_query);
            $stmt->bind_param("i", $cancel_booking_id);
            $stmt->execute();
            header("Location: bookings.php?success={$type} booking cancelled successfully.");
        } else {
            header("Location: bookings.php?error=Booking not found.");
        }
    } else {
        header("Location: bookings.php?error=Invalid cancellation request.");
    }
    exit();
}

// Fetch ticket and hotel bookings
$tickets_query = "SELECT b.booking_id, t.service_type, t.description, t.price, b.booking_date FROM bookings b INNER JOIN tickets t ON b.ticket_id = t.ticket_id WHERE b.user_id = ? AND b.ticket_id IS NOT NULL";
$hotels_query = "SELECT b.booking_id, h.name, h.description, h.price, b.booking_date FROM bookings b INNER JOIN hotels h ON b.hotel_id = h.hotel_id WHERE b.user_id = ? AND b.hotel_id IS NOT NULL";

$tickets_stmt = $conn->prepare($tickets_query);
$tickets_stmt->bind_param("i", $user_id);
$tickets_stmt->execute();
$ticket_bookings = $tickets_stmt->get_result();
$tickets_stmt->close();

$hotels_stmt = $conn->prepare($hotels_query);
$hotels_stmt->bind_param("i", $user_id);
$hotels_stmt->execute();
$hotel_bookings = $hotels_stmt->get_result();
$hotels_stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Bookings</title>
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
        }

        a:hover {
            text-decoration: underline;
        }

        .message {
            padding: 10px;
            text-align: center;
        }

        .success {
            color: green;
            font-weight: bold;
        }

        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>My Bookings</h2>

    <?php if (isset($_GET['success'])): ?>
        <p class="message success"><?php echo htmlspecialchars($_GET['success']); ?></p>
    <?php elseif (isset($_GET['error'])): ?>
        <p class="message error"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>

    <h3>Ticket Bookings</h3>
    <?php if ($ticket_bookings->num_rows > 0): ?>
        <table>
            <thead>
                <tr style="background-color: #f2f2f2;">
                    <th>Booking ID</th>
                    <th>Service Type</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Booking Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($ticket = $ticket_bookings->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $ticket['booking_id']; ?></td>
                        <td><?php echo $ticket['service_type']; ?></td>
                        <td><?php echo $ticket['description']; ?></td>
                        <td><?php echo $ticket['price']; ?></td>
                        <td><?php echo $ticket['booking_date']; ?></td>
                        <td>
                            <a href="bookings.php?cancel_booking_id=<?php echo $ticket['booking_id']; ?>&type=ticket" onclick="return confirm('Cancel this booking?');">Cancel</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No ticket bookings found.</p>
    <?php endif; ?>

    <h3>Hotel Bookings</h3>
    <?php if ($hotel_bookings->num_rows > 0): ?>
        <table>
            <thead>
                <tr style="background-color: #f2f2f2;">
                    <th>Booking ID</th>
                    <th>Hotel Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Booking Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($hotel = $hotel_bookings->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $hotel['booking_id']; ?></td>
                        <td><?php echo $hotel['name']; ?></td>
                        <td><?php echo $hotel['description']; ?></td>
                        <td><?php echo $hotel['price']; ?></td>
                        <td><?php echo $hotel['booking_date']; ?></td>
                        <td>
                            <a href="bookings.php?cancel_booking_id=<?php echo $hotel['booking_id']; ?>&type=hotel" onclick="return confirm('Cancel this booking?');">Cancel</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hotel bookings found.</p>
    <?php endif; ?>
</body>
</html>

