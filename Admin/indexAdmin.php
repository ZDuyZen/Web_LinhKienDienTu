<?php
$title = 'AdminPage';
require '../class/Database.php';
require '../class/San_pham.php';
require '../class/Cart.php';
require '../inc/init.php';
require '../class/Danh_muc.php';

$db = new Database();
$pdo = $db->getConnect();

$tong = ceil(count(San_pham::getAll($pdo)));
$product_per_page = 8;
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

if (isset($_GET['type'])) {
    $type = $_GET['type'];
    $data = San_pham::getdatatype($pdo, $type);
} else {
    $data = San_pham::getPage($pdo, $limit, $offset);
}
if (isset($_GET['action']) && isset($_GET['proid'])) {
    if (!isset($_SESSION['log_detail']))
        header('location:login.php');
}
$danhmuc = Danh_muc::getAll($pdo);

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title><?= $title ?? 'No title' ?></title>
</head>
<style>
    .dropdown-menu {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .dropdown-menu a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown-menu a:hover {
        background-color: #f1f1f1;
    }

    .nav-item:hover .dropdown-menu {
        display: block;
    }
</style>

<body>
    <nav class="navbar navbar-expand" style="background-color: cyan; font-size: 20px;">
        <div class="container">
            <a class="navbar-brand" href="indexAdmin.php">Admin</a>
            <div class="navbar-collapse">
                <ul class="navbar-nav">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Loại sản phẩm
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php foreach ($danhmuc as $value) : ?>

                                <a class="dropdown-item" href="indexAdmin.php?type=<?= $value->danh_muc_id ?>" style="text-transform:uppercase; text-decoration:none; color: red"><?= $value->danh_muc_name ?></a>

                            <?php endforeach; ?>
                         
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="new-product.php">Thêm SP mới</a>
                    </li>   
                    <li class="nav-item">
                        <a class="nav-link" href="../GUI_LienHe.php">Liên hệ</a>
                    </li> 
                    
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid" style="padding-bottom: 30px;padding-top: 30px">
        <h2>Sản Phẩm</h2>
        <div class="row">
            <div id="content" class="row row-cols-1 row-cols-md-4 g-4 w-100">
                <?php foreach ($data as $value) : ?>
                    <div class="col">
                        <div class="card" style="height: 400px">
                            <img src="../images/product/<?= $value->sp_hinh ?>" class=" card-img-top " style="width: 100%; height: 300px; object-fit: cover;" />
                            <div class="card-body">
                                <h5 class="card-title"><a href="product.php?id=<?= $value->sp_id ?>"><?= $value->sp_name ?></a></h5>
                                <p class="card-text">Giá: <?= number_format($value->gia, 0, ',', '.') ?> VNĐ</p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    </div>
    <?php if ($_SERVER["REQUEST_METHOD"] != "POST" && !isset($_GET['type'])) : ?>
        <nav aria-label="Page navigation example" style="margin-left: 675px;">
            <ul class="pagination">
                <?php
                if ($page > 1 && $tongtrang > 1) {
                    echo ' <li class="page-item"><a class="page-link" href="indexAdmin.php?page=' . ($page - 1) . '">Prev</a> </li>';
                }

                for ($i = 1; $i <= $tongtrang + 1; $i++) {
                    if ($i == $page) {
                        echo ' <li class="page-item"><a class="page-link" style="color:red;"><span">' . $i . '</span></a> </li>';
                    } else {
                        echo ' <li class="page-item"><a class="page-link" href="indexAdmin.php?page=' . $i . '">' . $i . '</a>  </li>';
                    }
                }

                if ($page < $tongtrang && $tongtrang > 1) {
                    echo ' <li class="page-item"><a class="page-link" href="indexAdmin.php?page=' . ($page + 1) . '">Next</a>  </li>';
                }
                ?>
            </ul>
        </nav>
    <?php endif; ?>
</body>

</html>
