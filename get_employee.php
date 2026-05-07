<?php
include 'connection.php';

if (isset($_GET['bid'])) {
    $berkeleyID = mysqli_real_escape_string($conn, $_GET['bid']);
    $query = "SELECT * FROM employees WHERE bid = '$berkeleyID'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $response = array(
            'success' => true,
            'name' => $row['name'],
            'cwk_id' => $row['cwkid'],
            'section' => $row['section'],
            'image' => $row['image'] // Make sure this returns the image name
        );
    } else {
        $response = array('success' => false);
    }

    echo json_encode($response);
} else {
    echo json_encode(array('success' => false));
}
?>
