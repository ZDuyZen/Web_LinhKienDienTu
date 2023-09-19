<?php
require '../class/San_pham.php';
require '../class/Database.php';
require '../inc/init.php';
require '../class/Danh_muc.php';

$id = $_GET["id"];

$db = new Database();
$pdo = $db->getConnect();

$product = San_pham::getOneByID($pdo, $id);
$danh_muc = Danh_muc::getAll($pdo);

$nameErrors = '';
$priceErrors = '';
$descError = '';

$name = $product->sp_name;
$desc = $product->mo_ta;
$price = $product->gia;
$imagedelete=$product->sp_hinh;
$defaultCategoryId=$product->danh_muc_id;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $desc = $_POST['desc'];
    $price = $_POST['price'];
    $selected_cateID = $_POST['category'];

    // $data = $_SESSION['data'];

    if (empty($_POST['name'])) {
        $nameErrors = 'Name is required';
    }

    if (empty($_POST['desc'])) {
        $descError = 'Description is required';
    }

    if (empty($_POST['price'])) {
        $priceErrors = 'Price is required';
    } elseif ($price % 1000 != 0) {
        $priceErrors = 'Giá phải chia hết cho 1000';
    }
    require 'upload.php';

    
    

    // No errors???????
    if (!$nameErrors && !$priceErrors && !$descError) {
        $product->sp_id = $id;
        $product->sp_name = $name;
        $product->mo_ta = $desc;
        $product->gia = $price;
        $product->sp_hinh = $image;
        $product->danh_muc_id=$selected_cateID;

        if ($product->update($pdo)) {
            $filepath = '../images/product/'.$imagedelete;
            if (file_exists($filepath)) {
                unlink($filepath);
            }
            header("Location: product.php?id={$product->sp_id}");
            exit;
        }
    }
}
?>

<?php
require 'inc/header.php';
?>
    <h2>Chỉnh sửa sản phẩm</h2>
    <form action="" method="post" class="w-50 m-auto " enctype='multipart/form-data'>
        <div class="mb-3">
            <label for="name">Name: (*)</label>
            <input class="form-control" id="name" name="name" value="<?= $name ?>"> <span class='text-danger fw-bold'><?= $nameErrors ?></span>
        </div>
        <div class="mb-3">
            <label for="desc">Description: (*)</label>
            <textarea class="form-control" id="desc" name="desc" rows="4"><?= $desc ?></textarea> <span class='text-danger fw-bold'><?= $descError ?></span>
        </div>
        <div class="mb-3">
            <label for="price">Price: (*)</label>
            <input type="number" class="form-control" id="price" name="price" value="<?= $price ?>"> <span class='text-danger fw-bold'><?= $priceErrors ?></span>
        </div>
        <div class="mb-3">
                <img src="../images/product/<?= $product->sp_hinh?>"style="width: 100%; height: 400px; object-fit: cover;" />
                <label for="file">Chọn Ảnh Khác</label>
            <input class="form-control" id="file"type="file" name="file" />
        </div>
        <h5>Chọn Loại Sản Phẩm</h5>
        <?php foreach ($danh_muc as $cate) : ?>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="category" id="category<?= $cate->danh_muc_id ?>" value="<?= $cate->danh_muc_id ?>" <?php if ($cate->danh_muc_id == $defaultCategoryId) echo "checked"; ?>>
                <label class="form-check-label" for="category<?= $cate->danh_muc_id ?>">
                    <?= $cate->danh_muc_name ?>
                </label>
            </div>
        <?php endforeach; ?>
        <button type="submit" name="submit" value="Submit" class="btn btn-primary">ok!!!</button>
        
    </form>
