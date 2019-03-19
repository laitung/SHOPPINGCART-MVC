<?php
session_start();

if(!defined('APP_PATH')) {
    die('can not access');
}

// nhung file constant
require_once 'app/config/constant.php';
// su dung ham tien ich
require_once 'app/helper/common_helper.php';

class Route {
    public function dashboard(){
        require_once 'app/controller/DashboardController.php';
    }
    public function login(){
        require_once 'app/controller/LoginController.php';
    }

    public function product(){
        require_once 'app/controller/ProductController.php';
    }

    function __call($r,$q){
        echo "Not Found Request";
    }
}
$route = new Route;
$controller = $_GET['c'] ?? 'login';
$route->$controller();