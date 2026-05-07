<?php
include 'connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch employee data
    $query = "SELECT * FROM employees WHERE id = $id";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        echo "Employee not found.";
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $bid = $_POST['bid'];
    $cwkid = $_POST['cwkid'];
    $department = $_POST['department'];
    $section = $_POST['section'];
    $room = $_POST['room'];
    $status = $_POST['status'];

    $update_query = "UPDATE employees SET 
                     name='$name', bid='$bid', cwkid='$cwkid', 
                     department='$department', section='$section', 
                     room='$room', status='$status' 
                     WHERE id=$id";

    if ($conn->query($update_query) === TRUE) {
        header("Location: users.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
$conn->close();
?>

<!-- Add your HTML form here for editing -->
