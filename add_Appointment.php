<?php
session_start();


include 'connectDB.php';
//$donor_id = $_SESSION['donor_id'];
$email = $_SESSION['email'];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $add_appLocation = $_POST['place'];
    $add_appDate = $_POST['date'];
    $add_appTime = $_POST['time'];

    // Generate random appointment point between 10 and 50
    $appointmentPoint = rand(200, 500);
    // Set appointment status
    $appointmentStatus = 'Not Completed';

    // Prepare the SQL query to insert data into the appointment table
    $query = "INSERT INTO appointment (Appointment_Location, Appointment_Date, Appointment_Time, Appointment_Point, Appointment_Status, Donor_Email) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssss", $add_appLocation, $add_appDate, $add_appTime, $appointmentPoint, $appointmentStatus, $email);

    if ($stmt->execute()) {
        echo "Added Successfully! <a href='appointmentHistory.php'>See appointment</a>";
    } else {
        echo "Problem occurred: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>
