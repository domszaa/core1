<?php
require 'db.php';
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $task = "Room Cleaning Request"; 
    $requested_by = trim($_POST['requested_by'] ?? '');
    $room_id = (int)($_POST['room_id'] ?? 0);

    if (!$requested_by || !$room_id) {
        $msg = "Please enter your name and select a room.";
    } else {
        $ins = $pdo->prepare("INSERT INTO housekeeping (task, requested_by, status, room_id, created_at) VALUES (?,?,?,?, NOW())");
        $ins->execute([$task, $requested_by, 'Pending', $room_id]);

        $pdo->prepare("UPDATE rooms SET status='Cleaning' WHERE id=?")->execute([$room_id]);
        $msg = "Cleaning request submitted.";
    }
}

if (isset($_GET['done'])) {
    $id = (int)$_GET['done'];
    $pdo->prepare("UPDATE housekeeping SET status='Done' WHERE id=?")->execute([$id]);
    $msg = "Task marked done.";
}

$tasks = $pdo->query("SELECT h.*, r.room_number 
                      FROM housekeeping h 
                      LEFT JOIN rooms r ON r.id = h.room_id 
                      ORDER BY h.id DESC")->fetchAll();

$rooms = $pdo->query("SELECT id, room_number FROM rooms ORDER BY room_number")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Housekeeping - ATIÉRA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #8B0000, #000000);
      min-height: 100vh;
      font-family: Inter, Arial, sans-serif;
      color: #fff;
    }
    .navbar {
      background: rgba(#8B0000;);
      padding: 15px 0;
    }
    .navbar h2 {
      font-weight: bold;
      letter-spacing: 1px;
    }
    .card {
      border-radius: 12px;
      overflow: hidden;
    }
    .card-body {
      background: #fff;
      color: #000;
    }
    .btn-red {
      background-color: #8B0000;
      color: #fff;
    }
    .btn-red:hover {
      background-color: #a80000;
      color: #fff;
    }
    .table-dark th {
      background-color: #8B0000 !important;
    }
  </style>
</head>
<body>

<nav class="navbar shadow">
  <div class="container d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
      <img src="download.png" alt="ATIÉRA Logo" style="height:45px; margin-right:10px;">
      <h2 class="text-white mb-0">Housekeeping</h2>
    </div>
    <a href="home.php" class="btn btn-outline-light">⬅ Back to Home</a>
  </div>
</nav>


<div class="container mt-4">
  <?php if($msg): ?><div class="alert alert-info text-dark fw-bold"><?= htmlspecialchars($msg) ?></div><?php endif; ?>

  <div class="card mb-4 shadow-lg">
    <div class="card-body">
      <h5 class="mb-3 fw-bold text-danger">🧹 Guest Cleaning Request</h5>
      <form method="post" class="row g-2">
        <div class="col-md-4">
          <label class="form-label">Your Name</label>
          <input name="requested_by" class="form-control" placeholder="Guest name" required>
        </div>
        <div class="col-md-3">
          <label class="form-label">Room</label>
          <select name="room_id" class="form-select" required>
            <option value="">Select room</option>
            <?php foreach($rooms as $rm): ?>
              <option value="<?= $rm['id'] ?>"><?= htmlspecialchars($rm['room_number']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-3 d-flex align-items-end">
          <button name="add" class="btn btn-red w-100" type="submit">Request Cleaning</button>
        </div>
      </form>
    </div>
  </div>

  <div class="card shadow-lg">
    <div class="card-body">
      <h5 class="card-title fw-bold text-danger">📋 Task Board</h5>
      <div class="table-responsive">
        <table class="table table-striped align-middle">
          <thead class="table-dark">
            <tr>
              <th>ID</th>
              <th>Task</th>
              <th>Requested By</th>
              <th>Room</th>
              <th>Status</th>
              <th>Created</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if($tasks): foreach($tasks as $t): ?>
              <tr>
                <td><?= $t['id'] ?></td>
                <td><?= htmlspecialchars($t['task']) ?></td>
                <td><?= htmlspecialchars($t['requested_by']) ?></td>
                <td><?= htmlspecialchars($t['room_number']) ?></td>
                <td>
                  <?php if($t['status'] === 'Done'): ?>
                    <span class="badge bg-success">Done</span>
                  <?php else: ?>
                    <span class="badge bg-warning text-dark">Pending</span>
                  <?php endif; ?>
                </td>
                <td><?= $t['created_at'] ?></td>
                <td>
                  <?php if($t['status'] !== 'Done'): ?>
                    <a class="btn btn-sm btn-success" href="?done=<?= $t['id'] ?>" onclick="return confirm('Mark task done?')">Mark Done</a>
                  <?php else: ?> -
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; else: ?>
              <tr><td colspan="7" class="text-muted">No cleaning requests yet.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
