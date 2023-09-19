<?php
class Danh_muc
{
    public $danh_muc_id;
    public $danh_muc_name;

    public static function getAll($pdo)
    {
        $sql = "SELECT * FROM danh_muc";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Danh_muc');
            return $stmt->fetchAll();
        }
    }
}
