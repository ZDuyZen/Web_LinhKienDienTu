<?php
require 'class/Auth.php';
require 'class/Database.php';
require 'inc/init.php';

$db = new Database();
$pdo = $db->getConnect();

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $error = Auth::login($pdo, $username, $password);
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Đăng Nhập</title>
  <style>
    body {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      font-family: Arial, sans-serif;
    }

    .container {
      width: 400px;
      padding: 40px;
      background-color: #f0f0f0;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .container h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
    }

    .form-group input {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .form-group button[type="submit"] {
      background-color: #0066b3;
      height: 60px;
      width: 420px;
      font-size: 15px;
      color: white;
      cursor: pointer;
    }
  </style>
</head>

<body>
  <div class="container">
    <h2>Đăng nhập</h2>
    <form method="post">
      <div class="form-group">
        <label for="username">User name:</label>
        <input type="text" id="username" name="username" required>
      </div>
      <div class="form-group">
        <label for="login-password">Mật khẩu:</label>
        <input type="password" id="password" name="password" required>
      </div>
      <div class="form-group">
        <button type="submit" name="login">Login</button>
      </div>
    </form>
    <?php if ($error) : ?>
      <div class="card-footer">
        <p class="text-danger"><?= $error ?></p>
      </div>
    <?php endif; ?>
  </div>
</body>

</html>
