<?php
require 'db.php';
$msg = ''; $err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $room_number = trim($_POST['room_number'] ?? '');
    $type = trim($_POST['type'] ?? '');
    $status = 'Available';

    if (!$room_number || !$type) {
        $err = "Please fill all fields.";
    } else {
        $st = $pdo->prepare("INSERT INTO rooms (room_number, type, status) VALUES (?,?,?)");
        $st->execute([$room_number, $type, $status]);
        $msg = "Room added successfully.";
    }
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $pdo->prepare("DELETE FROM rooms WHERE id=?")->execute([$id]);
    $msg = "Room deleted.";
}

$rooms = $pdo->query("SELECT * FROM rooms ORDER BY room_number")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Rooms - ATIÉRA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #8B0000, #000000);
      font-family: Inter, Arial, sans-serif;
      min-height: 100vh;
      padding: 20px;
    }
    .container {
      max-width: 1100px;
    }
    .card {
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(243, 241, 241, 0.15);
    }
    h2, h5 {
      font-weight: 700;
      color: #f6f1f1ff;
    }
    .btn-red {
      background-color: #8B0000;
      color: #fff;
    }
    .btn-red:hover {
      background-color: #a80000;
      color: #fff;
    }
    .table thead {
      background-color: #8B0000;
      color: white;
    }
    .table-striped>tbody>tr:nth-of-type(odd)>* {
      background-color: rgba(250, 246, 246, 0.05);
    }
  </style>
</head>
<body>
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center">
      <img src="download.png" alt="ATIÉRA Logo" style="height:45px; margin-right:10px;">
      <h2 class="mb-0">Rooms Management</h2>
    </div>

    <a href="home.php" class="btn btn-outline-light">⬅ Back to Home</a>
  </div>

  <?php if($msg): ?><div class="alert alert-success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
  <?php if($err): ?><div class="alert alert-danger"><?= htmlspecialchars($err) ?></div><?php endif; ?>

  <div class="card mb-4">
    <div class="card-body">
      <h5 class="card-title">➕ Add New Room</h5>
      <form method="post" class="row g-2">
        <div class="col-md-4">
          <label class="form-label">Room Number</label>
          <input name="room_number" class="form-control" placeholder="e.g. 101" required>
        </div>
        <div class="col-md-4">
          <label class="form-label">Room Type</label>
          <input name="type" class="form-control" placeholder="e.g. Deluxe, Suite" required>
        </div>
        <div class="col-md-4 d-flex align-items-end">
          <button class="btn btn-red w-100 fw-semibold" name="add" type="submit">Add Room</button>
        </div>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <h5 class="card-title">📋 Room List</h5>
      <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
          <thead>
            <tr>
              <th>#</th>
              <th>Room Number</th>
              <th>Type</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if($rooms): foreach($rooms as $room): ?>
              <tr>
                <td><?= $room['id'] ?></td>
                <td><?= htmlspecialchars($room['room_number']) ?></td>
                <td><?= htmlspecialchars($room['type']) ?></td>
                <td>
                  <?php if($room['status']==='Available'): ?>
                    <span class="badge bg-success">Available</span>
                  <?php elseif($room['status']==='Occupied'): ?>
                    <span class="badge bg-warning text-dark">Occupied</span>
                  <?php else: ?>
                    <span class="badge bg-secondary"><?= htmlspecialchars($room['status']) ?></span>
                  <?php endif; ?>
                </td>
                <td>
                  <a href="?delete=<?= $room['id'] ?>" class="btn btn-sm btn-danger"
                     onclick="return confirm('Delete this room?')">Delete</a>
                </td>
              </tr>
            <?php endforeach; else: ?>
              <tr><td colspan="5" class="text-center text-muted">No rooms added yet.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</body>
</html>
