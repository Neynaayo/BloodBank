<?php include 'connectDB.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
/* General body styling */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
    color: #333;
}

/* Header styling */
header {
    background-color: #d9534f;
    color: white;
    padding: 10px 0;
    text-align: center;
}

header .logo img {
    height: 50px;
}

header .middle-container {
    display: flex;
    justify-content: center;
    align-items: center;
}

header .login-signup {
    display: flex;
    gap: 10px;
}

header .login-signup button {
    background-color: white;
    border: none;
    padding: 10px 15px;
    color: #d9534f;
    cursor: pointer;
    border-radius: 5px;
}

header .login-signup button a {
    text-decoration: none;
    color: inherit;
}

header .user-profile a {
    color: white;
    font-size: 1.5em;
    margin-left: 10px;
}

header .social-icons a {
    color: white;
    margin: 0 5px;
    font-size: 1.2em;
}

/* Navigation styling */
nav ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    justify-content: center;
    background-color: #d9534f;
}

nav ul li {
    margin: 0 15px;
}

nav ul li a {
    text-decoration: none;
    color: white;
    padding: 10px 15px;
    display: block;
}

nav ul li a:hover {
    background-color: #c9302c;
}

/* Event list styling */
.event-list {
    padding: 20px;
    background-color: white;
    max-width: 1000px;
    margin: 20px auto;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.event-list h2 {
    text-align: center;
    color: #d9534f;
}

.event-list table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.event-list th, .event-list td {
    padding: 15px;
    text-align: left;
}

.event-list th {
    background-color: #d9534f;
    color: white;
}

.event-list tr:nth-child(even) {
    background-color: #f9f9f9;
}

.event-list td {
    border-bottom: 1px solid #ddd;
}

.event-list td:last-child {
    text-align: center;
}

.event-list button {
    background-color: #d9534f;
    color: white;
    border: none;
    padding: 10px 15px;
    cursor: pointer;
    border-radius: 5px;
}

.event-list button:hover {
    background-color: #c9302c;
}

/* Event details styling */
.event-details {
    padding: 20px;
    background-color: white;
    max-width: 800px;
    margin: 20px auto;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.event-details h2 {
    color: #d9534f;
    text-align: center;
    margin-bottom: 20px;
}

.event-details p {
    font-size: 1.1em;
    margin-bottom: 10px;
}

.event-details button {
    background-color: #d9534f;
    color: white;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
    display: block;
    margin: 20px auto 0;
}

.event-details button:hover {
    background-color: #c9302c;
}

.event-details a {
    text-decoration: none;
    color: white;
}

    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="event-details">
        <?php
        if (isset($_GET['id'])) {
            $event_id = $_GET['id'];
            

            $sql = "SELECT * FROM donation_events WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $event_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "<h2>" . htmlspecialchars($row['event_name']) . "</h2>";
                echo "<p><strong>Date:</strong> " . htmlspecialchars($row['date']) . "</p>";
                echo "<p><strong>Location:</strong> " . htmlspecialchars($row['location']) . "</p>";
                echo "<p><strong>Description:</strong> " . htmlspecialchars($row['description']) . "</p>";
                // Add more details as needed, e.g., organizer, contact info, etc.
            } else { 
                echo "<p>No event found</p>";
            }
        } else {
            echo "<p>Invalid event ID</p>";
        }
        $conn->close();
        ?>
        <a href="event.php"><button>Back to Events</button></a>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
