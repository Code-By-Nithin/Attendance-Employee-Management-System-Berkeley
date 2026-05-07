<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id'])) {
    $signatureID = mysqli_real_escape_string($conn, $_GET['id']);

    // Fetch the signature record
    $query = "SELECT signature_image FROM staff_signatures WHERE id = '$signatureID'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $image_path = "uploads/" . $row['signature_image'];
        
        // Delete the image file
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        // Delete the record
        $delete_query = "DELETE FROM staff_signatures WHERE id = '$signatureID'";
        if (mysqli_query($conn, $delete_query)) {
            header("Location: sign-sheet.php?deleted=1");
        } else {
            header("Location: sign-sheet.php?error=3");
        }
    } else {
        header("Location: sign-sheet.php?notfound=1");
    }
} else {
    header("Location: sign-sheet.php");
}
exit();
?>