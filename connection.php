<?php
$servername = "localhost";  // Change if using a remote database
$username = "nithind";  // Your database username
$password = "Nithin6362@@123";  // Your database password
$database = "nithinde_portfolio";  // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
