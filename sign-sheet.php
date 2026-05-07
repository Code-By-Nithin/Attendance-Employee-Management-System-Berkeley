<?php
// sign-sheet.php
session_start();
include 'connection.php';

if (!isset($_SESSION['user'])) {
  header("Location: index.php");
  exit();
}

$email = $_SESSION['user'];

// Fetch user role
$query = "SELECT role FROM users WHERE username = '$email'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$role = $row['role'] ?? 'Unknown';

// Fetch signature records
$query_signatures = "SELECT * FROM staff_signatures ORDER BY sign_date DESC";
$result_signatures = mysqli_query($conn, $query_signatures);

// Prepare data for Word export
$export_data = [];
while ($row_sign = mysqli_fetch_assoc($result_signatures)) {
    $export_data[] = $row_sign;
}
// Reset pointer
mysqli_data_seek($result_signatures, 0);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Staff Sign Sheet</title>
  <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png">
  <link rel="stylesheet" href="assets/css/styles.css">
  <link rel="stylesheet" href="https://unpkg.com/@tabler/icons-webfont@2.41.0/tabler-icons.min.css">
  <style>
    .signature-pad {
      position: relative;
      width: 100%;
    }

    .signature-pad--body {
      border: 1px solid #ddd;
      border-radius: 4px;
      min-height: 200px;
      background-color: white;
    }

    .signature-pad--actions {
      margin-top: 10px;
    }

    canvas {
      width: 100%;
      height: 300px;
      touch-action: none;
    }
  </style>
</head>

