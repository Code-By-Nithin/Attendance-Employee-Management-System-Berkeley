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

// Fetch total number of employees
$total_employees_query = "SELECT COUNT(*) as total_employees FROM employees";
$total_employees_result = mysqli_query($conn, $total_employees_query);
$total_employees_row = mysqli_fetch_assoc($total_employees_result);
$total_employees = $total_employees_row['total_employees'];

// Fetch total number of terminations
$terminations_query = "SELECT COUNT(*) as terminations FROM employees WHERE status = 'Termination'";
$terminations_result = mysqli_query($conn, $terminations_query);
$terminations_row = mysqli_fetch_assoc($terminations_result);
$terminations = $terminations_row['terminations'];

// Fetch total number of resignations
$resignations_query = "SELECT COUNT(*) as resignations FROM employees WHERE status = 'Resigned'";
$resignations_result = mysqli_query($conn, $resignations_query);
$resignations_row = mysqli_fetch_assoc($resignations_result);
$resignations = $resignations_row['resignations'];

// Fetch total number of emergency leaves (EL)
$el_query = "SELECT COUNT(*) as el FROM employees WHERE status = 'EL'";
$el_result = mysqli_query($conn, $el_query);
$el_row = mysqli_fetch_assoc($el_result);
$el = $el_row['el'];

// Fetch total number of notice periods
$notice_period_query = "SELECT COUNT(*) as notice_period FROM employees WHERE status = 'Notice Period'";
$notice_period_result = mysqli_query($conn, $notice_period_query);
$notice_period_row = mysqli_fetch_assoc($notice_period_result);
$notice_period = $notice_period_row['notice_period'];

// Fetch attendance data for the chart
$attendance_query = "
    SELECT 
        date, 
        SUM(CASE WHEN shift = 'Day' AND status = 'Present' THEN 1 ELSE 0 END) as day_present,
        SUM(CASE WHEN shift = 'Night' AND status = 'Present' THEN 1 ELSE 0 END) as night_present
    FROM attendance
    GROUP BY date
    ORDER BY date
";
$attendance_result = mysqli_query($conn, $attendance_query);

$attendance_data = [];
while ($row = mysqli_fetch_assoc($attendance_result)) {
  $attendance_data[] = $row;
}

// Fetch department-wise attendance data
$department_attendance_query = "
    SELECT 
        department,
        date,
        SUM(CASE WHEN shift = 'Day' AND status = 'Present' THEN 1 ELSE 0 END) as day_present,
        SUM(CASE WHEN shift = 'Night' AND status = 'Present' THEN 1 ELSE 0 END) as night_present
    FROM attendance
    GROUP BY department, date
    ORDER BY date, department
";
$department_attendance_result = mysqli_query($conn, $department_attendance_query);

$department_attendance_data = [];
while ($row = mysqli_fetch_assoc($department_attendance_result)) {
  $department_attendance_data[] = $row;
}

// Convert PHP arrays to JSON for JavaScript
$attendance_json = json_encode($attendance_data);
$department_attendance_json = json_encode($department_attendance_data);
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

  <title>Berkeley</title>

</head>

