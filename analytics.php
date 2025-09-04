<?php
require 'db.php';

$totalRooms = (int)$pdo->query("SELECT COUNT(*) FROM rooms")->fetchColumn();
$available = (int)$pdo->query("SELECT COUNT(*) FROM rooms WHERE status='Available'")->fetchColumn();
$occupied = (int)$pdo->query("SELECT COUNT(*) FROM rooms WHERE status='Occupied'")->fetchColumn();
$reservationsCount = (int)$pdo->query("SELECT COUNT(*) FROM reservations WHERE status='Booked'")->fetchColumn();
$hkPending = (int)$pdo->query("SELECT COUNT(*) FROM housekeeping WHERE status='Pending'")->fetchColumn();

$labels = [];
$data = [];
for ($i=13;$i>=0;$i--){
    $day = date('Y-m-d', strtotime("-$i days"));
    $labels[] = $day;
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM reservations WHERE DATE(created_at)=?");
    $stmt->execute([$day]);
    $data[] = (int)$stmt->fetchColumn();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Analytics - ATIÉRA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      min-height: 100vh;
      background: linear-gradient(to bottom right, #8B0000, #000);
      font-family: 'Inter', Arial, sans-serif;
      color: #fff;
    }
    h2, h5, h6 {
      color: #fff;
    }
    .card {
      background: #fff;
      border-radius: 12px;
      border-top: 5px solid #8B0000;
    }
    .card h5, .card h6 {
      color: #8B0000;
      font-weight: 700;
    }
    .stat-value {
      font-size: 1.8rem;
      font-weight: bold;
      color: #000;
    }
    .btn-outline-secondary {
      border-color: #fff;
      color: #fff;
    }
    .btn-outline-secondary:hover {
      background-color: #8B0000;
      border-color: #8B0000;
      color: #fff;
    }
  </style>
</head>
<body>
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-start mb-3">
    
    <div class="d-flex align-items-center">
      <img src="download.png" alt="ATIÉRA Logo" style="height:50px; margin-right:10px;">
      <h2 class="mb-0">Analytics & Reporting</h2>
    </div>
    <a href="home.php" class="btn btn-outline-secondary">⬅ Back</a>
  </div>


  <div class="row g-3 mb-3">
    <div class="col-md-3">
      <div class="card p-3 text-center">
        <div class="text-muted small">Total Rooms</div>
        <div class="stat-value"><?= $totalRooms ?></div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card p-3 text-center">
        <div class="text-muted small">Available</div>
        <div class="stat-value text-success"><?= $available ?></div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card p-3 text-center">
        <div class="text-muted small">Occupied</div>
        <div class="stat-value text-danger"><?= $occupied ?></div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card p-3 text-center">
        <div class="text-muted small">Active Reservations</div>
        <div class="stat-value text-primary"><?= $reservationsCount ?></div>
      </div>
    </div>
  </div>

  <div class="row g-3">
    <div class="col-md-6">
      <div class="card p-3">
        <h5>Reservations — last 14 days</h5>
        <canvas id="resChart" height="180"></canvas>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card p-3">
        <h5>Occupancy</h5>
        <canvas id="occChart" height="180"></canvas>
        <div class="mt-2 text-muted small">Occupied vs Available</div>
      </div>
    </div>
  </div>

  <div class="card mt-3 p-3">
    <h6>Housekeeping Pending</h6>
    <p class="mb-0"><?= $hkPending ?> pending tasks</p>
  </div>
</div>

<script>
const labels = <?= json_encode($labels) ?>;
const data = <?= json_encode($data) ?>;
new Chart(document.getElementById('resChart'), {
  type: 'bar',
  data: {
    labels: labels,
    datasets: [{
      label: 'Reservations',
      data: data,
      backgroundColor: 'rgba(139,0,0,0.8)'
    }]
  },
  options: { responsive:true, scales: { y: { beginAtZero:true } } }
});

new Chart(document.getElementById('occChart'), {
  type: 'doughnut',
  data: {
    labels: ['Occupied','Available'],
    datasets: [{
      data: [<?= $occupied ?>, <?= max(0,$available) ?>],
      backgroundColor: ['#dc3545','#198754']
    }]
  },
  options: { responsive:true }
});
</script>
</body>
</html>