<body class="link-sidebar">
  <div class="preloader">
    <img src="assets/images/logos/favicon.png" alt="loader" class="lds-ripple img-fluid">
  </div>
  <div id="main-wrapper">
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
    <div class="page-wrapper">
      <?php include("header.php"); ?>
      <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card card-body py-3">
            <div class="row align-items-center">
              <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                  <h4 class="mb-4 mb-sm-0 card-title">Staff Sign Sheet</h4>
                  <nav aria-label="breadcrumb" class="ms-auto">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item d-flex align-items-center">
                        <a class="text-muted text-decoration-none d-flex" href="dashboard.php">
                          <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                        </a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">
                        <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                          Sign Form
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
                  <h4 class="card-title mb-0">Staff Sign-In</h4>
                </div>
                <div class="card-body p-4">
                  <form id="signForm" method="POST" action="save_signature.php">
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="mb-4">
                          <label for="berkeleyID" class="form-label">Berkeley ID</label>
                          <input type="text" class="form-control" id="berkeleyID" name="berkeley_id" placeholder="22510"
                            required>
                          <span id="berkeleyWarning" class="text-danger" style="display: none; font-size: 14px;">
                            No employee found with this Berkeley ID!
                          </span>
                          <span id="duplicateWarning" class="text-danger" style="display: none; font-size: 14px;">
                            This employee has already signed today!
                          </span>
                        </div>
                        <div class="mb-4">
                          <label for="cwkID" class="form-label">CWK ID</label>
                          <input type="text" class="form-control" id="cwkID" name="cwk_id" readonly required>
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
                      </div>

                      <div class="col-12">
                        <div class="mb-4">
                          <label class="form-label">Signature</label>
                          <div id="signature-pad" class="signature-pad">
                            <div class="signature-pad--body">
                              <canvas id="signature-canvas"></canvas>
                            </div>
                            <div class="signature-pad--footer mt-2">
                              <div class="signature-pad--actions">
                                <button type="button" id="clear-signature"
                                  class="btn btn-secondary btn-sm">Clear</button>
                                <button type="button" id="undo-signature" class="btn btn-secondary btn-sm">Undo</button>
                              </div>
                            </div>
                          </div>
                          <input type="hidden" id="signatureData" name="signature_data">
                        </div>
                      </div>

                      <div class="col-12">
                        <div class="d-flex align-items-center gap-3">
                          <button type="submit" class="btn btn-primary">Submit Signature</button>
                          <button type="reset" class="btn bg-danger-subtle text-danger" id="resetForm">Cancel</button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <div class="card w-100 position-relative overflow-hidden mt-4">
            <div class="px-4 py-3 border-bottom d-flex justify-content-between align-items-center">
              <h4 class="card-title mb-0">Staff Signatures</h4>
              <button id="exportWord" class="btn btn-success">
                <i class="ti ti-file-export me-2"></i>Export to Word
              </button>
            </div>
            <div class="card-body p-4">
              <div class="table-responsive mb-4 border rounded-1">
                <table class="table text-nowrap mb-0 align-middle" id="signatureTable">
                  <thead class="text-dark fs-4">
                    <tr>
                      <th>Employee</th>
                      <th>CWK ID</th>
                      <th>Section</th>
                      <th>Date</th>
                      <th>Signature</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php while ($row_sign = mysqli_fetch_assoc($result_signatures)) { ?>
                      <tr>
                        <td>
                          <div class="d-flex align-items-center">
                            <div class="">
                              <h6 class="fs-4 fw-semibold mb-0"><?php echo htmlspecialchars($row_sign['name']); ?></h6>
                              <span class="fw-normal"><?php echo htmlspecialchars($row_sign['berkeley_id']); ?></span>
                            </div>
                          </div>
                        </td>
                        <td>
                          <p class="mb-0 fw-normal fs-4"><?php echo htmlspecialchars($row_sign['cwk_id'] ?? 'N/A'); ?></p>
                        </td>
                        <td>
                          <p class="mb-0 fw-normal fs-4"><?php echo htmlspecialchars($row_sign['section']); ?></p>
                        </td>
                        <td>
                          <p class="mb-0 fw-normal fs-4">
                            <?php echo date('Y-m-d H:i', strtotime($row_sign['sign_date'])); ?></p>
                        </td>
                        <td>
                          <img src="uploads/<?php echo htmlspecialchars($row_sign['signature_image']); ?>" alt="Signature"
                            style="max-width: 150px; max-height: 50px;">
                        </td>
                        <td>
                          <a href="delete_signature.php?id=<?php echo $row_sign['id']; ?>" class="text-danger">
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
      <?php include("search.php"); ?>
    </div>
    <div class="dark-transparent sidebartoggler"></div>
  </div>

  <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/libs/simplebar/dist/simplebar.min.js"></script>
  <script src="assets/js/theme/app.init.js"></script>
  <script src="assets/js/theme/theme.js"></script>
  <script src="assets/js/theme/app.min.js"></script>
  <script src="assets/js/theme/sidebarmenu-default.js"></script>
  <script src="npm/iconify-icon%401.0.8/dist/iconify-icon.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
  <script>
    // Employee lookup with duplicate check
    document.getElementById("berkeleyID").addEventListener("blur", function () {
      let berkeleyID = this.value.trim();
      let warning = document.getElementById("berkeleyWarning");
      let duplicateWarning = document.getElementById("duplicateWarning");
      let fullNameField = document.getElementById("fullName");
      let cwkIDField = document.getElementById("cwkID");
      let sectionField = document.getElementById("section");

      if (berkeleyID !== "") {
        fetch("get_employee.php?bid=" + encodeURIComponent(berkeleyID))
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              // Check if employee has already signed today
              fetch("check_duplicate.php?bid=" + encodeURIComponent(berkeleyID))
                .then(response => response.json())
                .then(duplicateData => {
                  if (duplicateData.exists) {
                    fullNameField.value = data.name;
                    cwkIDField.value = data.cwk_id;
                    sectionField.value = data.section;
                    warning.style.display = "none";
                    duplicateWarning.style.display = "block";
                  } else {
                    fullNameField.value = data.name;
                    cwkIDField.value = data.cwk_id;
                    sectionField.value = data.section;
                    warning.style.display = "none";
                    duplicateWarning.style.display = "none";
                  }
                })
                .catch(error => console.error("Error checking duplicate:", error));
            } else {
              fullNameField.value = "";
              cwkIDField.value = "";
              sectionField.value = "";
              warning.style.display = "block";
              duplicateWarning.style.display = "none";
            }
          })
          .catch(error => console.error("Error:", error));
      } else {
        fullNameField.value = "";
        cwkIDField.value = "";
        sectionField.value = "";
        warning.style.display = "none";
        duplicateWarning.style.display = "none";
      }
    });

    // Signature Pad Implementation
    document.addEventListener('DOMContentLoaded', function () {
      const canvas = document.getElementById("signature-canvas");
      const ctx = canvas.getContext("2d");
      let drawing = false;
      let points = [];
      let currentStroke = [];

      // Set canvas size
      function resizeCanvas() {
        const container = canvas.parentElement;
        canvas.width = container.offsetWidth;
        canvas.height = 300;
        redrawSignature();
      }

      // Redraw all strokes
      function redrawSignature() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.strokeStyle = "#000";
        ctx.lineWidth = 2;
        ctx.lineCap = "round";
        ctx.lineJoin = "round";

        points.forEach(stroke => {
          if (stroke.length < 2) return;

          ctx.beginPath();
          ctx.moveTo(stroke[0].x, stroke[0].y);

          for (let i = 1; i < stroke.length; i++) {
            ctx.lineTo(stroke[i].x, stroke[i].y);
          }

          ctx.stroke();
        });
      }

      // Start drawing
      function startDrawing(e) {
        drawing = true;
        const pos = getPosition(e);
        currentStroke = [{ x: pos.x, y: pos.y }];
        points.push(currentStroke);
        redrawSignature();
      }

      // Continue drawing
      function draw(e) {
        if (!drawing) return;

        const pos = getPosition(e);
        currentStroke.push({ x: pos.x, y: pos.y });
        redrawSignature();
      }

      // Stop drawing
      function stopDrawing() {
        drawing = false;
        updateSignatureData();
      }

      // Get mouse/touch position
      function getPosition(e) {
        const rect = canvas.getBoundingClientRect();
        const clientX = e.clientX || (e.touches && e.touches[0].clientX);
        const clientY = e.clientY || (e.touches && e.touches[0].clientY);

        return {
          x: clientX - rect.left,
          y: clientY - rect.top
        };
      }

      // Update hidden input with signature data
      function updateSignatureData() {
        if (points.length > 0) {
          document.getElementById("signatureData").value = canvas.toDataURL();
        } else {
          document.getElementById("signatureData").value = "";
        }
      }

      // Clear signature
      document.getElementById("clear-signature").addEventListener("click", function () {
        points = [];
        redrawSignature();
        updateSignatureData();
      });

      // Undo last stroke
      document.getElementById("undo-signature").addEventListener("click", function () {
        if (points.length > 0) {
          points.pop();
          redrawSignature();
          updateSignatureData();
        }
      });

      // Form submission validation
      document.getElementById("signForm").addEventListener("submit", function (e) {
        if (points.length === 0) {
          alert("Please provide your signature");
          e.preventDefault();
        }
        
        // Also prevent submission if duplicate warning is shown
        if (document.getElementById("duplicateWarning").style.display === "block") {
          alert("This employee has already signed today!");
          e.preventDefault();
        }
      });

      // Reset form
      document.getElementById("resetForm").addEventListener("click", function () {
        points = [];
        redrawSignature();
        updateSignatureData();
      });

      // Export to Word
      document.getElementById("exportWord").addEventListener("click", function () {
        // Create HTML content for Word document
        let htmlContent = `
          <html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word" xmlns="http://www.w3.org/TR/REC-html40">
          <head>
            <title>Staff Signatures Report</title>
            <meta charset="UTF-8">
            <style>
              body { font-family: Arial, sans-serif; }
              table { border-collapse: collapse; width: 100%; }
              th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
              th { background-color: #f2f2f2; }
              img { max-width: 150px; max-height: 50px; }
            </style>
          </head>
          <body>
            <h1>Staff Signatures Report - ${new Date().toLocaleDateString()}</h1>
            <table>
              <tr>
                <th>Name</th>
                <th>Berkeley ID</th>
                <th>CWK ID</th>
                <th>Section</th>
                <th>Signature</th>
              </tr>
        `;

        // Add table rows
        document.querySelectorAll("#signatureTable tbody tr").forEach(row => {
          const name = row.querySelector("h6").textContent;
          const berkeleyId = row.querySelector("span").textContent;
          const cwkId = row.querySelector("td:nth-child(2) p").textContent;
          const section = row.querySelector("td:nth-child(3) p").textContent;
          const signatureImg = row.querySelector("img").getAttribute("src");

          htmlContent += `
            <tr>
              <td>${name}</td>
              <td>${berkeleyId}</td>
              <td>${cwkId}</td>
              <td>${section}</td>
              <td><img src="${signatureImg}" alt="Signature"></td>
            </tr>
          `;
        });

        htmlContent += `
            </table>
          </body>
          </html>
        `;

        // Create Blob and download
        const blob = new Blob([htmlContent], { type: "application/msword" });
        saveAs(blob, `Staff_Signatures_${new Date().toISOString().slice(0,10)}.doc`);
      });// Export to Word with embedded images
      document.getElementById("exportWord").addEventListener("click", function() {
        // Create HTML content for Word document
        let htmlContent = `
          <html xmlns:o="urn:schemas-microsoft-com:office:office" 
                xmlns:w="urn:schemas-microsoft-com:office:word" 
                xmlns="http://www.w3.org/TR/REC-html40">
          <head>
            <title>Staff Signatures Report</title>
            <meta charset="UTF-8">
            <style>
              body { font-family: Arial, sans-serif; margin: 20px; }
              table { border-collapse: collapse; width: 100%; margin-top: 20px; }
              th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
              th { background-color: #f2f2f2; }
              img { max-width: 200px; max-height: 80px; }
              h1 { color: #2c3e50; text-align: center; }
              .header { margin-bottom: 30px; }
            </style>
          </head>
          <body>
            <div class="header">
              <h1>Staff Signatures Report</h1>
              <p>Generated on: ${new Date().toLocaleString()}</p>
            </div>
            <table>
              <tr>
                <th>Name</th>
                <th>Berkeley ID</th>
                <th>CWK ID</th>
                <th>Section</th>
                <th>Signature</th>
              </tr>
        `;

        // Add table rows with embedded images
        <?php foreach ($export_data as $row): ?>
          <?php 
          $image_path = 'uploads/' . htmlspecialchars($row['signature_image']);
          $image_data = file_get_contents($image_path);
          $base64_image = base64_encode($image_data);
          ?>
          htmlContent += `
            <tr>
              <td><?php echo htmlspecialchars($row['name']); ?></td>
              <td><?php echo htmlspecialchars($row['berkeley_id']); ?></td>
              <td><?php echo htmlspecialchars($row['cwk_id'] ?? 'N/A'); ?></td>
              <td><?php echo htmlspecialchars($row['section']); ?></td>
              <td><img src="data:image/png;base64,<?php echo $base64_image; ?>" alt="Signature"></td>
            </tr>
          `;
        <?php endforeach; ?>

        htmlContent += `
            </table>
          </body>
          </html>
        `;

        // Create Blob and download
        const blob = new Blob([htmlContent], { type: "application/msword" });
        const fileName = `Staff_Signatures_<?php echo date('Y-m-d'); ?>.doc`;
        
        // Create download link
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = fileName;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
      });

      // Event listeners
      canvas.addEventListener("mousedown", startDrawing);
      canvas.addEventListener("mousemove", draw);
      canvas.addEventListener("mouseup", stopDrawing);
      canvas.addEventListener("mouseout", stopDrawing);

      // Touch support
      canvas.addEventListener("touchstart", function (e) {
        e.preventDefault();
        startDrawing(e.touches[0]);
      });

      canvas.addEventListener("touchmove", function (e) {
        e.preventDefault();
        draw(e.touches[0]);
      });

      canvas.addEventListener("touchend", stopDrawing);

      // Initial resize
      window.addEventListener("resize", resizeCanvas);
      resizeCanvas();
    });
  </script>
</body>
</html>