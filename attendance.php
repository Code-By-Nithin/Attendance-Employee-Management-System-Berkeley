<?php
session_start();
include 'connection.php'; // Ensure database connection

// Redirect if user is not logged in
if (!isset($_SESSION['user'])) {
  header("Location: index.php");
  exit();
}

$email = $_SESSION['user'];

// Fetch user role from the database
$query = "SELECT role FROM users WHERE username = '$email'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$role = $row['role'] ?? 'Unknown'; // Default to 'Unknown' if no role found

// Fetch date and shift from GET request or use today's date and default shift
$selectedDate = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$selectedShift = isset($_GET['shift']) ? $_GET['shift'] : 'Day';

// Fetch present employees from the attendance table for the selected date and shift
$query = "SELECT section, COUNT(*) AS present_count 
          FROM attendance 
          WHERE date = '$selectedDate' AND shift = '$selectedShift' AND status = 'Present' 
          GROUP BY section";
$result = mysqli_query($conn, $query);

// Initialize counters
$totalPresentCount = 0;
$cleaningCount = 0;
$dcCount = 0;
$washingCount = 0;
$atpCount = 0;
$blanketCount = 0;
$finishingCount = 0;
$hotelCount = 0;

while ($row = mysqli_fetch_assoc($result)) {
  $totalPresentCount += $row['present_count'];
  switch ($row['section']) {
    case 'Cleaning':
      $cleaningCount = $row['present_count'];
      break;
    case 'DC':
      $dcCount = $row['present_count'];
      break;
    case 'Washing':
      $washingCount = $row['present_count'];
      break;
    case 'ATP':
      $atpCount = $row['present_count'];
      break;
    case 'Blanket':
      $blanketCount = $row['present_count'];
      break;
    case 'Finishing':
      $finishingCount = $row['present_count'];
      break;
    case 'Hotel':
      $hotelCount = $row['present_count'];
      break;
  }
}
?>

<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <!-- Required meta tags -->
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Favicon icon-->
  <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png" />

  <!-- Core Css -->
  <link rel="stylesheet" href="assets/css/styles.css" />
  <link rel="stylesheet" href="https://unpkg.com/@tabler/icons-webfont@2.41.0/tabler-icons.min.css">

  <title>Attendance</title>
</head>

