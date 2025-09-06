<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Front Desk & Reception | ATIÉRA</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body class="bg-white m-0">
  
<header class="bg-red-900 text-white shadow-md fixed w-full top-0 z-50">
  <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
    <div class="flex items-center space-x-2">
      <img src="aa.png" alt="ATIÉRA Logo" class="h-14 w-auto"> 
    </div>
    <nav class="space-x-6 font-semibold">
      <a href="home.php" class="text-white hover:text-yellow-500">Home</a>
      <a href="reservations.php" class="text-white hover:text-yellow-500">Reservation</a>
      <a href="restaurant.php" class="text-white hover:text-yellow-500">Dine</a>
      <a href="housekeeping.php" class="text-white hover:text-yellow-500">Housekeeping</a>
      <a href="analytics.php" class="text-white hover:text-yellow-500">Analytics</a>
    </nav>
  </div>
</header>


<section class="relative bg-cover bg-center h-screen flex items-center justify-center" 
  style="background-image: url('tay.jpg');">
  <div class="absolute inset-0 bg-black bg-opacity-50"></div>

  <div class="relative z-10 flex flex-col items-center text-center text-white px-6">

<h1 class="text-3xl md:text-4xl font-bold tracking-wide text-center mt-20 mb-6">
  <span class="text-yellow-400">FRONT DESK</span> 
  <span class="text-yellow-400">& RECEPTION</span>
</h1>



<p class="text-sm md:text-base mb-8 max-w-2xl text-white">
      "We’re here to make every check-in a warm welcome."
    </p>
    
    <div class="flex flex-col md:flex-row items-center justify-center gap-4">
      <a href="checkin.php" class="bg-yellow-500 hover:bg-yellow-600 text-black px-8 py-3 rounded-full text-lg font-medium shadow-lg transition">
        🛎️ Guest Check-In
      </a>
      <a href="checkout.php" class="bg-yellow-500 hover:bg-yellow-600 text-black px-8 py-3 rounded-full text-lg font-medium shadow-lg transition">
        🚪 Guest Check-Out
      </a>
    </div>

  </div>
</section>


<!-- FOOTER -->
<footer class="bg-red-900 text-white py-8">
  <div class="max-w-7xl mx-auto px-6 text-center space-y-3">
    
    <p>123 Bestlink College, Philippines</p>
    <p>📞 +63 912 345 6789 | ✉️ contact@atiera.com</p>

    <!-- Divider -->
    <div class="border-t border-red-700 my-4"></div>

    <!-- Copyright -->
    <p class="text-sm">&copy; 2025 ATIÉRA Hotel. All Rights Reserved.</p>

    <!-- Social Media (Optional) -->
    <div class="flex justify-center space-x-4 mt-2">
      <a href="#" class="hover:text-yellow-400">Facebook</a>
      <a href="#" class="hover:text-yellow-400">Instagram</a>
      <a href="#" class="hover:text-yellow-400">Twitter</a>
    </div>

  </div>
</footer>

</body>
</html>
