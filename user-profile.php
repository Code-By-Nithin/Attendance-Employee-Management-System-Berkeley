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

// Check if 'id' is passed in URL
if (isset($_GET['id'])) {
  $user_id = intval($_GET['id']); // Ensure it's an integer for security
  $query = "SELECT * FROM employees WHERE id = $user_id";
} else {
  // If no 'id' is provided, fetch the logged-in user's profile
  $query = "SELECT * FROM employees WHERE email = '$email'";
}

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
  $user = mysqli_fetch_assoc($result);
} else {
  echo "User not found.";
  exit();
}

// Profile image handling
$imagePath = "uploads/" . htmlspecialchars($user['image']);
$defaultImage = "uploads/default.jpg"; // Default placeholder image
if (!file_exists($imagePath) || empty($user['image'])) {
  $imagePath = $defaultImage;
}

// Handle remark submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_remark'])) {
  $remark = mysqli_real_escape_string($conn, $_POST['remark']);
  $employee_id = $user['id'];

  // Handle file upload
  $media = null;
  if (isset($_FILES['media']) && $_FILES['media']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = "uploads/";
    $uploadFile = $uploadDir . basename($_FILES['media']['name']);
    if (move_uploaded_file($_FILES['media']['tmp_name'], $uploadFile)) {
      $media = basename($_FILES['media']['name']);
    }
  }

  // Insert remark into the database
  $insertQuery = "INSERT INTO remarks (employee_id, remark, media) VALUES ('$employee_id', '$remark', '$media')";
  if (mysqli_query($conn, $insertQuery)) {
    echo "<script>alert('Remark added successfully!');</script>";
  } else {
    echo "<script>alert('Error adding remark!');</script>";
  }
}

