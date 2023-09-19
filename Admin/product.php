<?php
$title = 'San_pham page';
if (! isset($_GET["id"])) {
    die("Cần cung cấp id sản phẩm !!!");
}

$id = $_GET["id"];

require '../class/Database.php';
require '../class/San_pham.php';

$db = new Database();
$pdo = $db->getConnect();

$San_pham = San_pham::getOneByID($pdo, $id);

if (!$San_pham) {
    die("id không hợp lệ.");
}
?>

<?php require 'inc/header.php'; ?>

<h2>Thông tin sản phẩm</h2>
<table class="table table-success">
    <tr>
        <td class="table-dark" style="width: 10%">Mã SP</td>
        <td><?= $San_pham->sp_id ?></td>
    </tr>
    <tr>
        <td class="table-dark">Tên SP</td>
        <td><?= $San_pham->sp_name ?></td>
    </tr>
    <tr>
        <td class="table-dark">Mô tả</td>
        <td><?= $San_pham->mo_ta ?></td>
    </tr>
    <tr>
        <td class="table-dark">Giá</td>
        <td><?= number_format($San_pham->gia, 0, ',', '.') ?> VNĐ</td>
    </tr>
    <?php if($San_pham->sp_hinh!=NULL): ?>
        <td class="table-dark">Image</td>
        <td> <img src="../images/product/<?= $San_pham->sp_hinh?>"style="width: 300px; height: 300px; object-fit: cover;" /></td> 
    <?php endif; ?>
    <tr>
        <td colspan="2" style="padding-left: 10%">
            <a class="btn btn-info" href="edit-product.php?id=<?= $San_pham->sp_id ?>">Edit</a> 
            <a class="btn btn-danger" href="delete-product.php?id=<?= $San_pham->sp_id ?>">Delete</a> 
        </td>
    </tr>
</table>

