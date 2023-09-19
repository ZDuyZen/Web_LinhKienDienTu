<?php

use gio_hang as Globalgio_hang;

class gio_hang
{
    public $gio_hang_id;
    public $gio_hang_name;
    public $gio_hang_gia;
    public $gio_hang_soluong;
    public $gio_hang_trang_thai;

    public static function getAllgio_hang($pdo)
    {
        $sql = "SELECT * FROM gio_hang where gio_hang_trang_thai is null";
        $stmt = $pdo->prepare($sql);

        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'gio_hang');
        return $stmt->fetchAll();
    }

    public static function getAllgio_hang_thanhtoan($pdo)
    {
        $sql = "SELECT * FROM gio_hang where gio_hang_trang_thai = 1";
        $stmt = $pdo->prepare($sql);

        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'gio_hang');
        return $stmt->fetchAll();
    }

    public static function getOnegio_hangByID($pdo, $gio_hang_id, $gio_hang_name)
    {
        $sql = "SELECT * FROM gio_hang WHERE gio_hang_id = :gio_hang_id and gio_hang_name = :gio_hang_name";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':gio_hang_id', $gio_hang_id, PDO::PARAM_INT);
        $stmt->bindValue(':gio_hang_name', $gio_hang_name, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'gio_hang');
            return $stmt->fetch();
        }
    }

    public static function addgio_hang($pdo, $data)
    {

        if (isset($_GET['action']) && isset($_GET['proid']) && isset($_SESSION['log_detail'])) {
            $action = $_GET['action'];
            $proid = $_GET['proid'];
            $sl = $_GET['sl'];
            if ($action == 'add_gio_hang') {
                $product = San_pham::getOneByID($pdo, $proid);
                if ($product) {
                    $proidCol = gio_hang::getOnegio_hangByID($pdo, $proid, $product->sp_name);
                    if ($proidCol) {
                        

                        $sql = "UPDATE `gio_hang` SET `gio_hang_soluong`= :soluong WHERE `gio_hang_id` = :gio_hang_id AND `gio_hang_name` = :gio_hang_name";
                        $stmt = $pdo->prepare($sql);

                        $gio_hang_soluong = $proidCol->gio_hang_soluong + $sl;
                        $stmt->bindParam(':soluong', $gio_hang_soluong, PDO::PARAM_INT);
                        $stmt->bindParam(':gio_hang_id', $proid, PDO::PARAM_INT);
                        $stmt->bindParam(':gio_hang_name', $product->sp_name, PDO::PARAM_STR);

                        $completedSql = $sql;
                        $completedSql = str_replace(':soluong', $gio_hang_soluong, $completedSql);

                        echo $completedSql;


                        if ($stmt->execute()) {
                            return true;
                        } else {
                            $error = $stmt->errorInfo();
                            var_dump($error);
                        }
                    } else {
                        $sql = "INSERT INTO `gio_hang`(`gio_hang_id`,`gio_hang_name`, `gio_hang_gia`, `gio_hang_soluong`) VALUES (:gio_hang_id,:gio_hang_name, :gio_hang_gia,:gio_hang_soluong)";
                        $stmt = $pdo->prepare($sql);

                        $stmt->bindValue(':gio_hang_id', $product->sp_id, PDO::PARAM_INT);
                        $stmt->bindValue(':gio_hang_name', $product->sp_name, PDO::PARAM_STR);
                        $stmt->bindValue(':gio_hang_gia', $product->gia, PDO::PARAM_STR);
                        $stmt->bindValue(':gio_hang_soluong', $sl, PDO::PARAM_INT);

                        if ($stmt->execute()) {
                            return true;
                        }
                    }
                }
            }
        }
    }

    public static function editgio_hang($pdo)
    {
        if (isset($_GET['action'])) {
            $action = $_GET['action'];
            if ($action == 'thanhtoan') {
                $sql = "update `gio_hang` SET `gio_hang_trang_thai` = 1 where gio_hang_trang_thai is null";
                $stmt = $pdo->prepare($sql);
                

                if ($stmt->execute()) {
                    $stmt->setFetchMode(PDO::FETCH_CLASS, 'gio_hang');
                    return $stmt->fetchAll();
                    header('location:thanhtoan.php');
                    return true;
                } else {
                    $error = $stmt->errorInfo();
                    var_dump($error);
                }
            }

            if ($action == 'empty') {
                $sql = "DELETE FROM `gio_hang`";
                $stmt = $pdo->prepare($sql);

                if ($stmt->execute()) {
                    header('location:gio_hang.php');
                    return true;
                } else {
                    $error = $stmt->errorInfo();
                    var_dump($error);
                }
            }
            if ($action == 'delete') {
                $proName = $_GET['proName'];
                $id = $_GET['id'];
                $sql = "DELETE FROM `gio_hang` WHERE `gio_hang_id` = :gio_hang_id AND `gio_hang_name` = :gio_hang_name AND gio_hang_trang_thai is null";
                $stmt = $pdo->prepare($sql);

                $stmt->bindParam(':gio_hang_id', $id, PDO::PARAM_INT);
                $stmt->bindValue(':gio_hang_name', $proName, PDO::PARAM_STR);
                if ($stmt->execute()) {
                    header('location:gio_hang.php');
                    return true;
                } else {
                    $error = $stmt->errorInfo();
                    var_dump($error);
                }
            }
            if ($action == 'update') {
                $id = $_GET['id'];
                $proName = $_GET['proName'];
                $gio_hang_soluong = $_GET['qty'];

                $sql = "UPDATE `gio_hang` SET `gio_hang_soluong`= :gio_hang_soluong WHERE `gio_hang_id` = :gio_hang_id AND `gio_hang_name`=:gio_hang_name AND gio_hang_trang_thai is null";
                $stmt = $pdo->prepare($sql);

                $stmt->bindParam(':gio_hang_soluong', $gio_hang_soluong, PDO::PARAM_INT);
                $stmt->bindParam(':gio_hang_id',  $id, PDO::PARAM_INT);
                $stmt->bindParam(':gio_hang_name', $proName, PDO::PARAM_STR);
                if ($stmt->execute()) {
                    header('location:gio_hang.php');
                    return true;
                } else {
                    $error = $stmt->errorInfo();
                    var_dump($error);
                }
            }
          
        }
    }
}
