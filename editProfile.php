<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Fetch user information from the database based on session variables
include 'connectDB.php';

$email = $_SESSION['email'];
$role = $_SESSION['role'];

// Assign column names based on the user role
if ($role == 'donor') {
    $table = 'donor';
    $email_column = 'Donor_Email';
    $name_column = 'Donor_Name';
    $address_column = 'Donor_Address';
    $blood_group_column = 'Donor_BloodG';
    $gender_column = 'Donor_Gender';
    $marital_status_column = 'Donor_MartialStat';
    $occupation_column = 'Donor_Occupation';
    $age_column = 'Donor_Age';
    $phone_column = 'Donor_NoPhone';
    $pic_column = 'Donor_pic';
}

// Fetch current donor data
$sql = "SELECT * FROM $table WHERE $email_column = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$donor = $result->fetch_assoc();

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address = $_POST['address'];
    $blood_group = $_POST['blood_group'];
    $gender = $_POST['gender'];
    $marital_status = $_POST['marital_status'];
    $occupation = $_POST['occupation'];
    $age = $_POST['age'];
    $phone = $_POST['phone'];

    // Initialize the profile picture path variable
    $profile_picture_path = $donor[$pic_column];

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

    // Update user data in the database
    $sql = "UPDATE $table SET $address_column = ?, $blood_group_column = ?, $gender_column = ?, $marital_status_column = ?, $occupation_column = ?, $age_column = ?, $phone_column = ?, $pic_column = ? WHERE $email_column = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $address, $blood_group, $gender, $marital_status, $occupation, $age, $phone, $profile_picture_path, $email);
    if ($stmt->execute()) {
        // Redirect to profile page after successful update
        header("Location: donorProfile.php");
        exit();
    } else {
        echo "Error: Unable to update profile.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Donor Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }

        header {
            background: #50b3a2;
            color: #fff;
            padding: 20px 0;
            text-align: center;
            border-bottom: #e8491d 3px solid;
        }

        header a {
            color: #fff;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 16px;
            margin: 0 15px;
            display: inline-block;
        }

        header .icon {
            margin-right: 8px;
        }

        main {
            padding: 20px;
            background: #fff;
            margin-top: 30px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
        }

        input[type="text"],
        input[type="file"],
        select {
            padding: 10px;
            width: 300px;
            margin: 5px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background: #50b3a2;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }

        input[type="submit"]:hover {
            background: #3e8e7e;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <nav>
                <a href="index.php"><i class="fas fa-home icon"></i> HOME</a>
                <a href="donorProfile.php"><i class="fas fa-user icon"></i> PROFILE</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt icon"></i> LOGOUT</a>
            </nav>
        </header>
        <main>
            <h1>EDIT DONOR PROFILE</h1>
            <form method="POST" enctype="multipart/form-data">
                <label for="address">ADDRESS:</label>
                <input type="text" name="address" id="address" value="<?php echo htmlspecialchars($donor[$address_column]); ?>" required>

                <label for="blood_group">BLOOD GROUP:</label>
                <input type="text" name="blood_group" id="blood_group" value="<?php echo htmlspecialchars($donor[$blood_group_column]); ?>" required>

                <label for="gender">GENDER:</label>
                <select name="gender" id="gender" required>
                    <option value="Male" <?php if ($donor[$gender_column] == 'Male') echo 'selected'; ?>>Male</option>
                    <option value="Female" <?php if ($donor[$gender_column] == 'Female') echo 'selected'; ?>>Female</option>
                    <option value="Other" <?php if ($donor[$gender_column] == 'Other') echo 'selected'; ?>>Other</option>
                </select>

                <label for="marital_status">MARITAL STATUS:</label>
                <select name="marital_status" id="marital_status" required>
                    <option value="Single" <?php if ($donor[$marital_status_column] == 'Single') echo 'selected'; ?>>Single</option>
                    <option value="Married" <?php if ($donor[$marital_status_column] == 'Married') echo 'selected'; ?>>Married</option>
                    <option value="Divorced" <?php if ($donor[$marital_status_column] == 'Divorced') echo 'selected'; ?>>Divorced</option>
                    <option value="Widowed" <?php if ($donor[$marital_status_column] == 'Widowed') echo 'selected'; ?>>Widowed</option>
                </select>

                <label for="occupation">OCCUPATION:</label>
                <input type="text" name="occupation" id="occupation" value="<?php echo htmlspecialchars($donor[$occupation_column]); ?>" required>

                <label for="age">AGE:</label>
                <input type="text" name="age" id="age" value="<?php echo htmlspecialchars($donor[$age_column]); ?>" required>

                <label for="phone">PHONE NUMBER:</label>
                <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($donor[$phone_column]); ?>" required>

                <label for="profile_picture">PROFILE PICTURE:</label>
                <input type="file" name="profile_picture" id="profile_picture">

                <input type="submit" value="Update Profile">
            </form>
        </main>
    </div>
</body>
</html>
