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

// Fetch PPE records from database
$query_ppe = "SELECT * FROM ppe_records ORDER BY date DESC";
$result_ppe = mysqli_query($conn, $query_ppe);
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

  <title>PPE Sheet</title>
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
                  <h4 class="mb-4 mb-sm-0 card-title">Personal Protective Equipment Form</h4>
                  <nav aria-label="breadcrumb" class="ms-auto">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item d-flex align-items-center">
                        <a class="text-muted text-decoration-none d-flex" href="dashboard.php">
                          <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                        </a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">
                        <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                          PPE Form
                        </span>
                      </li>
                    </ol>
                  </nav>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="px-4 py-3 border-bottom">
                  <h4 class="card-title mb-0">Add New Staff</h4>
                </div>

                <div class="card-body p-4">
                  <form id="ppeForm" method="POST" action="save_ppe.php">
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="mb-4">
                          <label for="berkeleyID" class="form-label">Berkeley ID</label>
                          <input type="text" class="form-control" id="berkeleyID" name="berkeley_id" placeholder="22510"
                            required>
                          <span id="berkeleyWarning" class="text-danger" style="display: none; font-size: 14px;">
                            No employee found with this Berkeley ID!
                          </span>
                        </div>
                        <div class="mb-4">
                          <label for="cwkID" class="form-label">CWK ID</label>
                          <input type="text" class="form-control" id="cwkID" name="cwk_id" readonly required>
                        </div>
                        <div class="mb-4">
                          <label for="ppeDate" class="form-label">Date</label>
                          <input id="ppeDate" class="form-control" type="date" name="date" required>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="mb-4">
                          <label for="fullName" class="form-label">Full Name</label>
                          <input type="text" class="form-control" id="fullName" name="name" readonly required>
                        </div>
                        <div class="mb-4">
                          <label for="section" class="form-label">Section</label>
                          <input type="text" class="form-control" id="section" name="section" readonly required>
                        </div>
                        <div class="mb-4">
                          <label class="form-label">Category</label>
                          <select class="form-select" name="category" required>
                            <option selected="">Full Set</option>
                            <option value="Uniform -1">Uniform -1</option>
                            <option value="Uniform -2">Uniform -2</option>
                            <option value="Shoes">Shoes</option>
                            <option value="Hand Sleeves">Hand Sleeves</option>
                            <option value="Hand Glovese">Hand Gloves</option>
                          </select>
                        </div>
                      </div>
                      <input type="hidden" id="empImage" name="emp_image">
                      <div class="col-12">
                        <div class="d-flex align-items-center gap-3">
                          <button type="submit" class="btn btn-primary">Submit</button>
                          <button type="reset" class="btn bg-danger-subtle text-danger">Cancel</button>
                        </div>
                      </div>
                    </div>
                  </form>

                </div>
              </div>
            </div>
          </div>
          <div class="card w-100 position-relative overflow-hidden">
            <div class="px-4 py-3 border-bottom">
              <h4 class="card-title mb-0">Collected Staffs</h4>
            </div>
            <div class="card-body p-4">
              <div class="table-responsive mb-4 border rounded-1">
                <table class="table text-nowrap mb-0 align-middle">
                  <thead class="text-dark fs-4">
                    <tr>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">Employee</h6>
                      </th>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">CWK ID</h6>
                      </th>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">Section</h6>
                      </th>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">Date</h6>
                      </th>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">Category</h6>
                      </th>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">Action</h6>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php while ($row_ppe = mysqli_fetch_assoc($result_ppe)) { ?>
                      <tr>
                        <td>
                          <div class="d-flex align-items-center">
                            <div class="">
                              <h6 class="fs-4 fw-semibold mb-0"><?php echo $row_ppe['name']; ?></h6>
                              <span class="fw-normal"><?php echo $row_ppe['berkeley_id']; ?></span>
                            </div>
                          </div>
                        </td>
                        <td>
                          <p class="mb-0 fw-normal fs-4"><?php echo $row_ppe['cwk_id'] ?? 'N/A'; ?></p>
                        </td>
                        <td>
                          <p class="mb-0 fw-normal fs-4"><?php echo $row_ppe['section']; ?></p>
                        </td>
                        <td>
                          <p class="mb-0 fw-normal fs-4"><?php echo $row_ppe['date']; ?></p>
                        </td>
                        <td>
                          <p class="mb-0 fw-normal fs-4"><?php echo $row_ppe['category']; ?></p>
                        </td>
                        <td>
                          <a href="delete_ppe.php?id=<?php echo $row_ppe['id']; ?>" class="text-danger">
                            <i class="ti ti-trash fs-5"></i>
                          </a>
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

      <?php
      include 'connection.php';

      if (isset($_GET['id'])) {
        $ppeID = mysqli_real_escape_string($conn, $_GET['id']);

        // Fetch the PPE record to delete the associated file if needed
        $query = "SELECT * FROM ppe_records WHERE id = '$ppeID'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
          $row = mysqli_fetch_assoc($result);

          // Optionally, delete the file from the 'uploads' folder if required
          // Uncomment the following line to delete the image file
          // unlink("uploads/" . $row['emp_image']); // Delete the image file
      
          // Now delete the record from the database
          $delete_query = "DELETE FROM ppe_records WHERE id = '$ppeID'";
          if (mysqli_query($conn, $delete_query)) {
            header("Location: ppe_form.php"); // Redirect back to the PPE form page
          } else {
            echo "Error deleting PPE record.";
          }
        }
      }
      ?>

      <script>
        function handleColorTheme(e) {
          document.documentElement.setAttribute("data-color-theme", e);
        }
      </script>
      <script>
        document.getElementById("berkeleyID").addEventListener("blur", function () {
          let berkeleyID = this.value.trim(); // Trim whitespace
          let warning = document.getElementById("berkeleyWarning");
          let fullNameField = document.getElementById("fullName");
          let cwkIDField = document.getElementById("cwkID");
          let sectionField = document.getElementById("section");
          let empImageField = document.getElementById("empImage");

          if (berkeleyID !== "") {
            fetch("get_employee.php?bid=" + encodeURIComponent(berkeleyID))
              .then(response => response.json())
              .then(data => {
                if (data.success) {
                  fullNameField.value = data.name;  // Set employee name
                  cwkIDField.value = data.cwk_id;  // Set CWK ID
                  sectionField.value = data.section; // Set section
                  empImageField.value = data.image; // Set employee image
                  warning.style.display = "none";   // Hide warning
                } else {
                  fullNameField.value = "";  // Clear input
                  cwkIDField.value = "";
                  sectionField.value = "";
                  empImageField.value = "";
                  warning.style.display = "block"; // Show warning
                  warning.innerText = "Employee not found for this Berkeley ID."; // Set warning message
                }
              })
              .catch(error => console.error("Error fetching employee:", error));
          } else {
            fullNameField.value = "";
            cwkIDField.value = "";
            sectionField.value = "";
            empImageField.value = "";
            warning.style.display = "none";
          }
        });
      </script>

    </div>

    <!--  Search Bar -->
    <?php include("search.php"); ?>

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
  <script src="npm/iconify-icon%401.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>