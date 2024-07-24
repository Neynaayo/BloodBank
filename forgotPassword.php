<?php
include "connectDB.php"; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $userType = '';

    // Check if the email exists in the donors table
    $query = "SELECT * FROM donor WHERE Donor_Email = '$email'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $userType = 'donor';
    } else {
        // Check if the email exists in the doctors table
        $query = "SELECT * FROM doctor WHERE Doctor_Email = '$email'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $userType = 'doctor';
        }
    }

    if ($userType !== '') {
        // Generate a unique token
        $token = bin2hex(random_bytes(50));

        // Store the token in the database with an expiry date
        $expiry = date("Y-m-d H:i:s", strtotime('+1 hour'));
        $query = "INSERT INTO password_resets (email, token, expiry) VALUES ('$email', '$token', '$expiry')";
        $conn->query($query);

        // Send the reset link to the user's email
        $resetLink = "http://yourwebsite.com/resetPassword.php?token=$token&userType=$userType";
        $subject = "Password Reset Request";
        $message = "Click on this link to reset your password: $resetLink";
        $headers = "From: no-reply@yourwebsite.com";

        if (mail($email, $subject, $message, $headers)) {
            echo "A password reset link has been sent to your email.";
        } else {
            echo "Failed to send the password reset link. Please try again.";
        }
    } else {
        echo "This email is not registered.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="forgotPassword.css">
    <style>  
        body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f0f4f8;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.forgot-password-wrapper {
    width: 100%;
    max-width: 400px;
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.forgot-password-container h2 {
    margin-bottom: 20px;
    font-size: 1.5em;
    color: #333;
}

.forgot-password-container label {
    display: block;
    margin-bottom: 10px;
    font-size: 1em;
    color: #666;
}

.forgot-password-container input {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 1em;
}

.forgot-password-container button {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 5px;
    background-color: #4CAF50;
    color: #fff;
    font-size: 1em;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.forgot-password-container button:hover {
    background-color: #45a049;
}

    </style>
</head>
<body>
    <div class="forgot-password-wrapper">
        <div class="forgot-password-container">
            <h2>Reset Password</h2>
            <form action="forgotPassword.php" method="POST">
                <label for="email">Enter your email address:</label>
                <input type="email" id="email" name="email" required>
                <button type="submit">Send Reset Link</button>
            </form>
        </div>
    </div>
</body>
</html>
