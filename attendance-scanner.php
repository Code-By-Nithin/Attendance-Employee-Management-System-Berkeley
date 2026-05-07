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
$sectionCounts = [
  'Cleaning' => 0,
  'DC' => 0,
  'Washing' => 0,
  'ATP' => 0,
  'Blanket' => 0,
  'Finishing' => 0,
  'Hotel' => 0
];

while ($row = mysqli_fetch_assoc($result)) {
  $totalPresentCount += $row['present_count'];
  $sectionCounts[$row['section']] = $row['present_count'];
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="assets/css/styles.css" />
  <link rel="stylesheet" href="https://unpkg.com/@tabler/icons-webfont@2.41.0/tabler-icons.min.css">
  <link rel="stylesheet" href="assets/libs/dropzone/dist/min/dropzone.min.css">
  <!-- OpenCV.js -->
  <script async src="https://docs.opencv.org/4.x/opencv.js" type="text/javascript"></script>
  <!-- Tesseract.js -->
  <script src="https://cdn.jsdelivr.net/npm/tesseract.js@2.1.5/dist/tesseract.min.js"></script>
  <title>Attendance Scanner</title>
  <style>
    #scanner-container {
      position: relative;
      width: 100%;
      max-width: 640px;
      margin: 0 auto;
    }
    #scanner-video {
      width: 100%;
      height: auto;
      border: 1px solid #ccc;
    }
    #detected-number {
      margin-top: 10px;
      font-size: 18px;
      font-weight: bold;
      color: green;
    }
  </style>
</head>

<body class="link-sidebar">
  <div class="preloader">
    <img src="assets/images/logos/favicon.png" alt="loader" class="lds-ripple img-fluid">
  </div>
  <div id="main-wrapper">
    <aside class="left-sidebar with-vertical">
      <div>
        <div class="brand-logo d-flex align-items-center">
          <a href="dashboard.php" class="text-nowrap logo-img">
            <img src="assets/images/logos/logo.svg" alt="Logo">
          </a>
        </div>
        <?php include("sidebar.php"); ?>
      </div>
    </aside>
    <div class="page-wrapper">
      <?php include("header.php"); ?>
      <div class="body-wrapper">
        <div class="container-fluid">
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
                  <input type="date" class="form-control" id="attendance-date" value="<?php echo $selectedDate; ?>">
                </div>
                <div class="col-md-4 col-xl-3">
                  <div class="btn-group search-cnt" data-bs-toggle="buttons">
                    <label class="btn bg-primary-subtle text-primary">
                      <input type="radio" name="shift" value="Day" onchange="updateShift('Day')" <?php echo ($selectedShift == 'Day') ? 'checked' : ''; ?>> Day Shift
                    </label>
                    <label class="btn bg-primary-subtle text-primary">
                      <input type="radio" name="shift" value="Night" onchange="updateShift('Night')" <?php echo ($selectedShift == 'Night') ? 'checked' : ''; ?>> Night Shift
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="border-bottom title-part-padding">
                <h4 class="card-title mb-0">Scanner</h4>
              </div>
              <div class="card-body">
                <div id="scanner-container">
                  <video id="scanner-video" autoplay playsinline></video>
                </div>
                <button id="toggle-flash" class="btn btn-primary mt-3" disabled>Toggle Flash</button>
                <div id="detected-number">Detected CWK ID: <span id="number"></span></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const video = document.getElementById('scanner-video');
        const toggleFlash = document.getElementById('toggle-flash');
        const detectedNumber = document.getElementById('number');
        let flashOn = false;

        // Initialize camera
        navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } })
          .then(stream => {
            video.srcObject = stream;
            video.play();
            toggleFlash.disabled = false;
            startProcessing();
          })
          .catch(err => {
            console.error("Error accessing camera:", err);
          });

        // Start image processing
        function startProcessing() {
          const canvas = document.createElement('canvas');
          const context = canvas.getContext('2d');

          setInterval(() => {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Detect ID card and extract CWK ID
            detectIDCardAndExtractCWK(canvas);
          }, 1000); // Process every second
        }

        // Detect ID card and extract CWK ID
        function detectIDCardAndExtractCWK(canvas) {
          const src = cv.imread(canvas);
          const gray = new cv.Mat();
          const blurred = new cv.Mat();
          const edged = new cv.Mat();

          // Convert to grayscale
          cv.cvtColor(src, gray, cv.COLOR_RGBA2GRAY, 0);

          // Apply Gaussian blur
          cv.GaussianBlur(gray, blurred, new cv.Size(5, 5), 0);

          // Detect edges using Canny
          cv.Canny(blurred, edged, 75, 200);

          // Find contours
          const contours = new cv.MatVector();
          const hierarchy = new cv.Mat();
          cv.findContours(edged, contours, hierarchy, cv.RETR_LIST, cv.CHAIN_APPROX_SIMPLE);

          // Approximate contours to detect squares (ID card)
          for (let i = 0; i < contours.size(); i++) {
            const contour = contours.get(i);
            const peri = cv.arcLength(contour, true);
            const approx = new cv.Mat();
            cv.approxPolyDP(contour, approx, 0.02 * peri, true);

            if (approx.rows === 4) { // Square detected (ID card)
              const rect = cv.boundingRect(approx);
              const roi = src.roi(rect);

              // Convert ROI to a data URL for Tesseract.js
              const roiCanvas = document.createElement('canvas');
              const roiContext = roiCanvas.getContext('2d');
              roiCanvas.width = rect.width;
              roiCanvas.height = rect.height;
              cv.imshow(roiCanvas, roi);

              // Extract text using Tesseract.js
              Tesseract.recognize(
                roiCanvas,
                'eng',
                { logger: m => console.log(m) }
              ).then(({ data: { text } }) => {
                const cwkNumber = text.match(/CWK\s*(\d{6})/);
                if (cwkNumber) {
                  detectedNumber.textContent = cwkNumber[1];
                }
              });

              roi.delete();
              approx.delete();
              break;
            }
            approx.delete();
          }

          // Clean up
          src.delete();
          gray.delete();
          blurred.delete();
          edged.delete();
          contours.delete();
          hierarchy.delete();
        }

        // Toggle flash functionality
        toggleFlash.addEventListener('click', function () {
          if (!video.srcObject) {
            console.error("Camera stream not initialized.");
            return;
          }

          flashOn = !flashOn;
          const track = video.srcObject.getVideoTracks()[0];
          track.applyConstraints({
            advanced: [{ torch: flashOn }]
          }).then(() => {
            console.log("Flash toggled:", flashOn ? "ON" : "OFF");
          }).catch(err => {
            console.error("Error toggling flash:", err);
          });
        });
      });

      function updateShift(shift) {
        const selectedDate = document.getElementById("attendance-date").value;
        window.location.href = "?date=" + selectedDate + "&shift=" + shift;
      }
    </script>
  </div>
</body>

</html>