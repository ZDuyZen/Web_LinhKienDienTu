<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "phpmailer/src/Exception.php";

require "phpmailer/src/PHPMailer.php";

require "phpmailer/src/SMTP.php";

if (isset($_POST["send"])) {
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = "mia3.sinhvien@gmail.com"; // Tài khoản gmail tại đây
    $mail->Password = "fytdgxctyhnxkojo"; // Pass here
    $mail->SMTPSecure = "ssl";
    $mail->Port = 465;

    $mail->setFrom("mia3.sinhvien@gmail.com");  // Tài khoản gmail tại đây
    $mail->addAddress($_POST["email"]);

    $mail->isHTML(true);

    $mail->Subject = $_POST["subject"];
    $mail->Body = $_POST["message"];

    try {
        $mail->send();

        echo "
        <script>
            alert('SUCCESSFUL! Tin nhắn đã được gửi.');
            document.location.href = 'GUI_LienHe.php';
        </script>
        ";
    } catch (Exception $e) {
        echo "
        <script>
            alert('ERROR: Có lỗi xảy ra trong quá trình gửi email. Vui lòng thử lại sau.');
            document.location.href = 'GUI_LienHe.php';
        </script>
        ";
    }
}

?>
