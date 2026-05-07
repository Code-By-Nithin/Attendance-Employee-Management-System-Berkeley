<?php
session_start();
include 'connection.php';

if (!isset($_GET['bid'])) {
    echo json_encode(['exists' => false]);
    exit();
}

$berkeley_id = mysqli_real_escape_string($conn, $_GET['bid']);
$today = date('Y-m-d');

// Check if this employee has already signed today
$query = "SELECT id FROM staff_signatures 
          WHERE berkeley_id = '$berkeley_id' 
          AND DATE(sign_date) = '$today'";
$result = mysqli_query($conn, $query);

echo json_encode(['exists' => mysqli_num_rows($result) > 0]);
?>