<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']); // Sanitize input

    // Query to delete the employee
    $query = "DELETE FROM employees WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        echo "success"; // Return success message
    } else {
        echo "error"; // Return error message
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
