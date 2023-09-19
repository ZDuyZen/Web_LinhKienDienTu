<?php


class Auth 
{
    public $id_DN;
    public $ten_DN;
    public $matkhau;
    public $admin;
    public $email;
    public $token;
    public $datetime_reset;

    
    public static function KT_email ($pdo,$email) {
        $sql = "SELECT * FROM tai_khoan WHERE email= :email ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);

        if ($stmt->execute()) 
        {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Auth');
            $abc= $stmt->fetch();        
            if(!$abc )
            {
                return 'Email này chưa có đăng kí';
            }
            else{
                $datetime=date('Y-m-d H:i:s');
                $token_reset=rand(10000000, 99999999);
                $SQL = "UPDATE `tai_khoan`SET `token`= :token,`datetime_reset`=:datetimereset WHERE `id_DN` = :id";
                $STMT = $pdo->prepare($SQL);
                $STMT->bindValue(':id', $abc->id_DN, PDO::PARAM_INT);
                $STMT->bindValue(':token', $token_reset, PDO::PARAM_INT);
                $STMT->bindParam(':datetimereset', $datetime, PDO::PARAM_STR);
        
                if ($STMT->execute()) {

                    Auth::Send_Email($email,$abc->id_DN,$token_reset);
                    return 'Hãy kiểm tra tin nhắn trong Email của bạn';
                } 
                else 
                {
                    $error = $STMT->errorInfo();
                    var_dump($error);
                }
            }        
        } 
        else 
        {
            $error = $stmt->errorInfo();
            var_dump($error);
        }
    }
    public static function reset_token_datetimereset($pdo,$id)
    {
        $sql = "UPDATE `tai_khoan`SET `token`= NULL,`datetime_reset`=NULL WHERE `id_DN` = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            $error = $stmt->errorInfo();
            var_dump($error);
        }
    }
    public static function update_password($pdo,$id,$pass)
    {
        $sql = "UPDATE `tai_khoan`SET `matkhau`=:pass WHERE `id_DN` = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':pass', $pass, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        } else {
            $error = $stmt->errorInfo();
            var_dump($error);
        }
    }
    public static function login ($pdo,$username, $password) {
        $sql = "SELECT * FROM tai_khoan WHERE ten_DN= :ten ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':ten', $username, PDO::PARAM_STR);

        if ($stmt->execute()) 
        {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Auth');
            $abc= $stmt->fetch();        
            if(!$abc )
            {
                return 'Login Fail';
            }
            else if(password_verify($password,$abc->matkhau)==false){
                return 'Login Fail';
            }
            else{
                $kt_quyen=$abc->admin;
                if($kt_quyen == 1)
                {
                    $_SESSION['log_detail'] = $abc->id_DN;
                    $_SESSION['id'] = $abc->id_DN;
                    header('location:Admin/indexAdmin.php');
                    exit();
                }         
                else
                {
                    $_SESSION['log_detail'] = $abc->id_DN;
                    $_SESSION['id'] = $abc->id_DN;
                    header('location: index.php');
                    exit();
                }
            }        
        } 
        else 
        {
            return 'Login Fail';
        }
    }

    public function createtai_khoan($pdo) {
        $sql = "INSERT INTO `tai_khoan`(`ten_DN`, `matkhau`, `admin`,`email`) VALUES (:ten_DN, :matkhau, :admin,:email)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':ten_DN', $this->ten_DN, PDO::PARAM_STR);
        $stmt->bindValue(':matkhau', $this->matkhau , PDO::PARAM_STR);
        $stmt->bindValue(':admin', $this->admin, PDO::PARAM_INT);
        $stmt->bindValue(':email', $this->email , PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        }
        else {
            $error = $stmt->errorInfo();
            var_dump($error);
        }
    }
    public static function KT_trungtenDNvaEmail($pdo,$username,$email) {
        $sql = "SELECT * FROM tai_khoan WHERE ten_DN= :ten OR email=:email";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':ten', $username, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        if ($stmt->execute()) 
        {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Auth');
            $abc= $stmt->fetch();        
            if($abc)
            {
                return 'already have this username or email';
            }
        }
    }
    public static function getOneUserByID($pdo, $id) {
        $sql = "SELECT * FROM tai_khoan WHERE  `id_DN` = :id";
        $stmt = $pdo->prepare($sql);    
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Auth');
            return $stmt->fetch();
        }
    }
    public static function logout() {
        unset($_SESSION['log_detail']);
        header('location:index.php');
        exit;
    }
    public static function logoutAdmin() {
        unset($_SESSION['log_detail']);
        header('location: ../index.php');
        exit;
    }

    public static function requireLogin() {
        if (!isset($_SESSION['log_detail'])) {
            return 'Bạn không được phép truy cập';
        }
        return '';
    }
    public static function MaHoaMK($mk) {
        $hash=password_hash($mk,PASSWORD_DEFAULT);
        return $hash;
    }
}
