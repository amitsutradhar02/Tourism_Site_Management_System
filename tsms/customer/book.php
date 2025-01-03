<?php
require_once('../config/index.php');

//customer
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: ../login.php");
    exit("You must be logged in as a customer to book a service.");
}

// Retrive the customer ID
$user_id = $_SESSION['user_id'];

//book a ticket or a hotel
if (isset($_GET['ticket_id'])) {
    $ticket_id = $_GET['ticket_id'];


    $stmt = $conn->prepare("INSERT INTO bookings (user_id, ticket_id, booking_date) VALUES (?, ?, NOW())");
    $stmt->bind_param("ii", $user_id, $ticket_id);
    if ($stmt->execute()) {
        header("Location: bookings.php?success=Ticket booked successfully");
    } else {
        header("Location: view_services.php?error=Failed to book the ticket");
    }
    exit();
} elseif (isset($_GET['hotel_id'])) {
    $hotel_id = $_GET['hotel_id'];

    
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, hotel_id, booking_date) VALUES (?, ?, NOW())");
    $stmt->bind_param("ii", $user_id, $hotel_id);
    if ($stmt->execute()) {
        header("Location: bookings.php?success=Hotel booked successfully");
    } else {
        header("Location: view_services.php?error=Failed to book the hotel");
    }
    exit();
} else {
    header("Location: view_services.php?error=Invalid booking request");
    exit();
}
