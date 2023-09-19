<?php

require 'class/San_pham.php';
require 'class/Auth.php';
require 'class/Database.php';
require 'class/Cart.php';
require 'inc/init.php';
$db = new Database();
$pdo = $db->getConnect();
if (!isset($_SESSION['log_detail'])) {
    header('location: login.php');
    exit;
}
$data = gio_hang::getAllgio_hang_thanhtoan($pdo);
if (!$data) {
    header('location: index.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $sql = "UPDATE `gio_hang` SET `gio_hang_soluong`= :gio_hang_soluong WHERE `gio_hang_id` = :gio_hang_id AND `gio_hang_name`=:gio_hang_name";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':gio_hang_soluong', $_GET['qty'], PDO::PARAM_INT);
    $stmt->bindParam(':gio_hang_id',  $_GET['id'], PDO::PARAM_INT);
    $stmt->bindParam(':gio_hang_name', $_GET['name'], PDO::PARAM_STR);
    if ($stmt->execute()) {
    } else {
        $error = $stmt->errorInfo();
        var_dump($error);
    }
}


?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width" />
    <title>Test</title>
    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" />
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <link rel="stylesheet" href="giaodien.css">

</head>

<body>
    <div class="text-center">
        <!-- NAVIGATION -->
        <div class="row" style="height: 100px;">
            <div class="col-4 mt-2">
                <a href="index.php">
                    <img src="images/logo/logo.png" width="70%" class="rounded" />
                </a>
            </div>
            <div class="col-4 mt-4">
                <form method="POST" action="index.php">
                    <input class="form-control mx-auto" type="search" placeholder="search here" aria-label="search" name="search">
                </form>
            </div>
            <div class="col-1 mt-3">
                <form method="POST" action="index.php">
                    <button class="btn btn-link" type="submit" name="submit_search">
                        <img src="images/icon_search/tim.png" width="50%" class="rounded" />
                    </button>
                </form>
            </div>
            <div class="col-3">
                <a class="btn btn-link position-relative" href="gio_hang.php">
                    <img src="images/icon_search/cart-trolley-ui-5-svgrepo-com.svg" width="15%" class="rounded" />
                </a>
            </div>
        </div>

        <nav>
            <ul>
                <b>
                    <li>
                        <a style="text-decoration: none" href="index.php">TRANG CHỦ</a>
                    </li>
                </b>
                <b>
                    <li>
                        <a style="text-decoration: none" href="#">GIỚI THIỆU</a>
                    </li>
                </b>
                <b>
                    <li>
                        <a style="text-decoration: none" href="#">HƯỚNG DẪN MUA HÀNG</a>
                    </li>
                </b>
                <b>
                    <li>
                        <a style="text-decoration: none" href="#">GIỎ HÀNG</a>
                    </li>
                </b>
                <b>
                    <li>
                        <a style="text-decoration: none" href="GUI_LienHe.php">LIÊN HỆ</a>
                    </li>
                </b>
                <?php if (!isset($_SESSION['log_detail'])) :  ?>
                    <b>
                        <li>
                            <a style="text-decoration: none" href="register.php">Đăng ký</a>
                        </li>
                    </b>
                    <b>
                        <li>
                            <a style="text-decoration: none" href="login.php">Đăng nhập</a>
                        </li>
                    </b>
                <?php else : ?>
                    <b>
                        <li>
                            <a style="text-decoration: none" href="logout.php">Đăng xuất</a>
                        </li>
                    </b>
                <?php endif; ?>
            </ul>
        </nav>

        <!-- CONTAIN -->
        <div class="row">
            <div class="col-12">
                <h2 align="center">Thanh toán</h2>
            </div>

            <table class="table table-primary">

                <thead class="table-light">
                    <tr class="text-center">
                        <th>STT</th>
                        <th>Tên</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                    </tr>
                </thead>
                <tbody style="text-align: center;">
                    <?php $i = 1;
                    $total = 0; ?>
                    <?php foreach ($data as $product) : ?>
                        <form method="get">
                            <tr>
                                <td>
                                    <input type="hidden" name="id" value="<?= $product->gio_hang_id ?>" />
                                    <?= $i ?>

                                </td>
                                <td><a><?= $product->gio_hang_name ?></a>
                                    <input type="hidden" name="proName" value="<?= $product->gio_hang_name ?>" />
                                </td>
                                <td><?= number_format($product->gio_hang_gia, 0, ',', '.') ?> VNĐ</td>
                                <td>
                                    <?= $product->gio_hang_soluong ?>
                                </td>

                            </tr>
                        </form>
                        <?php $i++;
                        $total += $product->gio_hang_gia * $product->gio_hang_soluong; ?>
                    <?php endforeach; ?>

                    <tr>
                        <td colspan="5" class="text-center">
                            <h4>Total: <?= number_format($total, 0, ',', '.') ?> VNĐ</h4>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!--Footer-->
        <footer class="footer">
            <div class="contact-info">
                <b>
                    <p style="font-size: 20px; margin: 0; padding-left: -70px;">THÔNG TIN LIÊN HỆ : </p>
                </b>
                <p style="font-size: 15px; margin: 0; padding-left: -70px">Địa chỉ: 140 Lê Trọng Tấn, Phường Tây Thạnh, Quận Tân Phú, TP.HCM</p>
                <p style="font-size: 15px; margin: 0; padding-left: -70px">Điện thoại: <b>0123456789</b></p>
                <p style="font-size: 15px; margin: 0; padding-left: -70px">Email: info@email.com</p>
                <p style="font-size: 15px; margin: 0; padding-left: -70px">&copy; 2023 Bán linh kiện điện tử máy tính</p>
            </div>
            <div class="map">
                <b>
                    <p style="font-size: 20px; margin: 0; padding-left: -50px;">TÌM CỬA HÀNG : </p>
                </b>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.0624766960423!2d106.62628677475213!3d10.806526989344096!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752be2853ce7cd%3A0x4111b3b3c2aca14a!2zMTQwIEzDqiBUcuG7jW5nIFThuqVuLCBTxqFuIEvhu7MsIFTDom4gUGjDuiwgVGjDoG5oIHBo4buRIEjhu5MgQ2jDrSBNaW5oLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1684506220468!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
    </div>
    </footer>
</body>

</html>
