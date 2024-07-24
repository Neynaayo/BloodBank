<?php
include "connectDB.php"; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $newPassword = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $userType = $_POST['userType'];

    // Check if the token is valid and not expired
    $query = "SELECT * FROM password_resets WHERE token = '$token' AND expiry > NOW()";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $email = $row['email'];

        // Update the user's password in the respective table
        if ($userType == 'donor') {
            $query = "UPDATE donors SET password = '$newPassword' WHERE email = '$email'";
        } else {
            $query = "UPDATE doctors SET password = '$newPassword' WHERE email = '$email'";
        }
        $conn->query($query);

        // Delete the token
        $query = "DELETE FROM password_resets WHERE token = '$token'";
        $conn->query($query);

        echo "Your password has been reset successfully.";
    } else {
        echo "The reset link is invalid or has expired.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="forgotPassword.css">
</head>
<body>
    <div class="forgot-password-wrapper">
        <div class="forgot-password-container">
            <h2>Reset Password</h2>
            <form action="resetPassword.php" method="POST">
                <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
                <input type="hidden" name="userType" value="<?php echo $_GET['userType']; ?>">
                <label for="password">Enter your new password:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Reset Password</button>
            </form>
        </div>
    </div>
</body>
</html>
