<?php
namespace App\Model;
if(!defined('APP_PATH')) { die('can not access'); }

require 'app/config/database.php';
use App\Config\Database;
use \PDO;

class ProductModel extends Database
{
    function __construct(){
        // tu dong goi ket noi database tu class cha sang
        parent::__construct();
    }

    public function getDataProductById($id = 0) {
        $data = [];
        $sql  = "SELECT * FROM products WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        if($stmt){
            // kiem tra tham so truyen vao cau lenh SQL
            $stmt->bindParam(':id',$id,PDO::PARAM_INT);
            // thuc thi cau lenh
            if($stmt->execute()){
                if($stmt->rowCount() > 0){
                    $data = $stmt->fetch(PDO::FETCH_ASSOC);
                }
            }
            $stmt->closeCursor();
        }
        return $data;
    }

    public function getAllDataProducts(){
        // thuc hanh su dung pdo php lam viec voi database mysql
        $data = [];
        $sql  = "SELECT * FROM products";
        // no se bat dau kiem tra cau lenh sql cua em co hop phap ko
        $stmt = $this->db->prepare($sql);

        if($stmt){
            // truoc khi thuc thi can kiem tra cac tham so truyen vao cau lenh sql (neu co)
            // thuc thi cau lenh sql
            if($stmt->execute()){
                // kiem tra xem co dong du lieu nao trar ve
                if($stmt->rowCount() > 0){
                    // tra ve du lieu
                    // fetchAll : lay tat du lieu
                    // fetch : lay 1 dong du lieu
                    // FETCH_ASSOC: tra ve mang ko tuan tu voi key la ten truong nam trong db
                    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
            }
            // ngat ket noi toi prepare;
            $stmt->closeCursor();
        }
        return $data;
    }

    public function insertUserAdmin($username, $pass, $email, $role, $status){
        $ct = date('Y-m-d H:i:s');
        $ut = null;

        $flag = false;
        $sql = "INSERT INTO admins(username,password,email,role,status,create_time,update_time) VALUES(:user, :pass, :email, :role, :status, :ct, :ut)";
        $stmt = $this->db->prepare($sql);
        if($stmt){
            $stmt->bindParam(':user',$username,PDO::PARAM_STR);
            $stmt->bindParam(':pass',$pass,PDO::PARAM_STR);
            $stmt->bindParam(':email',$email, PDO::PARAM_STR);
            $stmt->bindParam(':role',$role,PDO::PARAM_INT);
            $stmt->bindParam(':status',$status, PDO::PARAM_INT);
            $stmt->bindParam(':ct',$ct, PDO::PARAM_STR);
            $stmt->bindParam(':ut',$ut, PDO::PARAM_STR);
            // thuc thi cau lenh
            if($stmt->execute()){
                $flag = true;
            }
            $stmt->closeCursor();
        }
        return $flag;
    }

    public function updateDataUser($username, $pass, $id){
        $flag = false;
        $sql = "UPDATE admins SET username = :user, password = :pass WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        if($stmt){
            $stmt->bindParam(':user', $username, PDO::PARAM_STR);
            $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            if($stmt->execute()){
                $flag = true;
            }
            $stmt->closeCursor();
        }
        return $flag;
    }

    public function deleteAdminById($id){

    }

    public function testInnerJoin($id){
        $sql = "SELECT a.name_cat, b.name_size FROM products AS c INNER JOIN categoties AS a ON a.id = c.cat_id INNER JOIN sizes AS b ON b.id = c.size_id WHERE c.id = :id";
    }

    public function testLikeSQL($keyword, $table = 'products'){
        $data = [];
        $key = "%".$keyword."%";
        $sql = "SELECT * FROM {$table} AS a WHERE a.name_pd LIKE :keywords OR a.price_pd LIKE :keyword";
        $stmt = $this->db->prepare($sql);
        if($stmt){
            $stmt->bindParam(':keywords',$key, PDO::PARAM_STR);
            $stmt->bindParam(':keyword',$key, PDO::PARAM_STR);
            if($stmt->execute()){
                if($stmt->rowCount() > 0){
                    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
            }
            $stmt->closeCursor();
        }
        return $data;
    }

    public function testLimitSQL($start, $limmit){
        $data = [];
        $sql = "SELECT * FROM products  LIMIT :start, :limmit";
    }

    public function testBetSQL($fr, $td){

    }
}