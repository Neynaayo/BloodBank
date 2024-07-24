<?php
session_start();
include 'connectDB.php';

// Get the form data
$email = $_POST['email'];
$password = $_POST['password'];
$role = $_POST['role'];

// Set the table and column names based on the role
if ($role == 'healthCare' || $role == 'Doctor') {
    $table = 'doctor';
    $email_column = 'Doctor_Email';
    $pass_column = 'Doctor_Pass';
    $id_column = 'Doctor_ID'; // Assuming the primary key column is Doctor_ID
} elseif ($role == 'donor') {
    $table = 'donor';
    $email_column = 'Donor_Email';
    $pass_column = 'Donor_Pass';
    $id_column = 'Donor_ID'; // Assuming the primary key column is Donor_ID
} else {
    echo "Invalid role specified!";
    exit();
}

// Query the database to check the user credentials
$sql = "SELECT * FROM $table WHERE $email_column = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Verify the password
    if (password_verify($password, $user[$pass_column])) {
        // Set session variables
        $_SESSION['user_id'] = $user[$id_column];
        $_SESSION['email'] = $user[$email_column];
        $_SESSION['role'] = $role;

        // Redirect based on user role
        if ($role == 'healthCare' || $role == 'Doctor') {
            header("Location: DocProfile.php");
        } elseif ($role == 'donor') {
            header("Location: donorProfile.php");
        } else {
            // Default redirect if role is unknown
            header("Location: index.php");
        }
        exit();
    } else {
        echo "Invalid email or password!";
    }
} else {
    echo "Invalid email or password!";
}

$stmt->close();
$conn->close();
?>
