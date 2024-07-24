<?php
session_start();

// Check if the session is active
if (session_status() === PHP_SESSION_ACTIVE) {
    // Destroy the session
    session_destroy();
}

// Redirect to the login page or another desired page
header("Location: login.php");
exit;