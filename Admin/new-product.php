<?php
$title = 'New Product';
require '../class/Database.php';
require '../class/San_pham.php';
require '../class/Danh_muc.php';
require '../inc/init.php';

$error = '';


$name = '';
$desc = '';
$price = '';
$image='';
$danh_muc='';

$nameErrors = '';
$descErrors = '';
$priceErrors = '';

$db = new Database();
$pdo = $db->getConnect();
$danh_muc = danh_muc::getAll($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $desc = $_POST['desc'];
    $price = $_POST['price'];
    $selected_cateID = $_POST['category'];

    if (empty($name)) {
        $nameErrors = 'Name is required';
    }

    if (empty($desc)) {
        $descErrors = 'Description is required';
    }

    if (empty($price)) {
        $priceErrors = 'Price is required';
    } 
    

    require 'upload.php';

    if (!$nameErrors && !$descErrors && !$priceErrors) {
        
        
        $product = new San_pham();
        $product->sp_name = $name;
        $product->mo_ta = $desc;
        $product->gia = $price;
        $product->sp_hinh = $image;
        $product->danh_muc_id=$selected_cateID;

        if ($product->create($pdo)) {
            header("Location: product.php?id={$product->sp_id}");
            exit;         
        }
    }
}
?>

<?php require 'inc/header.php'; ?>

<?php if (!$error) : ?>

    <h2>Thêm sản phẩm mới</h2>
    <form method="post" class="w-50 m-auto" enctype='multipart/form-data'>
        <div class="mb-3">
            <label for="name" class="form-label">Name (*)</label>
            <input class="form-control" id="name" name="name" value="<?= $name ?>" /> <span class="text-danger fw-bold"><?= $nameErrors ?></span>
        </div>
        <div class="mb-3">
            <label for="desc" class="form-label">Description (*)</label>
            <textarea class="form-control" id="desc" name="desc" rows="4"><?= $desc ?></textarea> <span class="text-danger fw-bold"><?= $descErrors ?></span>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price (*)</label>
            <input class="form-control" id="price" name="price" type="number" value="<?= $price ?>" /> <span class="text-danger fw-bold"><?= $priceErrors ?></span>
        </div>
        <div class="mb-3">
            <label for="file">Image file</label>
            <input class="form-control" id="file"type="file" name="file" />
        </div>
        <h5>Chọn Loại Sản Phẩm</h5>
        <?php foreach ($danh_muc as $cate) : ?>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="category" id="category<?= $cate->danh_muc_id ?>" value="<?= $cate->danh_muc_id ?>">
                <label class="form-check-label" for="category<?= $cate->danh_muc_id ?>">
                    <?= $cate->danh_muc_name ?>
                </label>
            </div>
        <?php endforeach; ?>
        <button type="submit" class="btn btn-primary">Add new</button>
    </form>

<?php else: ?>

    <h2 class="text-center text-danger"><?= $error ?></h2>

<?php endif; ?>
