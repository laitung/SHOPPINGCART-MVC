<?php
namespace App\Controller;
if(!defined('APP_PATH')) { die('can not access'); }
require 'app/model/product_model.php';
use App\Model\ProductModel;

class ProductController {
    function __construct(){
        $this->pdModel = new ProductModel();
    }
    private $pdModel;
    function __construct(){
        $this->pdModel = new ProductModel();
    }

    public function index(){
        //echo "Hello MVC";
        //require 'app/view/product/index_view.php';
        $data = $this->pdModel->getAllDataProducts();
        // echo "<pre>";
        // print_r($data['lstPd']);
    }
    public function detail(){
        //require 'app/view/product/detail_view.php';
        $idPd = $_GET['id'] ?? '';
        $idPd = is_numeric($idPd) ? $idPd : 0;
        $infoPd = $this->pdModel->getDataProductById($idPd);
        echo "<pre>"; print_r($infoPd);
    }

    public function insert(){
        $insert = $this->pdModel->insertUserAdmin('admin2','12345','admin2@gmail.com',-1,1);
        if($insert){
            echo "Success";
        } else {
            echo "Fail";
        }
    }

    public function update(){
        $up = $this->pdModel->updateDataUser('trieunt','9999',1);
        if($up){
            echo "Update Success";
        } else {
            echo "Update Fail";
        }
    }

    public function search(){
        $data = $this->pdModel->testLikeSQL('so mi');
        echo "<pre>";
        print_r($data);
    }

    function __call($r,$q){
        echo "Not found request";
    }
}
$product = new ProductController;
$method = $_GET['m'] ?? 'index';
$product->$method();