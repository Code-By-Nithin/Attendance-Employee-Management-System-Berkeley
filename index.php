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

  <title>Login</title>
</head>

<body class="link-sidebar">
  <!-- Preloader -->
  <div class="preloader">
    <img src="assets/images/logos/favicon.png" alt="loader" class="lds-ripple img-fluid">
  </div>
  <div id="main-wrapper">
    <div
      class="position-relative overflow-hidden auth-bg min-vh-100 w-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100 my-5 my-xl-0">
          <div class="col-md-9 d-flex flex-column justify-content-center">
            <div class="card mb-0 bg-body auth-login m-auto w-100">
              <div class="row gx-0">
                <!-- ------------------------------------------------- -->
                <!-- Part 1 -->
                <!-- ------------------------------------------------- -->
                <div class="col-xl-6 border-end">
                  <div class="row justify-content-center py-4">
                    <div class="col-lg-11">
                      <div class="card-body">
                        <a href="index.php" class="text-nowrap logo-img d-block mb-4 w-100">
                          <img src="assets/images/logos/logo.svg" class="dark-logo" alt="Logo-Dark">
                        </a>
                        <h2 class="lh-base mb-4">Let's get you signed in</h2>
                        <?php
                        session_start();
                        include 'connection.php';

                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                          $email = $_POST['email'];
                          $password = $_POST['password'];

                          // Query to check user credentials
                          $stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND password=?");
                          $stmt->bind_param("ss", $email, $password);
                          $stmt->execute();
                          $result = $stmt->get_result();

                          if ($result->num_rows > 0) {
                            $_SESSION['user'] = $email;  // Store user session
                            header("Location: dashboard.php");  // Redirect to dashboard
                            exit();
                          } else {
                            $error = "Invalid email or password!";
                          }
                        }
                        ?>
                        <form method="POST" action="">
                          <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email Address</label>
                            <input type="email" class="form-control" name="email" id="exampleInputEmail1"
                              placeholder="Enter your email" required>
                          </div>
                          <div class="mb-4">
                            <div class="d-flex align-items-center justify-content-between">
                              <label for="exampleInputPassword1" class="form-label">Password</label>
                              <a class="text-primary link-dark fs-2">Forgot
                                Password?</a>
                            </div>
                            <input type="password" class="form-control" name="password" id="exampleInputPassword1"
                              placeholder="Enter your password" required>
                          </div>
                          <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="form-check">
                              <input class="form-check-input primary" type="checkbox" id="flexCheckChecked" checked>
                              <label class="form-check-label text-dark" for="flexCheckChecked">Keep me logged in</label>
                            </div>
                          </div>
                          <button type="submit" class="btn btn-dark w-100 py-8 mb-4 rounded-1">Sign In</button>
                          <?php if (isset($error)) {
                            echo "<p style='color:red;'>$error</p>";
                          } ?>
                          <div class="d-flex align-items-center">
                            <p class="fs-12 mb-0 fw-medium">Don’t have an account yet?</p>
                            <a class="text-primary fw-bolder ms-2">Sign Up Now</a>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                </div>
                <!-- ------------------------------------------------- -->
                <!-- Part 2 -->
                <!-- ------------------------------------------------- -->
                <div class="col-xl-6 d-none d-xl-block">
                  <div class="row justify-content-center align-items-start h-100">
                    <div class="col-lg-9">
                      <div id="auth-login" class="carousel slide auth-carousel mt-5 pt-1" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                          <button type="button" data-bs-target="#auth-login" data-bs-slide-to="0" class="active"
                            aria-current="true" aria-label="Slide 1"></button>
                          <button type="button" data-bs-target="#auth-login" data-bs-slide-to="1"
                            aria-label="Slide 2"></button>
                          <button type="button" data-bs-target="#auth-login" data-bs-slide-to="2"
                            aria-label="Slide 3"></button>
                        </div>
                        <div class="carousel-inner">
                          <div class="carousel-item active">
                            <div
                              class="d-flex align-items-center justify-content-center w-100 h-100 flex-column gap-9 text-center">
                              <img src="assets/images/backgrounds/login-side.png" alt="login-side-img" width="300"
                                class="img-fluid">
                              <h4 class="mb-0">Strategic Partnerships</h4>
                              <p class="fs-12 mb-0">We build long-term collaborations, delivering innovative facility
                                management solutions tailored to your business needs and goals.</p>
                              <a href="https://www.berkeleyuae.com/" target="_blank" class="btn btn-primary rounded-1">Learn More</a>
                            </div>
                          </div>
                          <div class="carousel-item">
                            <div
                              class="d-flex align-items-center justify-content-center w-100 h-100 flex-column gap-9 text-center">
                              <img src="assets/images/backgrounds/login-side.png" alt="login-side-img" width="300"
                                class="img-fluid">
                              <h4 class="mb-0">Exceed Expectations</h4>
                              <p class="fs-12 mb-0">Our commitment to quality, efficiency, and reliability ensures
                                outstanding facility management services beyond your expectations.</p>
                              <a href="https://www.berkeleyuae.com/" target="_blank" class="btn btn-primary rounded-1">Learn More</a>
                            </div>
                          </div>
                          <div class="carousel-item">
                            <div
                              class="d-flex align-items-center justify-content-center w-100 h-100 flex-column gap-9 text-center">
                              <img src="assets/images/backgrounds/login-side.png" alt="login-side-img" width="300"
                                class="img-fluid">
                              <h4 class="mb-0">Your Needs Our Services</h4>
                              <p class="fs-12 mb-0">We provide customized facility management solutions, addressing
                                every requirement with professionalism, expertise, and dedication.</p>
                              <a href="https://www.berkeleyuae.com/" target="_blank" class="btn btn-primary rounded-1">Learn More</a>
                            </div>
                          </div>
                        </div>

                      </div>


                    </div>
                  </div>

                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
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
  <script src="npm/iconify-icon%401.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>