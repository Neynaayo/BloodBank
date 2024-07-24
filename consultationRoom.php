<?php
include "connectDB.php";
session_start();

$consultationEmail = $_GET['email'];
$consultationRole = $_GET['role'];

if (!isset($_SESSION['email']) || !isset($_SESSION['role'])) {
    die("User not logged in.");
}

if ($consultationRole == 'Donor') {
    $query = "SELECT Donor_Name AS name, Donor_pic AS img, Donor_Email AS email FROM donor WHERE Donor_Email = '$consultationEmail'";
} else {
    $query = "SELECT Doctor_Name AS name, Doctor_Pic AS img, Doctor_Email AS email FROM doctor WHERE Doctor_Email = '$consultationEmail'";
}

$result = $conn->query($query);
if ($result->num_rows > 0) {
    $chatUser = $result->fetch_assoc();
} else {
    die("User not found.");
}

function getChatHistory($conn, $email1, $email2) {
    $query = "SELECT * FROM chat_messages 
              WHERE (Donor_Email = '$email1' AND Doctor_Email = '$email2') 
              OR (Donor_Email = '$email2' AND Doctor_Email = '$email1') 
              ORDER BY message_time ASC";
    return $conn->query($query);
}

$userEmail = $_SESSION['email'];
$otherEmail = $consultationEmail;
$chatHistory = getChatHistory($conn, $userEmail, $otherEmail);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = $_POST['message'];
    $senderEmail = $userEmail;

    // Determine who is the donor and who is the doctor
    if ($_SESSION['role'] == 'Donor') {
        $donorEmail = $userEmail;
        $doctorEmail = $consultationEmail;
    } else {
        $donorEmail = $consultationEmail;
        $doctorEmail = $userEmail;
    }

    $query = "INSERT INTO chat_messages (Donor_Email, Doctor_Email, sender_email, message) 
              VALUES ('$donorEmail', '$doctorEmail', '$senderEmail', '$message')";
    
    if ($conn->query($query)) {
        exit(json_encode(['success' => true]));
    } else {
        exit(json_encode(['success' => false, 'error' => $conn->error]));
    }
}

include "header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation Room</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f4f8;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .chat-wrapper {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            width: 90%;
            max-width: 800px;
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: #fff;
            padding: 20px;
            display: flex;
            align-items: center;
            position: relative;
        }

        .header::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            right: 0;
            height: 10px;
            background: linear-gradient(135deg, #4CAF50, #45a049);
            filter: blur(10px);
        }

        .header img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: 20px;
            border: 3px solid #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .header-info h3 {
            margin: 0;
            font-size: 1.5em;
        }

        .header-info p {
            margin: 5px 0 0;
            font-size: 0.9em;
            opacity: 0.8;
        }

        .chat-container {
            padding: 20px;
            height: 400px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            background-color: #f9f9f9;
        }
        .message {
            background-color: #e6e6e6;
            padding: 12px 15px;
            border-radius: 18px;
            margin-bottom: 15px;
            max-width: 70%;
            align-self: flex-start;
            animation: fadeIn 0.3s ease-out;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .user-message {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: #fff;
            align-self: flex-end;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

       .input-container {
            display: flex;
            align-items: center;
            padding: 15px;
            background-color: #fff;
            border-top: 1px solid #e0e0e0;
        }

        .input-container form {
            display: flex;
            width: 100%;
        }

        .input-container input {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 25px;
            background-color: #f0f0f0;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }

        .input-container button {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            margin-left: 10px;
            cursor: pointer;
            transition: transform 0.3s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-shrink: 0;
        }

        .input-container button:hover {
            transform: scale(1.1);
        }

        .input-container button i {
            font-size: 1.2em;
        }

        /* Scrollbar styling */
        .chat-container::-webkit-scrollbar {
            width: 8px;
        }

        .chat-container::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .chat-container::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        .chat-container::-webkit-scrollbar-thumb:hover {
            background: #555;
        }       </style>
</head>
<body>
    <div class="chat-wrapper">
        <div class="container">
            <div class="header">
                <img src="profilePic/<?php echo htmlspecialchars($chatUser['img']); ?>" alt="Profile Picture">
                <div class="header-info">
                    <h3><?php echo htmlspecialchars($chatUser['name']); ?></h3>
                    <p><i class="fas fa-circle" style="color: #4CAF50;"></i> Online</p>
                </div>
            </div>
            <div id="chat-room">
                <div class="chat-container" id="chat-messages">
                    <?php while ($message = $chatHistory->fetch_assoc()) { 
                        $isUserMessage = $message['sender_email'] == $userEmail;
                    ?>
                        <div class="message <?php echo $isUserMessage ? 'user-message' : ''; ?>">
                            <?php echo htmlspecialchars($message['message']); ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="input-container">
                    <form method="POST" action="" id="chat-form">
                        <input type="text" name="message" id="message" placeholder="Type your message..." autocomplete="off">
                        <button type="submit"><i class="fas fa-paper-plane"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const chatContainer = document.getElementById('chat-messages');
        chatContainer.scrollTop = chatContainer.scrollHeight;
        
        document.getElementById('chat-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const messageInput = document.getElementById('message');
            const message = messageInput.value.trim();
            
            if (message !== '') {
                fetch('consultationRoom.php?email=<?php echo urlencode($consultationEmail); ?>&role=<?php echo urlencode($consultationRole); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'message=' + encodeURIComponent(message)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const newMessage = document.createElement('div');
                        newMessage.classList.add('message', 'user-message');
                        newMessage.textContent = message;
                        chatContainer.appendChild(newMessage);
                        chatContainer.scrollTop = chatContainer.scrollHeight;
                        messageInput.value = '';
                    } else {
                        console.error('Failed to send message:', data.error);
                    }
                });
            }
        });
    </script>
</body>
</html>
