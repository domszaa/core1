<?php

$servername = "localhost";
$username = "root";
$password = ""; 
$database = "hotel_system"; 

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$msg = '';
$err = '';


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $event_name = trim($_POST['event_name'] ?? '');
    $event_date = trim($_POST['event_date'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if (!$event_name || !$event_date || !$location || !$description) {
        $err = "Paki-fill lahat ng fields.";
    } else {
        $stmt = $conn->prepare("INSERT INTO events (event_name, event_date, location, description) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $event_name, $event_date, $location, $description);
        $stmt->execute();
        $stmt->close();
        $msg = "Event successfully naidagdag.";
    }
}


if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    $msg = "Event successfully natanggal.";
}


$result = $conn->query("SELECT * FROM events ORDER BY event_date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Event & Conference Management | ATIÉRA</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    background: linear-gradient(to right, #8B0000, #8B0000);
    font-family: 'Inter', Arial, sans-serif;
    min-height: 100vh;
    padding: 20px;
    color: white;
}
.container { max-width: 1100px; }


.card {
    border-radius: 15px;
    background-color: #8B0000;
    color: white;
    margin-bottom: 20px;
    padding: 20px;
}


h2, h5 { font-weight: 700; color: #ffd700; } 


.btn-red { background-color: #8B0000; color: #fff; font-weight: bold; }
.btn-red:hover { background-color: #a80000; color: #fff; }
.btn-gold { background-color: #ffd700; color: #8B0000; font-weight: bold; }
.btn-gold:hover { background-color: #e6c200; color: #7f0d0d; }


input.form-control, textarea.form-control {
    background-color: #fff; 
    color: #000;
    border: 1px solid #ccc;
}


.form-label { color: #ffd700; font-weight: 600; }


.table thead {
    background-color: #8B0000;
}
.table thead th {
    color: #ffd700 !important;
    font-weight: bold;
    text-align: center;
}
.table-striped>tbody>tr:nth-of-type(odd)>* {
    background-color: #fff;
    color: #000;
}
a { color: #ffd700; text-decoration: none; }
a:hover { text-decoration: underline; }
</style>
</head>
<body>
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center">
      <img src="aa.png" alt="ATIÉRA Logo" style="height:40px; margin-right:10px;">
      <h2 class="mb-0">Event & Conference Management</h2>
    </div>
    <a href="home.php" class="btn btn-gold">⬅ Back to Home</a>
  </div>

  <?php if($msg): ?><div class="alert alert-success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
  <?php if($err): ?><div class="alert alert-danger"><?= htmlspecialchars($err) ?></div><?php endif; ?>


  <div class="card">
    <h5 class="card-title">➕ Add New Event</h5>
    <form method="post" class="row g-3">
        <div class="col-md-4">
          <label class="form-label">Event Name</label>
          <input name="event_name" class="form-control" placeholder="Event Name" required>
        </div>
        <div class="col-md-3">
          <label class="form-label">Event Date</label>
          <input type="date" name="event_date" class="form-control" required>
        </div>
        <div class="col-md-3">
          <label class="form-label">Location</label>
          <input name="location" class="form-control" placeholder="Location" required>
        </div>
        <div class="col-md-2">
          <label class="form-label"> </label>
          <button class="btn btn-gold w-100" name="add" type="submit">Add Event</button>
        </div>
        <div class="col-12">
          <label class="form-label">Description</label>
          <textarea name="description" class="form-control" placeholder="Event Description" rows="3" required></textarea>
        </div>
    </form>
  </div>

 
  <div class="card">
    <h5 class="card-title">📋 Event List</h5>
    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle text-center">
        <thead>
          <tr>
            <th>#</th>
            <th>Event Name</th>
            <th>Date</th>
            <th>Location</th>
            <th>Description</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if($result->num_rows): while($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= $row['id'] ?></td>
              <td><?= htmlspecialchars($row['event_name']) ?></td>
              <td><?= $row['event_date'] ?></td>
              <td><?= htmlspecialchars($row['location']) ?></td>
              <td><?= htmlspecialchars($row['description']) ?></td>
              <td>
                <a href="?delete=<?= $row['id'] ?>" class="btn btn-red btn-sm" onclick="return confirm('Delete this event?')">Delete</a>
              </td>
            </tr>
          <?php endwhile; else: ?>
            <tr><td colspan="6" class="text-center text-muted">Walang events na naidagdag.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
