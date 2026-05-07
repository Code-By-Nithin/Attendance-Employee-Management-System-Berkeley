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

  <title>MatDash Bootstrap Admin</title>
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
  $query = "SELECT role FROM users WHERE username = '$email'";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_assoc($result);
  $role = $row['role'] ?? 'Unknown'; // Default to 'Unknown' if no role found
  ?>
  <style>
    .table-responsive {
      overflow-x: scroll !important;
      overflow-y: clip !important;
      white-space: nowrap;
      scrollbar-width: thin;
      scrollbar-color: #d4d4d4 #f2f2f2;
    }

    .table-responsive::-webkit-scrollbar {
      height: 3px !important;
    }

    .table-responsive::-webkit-scrollbar-track {
      background: #f2f2f2;
    }

    .table-responsive::-webkit-scrollbar-thumb {
      background: #888;
      border-radius: 3px;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
      background: #555;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th,
    td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: center;
    }

    th {
      background-color: #f2f2f2;
    }

    td.off {
      background-color: yellow !important;
    }

    .table-striped>tbody>tr:nth-of-type(odd)>* {
      --bs-table-color-type: var(--bs-table-striped-color);
      --bs-table-bg-type: transparent !important;
    }

    body table.dataTable.table-striped>tbody>tr:nth-of-type(2n+1)>* {
      box-shadow: inset 0 0 0 9999px #ffffff00;
    }

    .tab-pane {
      padding-bottom: 0 !important;
    }

    .dataTables_wrapper {
      margin-bottom: 16px;
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
          <div class="card card-body py-3">
            <div class="row align-items-center">
              <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                  <h4 class="mb-4 mb-sm-0 card-title">Duty Roster March</h4>
                  <nav aria-label="breadcrumb" class="ms-auto">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item d-flex align-items-center">
                        <a class="text-muted text-decoration-none d-flex" href="dashboard.php">
                          <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                        </a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">
                        <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                          Duty Roster
                        </span>
                      </li>
                    </ol>
                  </nav>
                </div>
              </div>
            </div>
          </div>

          <div class="datatables">


            <!-- start Tab with Flex Utilities -->
            <div class="card">
              <div class="card-body">
                <!-- Nav tabs -->
                <ul class="nav nav-pills flex-column flex-sm-row mt-4" role="tablist">
                  <li class="nav-item flex-sm-fill text-sm-center">
                    <a class="nav-link active" data-bs-toggle="tab" href="#navpill-11" role="tab">
                      <span>Day Shift</span>
                    </a>
                  </li>
                  <li class="nav-item flex-sm-fill text-sm-center">
                    <a class="nav-link" data-bs-toggle="tab" href="#navpill-22" role="tab">
                      <span>Night Shift</span>
                    </a>
                  </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content border mt-2">
                  <div class="tab-pane active p-3" id="navpill-11" role="tabpanel">
                    <div class="row">
                      <!-- start Multi-column ordering -->
                      <div class="table-responsive">
                        <table id="default_order" class="table table-striped table-bordered display text-nowrap">
                          <thead>
                            <tr>
                              <th>SN</th>
                              <th>Employee Name</th>
                              <th>ID</th>
                              <th>CWK</th>
                              <th>Section</th>
                              <th>Segments</th>
                              <th>Sat 1</th>
                              <th>Sun 2</th>
                              <th>Mon 3</th>
                              <th>Tue 4</th>
                              <th>Wed 5</th>
                              <th>Thu 6</th>
                              <th>Fri 7</th>
                              <th>Sat 8</th>
                              <th>Sun 9</th>
                              <th>Mon 10</th>
                              <th>Tue 11</th>
                              <th>Wed 12</th>
                              <th>Thu 13</th>
                              <th>Fri 14</th>
                              <th>Sat 15</th>
                              <th>Sun 16</th>
                              <th>Mon 17</th>
                              <th>Tue 18</th>
                              <th>Wed 19</th>
                              <th>Thu 20</th>
                              <th>Fri 21</th>
                              <th>Sat 22</th>
                              <th>Sun 23</th>
                              <th>Mon 24</th>
                              <th>Tue 25</th>
                              <th>Wed 26</th>
                              <th>Thu 27</th>
                              <th>Fri 28</th>
                              <th>Sat 29</th>
                              <th>Sun 30</th>
                              <th>Mon 31</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>1</td>
                              <td>JAMUNA PUN MAGAR</td>
                              <td>17125</td>
                              <td>708382</td>
                              <td>CLEANING</td>
                              <td>3LND</td>
                              <td class="off">OFF</td>
                              <td>P</td>
                              <td>P</td>
                              <td>P</td>
                              <td>P</td>
                              <td>P</td>
                              <td>P</td>
                              <td class="off">OFF</td>
                              <td>P</td>
                              <td>P</td>
                              <td>P</td>
                              <td>P</td>
                              <td>P</td>
                              <td>P</td>
                              <td class="off">OFF</td>
                              <td>P</td>
                              <td>P</td>
                              <td>P</td>
                              <td>P</td>
                              <td>P</td>
                              <td>P</td>
                              <td class="off">OFF</td>
                              <td>P</td>
                              <td>P</td>
                              <td>P</td>
                              <td>P</td>
                              <td>P</td>
                              <td>P</td>
                              <td class="off">OFF</td>
                              <td>P</td>
                              <td>P</td>
                            </tr>

                          </tbody>
                        </table>
                      </div>
                      <!-- end Multi-column ordering -->
                    </div>
                  </div>
                  <div class="tab-pane p-3" id="navpill-22" role="tabpanel">
                    <div class="row">
                      <!-- start Multi-column ordering -->
                      <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered display text-nowrap">
                          <thead>
                            <tr>
                              <th>SN</th>
                              <th>Employee Name</th>
                              <th>ID</th>
                              <th>CWK</th>
                              <th>Section</th>
                              <th>Segments</th>
                              <th>Sat 1</th>
                              <th>Sun 2</th>
                              <th>Mon 3</th>
                              <th>Tue 4</th>
                              <th>Wed 5</th>
                              <th>Thu 6</th>
                              <th>Fri 7</th>
                              <th>Sat 8</th>
                              <th>Sun 9</th>
                              <th>Mon 10</th>
                              <th>Tue 11</th>
                              <th>Wed 12</th>
                              <th>Thu 13</th>
                              <th>Fri 14</th>
                              <th>Sat 15</th>
                              <th>Sun 16</th>
                              <th>Mon 17</th>
                              <th>Tue 18</th>
                              <th>Wed 19</th>
                              <th>Thu 20</th>
                              <th>Fri 21</th>
                              <th>Sat 22</th>
                              <th>Sun 23</th>
                              <th>Mon 24</th>
                              <th>Tue 25</th>
                              <th>Wed 26</th>
                              <th>Thu 27</th>
                              <th>Fri 28</th>
                              <th>Sat 29</th>
                              <th>Sun 30</th>
                              <th>Mon 31</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>1</td>
                              <td>JAMUNA PUN MAGAR</td>
                              <td>17125</td>
                              <td>708382</td>
                              <td>CLEANING</td>
                              <td>3LND</td>
                              <td class="off">OFF</td>
                              <td>P</td>
                              <td>P</td>
                              <td>P</td>
                              <td>P</td>
                              <td>P</td>
                              <td>P</td>
                              <td class="off">OFF</td>
                              <td>P</td>
                              <td>P</td>
                              <td>P</td>
                              <td>P</td>
                              <td>P</td>
                              <td>P</td>
                              <td class="off">OFF</td>
                              <td>P</td>
                              <td>P</td>
                              <td>P</td>
                              <td>P</td>
                              <td>P</td>
                              <td>P</td>
                              <td class="off">OFF</td>
                              <td>P</td>
                              <td>P</td>
                              <td>P</td>
                              <td>P</td>
                              <td>P</td>
                              <td>P</td>
                              <td class="off">OFF</td>
                              <td>P</td>
                              <td>P</td>

                            </tr>
                          </tbody>
                        </table>

                      </div>
                      <!-- end Multi-column ordering -->
                    </div>
                  </div>
                </div>


              </div>
            </div>
            <!-- end Tab with Flex Utilities -->

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

  <?php include("search.php"); ?>


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
  <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="assets/js/datatable/datatable-basic.init.js"></script>
</body>

</html>