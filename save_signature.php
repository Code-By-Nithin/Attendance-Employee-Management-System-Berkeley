<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $berkeley_id = mysqli_real_escape_string($conn, $_POST['berkeley_id']);
    $cwk_id = mysqli_real_escape_string($conn, $_POST['cwk_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $section = mysqli_real_escape_string($conn, $_POST['section']);
    $signature_data = $_POST['signature_data'];

    // First check if this employee has already signed today
    $today = date('Y-m-d');
    $check_query = "SELECT id FROM staff_signatures 
                   WHERE berkeley_id = '$berkeley_id' 
                   AND DATE(sign_date) = '$today'";
    $check_result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($check_result) > 0) {
        header("Location: sign-sheet.php?error=duplicate");
        exit();
    }

    // Create uploads directory if it doesn't exist
    if (!file_exists('uploads')) {
        mkdir('uploads', 0777, true);
    }

    // Process signature image
    $signature_image = 'signature_' . time() . '_' . $berkeley_id . '.png';
    $signature_path = 'uploads/' . $signature_image;
    
    // Remove the "data:image/png;base64," part
    $signature_data = str_replace('data:image/png;base64,', '', $signature_data);
    $signature_data = str_replace(' ', '+', $signature_data);
    $signature_binary = base64_decode($signature_data);
    
    // Save the image
    if (file_put_contents($signature_path, $signature_binary)) {
        // Insert into database
        $query = "INSERT INTO staff_signatures (berkeley_id, cwk_id, name, section, signature_image) 
                  VALUES ('$berkeley_id', '$cwk_id', '$name', '$section', '$signature_image')";
        
        if (mysqli_query($conn, $query)) {
            header("Location: sign-sheet.php?success=1");
        } else {
            header("Location: sign-sheet.php?error=1");
        }
    } else {
        header("Location: sign-sheet.php?error=2");
    }
    exit();
} else {
    header("Location: sign-sheet.php");
    exit();
}
?>