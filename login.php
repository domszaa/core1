<?php
session_start();
require "db.php"; 

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    try {
        $stmt = $pdo->prepare("SELECT id, password FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user["password"])) {
            $_SESSION["username"] = $username;
            $_SESSION["user_id"] = $user["id"];
            header("Location: restaurant.php");
            exit();
        } else {
            $error = "❌ Invalid username or password!";
        }
    } catch (PDOException $e) {
        $error = "Database error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - ATIÉRA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #8B0000, #000000);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .login-card {
      width: 100%;
      max-width: 400px;
      border-radius: 15px;
      overflow: hidden;
    }
    .login-header {
      background-color: #8B0000;
      padding: 20px;
      text-align: center;
    }
    .login-header img {
      height: 60px;
      margin-bottom: 10px;
    }
    .login-header h3 {
      color: white;
      font-weight: bold;
      margin: 0;
      font-size: 1.5rem;
      letter-spacing: 2px;
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

  <div class="card shadow-lg login-card">
    <div class="login-header">
      <img src="aa.png" alt=>
    </div>

    <div class="card-body">
      <?php if ($error): ?>
        <div class="alert alert-danger py-2"><?php echo $error; ?></div>
      <?php endif; ?>

      <form method="POST">
        <div class="mb-3">
          <label class="form-label">Username</label>
          <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-red w-100 fw-semibold py-2">Login</button>
      </form>

      <p class="text-center text-muted small mt-3">
        Don’t have an account? <a href="register.php" class="text-danger fw-bold">Register here</a>
      </p>
    </div>
  </div>

</body>
</html>
