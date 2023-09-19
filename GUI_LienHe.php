<!DOCTYPE html>
<html>
  <head>
    <title>Liên hệ</title>
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

      .form-group input[type="submit"] {
        background-color: #0066b3;
        height: 60px;
        width: 420px;
        font-size: 15px;
        color: white;
        cursor: pointer;
      }

      .toggle-form-link {
        text-align: center;
        margin-top: 20px;
      }

      .toggle-form-link a {
        text-decoration: none;
        color: #999;
      }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  </head>
  <body>
    <div class="container">
      <h2>Form liên hệ</h2>
      <form class="" action="send.php" method="POST">
        <div class="form-group">
          <label for="name">Tên của bạn: </label>
          <input type="text" name="subject" placeholder="Tên">
        </div>
        <div class="form-group">
          <label for="email">Email người nhận:</label>
          <input type="email" name="email" placeholder="Email">
        </div>
        <div class="form-group">
          <label for="message">Vấn đề cần hỗ trợ:</label>
          <textarea id="message" name="message" placeholder="Nội dung"></textarea>
        </div>
        <div class="form-group">
          <input type="submit" name="send" value="Gửi">
        </div>
      </form>
    </div>
  </body>
</html>