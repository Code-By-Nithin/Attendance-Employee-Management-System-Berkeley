<?php
session_start();
include 'connection.php'; // Ensure database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'] ?? '';
    $bid = $_POST['bid'] ?? '';
    $cwkid = $_POST['cwkid'] ?? '';
    $department = $_POST['department'] ?? '';
    $section = $_POST['section'] ?? '';
    $room = $_POST['room'] ?? '';
    $status = $_POST['status'] ?? '';

    // Validate required fields
    if (empty($name) || empty($bid) || empty($cwkid) || empty($department) || empty($section) || empty($room) || empty($status)) {
        die("Error: Please fill all required fields.");
    }

    // Handle Image Upload
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true); // Create uploads folder if not exists
    }

    $image_name = "default.jpg"; // Default image

    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $image_name = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;

        // Move uploaded file
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            die("Error uploading image.");
        }
    }

    // Insert into database
    $sql = "INSERT INTO employees (image, name, bid, cwkid, department, section, room, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $image_name, $name, $bid, $cwkid, $department, $section, $room, $status);

    if ($stmt->execute()) {
        header("Location: users.php"); // Redirect to users.php after success
        exit();
    } else {
        die("Error inserting data: " . $stmt->error);
    }
}
?>
