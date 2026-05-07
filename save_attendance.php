<?php
include 'connection.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_POST['employee_id'];
    $bid = $_POST['bid'];
    $cwkid = $_POST['cwkid'];
    $section = $_POST['section'];
    $department = $_POST['department'];
    $date = $_POST['date'];
    $shift = $_POST['shift'];
    $status = $_POST['status'];

    // Check if the record already exists
    $checkQuery = "SELECT id FROM attendance WHERE employee_id = ? AND date = ? AND shift = ?";
    $stmt = mysqli_prepare($conn, $checkQuery);
    mysqli_stmt_bind_param($stmt, "iss", $employee_id, $date, $shift);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        // Update the existing record
        $updateQuery = "UPDATE attendance SET status = ? WHERE employee_id = ? AND date = ? AND shift = ?";
        $stmtUpdate = mysqli_prepare($conn, $updateQuery);
        mysqli_stmt_bind_param($stmtUpdate, "siss", $status, $employee_id, $date, $shift);

        if (mysqli_stmt_execute($stmtUpdate)) {
            echo "Attendance updated successfully!";
        } else {
            echo "Error updating attendance: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmtUpdate);
    } else {
        // Insert new record
        $insertQuery = "INSERT INTO attendance (employee_id, bid, cwkid, section, department, date, shift, status)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtInsert = mysqli_prepare($conn, $insertQuery);
        mysqli_stmt_bind_param($stmtInsert, "isssssss", $employee_id, $bid, $cwkid, $section, $department, $date, $shift, $status);

        if (mysqli_stmt_execute($stmtInsert)) {
            echo "Attendance saved successfully!";
        } else {
            echo "Error saving attendance: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmtInsert);
    }

    // Close statements and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>