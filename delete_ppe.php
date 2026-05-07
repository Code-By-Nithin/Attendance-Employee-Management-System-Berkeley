<?php
include 'connection.php';

if (isset($_GET['id'])) {
    $ppeID = mysqli_real_escape_string($conn, $_GET['id']);

    // Fetch the PPE record to delete the associated file if needed
    $query = "SELECT * FROM ppe_records WHERE id = '$ppeID'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Optionally, delete the file from the 'uploads' folder if required
        // Uncomment the following line to delete the image file
        // unlink("uploads/" . $row['emp_image']); // Delete the image file

        // Now delete the record from the database
        $delete_query = "DELETE FROM ppe_records WHERE id = '$ppeID'";
        if (mysqli_query($conn, $delete_query)) {
            header("Location: ppe-sheet-form.php"); // Redirect back to the PPE form page
        } else {
            echo "Error deleting PPE record.";
        }
    }
}
?>
