<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ATIÉRA - Restaurant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .restaurant-hero {
            background: url('images/restaurant-bg.jpg') no-repeat center center/cover;
            color: black;
            text-align: center;
            padding: 100px 20px;
            border-radius: 10px;
        }
        .restaurant-hero h1 {
            font-size: 3em;
            margin-bottom: 20px;
        }
        .restaurant-sections {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        .restaurant-card {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-align: center;
        }
        .restaurant-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 15px;
        }
        .restaurant-card h3 {
            margin-bottom: 10px;
            color: #6A1B9A;
        }
    </style>
</head>
<body class="bg-light">


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <span class="navbar-brand fw-bold">ATIÉRA</span>
    <ul class="navbar-nav ms-auto">
      <li class="nav-item"><a href="home.php" class="nav-link">Home</a></li>
      <li class="nav-item"><a href="logout.php" class="nav-link text-danger">Logout</a></li>
    </ul>
  </div>
</nav>


<div class="container mt-4">
    <div class="restaurant-hero">
        <h1>Welcome to ATIÉRA Restaurant</h1>
        <p>Fine dining and unforgettable experiences await you</p>
    </div>

   

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
