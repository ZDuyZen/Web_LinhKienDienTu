<?php
class San_pham
{
    public $sp_id;
    public $sp_name;
    public $mo_ta;
    public $gia;
    public $sp_hinh;
     public $so_luong_ton;
    public $danh_muc_id;
    public $hang_sx_id;
    
    public static function getAll($pdo) {
        $sql = "SELECT * FROM san_pham";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'San_pham');
            return $stmt->fetchAll();
        }
    }
    public static function getdatasearch($pdo,$search)
    {
        $sql = "SELECT * FROM san_pham WHERE sp_name LIKE '%$search%' ORDER by sp_id ASC";
        $stmt = $pdo->prepare($sql);    

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'San_pham');
            return $stmt->fetchAll();
        }
    }
    public static function getdatatype($pdo, $type) {
        $sql = "SELECT * FROM san_pham WHERE danh_muc_id = :danh_muc_id ORDER by sp_id ASC";
        $stmt = $pdo->prepare($sql);    
        $stmt->bindValue(':danh_muc_id', $type, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'San_pham');
            return $stmt->fetchAll();
        }
    }
    public static function getPage($pdo,$limit,$offset) {
        $sql = "SELECT * FROM san_pham ORDER by sp_id ASC LIMIT :limit OFFSET :offset";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'San_pham');
            return $stmt->fetchAll();
        }
    }


    public static function getOneByID($pdo, $sp_id) {
        $sql = "SELECT * FROM san_pham WHERE sp_id = :sp_id";
        $stmt = $pdo->prepare($sql);    
        $stmt->bindValue(':sp_id', $sp_id, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'San_pham');
            return $stmt->fetch();
        }
    }

    public function create($pdo) {
        $sql = "INSERT INTO `san_pham`(`sp_name`, `mo_ta`, `gia`, `sp_hinh`,`danh_muc_id`) VALUES (:sp_name, :mo_ta, :gia,:sp_hinh,:danh_muc_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':sp_name', $this->sp_name, PDO::PARAM_STR);
        $stmt->bindValue(':mo_ta', $this->mo_ta, PDO::PARAM_STR);
        $stmt->bindValue(':gia', $this->gia, PDO::PARAM_INT);
        $stmt->bindValue(':sp_hinh', $this->sp_hinh, PDO::PARAM_STR);
        $stmt->bindValue(':danh_muc_id', $this->danh_muc_id, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $this->sp_id = $pdo->lastInsertId();
            return true;
        }
    }
    public function update($pdo)
    {
        $sql = "UPDATE `san_pham` SET `sp_name`= :sp_name,`mo_ta`=:mo_ta,`gia`=:gia,`sp_hinh`= :sp_hinh,`danh_muc_id`=:danh_muc_id WHERE `sp_id` = :sp_id";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':sp_name', $this->sp_name, PDO::PARAM_STR);
        $stmt->bindParam(':mo_ta', $this->mo_ta, PDO::PARAM_STR);
        $stmt->bindParam(':gia', $this->gia, PDO::PARAM_INT);
        $stmt->bindValue(':sp_hinh', $this->sp_hinh, PDO::PARAM_STR);
        $stmt->bindValue(':danh_muc_id', $this->danh_muc_id, PDO::PARAM_STR);
        $stmt->bindParam(':sp_id', $this->sp_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            $error = $stmt->errorInfo();
            var_dump($error);
        }
    }

    public function delete($pdo, $sp_id)
    {
        $sql = "DELETE FROM san_pham WHERE sp_id = :sp_id";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':sp_id', $sp_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            $error = $stmt->errorInfo();
            var_dump($error);
        }
    }
}
