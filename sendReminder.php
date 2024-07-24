<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $event = $_POST['event'];
    $date = $_POST['date'];
    $location = $_POST['location'];

    $to = $email;
    $subject = 'Event Reminder: ' . $event;
    $message = 'You have an upcoming donation event:\n\n' . 
               'Event: ' . $event . '\n' .
               'Date: ' . $date . '\n' .
               'Location: ' . $location . '\n\n' .
               'Please be on time. Thank you!';
    $headers = 'From: noreply@yourdomain.com' . "\r\n" .
               'Reply-To: noreply@yourdomain.com' . "\r\n" .
               'X-Mailer: PHP/' . phpversion();

    if (mail($to, $subject, $message, $headers)) {
        echo 'Reminder sent!';
    } else {
        echo 'Failed to send reminder.';
    }
} else {
    echo 'Invalid request method.';
}
?>
