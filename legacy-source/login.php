<?php
session_start();
$login_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Set your own admin credentials here
    $adminUser = "officialajm";
    $adminPass = "Aftab@44416";

    if ($username === $adminUser && $password === $adminPass) {
        $_SESSION['admin'] = true;
        header("Location: admin.php");
        exit();
    } else {
        $login_error = "Invalid username or password.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login - AJM English School</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="unnamed-fotor-bg-remover-20250627142251.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Modern Fonts -->
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
      height: 100%;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .info-box:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    .section-title {
      font-weight: 100;
      margin-top: 7px;
      margin-bottom: 20px;
      text-align: center;
    }

    .navbar {
      background: linear-gradient(to right, #1a2980, #26d0ce);
      transition: background 0.4s ease;
    }

    .navbar .btn {
      transition: all 0.3s ease-in-out;
    }

    .navbar .btn:hover {
      transform: scale(1.06);
      background-color: rgba(255, 255, 255, 1);
      color: black;
    }

    .list-group-item {
      background-color: #fff;
      border-left: 5px solid #0d6efd;
    }

    .navbar-brand {
      font-weight: 600;
      font-size: 1.5rem;
    }

    .announcement-bar {
      font-family: 'Poppins', sans-serif;
      font-weight: 500;
    }

    .scrolling-text {
      display: flex;
      flex-direction: column;
      animation: scroll-up 15s linear infinite;
    }

    .announcement-item {
      padding: 10px 15px;
      font-size: 14px;
      font-weight: 600;
      color: #333;
      border-bottom: 15px solid #eee;
    }

    @keyframes scrollLoop {
      0% { transform: translateY(0); }
      100% { transform: translateY(-50%); }
    }

    @media (max-width: 767px) {
      select.form-select {
        max-width: 100%;
        width: 100%;
        overflow-x: hidden;
        font-size: 15px;
      }

      select.form-select option {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
      }

      .card {
        width: 100%;
      }

      .card-body {
        padding: 1rem;
      }
      .navbar .btn {
        margin-top: 5px;
        width: 100%;
      }

      .info-box {
        padding: 20px;
      }

      .carousel-inner img {
        height: 250px !important;
      }

      .announcement-item {
        font-size: 13px;
      }

      .section-title {
        font-size: 1.3rem;
      }

      .navbar-brand {
        font-size: 1.25rem;
      }
    }
    

  </style>
</head>

<body>
  <!-- Announcement Bar -->
  <div class="py-1 shadow-sm text-dark" style="background: linear-gradient(to right,rgb(255, 233, 125), #f9d423);">
    <div id="announcementCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000" data-bs-pause="false">
      <div class="carousel-inner text-center small fw-semibold">
        <div class="carousel-item active">
          📢 Admissions for 2025–26 are now <strong>OPEN</strong>! Apply before July 30.
        </div>
        <div class="carousel-item">🎓 Congratulations to our Class 10 batch for <strong>100%</strong> board results!</div>
        <div class="carousel-item">📚 "Education is the most powerful weapon you can use to change the world." – Nelson Mandela</div>
        <div class="carousel-item">🏫 Smart classrooms & digital attendance launched for Class 1 to 10!</div>
        <div class="carousel-item">🚫 Admission to Nursery & KG closed for 2025–26 – All seats filled.</div>
      </div>
    </div>
  </div>

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

<!-- Login Card -->
  <div class="container mt-5">
    <div class="card shadow mx-auto" style="max-width: 400px;">
      <div class="card-body">
        <h4 class="text-center mb-4">Admin Login</h4>
        <?php if ($login_error): ?>
          <div class="alert alert-danger"><?= $login_error ?></div>
        <?php endif; ?>
        <form method="POST" action="">
          <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
      </div>
    </div>
  </div>
<br>
<hr>
<br>
  <!-- Mission -->
  <div class="container">
    <h3 class="section-title">🌟 Our Mission</h3>
    <p class="text-center fs-10">To empower students with knowledge, discipline, and confidence to thrive in a dynamic world.</p>
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
    &copy; 2025 AJM English School | Exam Dates Portal
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

