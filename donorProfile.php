<?php
session_start();
include 'connectDB.php';
// Check if the user is logged in and if their role is 'donor'
if (!isset($_SESSION['email']) || $_SESSION['role'] != 'donor') {
    // Redirect to login page if the user is not logged in or not a donor
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styling.css">
</head>
<body>
    <div class="container">
        <header>
            <nav>
                <a href="index.php"><i class="fas fa-home icon"></i> HOME</a>
                <a href="editProfile.php"><i class="fas fa-edit icon"></i> EDIT PROFILE</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt icon"></i> LOGOUT</a>
            </nav>
        </header>
        <main>
            <h1>DONOR PROFILE</h1>
            <div class="profile-section">
                <div class="profile-picture">
                    <?php
                    // Fetch user information from the database
                    $email = $_SESSION['email'];
                    $sql = "SELECT * FROM donor WHERE Donor_Email = '$email'";
                    $gotResults = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($gotResults) > 0) {
                        $row = mysqli_fetch_assoc($gotResults);
                        if ($row['Donor_pic']) {
                            echo '<img src="profilePic/' . htmlspecialchars($row['Donor_pic']) . '" alt="Profile Picture">';
                        } else {
                            echo '<i class="fas fa-user-circle fa-5x"></i>';
                        }
                    ?>
                </div>
                <div class="profile-info">
                    <p><strong>NAME:</strong> <span id="name"><?php echo htmlspecialchars($row['Donor_Name']); ?></span></p>
                    <p><strong>EMAIL:</strong> <span id="email"><?php echo htmlspecialchars($row['Donor_Email']); ?></span></p>
                </div>
            </div>
            <div class="appointment-history">
                <a href="appointmentHistory.php"><i class="fas fa-history icon"></i> Appointment History</a>
            </div>
            <div class="personal-info">
                <h2>PERSONAL INFORMATION</h2>
                <p><strong>ADDRESS:</strong> <span id="address"><?php echo htmlspecialchars($row['Donor_Address']); ?></span></p>
                <p><strong>BLOOD GROUP:</strong> <span id="blood_group"><?php echo htmlspecialchars($row['Donor_BloodG']); ?></span></p>
                <p><strong>GENDER:</strong> <span id="gender"><?php echo htmlspecialchars($row['Donor_Gender']); ?></span></p>
                <p><strong>MARITAL STATUS:</strong> <span id="marital_status"><?php echo htmlspecialchars($row['Donor_MartialStat']); ?></span></p>
                <p><strong>OCCUPATION:</strong> <span id="occupation"><?php echo htmlspecialchars($row['Donor_Occupation']); ?></span></p>
                <p><strong>AGE:</strong> <span id="age"><?php echo htmlspecialchars($row['Donor_Age']); ?></span></p>
                <p><strong>PHONE NUMBER:</strong> <span id="phone"><?php echo htmlspecialchars($row['Donor_NoPhone']); ?></span></p>
            </div>
            <?php
                }
            ?>
            <div class="actions">
                <a href="appointment.php" class="action-button"><i class="fas fa-calendar-plus icon"></i> Make an appointment</a>
                <a href="cons.php" class="action-button"><i class="fas fa-stethoscope icon"></i> Make Consultation Room</a>
            </div>
            <div class="redeem-points">
               <a href="reward.php" > <button class="redeem-button"><i class="fas fa-heart icon"></i> Redeem Points</button> </a>
            </div>
        </main>
    </div>
</body>
</html>
