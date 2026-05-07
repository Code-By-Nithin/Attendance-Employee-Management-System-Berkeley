
<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <!-- Required meta tags -->
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Favicon icon-->
  <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png">

  <!-- Core CSS -->
  <link rel="stylesheet" href="assets/css/styles.css">
  <link rel="stylesheet" href="https://unpkg.com/@tabler/icons-webfont@2.41.0/tabler-icons.min.css">

  <title>Notes</title>
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
          <a href="index.php" class="text-nowrap logo-img">
            <img src="assets/images/logos/logo.svg" alt="Logo">
          </a>
        </div>
        <?php include("sidebar.php"); ?>
      </div>
    </aside>
    <!-- Sidebar End -->

    <div class="page-wrapper">
      <!-- Header Start -->
      <?php include("header.php"); ?>
      <!-- Header End -->

      <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card card-body py-3">
            <div class="row align-items-center">
              <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                  <h4 class="mb-4 mb-sm-0 card-title">Notes</h4>
                  <nav aria-label="breadcrumb" class="ms-auto">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item d-flex align-items-center">
                        <a class="text-muted text-decoration-none d-flex" href="dashboard.php">
                          <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                        </a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">
                        <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                          Notes
                        </span>
                      </li>
                    </ol>
                  </nav>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 col-lg-4">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center">
                      <img src="assets/images/profile/user-11.jpg" class="rounded-circle img-fluid" width="50">
                      <div class="ms-3">
                        <h4 class="card-title">Andrew Grant</h4>
                        <p class="card-subtitle mb-0">Yestarday at 5:06 PM</p>
                      </div>
                    </div>
                    <div class="ms-auto">
                      <div class="dropdown">
                        <a href="javascript:void(0)" class="link" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="ti ti-dots fs-6 text-dark"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <li>
                            <a class="dropdown-item" href="javascript:void(0)">Report</a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="javascript:void(0)">Turn on Post Notifications</a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="javascript:void(0)">Copy Link</a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="javascript:void(0)">Share to...</a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="javascript:void(0)">Unfollow</a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="javascript:void(0)">Mute</a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <img src="assets/images/blog/blog-img5.jpg" class="img-fluid rounded-1 mt-4">
                  <div class="mt-4">
                    <p class="fs-4">
                      Your beauty is one of the things I like about you.😍 🥰<a href="javascript:void(0)">#beauty</a>
                      <a href="javascript:void(0)">#goa🏄🏽‍♀️</a>
                      <a href="javascript:void(0)">#india</a>
                      <a href="javascript:void(0)">#happylife</a>
                    </p>
                  </div>
                  <div class="d-flex align-items-center">
                    <a href="javascript:void(0)" class="me-3">
                      <i class="ti ti-heart text-dark fs-7"></i>
                    </a>
                    <a href="javascript:void(0)" class="me-3">
                      <i class="ti ti-message-circle text-dark fs-7"></i>
                    </a>
                    <a href="javascript:void(0)" class="me-2">
                      <i class="ti ti-send text-dark fs-7"></i>
                    </a>
                    <div class="ms-auto">
                      <a href="javascript:void(0)">
                        <i class="ti ti-bookmark text-dark fs-7"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center">
                      <img src="assets/images/profile/user-4.jpg" class="rounded-circle img-fluid" width="50">
                      <div class="ms-3">
                        <h4 class="card-title">Maria Hernandez</h4>
                        <p class="card-subtitle mb-0">
                          Angular, Reactjs, Vuejs
                        </p>
                      </div>
                    </div>
                  </div>
                  <p class="text-muted fs-4 mt-4">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                    sed do eiusmod tempor incididunt ut labore et dolore magna
                    aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                    ullamco.
                  </p>
                  <div class="d-flex align-items-center pb-3 border-bottom">
                    <a href="javascript:void(0)" class="
                        me-3
                        d-flex
                        align-items-center
                        link
                        fw-medium
                      ">
                      <i class="ti ti-heart text-danger fs-7"></i>
                      <span class="ms-1 text-dark">45</span>
                    </a>
                    <a href="javascript:void(0)" class="
                        me-3
                        d-flex
                        align-items-center
                        link
                        fw-medium
                      ">
                      <i class="ti ti-message-circle text-dark fs-7"></i>
                      <span class="ms-1 text-dark">12</span>
                    </a>
                  </div>
                  <div class="d-flex align-items-start mt-3">
                    <img src="assets/images/profile/user-5.jpg" class="rounded-circle img-fluid" width="40">
                    <div class="ms-3 w-100">
                      <h6 class="card-title mb-0">Andrew Grant</h6>
                      <div class="form-floating my-3">
                        <input type="text" class="form-control form-input-bg" id="floatingInput" placeholder="name@example.com">
                        <label for="floatingInput">Write comment...</label>
                      </div>
                      <div class="text-end">
                        <button type="button" class="btn btn-primary">Post</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="comment-widgets">
                  <!-- Comment Row -->
                  <div class="d-flex flex-row comment-row mt-0 p-3">
                    <div class="p-2">
                      <img src="assets/images/profile/user-3.jpg" alt="user" width="50" class="rounded-circle">
                    </div>
                    <div class="comment-text w-100">
                      <h6 class="fw-medium">James Anderson</h6>
                      <span class="mb-3 d-block">Lorem Ipsum is simply dummy text of the printing and
                        type setting industry.
                      </span>
                      <div class="comment-footer d-md-flex align-items-center">
                        <div class="text-muted">April 14, 2023</div>
                        <div class="action-icons ms-auto">
                          <a href="javascript:void(0)">
                            <i data-feather="edit-3" class="feather-sm"></i>
                          </a>
                          <a href="javascript:void(0)">
                            <i data-feather="check-circle" class="feather-sm"></i>
                          </a>
                          <a href="javascript:void(0)">
                            <i data-feather="heart" class="feather-sm"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Comment Row -->
                  <div class="d-flex flex-row comment-row p-3">
                    <div class="p-2">
                      <img src="assets/images/profile/user-4.jpg" alt="user" width="50" class="rounded-circle">
                    </div>
                    <div class="comment-text w-100">
                      <h6 class="fw-medium">Michael Jorden</h6>
                      <span class="mb-3 d-block">Lorem Ipsum is simply dummy text of the printing and
                        type setting industry.
                      </span>
                      <div class="comment-footer d-md-flex align-items-center">
                        <div class="text-muted">April 14, 2023</div>
                        <div class="action-icons active ms-auto">
                          <a href="javascript:void(0)">
                            <i data-feather="edit-3" class="feather-sm"></i>
                          </a>
                          <a href="javascript:void(0)">
                            <i data-feather="x-circle" class="feather-sm"></i>
                          </a>
                          <a href="javascript:void(0)">
                            <i data-feather="heart" class="feather-sm text-danger"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-4">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center">
                      <img src="assets/images/profile/user-7.jpg" class="rounded-circle img-fluid" width="50">
                      <div class="ms-3">
                        <h4 class="card-title">John Smith</h4>
                        <p class="card-subtitle mb-0">Yestarday at 5:06 PM</p>
                      </div>
                    </div>
                    <div class="ms-auto">
                      <div class="dropdown">
                        <a href="javascript:void(0)" class="link" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="ti ti-dots fs-6 text-dark"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <li>
                            <a class="dropdown-item" href="javascript:void(0)">Report</a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="javascript:void(0)">Turn on Post Notifications</a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="javascript:void(0)">Copy Link</a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="javascript:void(0)">Share to...</a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="javascript:void(0)">Unfollow</a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="javascript:void(0)">Mute</a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <p class="text-muted fs-4 mt-4">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                    sed do eiusmod tempor incididunt ut labore et dolore magna
                    aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                    ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    Duis aute irure dolor in reprehenderit in voluptate velit
                    esse cillum dolore eu fugiat nulla pariatur. Excepteur sint
                    occaecat cupidatat non proident, sunt in culpa qui officia
                    deserunt mollit anim id est laborum.
                  </p>
                  <div class="d-flex align-items-center">
                    <a href="javascript:void(0)" class="me-3">
                      <i class="ti ti-heart text-dark fs-7"></i>
                    </a>
                    <a href="javascript:void(0)" class="me-3">
                      <i class="ti ti-message-circle text-dark fs-7"></i>
                    </a>
                    <a href="javascript:void(0)" class="me-2">
                      <i class="ti ti-send text-dark fs-7"></i>
                    </a>
                    <div class="ms-auto">
                      <a href="javascript:void(0)">
                        <i class="ti ti-bookmark text-dark fs-7"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center">
                      <img src="assets/images/profile/user-5.jpg" class="rounded-circle img-fluid" width="50">
                      <div class="ms-3">
                        <h4 class="card-title">Ritesh Deshmukh</h4>
                        <p class="card-subtitle mb-0">Today at 6:30 AM</p>
                      </div>
                    </div>
                    <div class="ms-auto">
                      <div class="dropdown">
                        <a href="javascript:void(0)" class="link" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="ti ti-dots fs-6 text-dark"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <li>
                            <a class="dropdown-item" href="javascript:void(0)">Report</a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="javascript:void(0)">Turn on Post Notifications</a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="javascript:void(0)">Copy Link</a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="javascript:void(0)">Share to...</a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="javascript:void(0)">Unfollow</a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="javascript:void(0)">Mute</a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="mt-4">
                    <div class="embed-responsive embed-responsive-16by9">
                      <iframe class="embed-responsive-item rounded" width="100%" height="350" src="https://www.youtube.com/embed/tgbNymZ7vqY" allowfullscreen="allowfullscreen"></iframe>
                    </div>
                  </div>
                  <div class="mt-4">
                    <p class="fs-4">
                      Your beauty is one of the things I like about you.😍 🥰<a href="javascript:void(0)">#beauty</a>
                      <a href="javascript:void(0)">#goa🏄🏽‍♀️</a>
                      <a href="javascript:void(0)">#india</a>
                      <a href="javascript:void(0)">#happylife</a>
                    </p>
                  </div>
                  <div class="d-flex align-items-center">
                    <a href="javascript:void(0)" class="me-3">
                      <i class="ti ti-heart text-dark fs-7"></i>
                    </a>
                    <a href="javascript:void(0)" class="me-3">
                      <i class="ti ti-message-circle text-dark fs-7"></i>
                    </a>
                    <a href="javascript:void(0)" class="me-2">
                      <i class="ti ti-send text-dark fs-7"></i>
                    </a>
                    <div class="ms-auto">
                      <a href="javascript:void(0)">
                        <i class="ti ti-bookmark text-dark fs-7"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center">
                      <img src="assets/images/profile/user-7.jpg" class="rounded-circle img-fluid" width="50">
                      <div class="ms-3">
                        <h4 class="card-title">Ritesh Deshmukh</h4>
                        <p class="card-subtitle mb-0">Today at 6:30 AM</p>
                      </div>
                    </div>
                    <div class="ms-auto">
                      <div class="dropdown">
                        <a href="javascript:void(0)" class="link" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="ti ti-dots fs-6 text-dark"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <li>
                            <a class="dropdown-item" href="javascript:void(0)">Report</a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="javascript:void(0)">Turn on Post Notifications</a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="javascript:void(0)">Copy Link</a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="javascript:void(0)">Share to...</a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="javascript:void(0)">Unfollow</a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="javascript:void(0)">Mute</a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <p class="fs-4 mt-3">
                    New Wireless headphone with 50% off...!
                  </p>
                  <div class="mt-4 text-center">
                    <a href="javascript:void(0)" class="link">
                      <div class="p-3 border rounded-1">
                        <div class="mt-n2 text-end mb-2">
                          <i class="ti ti-external-link fs-8 text-dark"></i>
                        </div>
                        <img src="assets/images/products/s4.jpg" class="img-fluid">
                      </div>
                    </a>
                  </div>
                  <div class="mt-4">
                    <h5>Sony Headphone</h5>
                    <span class="text-muted d-block fs-4">Noise One Wireless Bluetooth Headset</span>
                    <a href="javascript:void(0)" class="text-info fs-4 fw-medium">https://www.flipkart.com/search?q=headphone&otracker=search&otracker1=search&marketplace=FLIPKART&as-show=on&as=off</a>
                  </div>
                  <div class="d-flex align-items-center mt-3">
                    <a href="javascript:void(0)" class="me-3">
                      <i class="ti ti-heart text-dark fs-7"></i>
                    </a>
                    <a href="javascript:void(0)" class="me-3">
                      <i class="ti ti-message-circle text-dark fs-7"></i>
                    </a>
                    <a href="javascript:void(0)" class="me-2">
                      <i class="ti ti-send text-dark fs-7"></i>
                    </a>
                    <div class="ms-auto">
                      <a href="javascript:void(0)">
                        <i class="ti ti-bookmark text-dark fs-7"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-4">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center">
                      <img src="assets/images/profile/user-4.jpg" class="rounded-circle img-fluid" width="50">
                      <div class="ms-3">
                        <h4 class="card-title">Maria Hernandez</h4>
                        <p class="card-subtitle mb-0">
                          Angular, Reactjs, Vuejs
                        </p>
                      </div>
                    </div>
                  </div>
                  <p class="text-muted fs-4 mt-4">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                    sed do eiusmod tempor incididunt ut labore et dolore magna
                    aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                    ullamco.
                  </p>
                  <div class="d-flex align-items-center pb-3 border-bottom">
                    <a href="javascript:void(0)" class="
                        me-3
                        d-flex
                        align-items-center
                        link
                        fw-medium
                      ">
                      <i class="ti ti-heart text-danger fs-7"></i>
                      <span class="ms-1 text-dark">45</span>
                    </a>
                    <a href="javascript:void(0)" class="
                        me-3
                        d-flex
                        align-items-center
                        link
                        fw-medium
                      ">
                      <i class="ti ti-message-circle text-dark fs-7"></i>
                      <span class="ms-1 text-dark">12</span>
                    </a>
                  </div>
                  <div class="form-floating my-3">
                    <input type="text" class="form-control form-input-bg" id="floatingInput1" placeholder="name@example.com">
                    <label for="floatingInput1">Reply</label>
                  </div>
                  <div class="text-end">
                    <button type="button" class="btn btn-primary">Reply</button>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center">
                      <img src="assets/images/profile/user-6.jpg" class="rounded-circle img-fluid" width="50">
                      <div class="ms-3">
                        <h4 class="card-title">Ritesh Deshmukh</h4>
                        <p class="card-subtitle mb-0">Today at 6:30 AM</p>
                      </div>
                    </div>
                    <div class="ms-auto">
                      <div class="dropdown">
                        <a href="javascript:void(0)" class="link" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="ti ti-dots fs-6 text-dark"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <li>
                            <a class="dropdown-item" href="javascript:void(0)">Report</a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="javascript:void(0)">Turn on Post Notifications</a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="javascript:void(0)">Copy Link</a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="javascript:void(0)">Share to...</a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="javascript:void(0)">Unfollow</a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="javascript:void(0)">Mute</a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <p class="fs-4 mt-3">
                    Shows off his favourite features of the new Polestar 2.
                    Excited!<a href="javascript:void(0)">#PolestarCars</a>
                    <a href="javascript:void(0)">#cars</a>
                    <a href="javascript:void(0)">#india</a>
                    <a href="javascript:void(0)">#Polestar2</a>
                  </p>
                  <div class="mt-4 text-center">
                    <a href="javascript:void(0)" class="link">
                      <div class="p-3 border rounded-1">
                        <div class="mt-n2 text-end mb-2">
                          <i class="ti ti-external-link fs-8 text-dark"></i>
                        </div>
                        <img src="assets/images/products/s1.jpg" class="img-fluid">
                      </div>
                    </a>
                  </div>
                  <div class="mt-4">
                    <h5>Polestar 2</h5>
                    <span class="text-muted d-block fs-4">5-door all-electric fastback</span>
                    <a href="javascript:void(0)" class="text-info fs-4 fw-medium">https://www.polestar.com/us/pole-star-2/</a>
                  </div>
                  <div class="d-flex align-items-center mt-3">
                    <a href="javascript:void(0)" class="me-3">
                      <i class="ti ti-heart text-dark fs-7"></i>
                    </a>
                    <a href="javascript:void(0)" class="me-3">
                      <i class="ti ti-message-circle text-dark fs-7"></i>
                    </a>
                    <a href="javascript:void(0)" class="me-2">
                      <i class="ti ti-send text-dark fs-7"></i>
                    </a>
                    <div class="ms-auto">
                      <a href="javascript:void(0)">
                        <i class="ti ti-bookmark text-dark fs-7"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <script>
        // Mention feature
        const descriptionField = document.getElementById('note-has-description');
        const titleField = document.getElementById('note-has-title');
        const mentionDropdown = document.createElement('div');
        mentionDropdown.className = 'mention-dropdown';
        mentionDropdown.style.display = 'none';
        document.body.appendChild(mentionDropdown);

        function showMentionDropdown(inputField, cursorPos) {
          const textBeforeCursor = inputField.value.substring(0, cursorPos);
          const lastAtPos = textBeforeCursor.lastIndexOf('@');

          if (lastAtPos !== -1) {
            const searchTerm = textBeforeCursor.substring(lastAtPos + 1).toLowerCase();
            const filteredEmployees = <?php echo json_encode($employees); ?>.filter(emp =>
              emp.name.toLowerCase().includes(searchTerm)
            );

            if (filteredEmployees.length > 0) {
              mentionDropdown.innerHTML = filteredEmployees.map(emp => `
                <div class="mention-item" data-id="${emp.id}" data-name="${emp.name}">
                    ${emp.name} (${emp.id})
                </div>
            `).join('');
              mentionDropdown.style.display = 'block';

              // Position the dropdown near the cursor
              const rect = inputField.getBoundingClientRect();
              mentionDropdown.style.position = 'absolute';
              mentionDropdown.style.top = `${rect.bottom}px`;
              mentionDropdown.style.left = `${rect.left}px`;
            } else {
              mentionDropdown.style.display = 'none';
            }
          } else {
            mentionDropdown.style.display = 'none';
          }
        }

        descriptionField.addEventListener('input', function (e) {
          showMentionDropdown(descriptionField, e.target.selectionStart);
        });

        titleField.addEventListener('input', function (e) {
          showMentionDropdown(titleField, e.target.selectionStart);
        });

        mentionDropdown.addEventListener('click', function (e) {
          if (e.target.classList.contains('mention-item')) {
            const employeeId = e.target.getAttribute('data-id');
            const employeeName = e.target.getAttribute('data-name');
            const activeField = document.activeElement;
            const cursorPos = activeField.selectionStart;
            const textBeforeCursor = activeField.value.substring(0, cursorPos);
            const lastAtPos = textBeforeCursor.lastIndexOf('@');

            // Replace the @mention with the selected employee name
            activeField.value =
              textBeforeCursor.substring(0, lastAtPos) +
              `@${employeeName}` +
              activeField.value.substring(cursorPos);

            mentionDropdown.style.display = 'none';
          }
        });
      </script>
    </div>

    <!-- Search Bar -->
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
  <!-- Solar icons -->
  <script src="npm/iconify-icon%401.0.8/dist/iconify-icon.min.js"></script>
  <script src="assets/libs/fullcalendar/index.global.min.js"></script>
  <script src="assets/js/apps/notes.js"></script>
  <script>
   document.getElementById('add-note-form').addEventListener('submit', function (e) {
    e.preventDefault(); // Prevent default form submission

    const formData = new FormData(this);

    // Add mentions to the form data
    const mentions = [];
    document.querySelectorAll('.mention-item').forEach(item => {
        mentions.push({
            id: item.getAttribute('data-id'),
            name: item.getAttribute('data-name')
        });
    });
    formData.append('mentions', JSON.stringify(mentions));

    fetch('notes.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                window.location.reload(); // Reload the page to show the new note
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
});
  </script>
  <style>
    .mention-dropdown {
    position: absolute;
    background: white;
    border: 1px solid #ddd;
    max-height: 150px;
    overflow-y: auto;
    z-index: 1000;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.mention-item {
    padding: 8px;
    cursor: pointer;
}

.mention-item:hover {
    background: #f0f0f0;
}
  </style>
</body>

</html>