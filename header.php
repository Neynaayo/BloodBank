<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unique Header</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        .bb-header-wrapper {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        .bb-main-header {
            background: linear-gradient(135deg, #ff6b6b, #4ecdc4);
            color: #fff;
            padding: 15px 0;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .bb-header-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .bb-logo img {
            height: 60px;
            filter: drop-shadow(2px 2px 2px rgba(0,0,0,0.3));
        }

        .bb-nav-buttons {
            display: flex;
            gap: 15px;
        }

        .bb-nav-btn {
            background-color: rgba(255,255,255,0.2);
            border: none;
            padding: 10px 15px;
            color: #fff;
            border-radius: 25px;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: bold;
        }

        .bb-nav-btn:hover {
            background-color: rgba(255,255,255,0.3);
            transform: translateY(-2px);
        }

        .bb-user-profile {
            font-size: 24px;
            color: #fff;
        }

        .bb-social-icons {
            display: flex;
            gap: 15px;
        }

        .bb-social-icons a {
            color: #fff;
            font-size: 20px;
            transition: transform 0.3s ease;
        }

        .bb-social-icons a:hover {
            transform: scale(1.2);
        }

        .bb-nav-menu {
            background-color: #2c3e50;
            padding: 10px 0;
        }

        .bb-nav-list {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .bb-nav-item a {
            color: #ecf0f1;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .bb-nav-item a:hover {
            background-color: #34495e;
        }

        .bb-nav-item i {
            margin-right: 5px;
        }
    </style>
</head>
<body class="bb-header-wrapper">
    <header class="bb-main-header">
        <div class="bb-header-container">
            <div class="bb-logo">
                <img src="img/blooBankLogo.png" alt="Blood Bank Logo">
            </div>
            <div class="bb-nav-buttons">
                <?php if (isset($_SESSION['email'])): ?>
                    <a href="logout.php" class="bb-nav-btn">LOG OUT</a>
                    <div class="bb-user-profile">
                        <?php if ($_SESSION['role'] == 'healthCare' || $_SESSION['role'] == 'Doctor'): ?>
                            <a href="DocProfile.php"><i class="fas fa-user-md"></i></a>
                        <?php elseif ($_SESSION['role'] == 'donor'): ?>
                            <a href="donorProfile.php"><i class="fas fa-user"></i></a>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <a href="login.php" class="bb-nav-btn">LOG IN</a>
                    <a href="signUp.php" class="bb-nav-btn">SIGN UP</a>
                <?php endif; ?>
            </div>
            <div class="bb-social-icons">
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fas fa-envelope"></i></a>
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
            </div>
        </div>
    </header>

    <nav class="bb-nav-menu">
        <ul class="bb-nav-list">
            <li class="bb-nav-item"><a href="index.php"><i class="fas fa-home"></i> HOME</a></li>
            <li class="bb-nav-item"><a href="event.php"><i class="fas fa-calendar-check"></i> EVENT</a></li>
            <?php if (isset($_SESSION['role'])): ?>
                <?php if ($_SESSION['role'] == 'donor'): ?>
                    <li class="bb-nav-item"><a href="reward.php"><i class="fas fa-gift"></i> POINTER</a></li>
                    <li class="bb-nav-item"><a href="appointment.php"><i class="fas fa-calendar-alt"></i> APPOINTMENT</a></li>
                <?php endif; ?>
                <li class="bb-nav-item"><a href="cons.php"><i class="fas fa-comments"></i> CONSULTATION ROOM</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</body>
</html>
