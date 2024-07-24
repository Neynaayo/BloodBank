<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "header.php";
include 'connectDB.php';

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

// Retrieve the user's total points
$pointsQuery = "SELECT SUM(Appointment_Point) AS total_points FROM appointment WHERE Donor_Email = ? AND Appointment_Status = 'Completed'";
$pointsStmt = $conn->prepare($pointsQuery);
$pointsStmt->bind_param("s", $email);
$pointsStmt->execute();
$pointsResult = $pointsStmt->get_result();
$pointsRow = $pointsResult->fetch_assoc();
$totalPoints = $pointsRow['total_points'] ? $pointsRow['total_points'] : 0;

// Retrieve the available rewards
$rewardsQuery = "SELECT * FROM redeempoint";
$rewardsResult = $conn->query($rewardsQuery);

// Retrieve user's personal information if available
$userInfoQuery = "SELECT Donor_Name, Donor_Address, Donor_NoPhone FROM donor WHERE Donor_Email = ?";
$userInfoStmt = $conn->prepare($userInfoQuery);
$userInfoStmt->bind_param("s", $email);
$userInfoStmt->execute();
$userInfoResult = $userInfoStmt->get_result();
$userInfo = $userInfoResult->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redeem Points</title>
    <style>
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        header {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }
        .home-btn {
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .balance {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 40px;
        }
        .rewards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        .reward-item {
            border: 1px solid #ccc;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .reward-image img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }
        .reward-details {
            padding: 10px;
        }
        .reward-details h3 {
            margin-top: 0;
        }
        .redeem-btn {
            display: block;
            width: 100%;
            max-width: 200px;
            margin: 0 auto;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        
    #redeem-form-container {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #redeem-form {
        background-color: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        max-width: 400px;
        width: 100%;
    }

    #redeem-form h2 {
        margin-top: 0;
        color: #007bff;
        text-align: center;
    }

    #redeem-form .form-group {
        margin-bottom: 20px;
    }

    #redeem-form label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #333;
    }

    #redeem-form input[type="text"],
    #redeem-form input[type="email"] {
        width: 100%;
        padding: 10px;
        border: 2px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
        transition: border-color 0.3s ease;
    }

    #redeem-form input[type="text"]:focus,
    #redeem-form input[type="email"]:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    #redeem-form button[type="submit"] {
        width: 100%;
        padding: 12px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    #redeem-form button[type="submit"]:hover {
        background-color: #0056b3;
    }

    #close-form {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 24px;
        color: #333;
        cursor: pointer;
        background: none;
        border: none;
    }
        
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Balance</h1>
        <p class="balance">
            <?php echo $totalPoints . " points"; ?>
        </p>

        <div class="rewards">
            <?php
            if ($rewardsResult->num_rows > 0) {
                while ($reward = $rewardsResult->fetch_assoc()) {
                    echo '<div class="reward-item">';
                    echo '<div class="reward-image">
                            <img src="img/' . htmlspecialchars($reward['Redeem_pic']) . '" alt="' . htmlspecialchars($reward['Redeem_Desc']) . '">
                          </div>';
                    echo '<div class="reward-details">';
                   echo '<h3>' . htmlspecialchars($reward['Redeem_Name']) . '</h3>';
                    echo '<p>' . htmlspecialchars($reward['Redeem_Desc']) . '</p>';
                    echo '<p>Points Required: ' . htmlspecialchars($reward['Redeem_PointValue']) . '</p>';
                    echo '<button class="redeem-btn" onclick="openRedeemForm(' . htmlspecialchars($reward['Redeem_ID']) . ', ' . htmlspecialchars($reward['Redeem_PointValue']) . ')">Redeem Now</button>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No rewards available at the moment.</p>';
            }
            ?>
        </div>
    </div>


<!-- Update your form HTML -->
<div id="redeem-form-container">
    <form id="redeem-form" action="process_redeem.php" method="post">
        <button type="button" id="close-form">&times;</button>
        <h2>Redeem Reward</h2>
        <input type="hidden" id="reward_id" name="reward_id">
        <input type="hidden" id="reward_points" name="reward_points">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($userInfo['Donor_Name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($userInfo['Donor_Address']); ?>" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($userInfo['Donor_NoPhone']); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly>
        </div>
        <button type="submit">Confirm Redeem</button>
    </form>
</div>

<script>
    function openRedeemForm(rewardId, rewardPoints) {
        const totalPoints = <?php echo $totalPoints; ?>;
        if (totalPoints < rewardPoints) {
            alert('You do not have enough points to redeem this reward.');
            return;
        }

        document.getElementById('reward_id').value = rewardId;
        document.getElementById('reward_points').value = rewardPoints;
        document.getElementById('redeem-form-container').style.display = 'flex';
    }

    document.getElementById('close-form').addEventListener('click', function() {
        document.getElementById('redeem-form-container').style.display = 'none';
    });
</script>
</body>
</html>

<?php
include('footer.php');
$conn->close();
?>
