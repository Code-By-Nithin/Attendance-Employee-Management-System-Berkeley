<?php
// Include database connection
include 'connection.php';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $id = $_POST['id'];
    $name = $_POST['name'];
    $bid = $_POST['bid'];
    $cwkid = $_POST['cwkid'];
    $department = $_POST['department'];
    $section = $_POST['section'];
    $room = $_POST['room'];
    $status = $_POST['status'];

    // Handle image upload
    $image = $_FILES['image']['name'];
    if (!empty($image)) {
        $target_dir = "uploads/"; // Make sure this folder exists
        $target_file = $target_dir . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
    } else {
        // Keep the existing image if no new one is uploaded
        $image = $_POST['existing_image'];
    }

    // Update employee details in the database
    $query = "UPDATE employees SET name = '$name', bid = '$bid', cwkid = '$cwkid', department = '$department', section = '$section', room = '$room', status = '$status', image = '$image' WHERE id = '$id'";

    if (mysqli_query($conn, $query)) {
        // Redirect to the employee list or dashboard page after successful update
        header("Location: users.php");
        exit();
    } else {
        // Handle any errors
        echo "Error updating employee: " . mysqli_error($conn);
    }
}
?>
