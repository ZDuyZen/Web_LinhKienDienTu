<?php
require 'class/Database.php';
require 'class/San_pham.php';
require 'inc/init.php';
require 'class/Cart.php';
require 'class/Danh_muc.php';

$db = new Database();
//Phân trang
$pdo = $db->getConnect();
$product_per_page = 8;
$tong = ceil(count(San_pham::getAll($pdo)));
$tongtrang = $tong / $product_per_page;
$page = $_GET['page'] ?? 1;
if ($page <= 0) {
  $page = 1;
}
if ($page > $tongtrang) {
  $page = $tongtrang;
}
$limit = $product_per_page;
$offset = ($page - 1) * $product_per_page;
//search,type nếu ko có thì lấy toàn bộ sản phẩm ngược lại thì lấy theo tên sản phẩm tìm kiếm,type
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $search = $_POST['search'];
  $data = San_pham::getdatasearch($pdo, $search);
  $tong = ceil(count($data));
  $tongtrang = $tong / $product_per_page;
} else if (isset($_GET['type'])) {
  $type = $_GET['type'];
  $data = San_pham::getdatatype($pdo, $type);
  $tong = ceil(count($data));
  $tongtrang = $tong / $product_per_page;
} else {
  $data = San_pham::getPage($pdo, $limit, $offset);
}


//Danh mục id
$danhmuc = Danh_muc::getAll($pdo);


//Cart
if (isset($_GET['action']) && isset($_GET['proid'])) {
  if (!isset($_SESSION['log_detail'])) {
    header('location:index.php');
  } else {
    gio_hang::addgio_hang($pdo, $data);
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
            <a style="text-decoration: none" href="#">LIÊN HỆ</a>
          </li>
        </b>
        <?php if (!isset($_SESSION['log_detail'])) :  ?>
          <b>
            <li>
              <a style="text-decoration: none" href="register.php">ĐĂNG KÝ</a>
            </li>
          </b>
          <b>
            <li>
              <a style="text-decoration: none" href="login.php">ĐĂNG NHẬP</a>
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
        <div class="row">
          <div class="col">
            <div id="carouselExampleControls" class="carousel w-100 mx-auto mt-3" data-ride="carousel">
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img src="images/banner/banner3.webp" class="d-block w-100 " alt="Ảnh 1" style="max-width: 1400px; max-height: 300px" />
                </div>
                <div class="carousel-item">
                  <img src="images/banner/banner2.webp" class="d-block w-100" alt="Ảnh 2" style="max-width: 1400px; max-height: 300px" />
                </div>
                <div class="carousel-item">
                  <img src="images/banner/banner1.jpg" class="d-block w-100 " alt="Ảnh 3" style="max-width: 1400px; max-height: 300px" />
                </div>
              </div>
              <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>
          </div>
        </div>


        <div class="row" style="margin-bottom: 10px;">
          <div class="col-12">
            <h2 style="color:black">SẢN PHẨM TIÊU BIỂU</h2>
          </div>

          <div class="col-12" style="">
            <?php if ($data) : ?>


              <div id="content" class="row row-cols-1 row-cols-md-4 g-4 md-5">
                <?php foreach ($data as $value) : ?>
                  <div class="col-3" style="margin-bottom: 20px;">
                    <div class="card" style="height: 450px; width: 100%">
                      <img src="images/product/<?= $value->sp_hinh ?>" class="card-img-top" />
                      <div class="card-body">
                        <h5 class="card-title"><a href="Trang_sanpham.php?id=<?= $value->sp_id ?>"><?= $value->sp_name ?></a></h5>
                        <p class="card-text">Giá: <?= number_format($value->gia, 0, ',', '.') ?> VNĐ</p>
                        <a href="index.php?id=<?= $value->sp_id?>&sl=1&action=add_gio_hang&proid=<?= $value->sp_id ?>" class="btn btn-dark" style="max-width: 100px;">Chọn mua</a>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>

            <?php endif; ?>


          </div>
          <!-- ẩn_hiện thanh phân trang        -->
          <div class="row">
            <div class="col-12">
              <?php if ($data != null) : ?>
                <nav aria-label="Page navigation example" style="margin-left: 400px;">
                  <ul class="pagination">
                    <?php
                    if ($page > 1 && $tongtrang > 1) {
                      echo ' <li class="page-item"><a class="page-link" href="index.php?page=' . ($page - 1) . '">Prev</a> </li>';
                    }

                    for ($i = 1; $i <= $tongtrang + 1; $i++) {
                      if ($i == $page) {
                        echo ' <li class="page-item"><a class="page-link" style="color:red;"><span">' . $i . '</span></a> </li>';
                      } else {
                        echo ' <li class="page-item"><a class="page-link" href="index.php?page=' . $i . '">' . $i . '</a>  </li>';
                      }
                    }

                    if ($page < $tongtrang && $tongtrang > 1) {
                      echo ' <li class="page-item"><a class="page-link" href="index.php?page=' . ($page + 1) . '">Next</a>  </li>';
                    }
                    ?>
                  </ul>
                </nav>
              <?php else : ?>
                <h2 style="color:white">Không Có Sản Phẩm Này!!!!</h2>
              <?php endif; ?>
            </div>
          </div>
        </div>


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