<body class="link-sidebar">
  <!-- Toast -->

  <!-- Preloader -->
  <div class="preloader">
    <img src="assets/images/logos/favicon.png" alt="loader" class="lds-ripple img-fluid">
  </div>
  <div id="main-wrapper">
    <!-- Sidebar Start -->
    <aside class="left-sidebar with-vertical">
      <!-- ---------------------------------- -->
      <!-- Start Vertical Layout Sidebar -->
      <!-- ---------------------------------- -->

      <div>

        <div class="brand-logo d-flex align-items-center">
          <a href="index.php" class="text-nowrap logo-img">
            <img src="assets/images/logos/logo.svg" alt="Logo">
          </a>

        </div>

        <!-- ---------------------------------- -->
        <!-- Dashboard -->
        <!-- ---------------------------------- -->
        <?php include("sidebar.php"); ?>

      </div>
    </aside>
    <!--  Sidebar End -->
    <div class="page-wrapper">
      <!--  Header Start -->
      <?php include("header.php"); ?>
      <!--  Header End -->

      <div class="body-wrapper">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body p-4 pb-0" data-simplebar="">
                  <div class="row flex-nowrap">
                    <div class="col">
                      <div class="card primary-gradient">
                        <div class="card-body text-center px-9 pb-4">
                          <div
                            class="d-flex align-items-center justify-content-center round-48 rounded text-bg-primary flex-shrink-0 mb-3 mx-auto">
                            <iconify-icon icon="solar:user-broken" class="fs-7 text-white"></iconify-icon>
                          </div>
                          <h6 class="fw-normal fs-3 mb-1">Total Staff</h6>
                          <h4 class="mb-3 d-flex align-items-center justify-content-center gap-1">
                            <?php echo $total_employees; ?>
                          </h4>
                        </div>
                      </div>
                    </div>
                    <div class="col">
                      <div class="card warning-gradient">
                        <div class="card-body text-center px-9 pb-4">
                          <div
                            class="d-flex align-items-center justify-content-center round-48 rounded text-bg-warning flex-shrink-0 mb-3 mx-auto">
                            <iconify-icon icon="solar:user-minus-broken" class="fs-7 text-white"></iconify-icon>
                          </div>
                          <h6 class="fw-normal fs-3 mb-1">Termination</h6>
                          <h4 class="mb-3 d-flex align-items-center justify-content-center gap-1">
                            <?php echo $terminations; ?>
                          </h4>
                        </div>
                      </div>
                    </div>
                    <div class="col">
                      <div class="card secondary-gradient">
                        <div class="card-body text-center px-9 pb-4">
                          <div
                            class="d-flex align-items-center justify-content-center round-48 rounded text-bg-secondary flex-shrink-0 mb-3 mx-auto">
                            <iconify-icon icon="solar:user-cross-broken" class="fs-7 text-white"></iconify-icon>
                          </div>
                          <h6 class="fw-normal fs-3 mb-1">Resigned</h6>
                          <h4 class="mb-3 d-flex align-items-center justify-content-center gap-1">
                            <?php echo $resignations; ?>
                          </h4>
                        </div>
                      </div>
                    </div>
                    <div class="col">
                      <div class="card danger-gradient">
                        <div class="card-body text-center px-9 pb-4">
                          <div
                            class="d-flex align-items-center justify-content-center round-48 rounded text-bg-danger flex-shrink-0 mb-3 mx-auto">
                            <iconify-icon icon="solar:user-block-broken" class="fs-7 text-white"></iconify-icon>
                          </div>
                          <h6 class="fw-normal fs-3 mb-1">Emergency Leave</h6>
                          <h4 class="mb-3 d-flex align-items-center justify-content-center gap-1">
                            <?php echo $el; ?>
                          </h4>
                        </div>
                      </div>
                    </div>
                    <div class="col">
                      <div class="card success-gradient">
                        <div class="card-body text-center px-9 pb-4">
                          <div
                            class="d-flex align-items-center justify-content-center round-48 rounded text-bg-success flex-shrink-0 mb-3 mx-auto">
                            <iconify-icon icon="solar:user-circle-broken" class="fs-7 text-white"></iconify-icon>
                          </div>
                          <h6 class="fw-normal fs-3 mb-1">Notice Period</h6>
                          <h4 class="mb-3 d-flex align-items-center justify-content-center gap-1">
                            <?php echo $notice_period; ?>
                          </h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- ----------------------------------------- -->
            <!-- Revenue Forecast -->
            <!-- ----------------------------------------- -->
            <div class="col-lg-8">
              <div class="card">
                <div class="card-body">
                  <div class="d-md-flex align-items-center justify-content-between mb-3">
                    <div>
                      <h5 class="card-title">Attendance</h5>
                      <p class="card-subtitle mb-0">Daily Staff Presence</p>
                    </div>
                  </div>
                  <div style="height: 280px;" class="me-n2 rounded-bars"> <!-- Reduced height -->
                    <div id="attendance-chart"></div>
                  </div>
                </div>
              </div>
            </div>
            <!-- ----------------------------------------- -->
            <!-- Annual Profit -->
            <!-- ----------------------------------------- -->
            <div class="col-lg-4">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title mb-4">Department-wise Attendance</h5>
                  <div class="bg-primary bg-opacity-10 rounded-1 overflow-hidden">
                    <div id="department-attendance-chart"></div>
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


  </div>
  <div class="dark-transparent sidebartoggler"></div>
  <!-- Import Js Files -->
  <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/libs/simplebar/dist/simplebar.min.js"></script>
  <script src="assets/js/theme/app.init.js"></script>
  <script src="assets/js/theme/theme.js"></script>
  <script src="assets/js/theme/app.min.js"></script>
  <script src="assets/js/theme/sidebarmenu-default.js"></script>

  <!-- solar icons -->
  <script src="npm//iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
  <script src="assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="assets/js/dashboards/dashboard1.js"></script>
  <script src="assets/libs/fullcalendar/index.global.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      // Parse PHP JSON data for attendance
      const attendanceData = <?php echo $attendance_json; ?>;
      const departmentAttendanceData = <?php echo $department_attendance_json; ?>;

      // Prepare data for the main attendance chart
      const dates = attendanceData.map((entry) => entry.date);
      const dayPresent = attendanceData.map((entry) => entry.day_present);
      const nightPresent = attendanceData.map((entry) => entry.night_present);

      // Initialize main attendance chart
      const attendanceChartOptions = {
        chart: {
          type: 'line',
          height: 280,
          toolbar: {
            show: false,
          },
        },
        series: [
          {
            name: 'Day Shift',
            data: dayPresent,
          },
          {
            name: 'Night Shift',
            data: nightPresent,
          },
        ],
        xaxis: {
          categories: dates,
          labels: {
            style: {
              colors: '#6B7280',
            },
          },
        },
        yaxis: {
          title: {
            text: 'Number of Staff',
            style: {
              color: '#6B7280',
            },
          },
          labels: {
            style: {
              colors: '#6B7280',
            },
          },
        },
        colors: ['#3B82F6', '#EF4444'], // Blue for Day Shift, Red for Night Shift
        stroke: {
          width: 2,
          curve: 'smooth',
        },
        markers: {
          size: 5,
        },
        tooltip: {
          enabled: true,
          shared: true,
          intersect: false,
        },
        legend: {
          position: 'top',
          horizontalAlign: 'right',
        },
      };

      const attendanceChart = new ApexCharts(document.querySelector("#attendance-chart"), attendanceChartOptions);
      attendanceChart.render();

      // Prepare data for department-wise attendance chart
      const departments = [...new Set(departmentAttendanceData.map((entry) => entry.department))];
      const departmentDates = [...new Set(departmentAttendanceData.map((entry) => entry.date))];

      const departmentSeries = departments.map((department) => {
        const data = departmentDates.map((date) => {
          const entry = departmentAttendanceData.find(
            (e) => e.department === department && e.date === date
          );
          return entry ? entry.day_present + entry.night_present : 0;
        });
        return {
          name: department,
          data: data,
        };
      });

      // Initialize department-wise attendance chart
      const departmentChartOptions = {
        chart: {
          type: 'line',
          height: 280,
          toolbar: {
            show: false,
          },
        },
        series: departmentSeries,
        xaxis: {
          categories: departmentDates,
          labels: {
            style: {
              colors: '#6B7280',
            },
          },
        },
        yaxis: {
          title: {
            text: 'Number of Staff',
            style: {
              color: '#6B7280',
            },
          },
          labels: {
            style: {
              colors: '#6B7280',
            },
          },
        },
        colors: ['#3B82F6', '#EF4444', '#10B981', '#F59E0B', '#8B5CF6', '#EC4899', '#6B7280'], // Colors for departments
        stroke: {
          width: 2,
          curve: 'smooth',
        },
        markers: {
          size: 5,
        },
        tooltip: {
          enabled: true,
          shared: true,
          intersect: false,
        },
        legend: {
          position: 'top',
          horizontalAlign: 'right',
        },
      };

      const departmentChart = new ApexCharts(document.querySelector("#department-attendance-chart"), departmentChartOptions);
      departmentChart.render();
    });
  </script>
</body>

</html>