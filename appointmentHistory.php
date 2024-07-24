<?php
// Check if the session has already been started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("header.php");
include 'connectDB.php';

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

// Query to get upcoming appointments using email as ID
$upcomingQuery = "SELECT * FROM appointment WHERE Donor_Email = ? AND Appointment_Status = 'Not completed' ORDER BY Appointment_Date ASC";
$upcomingStmt = $conn->prepare($upcomingQuery);
$upcomingStmt->bind_param("s", $email);
$upcomingStmt->execute();
$upcomingResult = $upcomingStmt->get_result();

// Query to get completed appointments using email as ID
$completedQuery = "SELECT * FROM appointment WHERE Donor_Email = ? AND Appointment_Status = 'Completed' ORDER BY Appointment_Date ASC";
$completedStmt = $conn->prepare($completedQuery);
$completedStmt->bind_param("s", $email);
$completedStmt->execute();
$completedResult = $completedStmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .button {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 8px 16px;
            cursor: pointer;
        }

        .edit-button {
            background-color: #2196F3;
        }

        .cancel-button {
            background-color: #f44336;
        }
    </style>
</head>
<body>
    <h1>APPOINTMENT HISTORY</h1>
    
    <h2>Upcoming Appointments:</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Appointment Location</th>
                <th>Date</th>
                <th>Time</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $upcomingResult->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['Appointment_ID']; ?></td>
                <td><?php echo $row['Appointment_Location']; ?></td>
                <td><?php echo $row['Appointment_Date']; ?></td>
                <td><?php echo $row['Appointment_Time']; ?></td>
                <td>
                <a href="appointment.php?appointment_id=<?php echo $row['Appointment_ID']; ?>"><button class="button edit-button">&#9998;</button></a>
                <a href="appointmentDelete.php?appointment_id=<?php echo $row['Appointment_ID']; ?>"><button class="button cancel-button">&#8722;</button></a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <h2>Completed Appointments:</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Appointment Location</th>
                <th>Date</th>
                <th>Time</th>
                <th>Point</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $completedResult->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['Appointment_ID']; ?></td>
                <td><?php echo $row['Appointment_Location']; ?></td>
                <td><?php echo $row['Appointment_Date']; ?></td>
                <td><?php echo $row['Appointment_Time']; ?></td>
                <td><?php echo $row['Appointment_Point']; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
<?php include("footer.php"); ?>
<?php
$upcomingStmt->close();
$completedStmt->close();
$conn->close();
?>
