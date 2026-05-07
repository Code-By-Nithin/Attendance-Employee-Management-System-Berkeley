<?php
session_start();
include 'connection.php'; // Ensure database connection

// Redirect if user is not logged in
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$email = $_SESSION['user'];

// Fetch user role from database
$query = "SELECT role FROM users WHERE username = '$email'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$role = $row['role'] ?? 'Unknown'; // Default to 'Unknown' if no role found

// Fetch distinct sections
$sections = ["Cleaning", "DC", "Washing", "ATP", "Blanket", "Finishing", "Hotel"];
$statuses = ["Present" => "P", "Absent" => "A", "Off" => "O", "Sick" => "S"];

// Fetch unique dates from the attendance table
$dateQuery = "SELECT DISTINCT date FROM attendance ORDER BY date ASC";
$dateResult = mysqli_query($conn, $dateQuery);

$dates = [];
while ($row = mysqli_fetch_assoc($dateResult)) {
    $dates[] = $row['date'];
}

// Handle month filter
$selectedMonth = isset($_GET['month']) ? $_GET['month'] : date('Y-m');
$monthQuery = "SELECT DISTINCT date FROM attendance WHERE DATE_FORMAT(date, '%Y-%m') = '$selectedMonth' ORDER BY date ASC";
$monthResult = mysqli_query($conn, $monthQuery);

$filteredDates = [];
while ($row = mysqli_fetch_assoc($monthResult)) {
    $filteredDates[] = $row['date'];
}

// If no dates found for selected month, show all dates
if (empty($filteredDates)) {
    $filteredDates = $dates;
}

