<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email']) || ($_SESSION['role'] != 'healthCare' && $_SESSION['role'] != 'Doctor')) {
    header("Location: login.php");
    exit();
}

// Fetch user information from the database based on session variables
include 'connectDB.php';

$email = $_SESSION['email'];
$role = $_SESSION['role'];

// Fetch doctor details
$sql = "SELECT * FROM doctor WHERE Doctor_Email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$doctor = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="body-eP">
    <div class="container-eP">
        <form action="docUpdateProfile.php" method="POST" enctype="multipart/form-data" id="edit-profile-form">
            <div class="profile-picture">
                <?php if ($doctor['Doctor_Pic']): ?>
                    <img src="profilePic/<?php echo htmlspecialchars($doctor['Doctor_Pic']); ?>" alt="Profile Picture">
                <?php else: ?>
                    <i class="fas fa-user-circle fa-5x"></i>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="profile_picture"><i class="fa fa-image"></i> Profile Picture:</label>
                <input type="file" id="profile_picture" name="profile_picture">
            </div>
            <div class="form-group">
                <label for="Name"><i class="fa fa-briefcase"></i> Name:</label>
                <input type="text" id="Name" name="Name" value="<?php echo htmlspecialchars($doctor['Doctor_Name']); ?>">
            </div>
            <div class="form-group">
                <label for="position"><i class="fa fa-briefcase"></i> Position:</label>
                <input type="text" id="position" name="position" value="<?php echo htmlspecialchars($doctor['Doctor_Position']); ?>">
            </div>
            <div class="form-group">
                <label for="certification"><i class="fa fa-certificate"></i> Certification:</label>
                <input type="text" id="certification" name="certification" value="<?php echo htmlspecialchars($doctor['Doctor_Certification']); ?>">
            </div>
            <div class="form-group">
                <label for="workingLoc"><i class="fa fa-hospital"></i> Working Location:</label>
                <input type="text" id="workingLoc" name="workingLoc" value="<?php echo htmlspecialchars($doctor['Doctor_WorkingLoc']); ?>">
            </div>
            <div class="form-group">
                <label for="aboutMe"><i class="fa fa-user-circle"></i> About Me:</label>
                <textarea id="aboutMe" name="aboutMe"><?php echo htmlspecialchars($doctor['Doctor_Aboutme']); ?></textarea>
            </div>
            <button type="submit" class="btn"><i class="fa fa-save"></i> Update Profile</button>
        </form>
    </div>
</body>
</html>