<body class="link-sidebar">
  <!-- Preloader -->
  <div class="preloader">
    <img src="assets/images/logos/favicon.png" alt="loader" class="lds-ripple img-fluid">
  </div>
  <div id="main-wrapper">
    <!-- Sidebar Start -->
    <aside class="left-sidebar with-vertical">
      <div><!-- ---------------------------------- -->
        <!-- Start Vertical Layout Sidebar -->
        <!-- ---------------------------------- -->

        <div>

          <div class="brand-logo d-flex align-items-center">
            <a href="dashboard.php" class="text-nowrap logo-img">
              <img src="assets/images/logos/logo.svg" alt="Logo">
            </a>

          </div>

          <!-- ---------------------------------- -->
          <!-- Dashboard -->
          <!-- ---------------------------------- -->
          <?php include("sidebar.php"); ?>

        </div>
      </div>
    </aside>
    <!--  Sidebar End -->
    <div class="page-wrapper">
      <!--  Header Start -->
      <?php include("header.php"); ?>
      <!--  Header End -->

      <div class="body-wrapper">
        <div class="container-fluid">
          <div class="col-12">
            <div class="card">
              <div class="card-body p-4 pb-0" data-simplebar="">
                <div class="row flex-nowrap">
                  <div class="col">
                    <div class="card success-gradient">
                      <div class="card-body text-center px-9 pb-3 pt-4">
                        <div
                          class="mb-3 d-flex align-items-center justify-content-center round-48 rounded text-bg-success flex-shrink-0 mx-auto">
                          <i class="ti ti-user fs-7"></i>
                        </div>
                        <h6 class="fw-normal fs-3 mb-0">Total</h6>
                        <h4 class="d-flex align-items-center justify-content-center gap-1 mb-0" id="total-count">
                          <?php echo $totalPresentCount; ?>
                        </h4>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card primary-gradient">
                      <div class="card-body text-center px-9 pb-3 pt-4">
                        <div
                          class="mb-3 d-flex align-items-center justify-content-center round-48 rounded text-bg-primary flex-shrink-0 mx-auto">
                          <i class="ti ti-user fs-7"></i>
                        </div>
                        <h6 class="fw-normal fs-3 mb-0">Cleaning</h6>
                        <h4 class="d-flex align-items-center justify-content-center gap-1 mb-0" id="cleaning-count">
                          <?php echo $cleaningCount; ?>
                        </h4>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card warning-gradient">
                      <div class="card-body text-center px-9 pb-3 pt-4">
                        <div
                          class="mb-3 d-flex align-items-center justify-content-center round-48 rounded text-bg-warning flex-shrink-0 mx-auto">
                          <i class="ti ti-user fs-7"></i>
                        </div>
                        <h6 class="fw-normal fs-3 mb-0">DC</h6>
                        <h4 class="d-flex align-items-center justify-content-center gap-1 mb-0" id="dc-count">
                          <?php echo $dcCount; ?>
                        </h4>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card secondary-gradient">
                      <div class="card-body text-center px-9 pb-3 pt-4">
                        <div
                          class="mb-3 d-flex align-items-center justify-content-center round-48 rounded text-bg-secondary flex-shrink-0 mx-auto">
                          <i class="ti ti-user fs-7"></i>
                        </div>
                        <h6 class="fw-normal fs-3 mb-0">Washing</h6>
                        <h4 class="d-flex align-items-center justify-content-center gap-1 mb-0" id="washing-count">
                          <?php echo $washingCount; ?>
                        </h4>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card danger-gradient">
                      <div class="card-body text-center px-9 pb-3 pt-4">
                        <div
                          class="mb-3 d-flex align-items-center justify-content-center round-48 rounded text-bg-danger flex-shrink-0 mx-auto">
                          <i class="ti ti-user fs-7"></i>
                        </div>
                        <h6 class="fw-normal fs-3 mb-0">ATP</h6>
                        <h4 class="d-flex align-items-center justify-content-center gap-1 mb-0" id="atp-count">
                          <?php echo $atpCount; ?>
                        </h4>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card success-gradient">
                      <div class="card-body text-center px-9 pb-3 pt-4">
                        <div
                          class="mb-3 d-flex align-items-center justify-content-center round-48 rounded text-bg-success flex-shrink-0 mx-auto">
                          <i class="ti ti-user fs-7"></i>
                        </div>
                        <h6 class="fw-normal fs-3 mb-0">Blanket</h6>
                        <h4 class="d-flex align-items-center justify-content-center gap-1 mb-0" id="blanket-count">
                          <?php echo $blanketCount; ?>
                        </h4>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card warning-gradient">
                      <div class="card-body text-center px-9 pb-3 pt-4">
                        <div
                          class="mb-3 d-flex align-items-center justify-content-center round-48 rounded text-bg-warning flex-shrink-0 mx-auto">
                          <i class="ti ti-user fs-7"></i>
                        </div>
                        <h6 class="fw-normal fs-3 mb-0">Finishing</h6>
                        <h4 class="d-flex align-items-center justify-content-center gap-1 mb-0" id="finishing-count">
                          <?php echo $finishingCount; ?>
                        </h4>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card primary-gradient">
                      <div class="card-body text-center px-9 pb-3 pt-4">
                        <div
                          class="mb-3 d-flex align-items-center justify-content-center round-48 rounded text-bg-primary flex-shrink-0 mx-auto">
                          <i class="ti ti-user fs-7"></i>
                        </div>
                        <h6 class="fw-normal fs-3 mb-0">Hotel</h6>
                        <h4 class="d-flex align-items-center justify-content-center gap-1 mb-0" id="hotel-count">
                          <?php echo $hotelCount; ?>
                        </h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="widget-content searchable-container list">
            <div class="card card-body">
              <div class="row">
                <div class="col-md-8 col-xl-6">
                  <form class="position-relative">
                    <input type="text" class="form-control product-search ps-5" id="input-search"
                      placeholder="Search Staffs..." onkeyup="searchEmployees()" />
                    <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                  </form>
                </div>
                <div class="col-md-4 col-xl-3">
                  <form class="search-cnt">
                    <div class="form-group">
                      <input type="date" class="form-control" id="attendance-date" value="<?php echo $selectedDate; ?>">
                    </div>
                  </form>
                </div>
                <div class="col-md-4 col-xl-3">
                  <div class="btn-group search-cnt" data-bs-toggle="buttons">
                    <label class="btn bg-primary-subtle text-primary">
                      <div class="form-check">
                        <input type="radio" id="customRadio4" name="customRadio" class="form-check-input" value="Day"
                          onchange="updateShift('Day')" <?php echo ($selectedShift == 'Day') ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="customRadio4">
                          <span class="d-block d-md-none">Day Shift</span>
                          <span class="d-none d-md-block">Day Shift</span>
                        </label>
                      </div>
                    </label>
                    <label class="btn bg-primary-subtle text-primary">
                      <div class="form-check">
                        <input type="radio" id="customRadio5" name="customRadio" class="form-check-input" value="Night"
                          onchange="updateShift('Night')" <?php echo ($selectedShift == 'Night') ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="customRadio5">
                          <span class="d-block d-md-none">Night Shift</span>
                          <span class="d-none d-md-block">Night Shift</span>
                        </label>
                      </div>
                    </label>
                  </div>
                </div>
              </div>
            </div>

            <div class="card card-body">
              <div class="tab-content mt-2">
                <div class="row">
                  <div class="table-responsive">
                    <table class="table search-table align-middle text-nowrap">
                      <thead class="header-item">
                        <th>Name</th>
                        <th>CWK ID</th>
                        <th>Section</th>
                        <th>Department</th>
                        <th>Action</th>
                      </thead>
                      <tbody id="employee-list">
                        <?php
                        // Fetch employees and their attendance status for the selected date and shift
                        $query = "SELECT e.*, a.status AS attendance_status 
                          FROM employees e 
                          LEFT JOIN attendance a ON e.id = a.employee_id AND a.date = '$selectedDate' AND a.shift = '$selectedShift'
                          WHERE e.status IN ('Active', 'Notice Period')"; // Include both Active and Notice Period employees
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                          <tr class="search-items">
                            <td>
                              <div class="d-flex align-items-center">
                                <img
                                  src="uploads/<?php echo (!empty($row["image"]) && file_exists("uploads/" . $row["image"])) ? htmlspecialchars($row["image"]) : 'default.jpg'; ?>"
                                  alt="avatar" class="rounded-circle" width="35" height="35" />
                                <div class="ms-3">
                                  <div class="user-meta-info">
                                    <h6 class="user-name mb-0" data-name="<?php echo htmlspecialchars($row['name']); ?>">
                                      <?php echo htmlspecialchars($row['name']); ?>
                                    </h6>
                                    <span class="user-work fs-3"
                                      data-occupation="<?php echo htmlspecialchars($row['bid']); ?>">
                                      <?php echo htmlspecialchars($row['bid']); ?>
                                    </span>
                                  </div>
                                </div>
                              </div>
                            </td>
                            <td>
                              <span class="usr-email-addr" data-email="<?php echo htmlspecialchars($row['cwkid']); ?>">
                                <?php echo htmlspecialchars($row['cwkid']); ?>
                              </span>
                            </td>
                            <td>
                              <span class="usr-location" data-location="<?php echo htmlspecialchars($row['section']); ?>">
                                <?php echo htmlspecialchars($row['section']); ?>
                              </span>
                            </td>
                            <td>
                              <div class="action-btn">
                                <span class="usr-location"
                                  data-location="<?php echo htmlspecialchars($row['department']); ?>">
                                  <?php echo htmlspecialchars($row['department']); ?>
                                </span>
                              </div>
                            </td>

                            <td>
                              <div class="btn-group" data-bs-toggle="buttons">
                                <?php
                                $statuses = ['Present', 'Absent', 'Off', 'Sick'];
                                foreach ($statuses as $index => $status) {
                                  $checked = ($row['attendance_status'] == $status) ? 'checked' : '';
                                  ?>
                                  <label class="btn bg-primary-subtle text-primary">
                                    <div class="form-check">
                                      <input type="radio" name="attendance_<?php echo $row['id']; ?>"
                                        class="form-check-input attendance-radio"
                                        data-employee-id="<?php echo $row['id']; ?>" data-bid="<?php echo $row['bid']; ?>"
                                        data-cwkid="<?php echo $row['cwkid']; ?>"
                                        data-section="<?php echo $row['section']; ?>"
                                        data-department="<?php echo $row['department']; ?>"
                                        data-date="<?php echo $selectedDate; ?>" data-shift="<?php echo $selectedShift; ?>"
                                        value="<?php echo $status; ?>" <?php echo $checked; ?>>
                                      <label class="form-check-label">
                                        <span class="d-block d-md-none"><?php echo $index + 1; ?></span>
                                        <span class="d-none d-md-block"><?php echo $status; ?></span>
                                      </label>
                                    </div>
                                  </label>
                                <?php } ?>
                              </div>
                            </td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
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

        function updateShift(shift) {
          var selectedDate = document.getElementById("attendance-date").value;
          window.location.href = "?date=" + selectedDate + "&shift=" + shift;
        }
      </script>
    </div>

    <!--  Search Bar -->
    <?php include("search.php"); ?>

  </div>
  <div class="dark-transparent sidebartoggler"></div>
  <script src="assets/js/vendor.min.js"></script>
  <!-- Import Js Files -->
  <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/libs/simplebar/dist/simplebar.min.js"></script>
  <script src="assets/js/theme/app.init.js"></script>
  <script src="assets/js/theme/theme.js"></script>
  <script src="assets/js/theme/app.min.js"></script>
  <script src="assets/js/theme/sidebarmenu-default.js"></script>

  <!-- solar icons -->
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

  <!-- highlight.js (code view) -->
  <script src="assets/js/highlights/highlight.min.js"></script>
  <script>
    $(document).ready(function () {
      // Change attendance and store in the database without popup notification
      $(".attendance-radio").on("change", function () {
        var employee_id = $(this).data("employee-id");
        var bid = $(this).data("bid");
        var cwkid = $(this).data("cwkid");
        var section = $(this).data("section");
        var department = $(this).data("department");
        var date = $("#attendance-date").val();
        var shift = $(this).data("shift");
        var status = $(this).val();

        $.ajax({
          url: "save_attendance.php", // Path to your PHP script to save the attendance
          type: "POST",
          data: {
            employee_id: employee_id,
            bid: bid,
            cwkid: cwkid,
            section: section,
            department: department,
            date: date,
            shift: shift,
            status: status
          },
          success: function (response) {
            // Update the status on the page without refreshing
            var statusLabel = $("input[name='attendance_" + employee_id + "'][value='" + status + "']").parent().find("span.d-none.d-md-block");
            statusLabel.text(status); // Update the displayed status text dynamically

            // Update counters based on the section
            updateCounters(section, status);
          },
          error: function () {
            alert("Error updating attendance.");
          }
        });
      });

      // Change date and dynamically reload attendance data
      $("#attendance-date").on("change", function () {
        var selectedDate = $(this).val();
        var selectedShift = $("input[name='customRadio']:checked").val();
        window.location.href = "?date=" + selectedDate + "&shift=" + selectedShift; // Reload the page with the new date and shift
      });
    });

    function updateCounters(section, status) {
      var counterId = section.toLowerCase() + "-count";
      var counterElement = document.getElementById(counterId);

      if (counterElement) {
        var currentCount = parseInt(counterElement.innerText);
        if (status === "Present") {
          counterElement.innerText = currentCount + 1;
        } else if (status === "Absent" || status === "Off" || status === "Sick") {
          counterElement.innerText = currentCount - 1;
        }
      }

      // Update total count
      var totalCountElement = document.getElementById("total-count");
      var totalCount = parseInt(totalCountElement.innerText);
      if (status === "Present") {
        totalCountElement.innerText = totalCount + 1;
      } else if (status === "Absent" || status === "Off" || status === "Sick") {
        totalCountElement.innerText = totalCount - 1;
      }
    }

    function searchEmployees() {
      let input = document.getElementById("input-search").value.toLowerCase();
      let rows = document.querySelectorAll("#employee-list .search-items");

      rows.forEach(row => {
        let name = row.querySelector(".user-name").innerText.toLowerCase();
        let bid = row.querySelector(".user-work").innerText.toLowerCase();
        let cwkid = row.querySelector(".usr-email-addr").innerText.toLowerCase();
        let section = row.querySelector(".usr-location").innerText.toLowerCase();
        let department = row.querySelector(".action-btn .usr-location").innerText.toLowerCase();

        if (name.includes(input) || bid.includes(input) || cwkid.includes(input) || section.includes(input) || department.includes(input)) {
          row.style.display = "";
        } else {
          row.style.display = "none";
        }
      });
    }

    function updateShift(shift) {
      var selectedDate = document.getElementById("attendance-date").value;
      window.location.href = "?date=" + selectedDate + "&shift=" + shift;
    }
  </script>
</body>

</html>