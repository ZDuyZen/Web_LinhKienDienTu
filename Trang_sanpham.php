<?php
require 'class/Database.php';
require 'class/San_pham.php';
require 'inc/init.php';
require 'class/Cart.php';
require 'class/Danh_muc.php';

$db = new Database();
$pdo = $db->getConnect();


$id = $_GET["id"];

$data = San_pham::getOneByID($pdo, $id);




//Danh mục id
$danhmuc = Danh_muc::getAll($pdo);


//Cart
if (isset($_GET['action']) && isset($_GET['proid'])) {
    if (!isset($_SESSION['log_detail'])) {
        header('location:GUI_DangNhapDangKy.php');
    } else {
        Cart::addCart($pdo, $data);
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

                <b>
                    <li>
                        <a style="text-decoration: none" href="thanhtoan.php">Thanh toán</a>
                    </li>
                </b>
            </ul>
        </nav>
        <!-- CONTAIN -->
        <div class="row">
            <div class="col col-md-2  card">
                <b>
                    <h5 style="padding-top: 22px; padding-bottom: 22px"> MENU CÁC SẢN PHẨM </h5>
                </b>
                <ul class="list-group list-group-flush text-left">


                    <?php foreach ($danhmuc as $value) : ?>

                        <b>
                            <li class="list-group-item">
                                <a href="index.php?type=<?= $value->danh_muc_id ?>" style="text-transform:uppercase; text-decoration:none; color: red"><?= $value->danh_muc_name ?></a>
                            </li>
                        </b>


                    <?php endforeach; ?>
                </ul>



            </div>
            <div class="col col-md-10 main-content" style="background-color:lavender;">




                <div class="row" style="margin-bottom: 10px; margin-top: 10px">


                    <?php if ($data) : ?>
                        <div class="col-12">
                            <div class="row justify-content-between">
                                <div class="col-3">
                                    <img src="images/product/<?= $data->sp_hinh ?>" style="width: 500px; height: 400px" />
                                </div>

                                <div class="col-7" style="font-size: 25px">
                                    <div class="row">
                                        <div class="col-12">
                                            <table class="table" border="0" cellpadding="2" style="border-color: black;">
                                                <tr>
                                                    <td>Mã sản phẩm</td>
                                                    <td><?= $data->sp_id ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Tên sản phẩm</td>
                                                    <td><?= $data->sp_name ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Mô tả</td>
                                                    <td><?= $data->mo_ta ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Giá</td>
                                                    <td><span style="color:red"><?= $data->gia ?> VND</span></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <input type="number" name="quantity" id="quantity" value="1" min="1" max="10">
                                                        <a href="#" onclick="addGioHang()" class="btn btn-dark" style="max-width: 100px;">Chọn mua</a>
                                                    </td>
                                                </tr>
                                            </table>

                                            <script>
                                                var spId = <?= $data->sp_id ?>; // Lưu giá trị sp_id vào biến JavaScript

                                                function addGioHang() {
                                                    var quantity = document.getElementById('quantity').value;
                                                    window.location.href = "index.php?&action=add_gio_hang&proid=" + spId + "&sl=" + quantity;
                                                }
                                            </script>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    <?php endif; ?>



                </div>
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
