<?php
include 'connection.php';

$section = isset($_POST['section']) ? $_POST['section'] : 'All';
$department = isset($_POST['department']) ? $_POST['department'] : 'All';

$query = "SELECT * FROM employees WHERE 1";

if ($section !== "All") {
    $query .= " AND section = '" . mysqli_real_escape_string($conn, $section) . "'";
}

if ($department !== "All") {
    $query .= " AND department = '" . mysqli_real_escape_string($conn, $department) . "'";
}

$result = mysqli_query($conn, $query);
$output = "";

while ($row = mysqli_fetch_assoc($result)) {
    $imagePath = "uploads/" . htmlspecialchars($row['image']);
    $defaultImage = "uploads/default.jpg"; 
    if (!file_exists($imagePath) || empty($row['image'])) {
        $imagePath = $defaultImage;
    }

    $output .= "
    <tr class='search-items'>
        <td>
            <div class='d-flex align-items-center'>
                <img src='$imagePath' alt='avatar' class='rounded-circle' width='35' height='35' />
                <div class='ms-3'>
                    <h6 class='user-name mb-0'>" . htmlspecialchars($row['name']) . "</h6>
                    <span class='fs-3'>" . htmlspecialchars($row['bid']) . "</span>
                </div>
            </div>
        </td>
        <td><span>" . htmlspecialchars($row['cwkid']) . "</span></td>
        <td><span>" . htmlspecialchars($row['section']) . "</span></td>
        <td><span>" . htmlspecialchars($row['department']) . "</span></td>
        <td>
            <div class='btn-group' data-bs-toggle='buttons'>
                <label class='btn bg-primary-subtle text-primary'>
                    <input type='radio' name='attendance_" . $row['id'] . "' class='form-check-input'>
                    <span>Present</span>
                </label>
                <label class='btn bg-primary-subtle text-primary'>
                    <input type='radio' name='attendance_" . $row['id'] . "' class='form-check-input'>
                    <span>Absent</span>
                </label>
                <label class='btn bg-primary-subtle text-primary'>
                    <input type='radio' name='attendance_" . $row['id'] . "' class='form-check-input'>
                    <span>Off</span>
                </label>
                <label class='btn bg-primary-subtle text-primary'>
                    <input type='radio' name='attendance_" . $row['id'] . "' class='form-check-input'>
                    <span>Sick</span>
                </label>
            </div>
        </td>
    </tr>";
}

echo $output;
?>
