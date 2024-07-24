<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email']) || ($_SESSION['role'] != 'healthCare' && $_SESSION['role'] != 'Doctor')) {
    header("Location: login.php");
    exit();
}

include 'connectDB.php';

$email = $_SESSION['email'];

$sql = "DELETE FROM doctor WHERE Doctor_Email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);

if ($stmt->execute()) {
    // Logout the user and redirect to login page
    session_destroy();
    header("Location: login.php");
    exit();
}

$stmt->close();
$conn->close();
?>
