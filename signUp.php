<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="stylesSignUp.css">
    <script>
        function validateForm() {
            var password = document.forms["signupForm"]["password"].value;
            var confirmPassword = document.forms["signupForm"]["confirm_password"].value;

            if (password.length < 5 || password.length > 10) {
                alert("Password must be between 5 and 10 characters.");
                return false;
            }

            if (password !== confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>SIGN UP</h1>
        <form name="signupForm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" onsubmit="return validateForm()">
            <div class="user-type">
                <input type="radio" name="user_type" value="doctor" id="doctor" required>
                <label for="doctor">DOCTOR</label>
                <input type="radio" name="user_type" value="healthcare" id="healthcare">
                <label for="healthcare">HEALTH CARE</label>
                <input type="radio" name="user_type" value="donor" id="donor">
                <label for="donor">DONOR</label>
            </div>
            <div class="input-group">
                <input type="text" name="name" placeholder="NAME" required>
            </div>
            <div class="input-group">
                <input type="email" name="email" placeholder="EMAIL" required>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="PASSWORD" required>
            </div>
            <div class="input-group">
                <input type="password" name="confirm_password" placeholder="CONFIRM PASSWORD" required>
            </div>
            <button type="submit" name="register">SIGN UP</button>
        </form>
    </div>

    <?php
    include 'connectDB.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get form data
        $full_name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $user_type = $_POST['user_type'];

        // Validate form data
        if (strlen($password) < 5 || strlen($password) > 10) {
            echo "<div class='error-message'>Password must be between 5 and 10 characters.</div>";
            exit;
        }

        if ($password !== $confirm_password) {
            echo "<div class='error-message'>Passwords do not match.</div>";
            exit;
        }

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert data into the appropriate database based on user type
        if ($user_type === 'donor') {
            $query = "INSERT INTO donor (Donor_Name, Donor_Email, Donor_Pass) VALUES ('$full_name', '$email', '$hashed_password')";
        } elseif ($user_type === 'doctor' || $user_type === 'healthcare') {
            $query = "INSERT INTO doctor (Doctor_Name, Doctor_Email, Doctor_Pass) VALUES ('$full_name', '$email', '$hashed_password')";
        }

        $result = mysqli_query($conn, $query) or die("Query failed: " . mysqli_error($conn));

        // Check if the query was successful
        if ($result) {
            echo "<div class='success-message'>Registration successful! <a href='login.php'>Go to login page</a></div>";
        } else {
            echo "<div class='error-message'>Problem occurred!</div>";
        }

        mysqli_close($conn);
    }
    ?>
</body>
</html>
