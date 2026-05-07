<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

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


$sql = "SELECT * FROM employees";
$result = $conn->query($sql);
?>

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


  <title>Employees</title>


  <style>
    /* New modal styling */
    .new-modal-content {
      border-radius: 8px;
      padding: 20px;
    }

    .new-modal-content .modal-header {
      color: #fff;
      font-size: 1.25rem;
      font-weight: bold;
    }

    .new-modal-content .modal-body {
      background-color: #fff;
    }

    .new-modal-content .form-control,
    .new-modal-content .form-select {
      border-radius: 5px;
      padding: 10px;
    }

    .new-modal-content .btn-success {
      background-color: #28a745;
      border: none;
    }

    .new-modal-content .btn-danger {
      background-color: #dc3545;
      border: none;
    }

    .new-modal-content .modal-footer {
      padding-top: 15px;
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


          <div class="widget-content searchable-container list">
            <div class="card card-body">
              <div class="row">
                <div class="col-md-4 col-xl-3">
                  <form class="position-relative">
                    <input type="text" class="form-control product-search ps-5" id="input-search"
                      placeholder="Search Employee...">
                    <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                  </form>
                </div>
                <div
                  class="col-md-8 col-xl-9 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                  <?php if ($role == 'admin'): ?>
                    <a href="javascript:void(0)" id="btn-add-contact" class="btn btn-primary d-flex align-items-center">
                      <i class="ti ti-users text-white me-1 fs-5"></i> Add Employee
                    </a>
                  <?php else: ?>
                    <a href="javascript:void(0)" id="btn-add-contact" class="btn btn-primary d-flex align-items-center"
                      style="display: none !important">
                      <i class="ti ti-users text-white me-1 fs-5"></i> Add Employee
                    </a>
                  <?php endif; ?>
                </div>
              </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="addContactModal" tabindex="-1" role="dialog"
              aria-labelledby="addContactModalTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <form id="addEmployeeForm" action="upload_employee.php" method="POST" enctype="multipart/form-data">
                  <div class="modal-content">
                    <div class="modal-header d-flex align-items-center">
                      <h5 class="modal-title">Add Employee</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="add-contact-box">
                        <div class="add-contact-content">
                          <div class="row">
                            <div class="col-md-12">
                              <div class="mb-3 contact-name">
                                <input class="form-control" type="file" name="image" id="formFile" required>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="mb-3 contact-name">
                                <input type="text" name="name" class="form-control" placeholder="Name" required>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="mb-3 contact-name">
                                <input type="text" name="bid" class="form-control" placeholder="Berkeley ID" required>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="mb-3 contact-email">
                                <input type="text" name="cwkid" class="form-control" placeholder="CWK ID" required>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="mb-3 contact-occupation">
                                <input type="text" name="department" class="form-control" placeholder="Department"
                                  required>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="mb-3 contact-phone">
                                <input type="text" name="section" class="form-control" placeholder="Section" required>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="mb-3 contact-phone">
                                <input type="text" name="room" class="form-control" placeholder="Room" required>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="mb-3 contact-phone">
                                <select class="form-select" name="status" required>
                                  <option selected disabled>Status</option>
                                  <option value="Active">Active</option>
                                  <option value="Termination">Termination</option>
                                  <option value="Resigned">Resigned</option>
                                  <option value="Notice Period">Notice Period</option>
                                  <option value="EL">EL</option>
                                  <option value="Personal Reason">Personal Reason</option>
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-success">Add Employee</button>
                      <button class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">Discard</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="card card-body">
              <div class="table-responsive">
                <table class="table search-table align-middle text-nowrap">
                  <thead class="header-item">
                    <th>Name</th>
                    <th>CWK ID</th>
                    <th>Department</th>
                    <th>Section</th>
                    <th>Room</th>
                    <th>Status</th>
                    <?php if ($role == 'admin'): ?>
                      <th>Action</th>
                    <?php else: ?>
                      <th style="display: none;">Action</th>
                    <?php endif; ?>
                  </thead>
                  <tbody>
                    <!-- start row -->
                    <?php if ($result->num_rows > 0): ?>
                      <?php while ($row = $result->fetch_assoc()): ?>
                        <tr class="search-items">
                          <td>
                            <div class="d-flex align-items-center">
                              <img
                                src="uploads/<?php echo (!empty($row["image"]) && file_exists("uploads/" . $row["image"])) ? htmlspecialchars($row["image"]) : 'default.jpg'; ?>"
                                alt="avatar" class="rounded-circle" width="40" height="40">

                              <div class="ms-3">
                                <div class="user-meta-info">
                                  <h6 class="user-name mb-0">
                                    <a
                                      href="user-profile.php?id=<?php echo $row["id"]; ?>"><?php echo htmlspecialchars($row["name"]); ?></a>
                                  </h6>
                                  <span class="user-work fs-3"><?php echo htmlspecialchars($row["bid"]); ?></span>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td><span class="usr-email-addr"><?php echo htmlspecialchars($row["cwkid"]); ?></span></td>
                          <td><span class="usr-location"><?php echo htmlspecialchars($row["department"]); ?></span></td>
                          <td><span class="usr-ph-no"><?php echo htmlspecialchars($row["section"]); ?></span></td>
                          <td><span class="usr-ph-no"><?php echo htmlspecialchars($row["room"]); ?></span></td>
                          <td><span class="usr-ph-no"><?php echo htmlspecialchars($row["status"]); ?></span></td>
                          <td>
                            <div class="action-btn">
                              <?php if ($role == 'admin'): ?>
                                <a href="#" class="text-primary edit-employee-btn"
                                  id="edit-employee-<?php echo $row["id"]; ?>" data-id="<?php echo $row['id']; ?>"
                                  data-name="<?php echo $row['name']; ?>" data-bid="<?php echo $row['bid']; ?>"
                                  data-cwkid="<?php echo $row['cwkid']; ?>"
                                  data-department="<?php echo $row['department']; ?>"
                                  data-section="<?php echo $row['section']; ?>" data-room="<?php echo $row['room']; ?>"
                                  data-status="<?php echo $row['status']; ?>" data-image="<?php echo $row['image']; ?>">
                                  <i class="ti ti-pencil fs-5"></i>
                                </a>
                              <?php else: ?>
                                <a href="#" class="text-primary edit-employee-btn" style="display: none;">
                                  <i class="ti ti-pencil fs-5"></i>
                                </a>
                              <?php endif; ?>
                            </div>
                          </td>

                        </tr>
                      <?php endwhile; ?>
                    <?php else: ?>
                      <tr>
                        <td colspan="7" class="text-center">No employees found</td>
                      </tr>
                    <?php endif; ?>

                    <?php $conn->close(); ?>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- New Edit Employee Modal -->
      <!-- Edit Employee Modal -->
      <div class="modal fade" id="newEditEmployeeModal" tabindex="-1" aria-labelledby="newEditEmployeeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content new-modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="newEditEmployeeModalLabel">Edit Employee Information</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form id="newEditEmployeeForm" action="update_employee.php" method="POST" enctype="multipart/form-data">
                <!-- Hidden input for employee ID -->
                <input type="hidden" name="id" id="new-edit-id">

                <!-- Profile Image -->
                <div class="mb-3">
                  <label for="new-edit-image" class="form-label">Profile Image</label>
                  <input type="file" name="image" id="new-edit-image" class="form-control">
                  <img id="new-edit-employee-image" src="" class="mt-2 rounded-circle" width="50" height="50"
                    alt="Current Image">
                </div>

                <!-- Employee Details -->
                <div class="mb-3">
                  <label for="new-edit-name" class="form-label">Employee Name</label>
                  <input type="text" name="name" id="new-edit-name" class="form-control" required>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="new-edit-bid" class="form-label">Berkeley ID</label>
                      <input type="text" name="bid" id="new-edit-bid" class="form-control" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="new-edit-cwkid" class="form-label">CWK ID</label>
                      <input type="text" name="cwkid" id="new-edit-cwkid" class="form-control" required>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="new-edit-department" class="form-label">Department</label>
                      <input type="text" name="department" id="new-edit-department" class="form-control" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="new-edit-section" class="form-label">Section</label>
                      <input type="text" name="section" id="new-edit-section" class="form-control" required>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="new-edit-room" class="form-label">Room</label>
                      <input type="text" name="room" id="new-edit-room" class="form-control" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="new-edit-status" class="form-label">Status</label>
                      <select name="status" id="new-edit-status" class="form-select" required>
                        <option value="Active">Active</option>
                        <option value="Termination">Termination</option>
                        <option value="Resigned">Resigned</option>
                        <option value="Notice Period">Notice Period</option>
                        <option value="EL">EL</option>
                        <option value="Personal Reason">Personal Reason</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="modal-footer">
                  <button type="submit" class="btn btn-success">Update Employee</button>
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>


      <div class="offcanvas customizer offcanvas-end" tabindex="-1" id="offcanvasExample"
        aria-labelledby="offcanvasExampleLabel">
        <div class="d-flex align-items-center justify-content-between p-3 border-bottom">
          <h4 class="offcanvas-title fw-semibold" id="offcanvasExampleLabel">
            Settings
          </h4>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body" data-simplebar="" style="height: calc(100vh - 80px)">
          <h6 class="fw-semibold fs-4 mb-2">Theme</h6>

          <div class="d-flex flex-row gap-3 customizer-box" role="group">
            <input type="radio" class="btn-check light-layout" name="theme-layout" id="light-layout" autocomplete="off">
            <label class="btn p-9 btn-outline-primary rounded-2" for="light-layout">
              <i class="icon ti ti-brightness-up fs-7 me-2"></i>Light
            </label>

            <input type="radio" class="btn-check dark-layout" name="theme-layout" id="dark-layout" autocomplete="off">
            <label class="btn p-9 btn-outline-primary rounded-2" for="dark-layout">
              <i class="icon ti ti-moon fs-7 me-2"></i>Dark
            </label>
          </div>

          <h6 class="mt-5 fw-semibold fs-4 mb-2">Theme Direction</h6>
          <div class="d-flex flex-row gap-3 customizer-box" role="group">
            <input type="radio" class="btn-check" name="direction-l" id="ltr-layout" autocomplete="off">
            <label class="btn p-9 btn-outline-primary rounded-2" for="ltr-layout">
              <i class="icon ti ti-text-direction-ltr fs-7 me-2"></i>LTR
            </label>

            <input type="radio" class="btn-check" name="direction-l" id="rtl-layout" autocomplete="off">
            <label class="btn p-9 btn-outline-primary rounded-2" for="rtl-layout">
              <i class="icon ti ti-text-direction-rtl fs-7 me-2"></i>RTL
            </label>
          </div>

          <h6 class="mt-5 fw-semibold fs-4 mb-2">Theme Colors</h6>

          <div class="d-flex flex-row flex-wrap gap-3 customizer-box color-pallete" role="group">
            <input type="radio" class="btn-check" name="color-theme-layout" id="Blue_Theme" autocomplete="off">
            <label class="btn p-9 btn-outline-primary rounded-2 d-flex align-items-center justify-content-center"
              onclick="handleColorTheme('Blue_Theme')" for="Blue_Theme" data-bs-toggle="tooltip" data-bs-placement="top"
              data-bs-title="BLUE_THEME">
              <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-1">
                <i class="ti ti-check text-white d-flex icon fs-5"></i>
              </div>
            </label>

            <input type="radio" class="btn-check" name="color-theme-layout" id="Aqua_Theme" autocomplete="off">
            <label class="btn p-9 btn-outline-primary rounded-2 d-flex align-items-center justify-content-center"
              onclick="handleColorTheme('Aqua_Theme')" for="Aqua_Theme" data-bs-toggle="tooltip" data-bs-placement="top"
              data-bs-title="AQUA_THEME">
              <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-2">
                <i class="ti ti-check text-white d-flex icon fs-5"></i>
              </div>
            </label>

            <input type="radio" class="btn-check" name="color-theme-layout" id="Purple_Theme" autocomplete="off">
            <label class="btn p-9 btn-outline-primary rounded-2 d-flex align-items-center justify-content-center"
              onclick="handleColorTheme('Purple_Theme')" for="Purple_Theme" data-bs-toggle="tooltip"
              data-bs-placement="top" data-bs-title="PURPLE_THEME">
              <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-3">
                <i class="ti ti-check text-white d-flex icon fs-5"></i>
              </div>
            </label>

            <input type="radio" class="btn-check" name="color-theme-layout" id="green-theme-layout" autocomplete="off">
            <label class="btn p-9 btn-outline-primary rounded-2 d-flex align-items-center justify-content-center"
              onclick="handleColorTheme('Green_Theme')" for="green-theme-layout" data-bs-toggle="tooltip"
              data-bs-placement="top" data-bs-title="GREEN_THEME">
              <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-4">
                <i class="ti ti-check text-white d-flex icon fs-5"></i>
              </div>
            </label>

            <input type="radio" class="btn-check" name="color-theme-layout" id="cyan-theme-layout" autocomplete="off">
            <label class="btn p-9 btn-outline-primary rounded-2 d-flex align-items-center justify-content-center"
              onclick="handleColorTheme('Cyan_Theme')" for="cyan-theme-layout" data-bs-toggle="tooltip"
              data-bs-placement="top" data-bs-title="CYAN_THEME">
              <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-5">
                <i class="ti ti-check text-white d-flex icon fs-5"></i>
              </div>
            </label>

            <input type="radio" class="btn-check" name="color-theme-layout" id="orange-theme-layout" autocomplete="off">
            <label class="btn p-9 btn-outline-primary rounded-2 d-flex align-items-center justify-content-center"
              onclick="handleColorTheme('Orange_Theme')" for="orange-theme-layout" data-bs-toggle="tooltip"
              data-bs-placement="top" data-bs-title="ORANGE_THEME">
              <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-6">
                <i class="ti ti-check text-white d-flex icon fs-5"></i>
              </div>
            </label>
          </div>

          <h6 class="mt-5 fw-semibold fs-4 mb-2">Layout Type</h6>
          <div class="d-flex flex-row gap-3 customizer-box" role="group">
            <div>
              <input type="radio" class="btn-check" name="page-layout" id="vertical-layout" autocomplete="off">
              <label class="btn p-9 btn-outline-primary rounded-2" for="vertical-layout">
                <i class="icon ti ti-layout-sidebar-right fs-7 me-2"></i>Vertical
              </label>
            </div>
            <div>
              <input type="radio" class="btn-check" name="page-layout" id="horizontal-layout" autocomplete="off">
              <label class="btn p-9 btn-outline-primary rounded-2" for="horizontal-layout">
                <i class="icon ti ti-layout-navbar fs-7 me-2"></i>Horizontal
              </label>
            </div>
          </div>

          <h6 class="mt-5 fw-semibold fs-4 mb-2">Container Option</h6>

          <div class="d-flex flex-row gap-3 customizer-box" role="group">
            <input type="radio" class="btn-check" name="layout" id="boxed-layout" autocomplete="off">
            <label class="btn p-9 btn-outline-primary rounded-2" for="boxed-layout">
              <i class="icon ti ti-layout-distribute-vertical fs-7 me-2"></i>Boxed
            </label>

            <input type="radio" class="btn-check" name="layout" id="full-layout" autocomplete="off">
            <label class="btn p-9 btn-outline-primary rounded-2" for="full-layout">
              <i class="icon ti ti-layout-distribute-horizontal fs-7 me-2"></i>Full
            </label>
          </div>

          <h6 class="fw-semibold fs-4 mb-2 mt-5">Sidebar Type</h6>
          <div class="d-flex flex-row gap-3 customizer-box" role="group">
            <a href="javascript:void(0)" class="fullsidebar">
              <input type="radio" class="btn-check" name="sidebar-type" id="full-sidebar" autocomplete="off">
              <label class="btn p-9 btn-outline-primary rounded-2" for="full-sidebar">
                <i class="icon ti ti-layout-sidebar-right fs-7 me-2"></i>Full
              </label>
            </a>
            <div>
              <input type="radio" class="btn-check" name="sidebar-type" id="mini-sidebar" autocomplete="off">
              <label class="btn p-9 btn-outline-primary rounded-2" for="mini-sidebar">
                <i class="icon ti ti-layout-sidebar fs-7 me-2"></i>Collapse
              </label>
            </div>
          </div>

          <h6 class="mt-5 fw-semibold fs-4 mb-2">Card With</h6>

          <div class="d-flex flex-row gap-3 customizer-box" role="group">
            <input type="radio" class="btn-check" name="card-layout" id="card-with-border" autocomplete="off">
            <label class="btn p-9 btn-outline-primary rounded-2" for="card-with-border">
              <i class="icon ti ti-border-outer fs-7 me-2"></i>Border
            </label>

            <input type="radio" class="btn-check" name="card-layout" id="card-without-border" autocomplete="off">
            <label class="btn p-9 btn-outline-primary rounded-2" for="card-without-border">
              <i class="icon ti ti-border-none fs-7 me-2"></i>Shadow
            </label>
          </div>
        </div>
      </div>

      <script>
        function handleColorTheme(e) {
          document.documentElement.setAttribute("data-color-theme", e);
        }
      </script>
    </div>

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
  <script src="npm/iconify-icon%401.0.8/dist/iconify-icon.min.js"></script>
  <script src="assets/libs/fullcalendar/index.global.min.js"></script>
  <script src="assets/js/apps/contact.js"></script>
  <script>
    document.getElementById("new-edit-image").addEventListener("change", function (event) {
      let output = document.getElementById("new-edit-employee-image");
      output.src = URL.createObjectURL(event.target.files[0]);
      output.onload = function () {
        URL.revokeObjectURL(output.src); // Free memory
      };
    });

    // Function to dynamically fill the edit form with data
    function populateEditEmployeeModal(employeeData) {
      document.getElementById("new-edit-id").value = employeeData.id;
      document.getElementById("new-edit-name").value = employeeData.name;
      document.getElementById("new-edit-bid").value = employeeData.bid;
      document.getElementById("new-edit-cwkid").value = employeeData.cwkid;
      document.getElementById("new-edit-department").value = employeeData.department;
      document.getElementById("new-edit-section").value = employeeData.section;
      document.getElementById("new-edit-room").value = employeeData.room;
      document.getElementById("new-edit-status").value = employeeData.status;
      document.getElementById("new-edit-employee-image").src = employeeData.image;
    }

    // Example: Fetch employee data (AJAX or server-side fetch)
    function editEmployee(employeeId) {
      // For simplicity, using static data here for illustration
      const employeeData = {
        id: employeeId,
        name: "John Doe",
        bid: "12345",
        cwkid: "67890",
        department: "HR",
        section: "Recruitment",
        room: "A101",
        status: "Active",
        image: "assets/images/profile/user-1.jpg"
      };

      // Call the function to populate modal
      populateEditEmployeeModal(employeeData);
    }

    // Example to trigger the modal (replace this with actual logic)
    editEmployee(1);



    // Ensure this script is placed after your jQuery and Bootstrap JS libraries are loaded

    // When the "Edit" button is clicked
    $(document).on('click', '.edit-employee-btn', function () {
      // Get the data attributes from the clicked button
      var employeeId = $(this).data('id');
      var employeeName = $(this).data('name');
      var employeeBid = $(this).data('bid');
      var employeeCwkid = $(this).data('cwkid');
      var employeeDepartment = $(this).data('department');
      var employeeSection = $(this).data('section');
      var employeeRoom = $(this).data('room');
      var employeeStatus = $(this).data('status');
      var employeeImage = $(this).data('image');

      // Populate the modal fields with the data
      $('#new-edit-id').val(employeeId);
      $('#new-edit-name').val(employeeName);
      $('#new-edit-bid').val(employeeBid);
      $('#new-edit-cwkid').val(employeeCwkid);
      $('#new-edit-department').val(employeeDepartment);
      $('#new-edit-section').val(employeeSection);
      $('#new-edit-room').val(employeeRoom);
      $('#new-edit-status').val(employeeStatus);
      $('#new-edit-employee-image').attr('src', employeeImage);

      // Show the modal
      $('#newEditEmployeeModal').modal('show');
    });

  </script>
  <!-- Include jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Include Bootstrap JS (Make sure you have Bootstrap's CSS loaded as well) -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>


</body>

</html>