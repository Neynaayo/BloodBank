
<?php 
include 'connectDB.php';
include 'header.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Donation Events</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
    /* StyleIndex.css */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
        color: #333;
    }

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

    .search-bar {
        display: flex;
        justify-content: center;
        margin: 20px;
    }

    .search-bar input[type="text"] {
        padding: 10px;
        width: 300px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .search-bar button {
        padding: 10px 15px;
        background-color: #d9534f;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        margin-left: 10px;
    }

    .search-bar button:hover {
        background-color: #c9302c;
    }
    </style>
</head>
<body class="event-page">

    <div class="search-bar">
        <form action="" method="GET">
            <input type="text" name="search" placeholder="Search by location" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <div class="event-list">
        <h2>Upcoming Donation Events</h2>
        <table>
            <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

                $sql = "SELECT * FROM donation_events";
                if (!empty($search)) {
                    $sql .= " WHERE location LIKE '%$search%'";
                }
                $sql .= " ORDER BY date ASC";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['event_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['date']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['location']) . "</td>";
                        echo "<td>
                                <a href='eventDetails.php?id=" . $row['id'] . "'><button>Read More</button></a>
                                <button onclick=\"sendReminder('" . $row['event_name'] . "', '" . $row['date'] . "', '" . $row['location'] . "')\">Reminder</button>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No upcoming events found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script>
    function sendReminder(email, eventName, date, location) {
        if (confirm('Send a reminder email for ' + eventName + ' on ' + date + ' at ' + location + ' to ' + email + '?')) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'sendReminder.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    alert('Reminder sent!');
                } else {
                    alert('Failed to send reminder.');
                }
            };
            xhr.send('email=' + encodeURIComponent(email) + '&event=' + encodeURIComponent(eventName) + '&date=' + encodeURIComponent(date) + '&location=' + encodeURIComponent(location));
        }
    }
    </script>

    <?php include 'footer.php'; ?>
</body>
</html>
