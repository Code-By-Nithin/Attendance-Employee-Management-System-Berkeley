<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_id = $_POST['employee_id'];
    $date = $_POST['date'];
    $status = $_POST['status'];

    $checkQuery = "SELECT * FROM attendance WHERE employee_id = $employee_id AND date = '$date'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        $query = "UPDATE attendance SET status = '$status' WHERE employee_id = $employee_id AND date = '$date'";
    } else {
        $query = "INSERT INTO attendance (employee_id, date, status, department, section)
                  VALUES ($employee_id, '$date', '$status', 
                         (SELECT department FROM employees WHERE id = $employee_id), 
                         (SELECT section FROM employees WHERE id = $employee_id))";
    }

    if (mysqli_query($conn, $query)) {
        echo "Success";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
