<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Dashboard Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #d1e7f3;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            text-align: center;
        }

        .logo img {
            width: 100px;
            margin-bottom: 20px;
        }

        .login-box {
            background-color: #0089a7;
            padding: 20px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            color: white;
            width: 300px;
        }

        h2 {
            margin-bottom: 20px;
        }

        .role-selector {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .role-button {
            background-color: #0089a7;
            border: 2px solid #005b6f;
            color: white;
            padding: 10px;
            flex: 1;
            margin: 0 5px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .role-button.active,
        .role-button:hover {
            background-color: #005b6f;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
        }

        .options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .options label {
            display: flex;
            align-items: center;
        }

        .options input[type="checkbox"] {
            margin-right: 5px;
        }

        .forgot-password {
            color: white;
            text-decoration: none;
        }

        .login-button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #005b6f;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .login-button:hover {
            background-color: #004057;
        }

        .signup-link {
            margin-top: 20px;
        }

        .signup-link a {
            color: white;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <img src="img/blooBankLogo.png" alt="Medical Dashboard Logo">
        </div>
        <div class="login-box">
            <h2>User Login</h2>
            <form action="loginProcess.php" method="post">
                <div class="role-selector">
                    <label>
                        <input type="radio" id="healthCare" name="role" value="healthCare" checked>
                        Health Care
                    </label>
                    <label>
                        <input type="radio" id="doctor" name="role" value="Doctor">
                        Doctor
                    </label>
                    <label>
                        <input type="radio" id="donor" name="role" value="donor">
                        Donor
                    </label>
                </div>
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="options">
                    <label>
                        <input type="checkbox" name="remember" id="remember">
                        Remember Me
                    </label>
                    <a href="forgotPassword.php" class="forgot-password">Forget Password?</a>
                </div>
                <button type="submit" class="login-button">Login</button>
            </form>
            <div class="signup-link">
                <p>Don't have an account? <a href="signUp.php">Join us now...</a></p>
            </div>
        </div>
    </div>
</body>
</html>