// Fetch remarks for the employee
$remarksQuery = "SELECT * FROM remarks WHERE employee_id = {$user['id']} ORDER BY created_at DESC";
$remarksResult = mysqli_query($conn, $remarksQuery);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($user['name']); ?>'s Profile</title>

  <!-- Favicon -->
  <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png">
  <link rel="stylesheet" href="https://unpkg.com/@tabler/icons-webfont@2.41.0/tabler-icons.min.css">

  <!-- Core CSS -->
  <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body class="link-sidebar">
  <div id="main-wrapper">
    <!-- Sidebar -->
    <aside class="left-sidebar with-vertical">
      <div class="brand-logo d-flex align-items-center">
        <a href="dashboard.php" class="text-nowrap logo-img">
          <img src="assets/images/logos/logo.svg" alt="Logo">
        </a>
      </div>
      <?php include("sidebar.php"); ?>
    </aside>

    <div class="page-wrapper">
      <!-- Header -->
      <?php include("header.php"); ?>

      <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card card-body py-3">
            <div class="row align-items-center">
              <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                  <h4 class="mb-4 mb-sm-0 card-title"><?php echo htmlspecialchars($user['name']); ?>'s Profile</h4>
                  <nav aria-label="breadcrumb" class="ms-auto">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="dashboard.php">
                          <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                        </a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">
                        <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                          Staff Profile
                        </span>
                      </li>
                    </ol>
                  </nav>
                </div>
              </div>
            </div>
          </div>

          <div class="card overflow-hidden">
            <div class="card-body p-0">
              <img src="assets/images/backgrounds/profilebg.jpg" alt="Profile Background" class="img-fluid">
              <div class="row align-items-center">
                <div class="col-lg-4 order-lg-1 order-2 card-values">
                  <div class="d-flex align-items-center justify-content-around m-4">
                    <div class="text-center">
                      <i class="ti ti-user-check fs-6 d-block mb-2"></i>
                      <p class="mb-0">Berkeley ID</p>
                      <h4 class="mb-0 fw-semibold lh-1"><?php echo htmlspecialchars($user['bid']); ?></h4>
                    </div>
                    <div class="text-center">
                      <i class="ti ti-user-circle fs-6 d-block mb-2"></i>
                      <p class="mb-0">CWK ID</p>
                      <h4 class="mb-0 fw-semibold lh-1"><?php echo htmlspecialchars($user['cwkid']); ?></h4>
                    </div>
                    <div class="text-center">
                      <i class="ti ti-file-description fs-6 d-block mb-2"></i>
                      <p class="mb-0">Department</p>
                      <h4 class="mb-0 fw-semibold lh-1"><?php echo htmlspecialchars($user['department']); ?></h4>
                    </div>
                  </div>
                </div>

                <div class="col-lg-4 mt-n3 order-lg-2 order-1">
                  <div class="mt-n5">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                      <div class="d-flex align-items-center justify-content-center round-110">
                        <div
                          class="border border-4 border-white d-flex align-items-center justify-content-center rounded-circle overflow-hidden round-100">
                          <img src="<?php echo $imagePath; ?>" alt="User Image" class="w-100 h-100">
                        </div>
                      </div>
                    </div>
                    <div class="text-center">
                      <h5 class="mb-0"><?php echo htmlspecialchars($user['name']); ?></h5>
                      <p class="mb-0"><?php echo htmlspecialchars($user['status']); ?></p>
                    </div>
                  </div>
                </div>

                <div class="col-lg-4 order-last card-values">
                  <div class="d-flex align-items-center justify-content-around m-4">
                    <div class="text-center">
                      <i class="ti ti-file-description fs-6 d-block mb-2"></i>
                      <p class="mb-0">Section</p>
                      <h4 class="mb-0 fw-semibold lh-1"><?php echo htmlspecialchars($user['section']); ?></h4>
                    </div>
                    <div class="text-center">
                      <i class="ti ti-user-circle fs-6 d-block mb-2"></i>
                      <p class="mb-0">Room</p>
                      <h4 class="mb-0 fw-semibold lh-1"><?php echo htmlspecialchars($user['room']); ?></h4>
                    </div>
                    <div class="text-center">
                      <ul
                        class="list-unstyled d-flex align-items-center justify-content-center justify-content-lg-end my-3 mx-4 pe-4 gap-3"
                        style="margin-right: 0px !important; padding-right: 0px !important;">
                        <li>
                          <button class="btn btn-danger bg-danger-subtle text-danger" id="deleteUserBtn"
                            data-id="<?php echo $user['id']; ?>"><i class="ti ti-trash fs-5"></i>Remove</button>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-profile" role="tabpanel"
              aria-labelledby="pills-profile-tab" tabindex="0">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card shadow-none border">
                    <div class="card-body">
                      <form method="POST" enctype="multipart/form-data">
                        <div class="form-floating mb-3">
                          <textarea class="form-control h-140" placeholder="Leave a comment here"
                            id="remark" name="remark" required></textarea>
                          <label for="remark">Share your thoughts</label>
                        </div>
                        <div class="d-flex align-items-center gap-6 flex-wrap">
                          <label class="d-flex align-items-center round-32 justify-content-center btn btn-primary rounded-circle">
                            <i class="ti ti-photo"></i>
                            <input type="file" name="media" style="display: none;">
                          </label>
                          <a href="javascript:void(0)" class="text-dark link-primary pe-3 py-2">Photo / Video</a>
                          <button type="submit" name="submit_remark" class="btn btn-primary ms-auto">Post</button>
                        </div>
                      </form>
                    </div>
                  </div>

                  <!-- Display Remarks -->
                  <?php while ($remark = mysqli_fetch_assoc($remarksResult)) : ?>
                    <div class="card mt-3">
                      <div class="card-body">
                        <div class="d-flex align-items-center gap-6 flex-wrap">
                          <img src="<?php echo $imagePath; ?>" alt="User Image" class="rounded-circle" width="40" height="40">
                          <h6 class="mb-0"><?php echo htmlspecialchars($user['name']); ?></h6>
                          <span class="fs-2 hstack gap-2">
                            <span class="round-10 text-bg-light rounded-circle d-inline-block"></span>
                            <?php echo date('d-m-Y', strtotime($remark['created_at'])); ?>
                          </span>
                        </div>
                        <p class="text-dark my-3"><?php echo htmlspecialchars($remark['remark']); ?></p>
                        <?php if ($remark['media']) : ?>
                          <img src="uploads/<?php echo htmlspecialchars($remark['media']); ?>" alt="Remark Media" height="360" class="rounded-4 w-100 object-fit-cover">
                        <?php endif; ?>
                      </div>
                    </div>
                  <?php endwhile; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- JavaScript -->
  <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/libs/simplebar/dist/simplebar.min.js"></script>
  <script src="assets/js/theme/app.init.js"></script>
  <script src="assets/js/theme/theme.js"></script>
  <script src="assets/js/theme/sidebarmenu-default.js"></script>

  <!-- AJAX for Delete Button -->
  <script>
  document.getElementById('deleteUserBtn').addEventListener('click', function () {
    const userId = this.getAttribute('data-id'); // Get the user ID from the button's data attribute

    if (confirm('Are you sure you want to delete this user?')) {
      fetch(`delete_user.php?id=${userId}`, {
        method: 'GET', // Use GET for simplicity (you can switch to DELETE later if needed)
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('User deleted successfully!');
            window.location.href = 'users.php'; // Redirect to dashboard after deletion
          } else {
            alert('Error deleting user: ' + data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('An error occurred while deleting the user.');
        });
    }
  });
</script>

  <!-- solar icons -->
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>