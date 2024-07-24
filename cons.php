<?php include "header.php";
include "connectDB.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f4f8;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            font-size: 2.5em;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }

        h2 {
            color: #3498db;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            margin-top: 40px;
        }

        .consultation-list {
            list-style-type: none;
            padding: 0;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .consultation-item {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .consultation-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }

        .avatar {
            width: 100%;
            height: 200px;
            overflow: hidden;
            position: relative;
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .consultation-item:hover .avatar img {
            transform: scale(1.1);
        }

        .info {
            padding: 15px;
            text-align: center;
        }

        .doctor-name {
            font-weight: bold;
            font-size: 1.2em;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .message-icon {
            background-color: #2ecc71;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .message-icon:hover {
            background-color: #27ae60;
            transform: scale(1.1);
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }

        .consultation-item:hover .message-icon {
            animation: pulse 1s infinite;
        }
    </style>
</head>
<body>
    <h1>CONSULTATION WITH <?php echo ($_SESSION['role'] == 'healthCare' || $_SESSION['role'] == 'Doctor') ? 'DONOR' : 'DOCTOR'; ?></h1>

    <h2>Recent Consultation:</h2>
    <ul class="consultation-list">
        <?php
        if ($_SESSION['role'] == 'healthCare' || $_SESSION['role'] == 'Doctor') {
            $query = "SELECT Donor_Email AS email, Donor_Name AS name, Donor_pic AS img FROM donor LIMIT 3";
        } else {
            $query = "SELECT Doctor_Email AS email, Doctor_Name AS name, Doctor_Pic AS img FROM doctor LIMIT 3";
        }

        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<li class="consultation-item">
                        <div class="avatar">
                            <img src="profilePic/' . $row['img'] . '" alt="' . $row['name'] . '">
                        </div>
                        <div class="info">
                            <div class="doctor-name">' . $row['name'] . '</div>
                            <a href="consultationRoom.php?email=' . urlencode($row['email']) . '&role=' . ($_SESSION['role'] == 'healthCare' || $_SESSION['role'] == 'Doctor' ? 'Donor' : 'Doctor') . '" class="message-icon">
                                <i class="fas fa-comment"></i>
                            </a>
                        </div>
                      </li>';
            }
        } else {
            echo '<li>No recent consultations found.</li>';
        }
        ?>
    </ul>

    <h2>Recommended Consultation:</h2>
    <ul class="consultation-list">
        <?php
        if ($_SESSION['role'] == 'healthCare' || $_SESSION['role'] == 'Doctor') {
            $query = "SELECT Donor_Email AS email, Donor_Name AS name, Donor_pic AS img FROM donor LIMIT 10";
        } else {
            $query = "SELECT Doctor_Email AS email, Doctor_Name AS name, Doctor_Pic AS img FROM doctor LIMIT 10";
        }

        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<li class="consultation-item">
                        <div class="avatar">
                            <img src="profilePic/' . $row['img'] . '" alt="' . $row['name'] . '">
                        </div>
                        <div class="info">
                            <div class="doctor-name">' . $row['name'] . '</div>
                            <a href="consultationRoom.php?email=' . urlencode($row['email']) . '&role=' . ($_SESSION['role'] == 'healthCare' || $_SESSION['role'] == 'Doctor' ? 'Donor' : 'Doctor') . '" class="message-icon">
                                <i class="fas fa-comment"></i>
                            </a>
                        </div>
                      </li>';
            }
        } else {
            echo '<li>No recommended consultations found.</li>';
        }
        ?>
    </ul>

</body>
</html>
<?php include "footer.php"; ?>