// Handle search
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Report</title>

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png">

    <!-- Core CSS -->
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://unpkg.com/@tabler/icons-webfont@2.41.0/tabler-icons.min.css">

    <!-- Custom Styles for Filter and Print Button -->
    <style>
        /* Attractive filter and print section */
        .filter-section {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .filter-section .form-control {
            border-radius: 25px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .filter-section .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .filter-section .btn {
            border-radius: 25px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .filter-section .btn-primary {
            background: #2575fc;
            border: none;
        }

        .filter-section .btn-primary:hover {
            background: #1b5fd9;
        }

        .filter-section .btn-success {
            background: #28a745;
            border: none;
        }

        .filter-section .btn-success:hover {
            background: #218838;
        }

        .filter-section .input-group {
            gap: 10px;
        }

        /* Print button with icon */
        .print-btn {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .table>:not(caption)>*>* {
            padding: 4px 4px !important;
            font-size: 12px;
        }

        /* Status Colors */
        .status-present {
            background-color: #ffffff !important; /* White for present */
            color: #000000 !important;
        }

        .status-absent {
            background-color: #ff0000 !important; /* Red for absent */
            color: #000000 !important;
        }

        .status-off {
            background-color: #ffff00 !important; /* Yellow for off */
            color: #000000 !important;
        }

        .status-sick {
            background-color: #00ce00 !important; /* Green for sick */
            color: #000000 !important;
        }

        .total-present {
            background-color: #e6f7ff !important;
            font-weight: bold;
        }

        /* Print styles */
        @media print {
            body * {
                visibility: hidden;
            }

            .print-tables,
            .print-tables * {
                visibility: visible;
            }

            .print-tables {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .print-tables table {
                page-break-after: always;
                /* Ensure each table prints on a new page */
            }
        }
    </style>
</head>

<body class="link-sidebar">
    <div class="preloader">
        <img src="assets/images/logos/favicon.png" alt="loader" class="lds-ripple img-fluid">
    </div>
    <div id="main-wrapper">
        <!-- Sidebar Start -->
        <aside class="left-sidebar with-vertical">
            <div>
                <div class="brand-logo d-flex align-items-center">
                    <a href="dashboard.php" class="text-nowrap logo-img">
                        <img src="assets/images/logos/logo.svg" alt="Logo">
                    </a>
                </div>
                <?php include('sidebar.php'); ?>
            </div>
        </aside>
        <!-- Sidebar End -->

        <div class="page-wrapper">
            <!-- Header Start -->
            <?php include('header.php'); ?>
            <!-- Header End -->

            <div class="body-wrapper">
                <div class="container-fluid">
                    <div class="card card-body py-3">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <div class="d-sm-flex align-items-center justify-space-between">
                                    <h4 class="mb-4 mb-sm-0 card-title">Attendance Sheet Report</h4>
                                    <nav aria-label="breadcrumb" class="ms-auto">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item d-flex align-items-center">
                                                <a class="text-muted text-decoration-none d-flex" href="dashboard.php">
                                                    <iconify-icon icon="solar:home-2-line-duotone"
                                                        class="fs-6"></iconify-icon>
                                                </a>
                                            </li>
                                            <li class="breadcrumb-item" aria-current="page">
                                                <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                                                    Attendance
                                                </span>
                                            </li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Search and Filter Section -->
                    <div class="filter-section">
                        <div class="row">
                            <div class="col-md-4">
                                <form method="GET" action="">
                                    <div class="input-group search-cnt">
                                        <input type="text" class="form-control" name="search"
                                            placeholder="Search by name..."
                                            value="<?php echo htmlspecialchars($searchQuery); ?>">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ti ti-search"></i> Search
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-4">
                                <form method="GET" action="">
                                    <div class="input-group search-cnt">
                                        <input type="month" class="form-control" name="month"
                                            value="<?php echo htmlspecialchars($selectedMonth); ?>">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ti ti-filter"></i> Filter
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-4 text-end search-cnt">
                                <button class="btn btn-success print-btn" onclick="window.print()">
                                    <i class="ti ti-printer"></i> Print Table
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Table -->
                    <div class="row print-tables">
                        <div class="col-lg-12 d-flex align-items-stretch">
                            <div class="card w-100">
                                <div class="card-body">
                                    <div class="row">
                                        <?php foreach ($sections as $section): ?>
                                            <?php foreach (['Day', 'Night'] as $shift): ?>
                                                <?php
                                                // Check if there are employees in this section and shift
                                                $checkQuery = "SELECT COUNT(DISTINCT e.id) as emp_count 
                                                              FROM employees e
                                                              JOIN attendance a ON e.id = a.employee_id
                                                              WHERE a.section = '$section' AND a.shift = '$shift'
                                                              AND (e.name LIKE '%$searchQuery%' OR e.bid LIKE '%$searchQuery%' OR e.cwkid LIKE '%$searchQuery%')";
                                                $checkResult = mysqli_query($conn, $checkQuery);
                                                $checkRow = mysqli_fetch_assoc($checkResult);
                                                
                                                if ($checkRow['emp_count'] > 0): ?>
                                                    <div class="col-12 mb-4">
                                                        <h5 class="mb-2 table-name">
                                                            <?php echo $section . ' (' . $shift . ' Shift)'; ?>
                                                        </h5>
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Name</th>
                                                                        <th>BID</th>
                                                                        <th>CWKID</th>
                                                                        <?php foreach ($filteredDates as $date): ?>
                                                                            <th><?php echo date("j", strtotime($date)); ?></th>
                                                                        <?php endforeach; ?>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    // Initialize daily present counts
                                                                    $dailyPresentCounts = array_fill_keys($filteredDates, 0);
                                                                    
                                                                    // Fetch all employees in this section and shift
                                                                    $query = "SELECT DISTINCT e.name, e.bid, e.cwkid 
                                                                              FROM employees e
                                                                              JOIN attendance a ON e.id = a.employee_id
                                                                              WHERE a.section = '$section' AND a.shift = '$shift'
                                                                              AND (e.name LIKE '%$searchQuery%' OR e.bid LIKE '%$searchQuery%' OR e.cwkid LIKE '%$searchQuery%')
                                                                              ORDER BY e.name";
                                                                    $result = mysqli_query($conn, $query);

                                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                                        $name = $row['name'];
                                                                        $bid = $row['bid'];
                                                                        $cwkid = $row['cwkid'];

                                                                        echo "<tr>";
                                                                        echo "<td>$name</td>";
                                                                        echo "<td>$bid</td>";
                                                                        echo "<td>$cwkid</td>";

                                                                        // Fetch attendance for each date
                                                                        foreach ($filteredDates as $date) {
                                                                            $attendanceQuery = "SELECT status 
                                                                                               FROM attendance 
                                                                                               WHERE employee_id = (SELECT id FROM employees WHERE name = '$name' AND bid = '$bid' AND cwkid = '$cwkid')
                                                                                               AND date = '$date' AND section = '$section' AND shift = '$shift'";
                                                                            $attendanceResult = mysqli_query($conn, $attendanceQuery);
                                                                            $attendanceRow = mysqli_fetch_assoc($attendanceResult);
                                                                            $status = $attendanceRow['status'] ?? '-';

                                                                            // Map status to the desired symbols
                                                                            switch ($status) {
                                                                                case 'Present':
                                                                                    $statusSymbol = 'P';
                                                                                    $statusClass = 'status-present';
                                                                                    $dailyPresentCounts[$date]++;
                                                                                    break;
                                                                                case 'Absent':
                                                                                    $statusSymbol = 'A';
                                                                                    $statusClass = 'status-absent';
                                                                                    break;
                                                                                case 'Off':
                                                                                    $statusSymbol = 'O';
                                                                                    $statusClass = 'status-off';
                                                                                    break;
                                                                                case 'Sick':
                                                                                    $statusSymbol = 'S';
                                                                                    $statusClass = 'status-sick';
                                                                                    break;
                                                                                default:
                                                                                    $statusSymbol = '-';
                                                                                    $statusClass = '';
                                                                                    break;
                                                                            }

                                                                            echo "<td class='$statusClass'>$statusSymbol</td>";
                                                                        }

                                                                        echo "</tr>";
                                                                    }
                                                                    
                                                                    // Add total present row
                                                                    echo "<tr class='total-present'>";
                                                                    echo "<td colspan='3'><strong>Total Present</strong></td>";
                                                                    foreach ($filteredDates as $date) {
                                                                        echo "<td><strong>" . $dailyPresentCounts[$date] . "</strong></td>";
                                                                    }
                                                                    echo "</tr>";
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function handleColorTheme(e) {
                document.documentElement.setAttribute("data-color-theme", e);
            }
        </script>
    </div>

    <?php include('search.php'); ?>
    <div class="dark-transparent sidebartoggler"></div>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/simplebar/dist/simplebar.min.js"></script>
    <script src="assets/js/theme/app.init.js"></script>
    <script src="assets/js/theme/theme.js"></script>
    <script src="assets/js/theme/app.min.js"></script>
    <script src="assets/js/theme/sidebarmenu-default.js"></script>

    <!-- Solar Icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

    <!-- Highlight.js -->
    <script src="assets/js/highlights/highlight.min.js"></script>
</body>
</html>