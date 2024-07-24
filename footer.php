<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer Example</title>
    <style>
        /* Body styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Footer styles */
        footer {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .footer-container {
            display: flex;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-section {
            flex: 1;
            margin: 0 10px;
            text-align: left;
        }

        .footer-section h3 {
            margin-top: 0;
        }

        .footer-section ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .footer-section ul li {
            margin-bottom: 5px;
        }

        .footer-section ul li a {
            color: #fff;
            text-decoration: none;
        }

        .footer-section ul li a:hover {
            text-decoration: underline;
        }

        .footer-bottom {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Your website content goes here -->

    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h3>About Us</h3>
                <p>We are trying to encourage and help new people to get to know about blood donation and help those who in need.</p>
                <a href="#top" class="back-to-top">Back to Top</a>
            </div>
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="consultationList.php">Consultation</a></li>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'donor') { ?>
                        <li><a href="reward.php">Reward</a></li>
                        <li><a href="appointmentHistory.php">Appointment</a></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Follow Us</h3>
                <ul>
                    <li><a href="#">Facebook</a></li>
                    <li><a href="#">Twitter</a></li>
                    <li><a href="#">Instagram</a></li>
                    <li><a href="#">LinkedIn</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 BLOOD BANK. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
