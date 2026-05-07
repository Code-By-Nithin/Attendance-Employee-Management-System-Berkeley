<?php
// Database connection
require_once('connection.php');

// Get today's date
$today = date('Y-m-d');

// Query the attendance table for today's data
$sql = "SELECT * FROM attendance WHERE date = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $today);
$stmt->execute();
$result = $stmt->get_result();

// Initialize an array to hold the count of "Present" employees for each section
$attendanceCounts = [
    'Cleaning' => 0,
    'DC' => 0,
    'Washing' => 0,
    'ATP' => 0,
    'Blanket' => 0,
    'Finishing' => 0,
    'Hotel' => 0
];

// Fetch the attendance data
while ($row = $result->fetch_assoc()) {
    if ($row['status'] === 'Present') {
        $attendanceCounts[$row['section']]++;
    }
}

// Close the database connection
$stmt->close();
$conn->close();
?>

<!-- Now, pass the PHP data to JavaScript -->
<script>
    // Pass PHP array to JavaScript
    const attendanceCounts = <?php echo json_encode($attendanceCounts); ?>;
    const totalPresent = Object.values(attendanceCounts).reduce((a, b) => a + b, 0);

    // Function to update the attendance counts on the page
    function updateAttendanceCounts() {
        document.getElementById('totalPresentCount').innerText = totalPresent;
        document.getElementById('cleaningCount').innerText = attendanceCounts['Cleaning'];
        document.getElementById('dcCount').innerText = attendanceCounts['DC'];
        document.getElementById('washingCount').innerText = attendanceCounts['Washing'];
        document.getElementById('atpCount').innerText = attendanceCounts['ATP'];
        document.getElementById('blanketCount').innerText = attendanceCounts['Blanket'];
        document.getElementById('finishingCount').innerText = attendanceCounts['Finishing'];
        document.getElementById('hotelCount').innerText = attendanceCounts['Hotel'];
    }

    // Call the function to update counts on page load
    updateAttendanceCounts();
</script>
