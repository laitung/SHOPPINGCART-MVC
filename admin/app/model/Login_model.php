<?php
namespace App\Model;

if(!defined('APP_PATH')) {
    die('can not access');
}

require "app/config/database.php";
use App\Config\Database;
use \PDO;

class LoginModel extends Database {
    function __construct(){
        parent::__construct();
    }

    public function checkLoginAdmin($user, $pass){
        $data = [];
        $sql = "SELECT * FROM admins AS a WHERE a.username = :user AND a.password = :pass AND a.status = 1 LIMIT 1";
        $stmt = $this->db->prepare($sql);
        if($stmt){
            $stmt->bindParam(':user',$user,PDO::PARAM_STR);
            $stmt->bindParam(':pass',$pass,PDO::PARAM_STR);
            if($stmt->execute()){
                if($stmt->rowCount() > 0){
                    $data = $stmt->fetch(PDO::FETCH_ASSOC);
                }
            }
            $stmt->closeCursor();
        }
        return $data;
    }
}