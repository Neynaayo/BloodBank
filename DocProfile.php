<?php
// Check if the session has already been started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("header.php");

// Check if the user is logged in
if (!isset($_SESSION['email']) || ($_SESSION['role'] != 'healthCare' && $_SESSION['role'] != 'Doctor')) {
    header("Location: login.php");
    exit();
}

// Fetch user information from the database
include 'connectDB.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor/Health Care Profile</title>
    <link rel="stylesheet" href="styles.css">

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<div>
    <div class="container">
        <div class="profile-header">
        <div class="profile-picture">
            <?php 
                $email = $_SESSION['email'];
                $sql = "SELECT * FROM doctor WHERE Doctor_Email = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <a href="docEditProfile.php"><i class="fas fa-edit edit-icon"></i></a>
                        <?php
                        if ($row['Doctor_Pic']) {
                            echo '<img src="profilePic/' . htmlspecialchars($row['Doctor_Pic']) . '" alt="Profile Picture">';
                        } else {
                            echo '<i class="fas fa-user-circle fa-5x"></i>';
                        }
                          ?>
                        </div>
                        <h1 class="doctor-name"><?php echo htmlspecialchars($row['Doctor_Name']); ?></h1>
                        <div class="doctor-position"><?php echo htmlspecialchars($row['Doctor_Position']); ?></div>
                    </div>

                    <div class="profile-body">
                    <div class="info-section">
                        <h2>Professional Info</h2>
                        <p><strong>Certification:</strong> <?php echo htmlspecialchars($row['Doctor_Certification']); ?></p>
                        <p><strong>Working Location:</strong> <?php echo htmlspecialchars($row['Doctor_WorkingLoc']); ?></p>
                    </div>
                         <div class="about-section">
                    <h2>About Me</h2>
                    <p><?php echo htmlspecialchars($row['Doctor_Aboutme']); ?></p>
                 </div>
                  </div>
                <?php
                    }
                } else {
                    echo "No profile found.";
                }
                
                $stmt->close();
                $conn->close();
                ?>
            
            <div class="profile-footer">
            <div class="rating">
            <input value="5" name="rate" id="star5" type="radio">
            <label title="text" for="star5"></label>
            <input value="4" name="rate" id="star4" type="radio">
            <label title="text" for="star4"></label>
            <input value="3" name="rate" id="star3" type="radio" checked="">
            <label title="text" for="star3"></label>
            <input value="2" name="rate" id="star2" type="radio">
            <label title="text" for="star2"></label>
            <input value="1" name="rate" id="star1" type="radio">
            <label title="text" for="star1"></label>
            </div>

            <div class="buttons">
            <a href="cons.php"><button class="button">Join Consultation Room</button></a>
            </div>

            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="far fa-envelope"></i></a>
            </div>
            </div>
        </div>
      </div>      
</body>
</html>
<?php include("footer.php");?>