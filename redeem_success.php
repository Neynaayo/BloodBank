<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redemption Success</title>
    <style>
        body, html {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .page-content {
            flex: 1 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f2f2f2;
            position: relative;
            z-index: 1;
        }
        .container {
            max-width: 800px;
            padding: 40px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            border-radius: 10px;
        }
        .success-message {
            font-size: 28px;
            font-weight: bold;
            color: #4CAF50;
            margin-bottom: 30px;
        }
        .home-btn {
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 5px;
            font-size: 18px;
            font-weight: bold;
            transition: background-color 0.3s ease;
            display: inline-block;
        }
        .home-btn:hover {
            background-color: #0056b3;
        }
        .confetti {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }
        .confetti-piece {
            position: absolute;
            width: 10px;
            height: 10px;
            background-color: #007bff;
            opacity: 0;
            animation: fall 5s linear infinite;
        }
        @keyframes fall {
            0% {
                opacity: 1;
                transform: translateY(0) rotateZ(0deg);
            }
            100% {
                opacity: 0;
                transform: translateY(100vh) rotateZ(360deg);
            }
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="page-content">
        <div class="container">
            <div class="success-message">Congratulations! You have successfully redeemed your reward.</div>
            <a href="index.php" class="home-btn">Go to Home</a>
        </div>
    </div>
    
    <div class="confetti" id="confetti"></div>

    <?php include 'footer.php'; ?>

    <script>
        // Confetti animation (unchanged)
        const confettiContainer = document.getElementById('confetti');
        for (let i = 0; i < 100; i++) {
            const confettiPiece = document.createElement('div');
            confettiPiece.className = 'confetti-piece';
            confettiPiece.style.left = Math.random() * 100 + 'vw';
            confettiPiece.style.animationDelay = Math.random() * 5 + 's';
            confettiContainer.appendChild(confettiPiece);
        }
    </script>
</body>
</html>
