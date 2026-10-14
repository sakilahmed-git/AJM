<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard – AJM English School</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="unnamed-fotor-bg-remover-20250627142251.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Poppins:wght@600&display=swap" rel="stylesheet">

  <style>
    body {
      background-color: #f5f9ff;
      font-family: 'Inter', sans-serif;
      font-size: 14px;
    }
    h1, h2, h3, h4, .navbar-brand {
      font-family: 'Poppins', sans-serif;
    }
    .info-box {
      padding: 30px;
      background: #ffffff;
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      transition: 0.3s ease;
    }
    .info-box:hover {
      transform: translateY(-4px);
      box-shadow: 0 6px 18px rgba(0,0,0,0.15);
    }
    .navbar {
      background: linear-gradient(to right, #1a2980, #26d0ce);
    }
    .navbar .btn:hover {
      transform: scale(1.05);
      background-color: #fff;
      color: #000;
    }
    .nav-tabs .nav-link.active {
      font-weight: 600;
      border-bottom: 3px solid #1a2980;
    }
  </style>
</head>

<body>

 <!-- Navbar -->
  <nav class="navbar navbar-expand-lg sticky-top shadow">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="index.php" style="color: #f0f0f0;">
        <img src="unnamed-fotor-bg-remover-20250627142251.png" alt="Logo" width="35" style="border-radius: 4px;">
        AJM English School
      </a>
      <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <div class="navbar-nav">
          <a class="btn btn-light me-2" href="index.php">Home</a>
          <a class="btn btn-light me-2" href="exam-dates.php">Exam Dates</a>
          <a class="btn btn-light me-2" href="results.php">Results</a>
          <a class="btn btn-light me-2" href="fees.php">Pay Fees</a>
          <a class="btn btn-light" href="gallery.php">Gallery</a>
        </div>
      </div>
    </div>
  </nav>
<div class="container mt-5">

  <h2 class="text-center mb-4">🔐 Admin Dashboard</h2>

  <ul class="nav nav-tabs" id="adminTabs">
    <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#resultsTab">📊 Results</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#examTab">📅 Exam Dates</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#feesTab">💸 Fees</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#galleryTab">🖼️ Gallery</button></li>
  </ul>

  <div class="tab-content mt-4">

    <!-- RESULTS -->
    <div class="tab-pane fade show active" id="resultsTab">
      <h4>Manage Results</h4>
      <p class="text-muted">Enter or edit marks for any student.</p>

      <a href="admin-select-student.php" class="btn btn-primary">➕ Enter / Edit Results</a>
    </div>

    <!-- EXAM DATES -->
    <div class="tab-pane fade" id="examTab">
      <h4>Manage Exam Dates</h4>
      <p class="text-muted">Enter subjects and exam dates for any class.</p>

      <a href="admin-exam.php" class="btn btn-warning">📅 Enter / Edit Exam Dates</a>
    </div>

    <!-- FEES -->
    <div class="tab-pane fade" id="feesTab">
      <h4>Manage Fees</h4>
      <p class="text-muted">Enter fee dues for any class or student.</p>

      <a href="edit-fees.php" class="btn btn-success">💸 Enter / Edit Fees</a>
    </div>

    <!-- GALLERY -->
    <div class="tab-pane fade" id="galleryTab">
      <h4>Gallery Upload</h4>

      <form action="upload.php" method="POST" enctype="multipart/form-data">
        <input type="file" class="form-control mb-2" name="galleryImage" accept="image/*" required>
        <button class="btn btn-success">Upload Photo</button>
      </form>

      <h6 class="mt-4">Uploaded Images</h6>
      <div class="row">
      <?php
      foreach (glob("uploads/*.{jpg,jpeg,png,webp}", GLOB_BRACE) as $img) {
          $fileName = basename($img);
          echo "
          <div class='col-md-3 mb-3 text-center'>
            <img src='$img' class='img-fluid rounded' style='max-height:150px'><br>
            <form method='POST' action='delete_file.php' onsubmit='return confirm(\"Delete $fileName?\");'>
              <input type='hidden' name='filepath' value='$img'>
              <button class='btn btn-sm btn-outline-danger mt-2'>Delete</button>
            </form>
          </div>";
      }
      ?>
      </div>
    </div>

  </div>
</div>

<!-- Mission Section -->
<div class="container mt-5">
  <h3 class="section-title text-center">🌟 Our Mission</h3>
  <p class="text-center fs-10">
    To empower students with knowledge, discipline, and confidence to thrive in a dynamic world.
  </p>
</div>


  <!-- Info Cards -->
  <div class="container mt-5">
    <div class="row g-4">
      <div class="col-md-4">
        <div class="info-box text-center">
          <h4>📅 Timely Exam Alerts</h4>
          <p>Get notified about upcoming exams and plan your study better with real-time updates.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="info-box text-center">
          <h4>📊 Transparent Results</h4>
          <p>Instant access to your class-wise academic performance, downloadable anytime.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="info-box text-center">
          <h4>💸 Online Fee Status</h4>
          <p>Check fee dues securely and pay online via the portal with simple steps.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-dark text-white text-center py-2 mt-5">
    &copy; 2025 AJM English School | Admin Portal
  </footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
