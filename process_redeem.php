
<?php
session_start();
include 'connectDB.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rewardId = $_POST['reward_id'];
    $rewardPoints = $_POST['reward_points'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    // Get user's current points
    $pointsQuery = "SELECT SUM(Appointment_Point) AS total_points FROM appointment WHERE Donor_Email = ? AND Appointment_Status = 'Completed'";
    $pointsStmt = $conn->prepare($pointsQuery);
    $pointsStmt->bind_param("s", $email);
    $pointsStmt->execute();
    $pointsResult = $pointsStmt->get_result();
    $pointsRow = $pointsResult->fetch_assoc();
    $totalPoints = $pointsRow['total_points'] ? $pointsRow['total_points'] : 0;

    if ($totalPoints < $rewardPoints) {
        echo "You do not have enough points to redeem this reward.";
        exit();
    }

    // Deduct points and insert into redemption table
    $updatePointsQuery = "INSERT INTO redemption (Donor_Email, Redeem_ID, Redeem_Points, Donor_Name, Donor_Address, Donor_NoPhone) VALUES (?, ?, ?, ?, ?, ?)";
    $updatePointsStmt = $conn->prepare($updatePointsQuery);
    $updatePointsStmt->bind_param("siisss", $email, $rewardId, $rewardPoints, $name, $address, $phone);
    $updatePointsStmt->execute();

    // Update points in the appointment table
    $deductPointsQuery = "UPDATE appointment SET Appointment_Point = Appointment_Point - ? WHERE Donor_Email = ? AND Appointment_Status = 'Completed' LIMIT ?";
    $deductPointsStmt = $conn->prepare($deductPointsQuery);
    $deductPointsStmt->bind_param("isi", $rewardPoints, $email, $rewardPoints);
    $deductPointsStmt->execute();

    header("Location: redeem_success.php");
    exit();
}

// Get user details for form auto-fill
$userQuery = "SELECT Donor_Name, Donor_Address, Donor_NoPhone FROM donor WHERE Donor_Email = ?";
$userStmt = $conn->prepare($userQuery);
$userStmt->bind_param("s", $email);
$userStmt->execute();
$userResult = $userStmt->get_result();
$user = $userResult->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redeem Reward</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        input[type="text"],
        input[type="email"],
        input[type="tel"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .btn-redeem {
            display: inline-block;
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: #fff;
            text-align: center;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn-redeem:hover {
            background-color: #218838;
        }
        .message {
            text-align: center;
            font-size: 18px;
            color: red;
        }
    </style>
</head>
<body>
    
    <div class="container">
        <h1>Redeem Reward</h1>
        <form action="redeem_process.php" method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['Donor_Name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user['Donor_Address']); ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($user['Donor_NoPhone']); ?>" required>
            </div>
            <input type="hidden" name="reward_id" value="<?php echo htmlspecialchars($rewardId); ?>">
            <input type="hidden" name="reward_points" value="<?php echo htmlspecialchars($rewardPoints); ?>">
            <button type="submit" class="btn-redeem">Redeem Now</button>
        </form>
    </div> 
</body>
</html>

<?php
$conn->close();
?>
