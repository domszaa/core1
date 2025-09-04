<?php 
require 'db.php'; 
$msg = ''; 
$err = ''; 

function isRoomAvailable($pdo, $room_id, $checkin, $checkout) {
    $sql = "SELECT COUNT(*) FROM reservations 
            WHERE room_id = ? 
            AND status = 'Booked' 
            AND NOT ( ? <= checkin OR ? >= checkout )";
    $st = $pdo->prepare($sql);
    $st->execute([$room_id, $checkout, $checkin]);
    return ($st->fetchColumn() == 0);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book'])) {
    $guest_name = trim($_POST['guest_name'] ?? '');
    $room_id = (int)($_POST['room_id'] ?? 0);
    $checkin = $_POST['checkin'] ?? '';
    $checkout = $_POST['checkout'] ?? '';

    if (!$guest_name || !$room_id || !$checkin || !$checkout) {
        $err = "Please fill all fields.";
    } elseif ($checkin >= $checkout) {
        $err = "Check-out must be after check-in.";
    } else {
        if (!isRoomAvailable($pdo, $room_id, $checkin, $checkout)) {
            $err = "Selected room is already booked for the chosen dates.";
        } else {
            $ins = $pdo->prepare("INSERT INTO reservations 
                (guest_name, room_id, checkin, checkout, status, created_at) 
                VALUES (?,?,?,?, 'Booked', NOW())");
            $ins->execute([$guest_name, $room_id, $checkin, $checkout]);

            $pdo->prepare("UPDATE rooms SET status='Occupied' WHERE id=?")->execute([$room_id]);
            $msg = "Reservation created successfully.";
        }
    }
}

$roomsForSelect = $pdo->query("SELECT id, room_number, type, status FROM rooms ORDER BY room_number")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Reservations - ATIÉRA</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  body {
    background: linear-gradient(to right, #8B0000, #000000);
    font-family: Inter, Arial, sans-serif;
    min-height: 100vh;
  }
  .container { max-width: 1000px; margin-top: 40px; }

  .card-custom {
    border-radius: 16px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.25);
    background: #ffffff;
    color: #333;
  }
  .card-custom h5, 
  .card-custom label { color: #000; }

  .btn-red {
    background-color: #8B0000;
    color: #fff;
    font-weight: 600;
    border: none;
  }
  .btn-red:hover {
    background-color: #a80000;
    color: #fff;
  }
</style>
</head>
<body>
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center">
      <img src="download.png" alt="ATIÉRA Logo" style="height:50px; margin-right:12px;">
      <h2 class="fw-bold text-white mb-0">Reservations & Booking</h2>
    </div>
    <a href="home.php" class="btn btn-outline-light">⬅ Back</a>
  </div>

  <?php if($msg): ?>
    <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
  <?php endif; ?>

  <?php if($err): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div>
  <?php endif; ?>

  <div class="card card-custom mb-4 p-4">
    <div class="card-body">
      <form method="post" class="row g-3">
        <div class="col-md-4">
          <label class="form-label">Guest Name</label>
          <input name="guest_name" class="form-control" placeholder="Full name" required>
        </div>
        <div class="col-md-4">
          <label class="form-label">Room</label>
          <select name="room_id" class="form-select" required>
            <option value="">-- Select room --</option>
            <?php foreach($roomsForSelect as $r): ?>
              <option value="<?= $r['id'] ?>">
                <?= htmlspecialchars($r['room_number'] . " — " . $r['type'] . " (" . $r['status'] . ")") ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label">Check-in</label>
          <input type="date" name="checkin" class="form-control" required>
        </div>
        <div class="col-md-2">
          <label class="form-label">Check-out</label>
          <input type="date" name="checkout" class="form-control" required>
        </div>
        <div class="col-12 text-end">
          <button class="btn btn-red px-4" name="book" type="submit">Book Now</button>
        </div>
      </form>
      <div class="mt-3 text-muted small fst-italic">
        ⚠️ System automatically prevents overlapping bookings for the same room.
      </div>
    </div>
  </div>
</div>
</body>
</html>
