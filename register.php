<?php
$title = 'Register page';
require 'class/Auth.php';
require 'class/Database.php';

$username = '';
$password = '';
$email = '';
$admin = 0;
$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    if (empty($email)) {
        $error = 'email is required';
    }
    if (empty($username)) {
        $error = 'username is required';
    }

    if (empty($password)) {
        $error = 'password is required';
    }

    $db = new Database();
    $pdo = $db->getConnect();
    $error=Auth::KT_trungtenDNvaEmail($pdo,$username,$email);
    if(!$error)
    {
        $passwordhash=Auth::MaHoaMK($password);

        $DangKi = new Auth();
        $DangKi->ten_DN=$username;
        $DangKi->matkhau=$passwordhash;
        $DangKi->admin=$admin;
        $DangKi->email=$email;

    
        if ($DangKi->create_tai_khoan($pdo)) {
            header("Location:login.php");
            exit;
        }
    }
   
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Đăng Ký</title>
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
      <h2>Đăng ký</h2>
      <form action="register.php" method="POST">
        <div class="form-group">
          <label for="username">Tên:</label>
          <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
          <label for="password">Mật khẩu:</label>
          <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
        <button type="submit" class="btn btn-primary" name="login">Đăng Ký</button>
        </div>
      </form>
      <?php if ($error): ?>
            <div class="card-footer">
                <p class="text-danger"><?= $error ?></p>
            </div>
        <?php endif; ?>
  </body>
</html>
