<?php
session_start();
include 'connection.php';

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

// Fetch PPE records based on date range (if provided)
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : null;
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : null;

$query_ppe = "SELECT * FROM ppe_records";
if ($startDate && $endDate) {
    $query_ppe .= " WHERE date BETWEEN '$startDate' AND '$endDate'";
}
$query_ppe .= " ORDER BY date DESC";
$result_ppe = mysqli_query($conn, $query_ppe);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png">

    <!-- Core Css -->
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://unpkg.com/@tabler/icons-webfont@2.41.0/tabler-icons.min.css">

    <title>PPE Report</title>
    <link rel="stylesheet" href="assets/libs/daterangepicker/daterangepicker.css">
    <style>
        /* Print-specific styles */
        @media print {
            body * {
                visibility: hidden;
            }

            .print-table,
            .print-table * {
                visibility: visible;
            }

            .print-table {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body class="link-sidebar">
    <!-- Preloader -->
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
        <!--  Sidebar End -->
        <div class="page-wrapper">
            <!--  Header Start -->
            <?php include('header.php'); ?>
            <!--  Header End -->

            <div class="body-wrapper">
                <div class="container-fluid">
                    <div class="card card-body py-3">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <div class="d-sm-flex align-items-center justify-space-between">
                                    <h4 class="mb-4 mb-sm-0 card-title">PPE Sheet Report</h4>
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
                                                    PPE Report
                                                </span>
                                            </li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Date Range Picker and Buttons -->
                    <div class="card no-print">
                        <div class="card-body">
                            <form method="GET" action="">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="input-group">
                                        <input type="date" class="form-control" name="start_date" id="start_date"
                                            value="<?php echo isset($_GET['start_date']) ? htmlspecialchars($_GET['start_date']) : ''; ?>">
                                        <span class="input-group-text">to</span>
                                        <input type="date" class="form-control" name="end_date" id="end_date"
                                            value="<?php echo isset($_GET['end_date']) ? htmlspecialchars($_GET['end_date']) : ''; ?>">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="button" class="btn bg-success-subtle text-success"
                                        onclick="window.print()">Print</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- PPE Records Table -->
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive print-table">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Employee</th>
                                            <th>Berkeley ID</th>
                                            <th>CWK ID</th>
                                            <th>Section</th>
                                            <th>Date</th>
                                            <th>Category</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (mysqli_num_rows($result_ppe) > 0) { ?>
                                            <?php while ($row_ppe = mysqli_fetch_assoc($result_ppe)) { ?>
                                                <tr>
                                                    <td><?php echo $row_ppe['name']; ?></td>
                                                    <td><?php echo $row_ppe['berkeley_id']; ?></td>
                                                    <td><?php echo $row_ppe['cwk_id']; ?></td>
                                                    <td><?php echo $row_ppe['section']; ?></td>
                                                    <td><?php echo $row_ppe['date']; ?></td>
                                                    <td><?php echo $row_ppe['category']; ?></td>
                                                </tr>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <tr>
                                                <td colspan="6" class="text-center">No records found for the selected date range.</td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
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
    </div>
    <div class="dark-transparent sidebartoggler"></div>
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/simplebar/dist/simplebar.min.js"></script>
    <script src="assets/js/theme/app.init.js"></script>
    <script src="assets/js/theme/theme.js"></script>
    <script src="assets/js/theme/app.min.js"></script>
    <script src="assets/js/theme/sidebarmenu-default.js"></script>
    <script src="npm/iconify-icon%401.0.8/dist/iconify-icon.min.js"></script>
    <script src="assets/js/extra-libs/moment/moment.min.js"></script>
    <script src="assets/libs/daterangepicker/daterangepicker.js"></script>
    <script src="assets/js/forms/daterangepicker-init.js"></script>
    <script src="assets/js/theme/sidebarmenu-default.js"></script>
    </body>

</html>