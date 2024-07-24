
<?php
// Connection to MySQL
$host = "localhost";
$username = "root";
$password = "";
$dbname = "bloodbank_websys";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
