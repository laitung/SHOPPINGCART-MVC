<?php
namespace App\Controller;
if(!defined('APP_PATH')) { die('can not access'); }

require 'app/model/product_model.php';
use App\Model\ProductModel;

class HomeController {
	private $pdModel;
	function __construct(){
		$this->pdModel = new ProductModel();
	}
    public function index(){
        //echo "Hello MVC";
        $data = [];
        $data['lstPd'] = $this->pdModel->getAllDataProducts();
        // echo "<prev>";
        // print_r($data['lstPd']); die;
        require 'app/view/home/index_view.php';
    }

    function __call($r,$q){
        echo "Not found request";
    }
}
$home = new HomeController;
$method = $_GET['m'] ?? 'index';
$home->$method();