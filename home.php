<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ATIÉRA - Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
      background: #f9f9f9;
      font-family: 'Segoe UI', sans-serif;
    }
    .navbar {
      background: #5a0e0e; 
    }
    .navbar-brand {
      font-weight: bold;
      color: gold !important;
      font-size: 1.5rem;
      letter-spacing: 2px;
    }
    .nav-link {
      color: #fff !important;
      transition: 0.3s;
    }
    .nav-link:hover {
      color: gold !important;
    }
    .hero {
      background: url('we.jpg') center/cover no-repeat;
      height: 450px;
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .hero::after {
      content: "";
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(0,0,0,0.5);
    }
    .hero-content {
      position: relative;
      z-index: 2;
      text-align: center;
      color: white;
    }
    .hero-content h1 {
      font-size: 2.5rem;
      font-weight: bold;
      color: gold;
      text-shadow: 2px 2px 8px rgba(0,0,0,0.8);
    }
    .card {
      border-radius: 15px;
      transition: transform 0.2s, box-shadow 0.2s;
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }
    .card h2 {
      font-weight: bold;
    }
    .footer {
      background: #5a0e0e;
      color: white;
      padding: 15px 0;
      text-align: center;
      margin-top: 40px;
    }
  </style>
</head>
<body>


<nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow">
  <div class="container-fluid px-4">
    <a class="navbar-brand d-flex align-items-center" href="index.php">
  <img src="aa.png" alt="" height="50" class="me-2">
  <span class="fw-bold"></span>
</a>

    <ul class="navbar-nav ms-auto">
      <li class="nav-item"><a href="home.php" class="nav-link active">Home</a></li>
      <li class="nav-item"><a href="reservations.php" class="nav-link">Reservations</a></li>
      <li class="nav-item"><a href="restaurant.php" class="nav-link">Restaurant</a></li>
      <li class="nav-item"><a href="housekeeping.php" class="nav-link">Housekeeping</a></li>
      <li class="nav-item"><a href="analytics.php" class="nav-link">Analytics</a></li>
      <li class="nav-item"><a href="frontdesk.php" class="nav-link">Check In</a></li>
    </ul>
  </div>
</nav>

<section class="hero mt-5">
  <div class="hero-content">
    <h1>Hotel & Restaurant</h1>
    <p class="lead">Welcome to ATIÉRA’S</p>
  </div>
</section>


<div class="container mt-5">
  <div class="row">
    <?php
    $totalRooms = $pdo->query("SELECT COUNT(*) FROM rooms")->fetchColumn();
    $reservations = $pdo->query("SELECT COUNT(*) FROM reservations")->fetchColumn();
    ?>
    
   
    <div class="col-md-6 mb-4">
      <div class="card text-center shadow-sm p-4 text-white" style="background: linear-gradient(135deg, #7b1113, #a71d2a);">
        <h5 class="fw-bold">Total Rooms</h5>
        <h2><?= $totalRooms ?></h2>
      </div>
    </div>

   
    <div class="col-md-6 mb-4">
      <div class="card text-center shadow-sm p-4 text-dark" style="background: linear-gradient(135deg, #f9d976, #f39c12);">
        <h5 class="fw-bold">Total Reservations</h5>
        <h2><?= $reservations ?></h2>
      </div>
    </div>
  </div>
</div>

<div class="row mt-4 justify-content-center">
  <?php
  $modules = [
    "Rooms" => ["rooms.php", "linear-gradient(135deg, #7b1113, #a71d2a)", "text-white"], 
    "Restaurant" => ["restaurant.php", "linear-gradient(135deg, #f9d976, #f39c12)", "text-dark"],
  ];
  foreach($modules as $name => $data) {
    $link = $data[0];
    $bg   = $data[1];
    $text = $data[2];
    echo "
      <div class='col-md-3 mb-3'>
        <a href='$link' class='card shadow-sm text-center p-4 text-decoration-none $text' 
           style='background: $bg; border-radius: 12px;'>
          <h5 class='fw-bold'>$name</h5>
        </a>
      </div>";
  }
  ?>
</div>


<div class="footer">
  <p>&copy; 2025 ATIÉRA Hotel & Restaurant. All Rights Reserved.</p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
