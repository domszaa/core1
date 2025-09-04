<?php
session_start();
require "db.php"; 

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);

        if ($stmt->fetch()) {
            $message = "❌ Username already exists!";
        } else {
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            if ($stmt->execute([$username, $password])) {
                $message = "✅ Registration successful! You can now login.";
            } else {
                $message = "❌ Registration failed, try again.";
            }
        }
    } catch (PDOException $e) {
        $message = "Database error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - ATIÉRA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #8B0000, #000000);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .register-card {
      width: 100%;
      max-width: 400px;
      border-radius: 15px;
      overflow: hidden;
    }
    .register-header {
      background-color: #8B0000;
      padding: 20px;
      text-align: center;
    }
    .register-header img {
      height: 60px;
      margin-bottom: 10px;
    }
    .btn-red {
      background-color: #8B0000;
      color: white;
    }
    .btn-red:hover {
      background-color: #a80000;
      color: white;
    }
  </style>
</head>
<body>

  <div class="card shadow-lg register-card">
    <div class="register-header">
      <img src="aa.png" alt="ATIÉRA Logo">
    </div>

    <div class="card-body text-center">
      <?php if ($message): ?>
        <div class="alert alert-info py-2"><?php echo $message; ?></div>
      <?php endif; ?>

      <form method="POST" class="text-start">
        <div class="mb-3">
          <label class="form-label">Username</label>
          <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-red w-100 fw-semibold py-2">Register</button>
      </form>

      <p class="text-center text-muted small mt-3">
        Already have an account? <a href="login.php" class="text-danger fw-bold">Login here</a>
      </p>
    </div>
  </div>

</body>
</html>
