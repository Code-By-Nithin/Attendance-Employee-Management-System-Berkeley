<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $berkeley_id = mysqli_real_escape_string($conn, $_POST['berkeley_id']);
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $cwk_id = mysqli_real_escape_string($conn, $_POST['cwk_id']);
  $section = mysqli_real_escape_string($conn, $_POST['section']);
  $date = mysqli_real_escape_string($conn, $_POST['date']);
  $category = mysqli_real_escape_string($conn, $_POST['category']);
  $emp_image = mysqli_real_escape_string($conn, $_POST['emp_image']);

  $query = "INSERT INTO ppe_records (berkeley_id, name, cwk_id, section, date, category, emp_image) 
            VALUES ('$berkeley_id', '$name', '$cwk_id', '$section', '$date', '$category', '$emp_image')";

  if (mysqli_query($conn, $query)) {
    header("Location: ppe_form.php");
    exit();
  } else {
    echo "Error: " . mysqli_error($conn);
  }
}
?>
