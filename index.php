
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hotel Landing Page</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
  <style>
    body {
      margin: 0;
      padding: 0;
    }
  </style>
</head>

<body class="bg-white m-0">
  
  <header class="bg-red-900 text-white shadow-md fixed w-full top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
      <div class="flex items-center space-x-2">
        <img src="aa.png" alt="Logo" class="h-16 w-auto"> 
      </div>
      <nav class="space-x-6 font-semibold">
        <a href="home.php" class="hover:text-yellow-400">Home</a>
        <a href="reservations.php" class="hover:text-yellow-400">Reservation</a>
        <a href="restaurant.php" class="hover:text-yellow-400">Dine</a>
        <a href="housekeeping.php" class="hover:text-yellow-400">Housekeeping</a>
        <a href="analytics.php" class="hover:text-yellow-400">Analytics</a>
      </nav>
    </div>
  </header>


  <section class="relative bg-cover bg-center h-screen flex items-center justify-center" style="background-image: url('we.jpg');">
    <div class="absolute inset-0 bg-black bg-opacity-40"></div>
    <div class="relative z-10 flex flex-col items-center text-center text-white px-6">
      <img src="aa.png" alt="Logo" class="h-32 w-auto mb-6 drop-shadow-lg">
      <p class="text-2xl md:text-3xl font-bold mb-8 text-yellow-400 tracking-wide">
        HOTEL & RESTAURANT
      </p>
      
      <div class="flex space-x-6">
        <a href="https://core1.atierahotelandrestaurant.com class="bg-yellow-500 hover:bg-yellow-600 text-black px-8 py-3 rounded-full text-lg font-medium shadow-lg transition">
          Visit Restaurant
        </a>
        <a href="reservations.php" class="bg-yellow-500 hover:bg-yellow-600 text-black px-8 py-3 rounded-full text-lg font-medium shadow-lg transition">
          Book Now
        </a>
      </div>
    </div>
  </section>


  <footer class="bg-red-900 text-white py-6">
    <div class="max-w-7xl mx-auto text-center">
      <p>&copy; 2025 Your Hotel. All rights reserved.</p>
    </div>
  </footer>
</body>
</html>