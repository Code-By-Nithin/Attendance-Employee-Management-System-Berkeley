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

  <title>Staff Rooms</title>
  <link rel="stylesheet" href="assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css">

  <?php
  session_start();
  include 'connection.php';

  if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
  }

  $email = $_SESSION['user'];

  // Fetch user role from database
  $query = "SELECT role FROM users WHERE username = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  $role = $row['role'] ?? 'Unknown';
  $stmt->close();

  // Handle checkbox actions
  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['employee_id'])) {
    $employee_id = intval($_POST['employee_id']);
    $is_checked = $_POST['is_checked'] === 'true';
    
    if ($is_checked) {
      // Check if already exists
      $check_query = "SELECT * FROM important_staff WHERE employee_id = ?";
      $check_stmt = $conn->prepare($check_query);
      $check_stmt->bind_param("i", $employee_id);
      $check_stmt->execute();
      $check_result = $check_stmt->get_result();
      
      if ($check_result->num_rows == 0) {
        $insert_query = "INSERT INTO important_staff (employee_id) VALUES (?)";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bind_param("i", $employee_id);
        $insert_stmt->execute();
        $insert_stmt->close();
      }
      $check_stmt->close();
    } else {
      // Remove from important_staff table
      $delete_query = "DELETE FROM important_staff WHERE employee_id = ?";
      $delete_stmt = $conn->prepare($delete_query);
      $delete_stmt->bind_param("i", $employee_id);
      $delete_stmt->execute();
      $delete_stmt->close();
    }
    exit();
  }
  
  // Fetch all employees from database and sort by room number
  $employee_query = "SELECT e.*, IF(i.employee_id IS NULL, 0, 1) as is_important 
                    FROM employees e
                    LEFT JOIN important_staff i ON e.id = i.employee_id
                    WHERE e.status = 'Active' 
                    ORDER BY 
                      SUBSTRING_INDEX(e.room, '/', 1), 
                      CAST(SUBSTRING_INDEX(e.room, '/', -1) AS UNSIGNED)";
  $employee_result = $conn->query($employee_query);
  ?>
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
          <div class="card card-body py-3">
            <div class="row align-items-center">
              <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                  <h4 class="mb-4 mb-sm-0 card-title">Staffs Rooms</h4>
                  <nav aria-label="breadcrumb" class="ms-auto">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item d-flex align-items-center">
                        <a class="text-muted text-decoration-none d-flex" href="dashboard.php">
                          <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                        </a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">
                        <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                          Rooms
                        </span>
                      </li>
                    </ol>
                  </nav>
                </div>
              </div>
            </div>
          </div>

          <div class="datatables">
            <div class="widget-content searchable-container list">
              <div class="card card-body">
                <div class="row">
                  <div class="col-md-4 col-xl-3">
                    <form class="position-relative">
                      <input type="text" class="form-control product-search ps-5" id="input-search"
                        placeholder="Search Contacts..." />
                      <i
                        class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                    </form>
                  </div>
                </div>
              </div>

              <div class="card card-body">
                <div class="table-responsive">
                  <table class="table search-table align-middle text-nowrap">
                    <thead class="header-item">
                      <th>Name</th>
                      <th>CWK ID</th>
                      <th>Section</th>
                      <th>Room</th>
                      <th>Important</th>
                    </thead>
                    <tbody>
                      <?php while($employee = $employee_result->fetch_assoc()): 
                        $room_class = $employee['is_important'] ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success';
                        $image_path = (!empty($employee['image']) && file_exists('uploads/' . $employee['image'])) ? 
                                      'uploads/' . htmlspecialchars($employee['image']) : 
                                      'assets/images/profile/default.jpg';
                      ?>
                      <tr class="search-items">
                        <td>
                          <div class="d-flex align-items-center">
                          <img 
                              src="uploads/<?php echo (!empty($employee['image']) && file_exists('uploads/' . $employee['image'])) ? htmlspecialchars($employee['image']) : 'default.jpg'; ?>" 
                              alt="avatar" 
                              class="rounded-circle" 
                              width="35" 
                              height="35" />
                            <div class="ms-3">
                              <div class="user-meta-info">
                                <h6 class="user-name mb-0"><?php echo htmlspecialchars($employee['name']); ?></h6>
                                <span class="user-work fs-3"><?php echo htmlspecialchars($employee['bid']); ?></span>
                              </div>
                            </div>
                          </div>
                        </td>
                        <td>
                          <span class="usr-email-addr"><?php echo htmlspecialchars($employee['cwkid']); ?></span>
                        </td>
                        <td>
                          <span class="usr-location"><?php echo htmlspecialchars($employee['section']); ?></span>
                        </td>
                        <td>
                          <span class="badge <?php echo $room_class; ?> fw-semibold fs-2 gap-1 d-inline-flex align-items-center">
                            <?php echo htmlspecialchars($employee['room']); ?>
                          </span>
                        </td>
                        <td>
                          <div class="n-chk align-self-center text-center">
                            <div class="form-check">
                              <input type="checkbox" 
                                     class="form-check-input contact-chkbox primary" 
                                     id="checkbox<?php echo $employee['id']; ?>" 
                                     data-employee-id="<?php echo $employee['id']; ?>"
                                     <?php echo $employee['is_important'] ? 'checked' : ''; ?> />
                              <label class="form-check-label" for="checkbox<?php echo $employee['id']; ?>"></label>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <?php endwhile; ?>
                    </tbody>
                  </table>
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

    // Handle checkbox changes
    document.addEventListener('DOMContentLoaded', function() {
      const checkboxes = document.querySelectorAll('.contact-chkbox');
      
      checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
          const employeeId = this.dataset.employeeId;
          const isChecked = this.checked;
          const row = this.closest('tr');
          const roomBadge = row.querySelector('.badge');
          
          // Send AJAX request to update database
          fetch(window.location.href, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `employee_id=${employeeId}&is_checked=${isChecked}`
          })
          .then(response => {
            if (response.ok) {
              // Update room badge color
              roomBadge.className = `badge fw-semibold fs-2 gap-1 d-inline-flex align-items-center 
                                   ${isChecked ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success'}`;
            } else {
              // Revert checkbox if request failed
              this.checked = !isChecked;
              alert('Error updating status. Please try again.');
            }
          })
          .catch(error => {
            console.error('Error:', error);
            this.checked = !isChecked;
            alert('Network error. Please try again.');
          });
        });
      });
    });
  </script>

  <?php include("search.php"); ?>

  <div class="dark-transparent sidebartoggler"></div>
  <script src="assets/js/vendor.min.js"></script>
  <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/libs/simplebar/dist/simplebar.min.js"></script>
  <script src="assets/js/theme/app.init.js"></script>
  <script src="assets/js/theme/theme.js"></script>
  <script src="assets/js/theme/app.min.js"></script>
  <script src="assets/js/theme/sidebarmenu.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
  <script src="assets/js/highlights/highlight.min.js"></script>
  <script>
    hljs.initHighlightingOnLoad();
  </script>
  <script src="assets/libs/fullcalendar/index.global.min.js"></script>
  <script src="assets/js/apps/contact.js"></script>
</body>
</html>