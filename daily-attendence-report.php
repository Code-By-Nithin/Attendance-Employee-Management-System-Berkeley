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

// Handle filters
$selectedDate = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$selectedShift = isset($_GET['shift']) ? $_GET['shift'] : 'Day';
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

// Fetch distinct sections
$sectionsQuery = "SELECT DISTINCT section FROM attendance WHERE date = '$selectedDate' AND shift = '$selectedShift'";
$sectionsResult = mysqli_query($conn, $sectionsQuery);
$sections = [];
while ($row = mysqli_fetch_assoc($sectionsResult)) {
    $sections[] = $row['section'];
}

// Status order: Present → Absent → Off → Sick
$statusOrder = ['Present', 'Absent', 'Off', 'Sick'];
?>
<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Attendance Report</title>

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png">

    <!-- Core CSS -->
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://unpkg.com/@tabler/icons-webfont@2.41.0/tabler-icons.min.css">

    <!-- Custom Styles -->
    <style>
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

        /* Placeholder color for search input */
        .filter-section .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7) !important;
        }

        /* Shift dropdown font color */
        .filter-section select.form-control {
            color: #000 !important; /* Black font color */
            background-color: rgba(255, 255, 255, 0.1) !important; /* Same background */
        }

        .filter-section .btn {
            border-radius: 25px;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }

        .status-present { background-color: #ffffff !important; color: #000000 !important; }
        .status-absent { background-color: #ff0000 !important; color: #000000 !important; }
        .status-off { background-color: #ffff00 !important; color: #000000 !important; }
        .status-sick { background-color: #00ce00 !important; color: #000000 !important; }

        @media print {
            body * { visibility: hidden; }
            .print-tables, .print-tables * { visibility: visible; }
            .print-tables { position: absolute; left: 0; top: 0; width: 100%; }
        }
        .table>:not(caption)>*>* {
            padding: 4px 4px !important;
            font-size: 12px;
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
                                    <h4 class="mb-4 mb-sm-0 card-title">Daily Attendance Report</h4>
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
                        <form method="GET" action="">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="search"
                                        placeholder="Search by name, BID, or CWKID"
                                        value="<?= htmlspecialchars($searchQuery) ?>">
                                </div>
                                <div class="col-md-3">
                                    <input type="date" class="form-control" name="date"
                                        value="<?= htmlspecialchars($selectedDate) ?>">
                                </div>
                                <div class="col-md-3">
                                    <select name="shift" class="form-control">
                                        <option value="Day" <?= $selectedShift === 'Day' ? 'selected' : '' ?>>Day Shift</option>
                                        <option value="Night" <?= $selectedShift === 'Night' ? 'selected' : '' ?>>Night Shift</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="ti ti-filter"></i> Filter
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Attendance Tables -->
                    <div class="row print-tables">
                        <?php if (empty($sections)): ?>
                            <div class="col-12">
                                <div class="alert alert-warning">No attendance records found for the selected date and shift.</div>
                            </div>
                        <?php else: ?>
                            <?php foreach ($sections as $section): ?>
                                <div class="col-12 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <?= $section ?> Section - <?= $selectedShift ?> Shift (<?= $selectedDate ?>)
                                            </h5>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>BID</th>
                                                            <th>CWKID</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        // Fetch attendance for this section, sorted by status
                                                        $query = "SELECT e.name, e.bid, e.cwkid, a.status 
                                                                  FROM employees e 
                                                                  INNER JOIN attendance a ON e.id = a.employee_id 
                                                                  WHERE a.date = '$selectedDate' 
                                                                  AND a.shift = '$selectedShift' 
                                                                  AND a.section = '$section'
                                                                  AND (e.name LIKE '%$searchQuery%' 
                                                                  OR e.bid LIKE '%$searchQuery%' 
                                                                  OR e.cwkid LIKE '%$searchQuery%')
                                                                  ORDER BY FIELD(a.status, 'Present', 'Absent', 'Off', 'Sick'), e.name";
                                                        $result = mysqli_query($conn, $query);

                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $statusClass = strtolower($row['status']);
                                                                echo "<tr class='status-$statusClass'>
                                                                    <td>{$row['name']}</td>
                                                                    <td>{$row['bid']}</td>
                                                                    <td>{$row['cwkid']}</td>
                                                                    <td>{$row['status']}</td>
                                                                </tr>";
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4'>No records found in this section.</td></tr>";
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Print Button -->
                    <div class="text-end mt-3">
                        <button class="btn btn-success print-btn" onclick="window.print()">
                            <i class="ti ti-printer"></i> Print Report
                        </button>
                    </div>
                </div>
            </div>
        </div>

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