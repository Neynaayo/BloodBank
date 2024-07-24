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

// Assign column names based on the user role
$table = 'doctor';
$email_column = 'Doctor_Email';
$name_column = 'Doctor_Name';
$certification_column = 'Doctor_Certification';
$working_loc_column = 'Doctor_WorkingLoc';
$about_me_column = 'Doctor_AboutMe';
$position_column = 'Doctor_Position';
$register_date_column = 'Doctor_Registerdate';
$pic_column = 'Doctor_Pic';

// Initialize the profile picture path variable
$profile_picture_path = '';

// Handle profile picture upload
if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
    $profile_picture = $_FILES['profile_picture'];
    $profile_picture_name = basename($profile_picture['name']);
    $profile_picture_tmp = $profile_picture['tmp_name'];
    $profile_picture_size = $profile_picture['size'];
    $profile_picture_type = mime_content_type($profile_picture_tmp);

    // Validate file type (allowing only JPEG, PNG, and GIF)
    if (in_array($profile_picture_type, ['image/jpeg', 'image/png', 'image/gif'])) {
        // Validate file size (limit to 2MB)
        if ($profile_picture_size <= 2 * 1024 * 1024) {
            // Define the target directory and file name
            $target_dir = "profilePic/";
            $target_file = $target_dir . $profile_picture_name;

            // Move the uploaded file to the target directory
            if (move_uploaded_file($profile_picture_tmp, $target_file)) {
                $profile_picture_path = $profile_picture_name;
            } else {
                echo "Error: Unable to move the uploaded file.";
            }
        } else {
            echo "Error: File size exceeds the limit of 2MB.";
        }
    } else {
        echo "Error: Invalid file type. Only JPEG, PNG, and GIF are allowed.";
    }
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name= $_POST['Name'];
    $position = $_POST['position'];
    $certification = $_POST['certification'];
    $working_loc = $_POST['workingLoc'];
    $about_me = $_POST['aboutMe'];

    // Prepare and bind
    $sql = "UPDATE $table SET $name_column=?, $position_column = ?, $certification_column = ?, $working_loc_column = ?, $about_me_column = ?, $pic_column = ? WHERE $email_column = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $name, $position, $certification, $working_loc, $about_me, $profile_picture_path, $email);

    if ($stmt->execute()) {
        echo "<div class='success-message'>Profile updated successfully! <a href='DocProfile.php'>Go back to profile</a></div>";
    } else {
        echo "<div class='error-message'>Error updating profile!</div>";
    }

    $stmt->close();
}

$conn->close();
?>
