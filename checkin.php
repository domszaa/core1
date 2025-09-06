<?php
include 'db.php';
$message = "";

// Handle check-in form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $guest_name = $_POST['guest_name'];
    $room_number = $_POST['room_number'];
    $checkin_date = $_POST['checkin_date'];

    // Check if room exists and is available
    $stmt = $pdo->prepare("SELECT status FROM rooms WHERE room_number=?");
    $stmt->execute([$room_number]);
    $room = $stmt->fetch();

    if (!$room) {
        $message = "❌ Room not found.";
    } elseif ($room['status'] !== 'Available') {
        $message = "❌ Room is already occupied.";
    } else {
        // Insert check-in
        $sql = "INSERT INTO checkins (guest_name, room_number, checkin_date, status)
                VALUES (:guest_name, :room_number, :checkin_date, 'Checked In')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':guest_name' => $guest_name,
            ':room_number' => $room_number,
            ':checkin_date' => $checkin_date
        ]);

        // Update room status to Occupied
        $pdo->prepare("UPDATE rooms SET status='Occupied' WHERE room_number=?")->execute([$room_number]);

        $message = "✅ Guest successfully checked in!";
    }
}

// Fetch all rooms for dropdown
$rooms = $pdo->query("SELECT room_number FROM rooms WHERE status='Available' ORDER BY room_number")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Guest Check-In</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-white">

<header class="bg-red-900 text-white shadow-md fixed w-full top-0 z-50">
  <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
    <div class="flex items-center space-x-2">
      <img src="aa.png" alt="Logo" class="h-12 w-auto">
      <span class="font-bold text-lg tracking-wide">HOTEL SYSTEM</span>
    </div>
    <nav class="space-x-6 font-semibold">
      <a href="home.php" class="hover:text-yellow-400">Home</a>
      <a href="reservations.php" class="hover:text-yellow-400">Reservation</a>
      <a href="checkout.php" class="hover:text-yellow-400">Check Out</a>
      <a href="housekeeping.php" class="hover:text-yellow-400">Housekeeping</a>
      <a href="analytics.php" class="hover:text-yellow-400">Analytics</a>
    </nav>
  </div>
</header>

<div class="max-w-lg mx-auto mt-32 bg-white border border-red-900 shadow-xl rounded-lg p-8">
  <h2 class="text-2xl font-bold text-red-900 mb-6 text-center">🛎️ Guest Check-In</h2>

  <?php if($message): ?>
    <div class="mb-4 text-center font-semibold <?= strpos($message, '✅')!==false?'text-green-600':'text-red-600' ?>">
      <?= $message ?>
    </div>
  <?php endif; ?>

  <!-- Back Button -->
  <div class="mb-4">
    <a href="index.php" 
       class="inline-block bg-gray-300 hover:bg-gray-400 text-black font-semibold px-4 py-2 rounded-lg shadow-sm transition">
       ⬅ Back
    </a>
  </div>

  <form method="POST" class="space-y-5">
    <div>
      <label class="block font-semibold text-red-900">Guest Name</label>
      <input type="text" name="guest_name" required
             class="w-full border-2 border-yellow-500 focus:border-red-900 focus:ring focus:ring-yellow-200 p-2 rounded-lg">
    </div>
    <div>
      <label class="block font-semibold text-red-900">Room Number</label>
      <select name="room_number" required
              class="w-full border-2 border-yellow-500 focus:border-red-900 focus:ring focus:ring-yellow-200 p-2 rounded-lg">
        <option value="" disabled selected>-- Select Available Room --</option>
        <?php foreach($rooms as $r): ?>
          <option value="<?= htmlspecialchars($r['room_number']) ?>"><?= htmlspecialchars($r['room_number']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div>
      <label class="block font-semibold text-red-900">Check-In Date</label>
      <input type="date" name="checkin_date" required
             class="w-full border-2 border-yellow-500 focus:border-red-900 focus:ring focus:ring-yellow-200 p-2 rounded-lg">
    </div>
    <button type="submit"
            class="w-full bg-yellow-500 hover:bg-yellow-600 text-black font-bold px-6 py-3 rounded-lg shadow-md transition">
      ✅ Check In Guest
    </button>
  </form>
</div>

<footer class="bg-red-900 text-white py-4 mt-16 text-center">
  &copy; 2025 Your Hotel. All rights reserved.
</footer>
</body>
</html>
