<?php
namespace App\Config;

if(!defined('APP_PATH')) {
    die('can not access');
}

use \PDO;

class Database {
    protected $db;

    function __construct(){
        $this->connection();
    }

    function __destruct(){
        $this->disconnection();
    }

    protected function connection(){
        try {
            // ket noi den database
            $this->db = new PDO('mysql:host=localhost;dbname=shopping;charset=utf8','root','');
            // giup bao loi khi viet sai cu phap
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // chong sql injection
            $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        return $this->db;
    }

    protected function disconnection(){
        // ngat ket noi den mysql bang pdo
        $this->db = null;
    }
}