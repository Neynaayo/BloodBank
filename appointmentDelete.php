<?php
// Check if the session has already been started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'connectDB.php';

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Check if the appointment_id is set in the URL
if (isset($_GET['appointment_id'])) {
    $appointmentId = $_GET['appointment_id'];

    // Prepare and execute the delete query
    $deleteQuery = "DELETE FROM appointment WHERE Appointment_ID = ?";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bind_param("i", $appointmentId);
    if ($deleteStmt->execute()) {
        // Redirect to appointment history page after successful deletion
        header("Location: appointmentHistory.php");
        exit();
    } else {
        echo "Error deleting appointment: " . $conn->error;
    }

    $deleteStmt->close();
} else {
    echo "No appointment ID specified!";
}

$conn->close();
?>
