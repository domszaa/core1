<?php
include 'db.php';
$message = "";

// Fetch all checked-in guests
$guests = $pdo->query("SELECT guest_name, room_number FROM checkins WHERE status='Checked In'")->fetchAll();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $guest_name = $_POST['guest_name'];
    $checkout_date = $_POST['checkout_date'];

    // Get guest's room number
    $stmt = $pdo->prepare("SELECT room_number FROM checkins WHERE guest_name=? AND status='Checked In'");
    $stmt->execute([$guest_name]);
    $guest = $stmt->fetch();

    if (!$guest) {
        $message = "❌ Guest not found or already checked out.";
    } else {
        $room_number = $guest['room_number'];

        // Update checkin record
        $stmt = $pdo->prepare("UPDATE checkins SET status='Checked Out', checkout_date=? WHERE guest_name=? AND status='Checked In'");
        $stmt->execute([$checkout_date, $guest_name]);

        // Update room status to Available
        $pdo->prepare("UPDATE rooms SET status='Available' WHERE room_number=?")->execute([$room_number]);

        $message = "✅ Guest successfully checked out!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Guest Check-Out</title>
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
      <a href="frontdesk.php" class="hover:text-yellow-400">Front Desk</a>
      <a href="housekeeping.php" class="hover:text-yellow-400">Housekeeping</a>
      <a href="analytics.php" class="hover:text-yellow-400">Analytics</a>
    </nav>
  </div>
</header>

<div class="max-w-lg mx-auto mt-32 bg-white border border-red-900 shadow-xl rounded-lg p-8">
  <h2 class="text-2xl font-bold text-red-900 mb-6 text-center">🛎️ Guest Check-Out</h2>

  <?php if($message): ?>
    <div class="mb-4 text-center font-semibold <?= strpos($message,'✅')!==false?'text-green-600':'text-red-600' ?>">
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
      <label class="block font-semibold text-red-900">Select Guest</label>
      <select name="guest_name" required
              class="w-full border-2 border-yellow-500 focus:border-red-900 focus:ring focus:ring-yellow-200 p-2 rounded-lg">
        <option value="" disabled selected>-- Choose Guest --</option>
        <?php if(!empty($guests)): foreach($guests as $guest): ?>
          <option value="<?= htmlspecialchars($guest['guest_name']) ?>">
            <?= htmlspecialchars($guest['guest_name']) ?> - Room <?= htmlspecialchars($guest['room_number']) ?>
          </option>
        <?php endforeach; else: ?>
          <option disabled>No checked-in guests</option>
        <?php endif; ?>
      </select>
    </div>
    <div>
      <label class="block font-semibold text-red-900">Check-Out Date</label>
      <input type="date" name="checkout_date" required
             class="w-full border-2 border-yellow-500 focus:border-red-900 focus:ring focus:ring-yellow-200 p-2 rounded-lg">
    </div>
    <button type="submit"
            class="w-full bg-yellow-500 hover:bg-yellow-600 text-black font-bold px-6 py-3 rounded-lg shadow-md transition">
      ✅ Check Out Guest
    </button>
  </form>
</div>

<footer class="bg-red-900 text-white py-4 mt-16 text-center">
  &copy; 2025 Your Hotel. All rights reserved.
</footer>
</body>
</html>
