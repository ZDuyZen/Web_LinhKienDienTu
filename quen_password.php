<?php
require 'class/Auth.php';
require 'class/Database.php';
require 'inc/init.php';

$db = new Database();
$pdo = $db->getConnect();
$email = '';
$error = '';
$emailErrors = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    if (empty($email)) {
        $emailErrors = 'email is required';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErrors = 'Email is not valid';
    } else {
        $error = Auth::KT_email($pdo, $email);
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="giaodien.css">
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
    <div class="container text-center d-flex align-items-center min-vh-100">
        <div class="card mx-auto bg-info py-5" style="width: 25rem;">
            <h1>Forget Password</h1>
            <div class="card-body">
                <form method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">Vui Lòng Nhập Email</label>
                        <input class="form-control" id="email" name="email" /> <span class="text-danger fw-bold"><?= $emailErrors ?></span>
                    </div>
                    <button type="submit" class="btn btn-primary" name="login">OK</button>
                </form>
            </div>
            <?php if ($error) : ?>
                <div class="card-footer">
                    <h2 class="text-danger"><?= $error ?></h2>
                </div>
            <?php endif; ?>
        </div>
    </div>



</body>

</html>
