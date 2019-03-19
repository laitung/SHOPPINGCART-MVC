<?php
session_start();
if(!defined('APP_PATH')) {
    die('can not access');
}

class Route {
    public function home(){
        require_once 'app/controller/homeController.php';
    }

    public function product(){
        require_once 'app/controller/productController.php';
    }
    public function cart(){
        require_once 'app/controller/cartController.php';
    }

    function __call($r,$q){
        echo "Not found request";
    }
}

$route = new Route;
// index.php?c=home&m=index
$c = $_GET['c'] ?? 'home';
$route->$c();