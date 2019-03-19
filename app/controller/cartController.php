<?php
namespace App\Controller;
if(!defined('APP_PATH')) { die('can not access'); }
require 'app/model/product_model.php';
use App\Model\ProductModel;

class CartController {
	private $pdModel;
    function __construct(){
        $this->pdModel = new ProductModel();
    }

	public function index(){
		$cart = $_SESSION['cart'] ?? [];
		// echo "<pre>";
		// print_r($cart);
		require 'app/view/cart/index_view.php';
	}
	public function add(){
		// them san pham vao gio hang
		$idPd = $_GET['id'];
		$idPd = is_numeric($idPd) ? $idPd : 0;
		//can lay ra thong tin chi tiet cua san pham theo id;
		$infoPd = $this->pdModel->getDataProductById($idPd);
		// echo "<pre>";
		// print_r($infoPd);
		if(!empty($infoPd)){
			//bat dau xay dung gio hang bang session
			// kiem tra xem gio hang ton tai chua// neu chua thi tao moi gio hang va them san pham vao luon
			if(!isset($_SESSION['cart'])){
				// them san pham vao
				$_SESSION['cart'][$idPd]['id'] = $idPd;
				$_SESSION['cart'][$idPd]['name'] = $infoPd['name_pd'];
				$_SESSION['cart'][$idPd]['price'] = $infoPd['price_pd'];
				$_SESSION['cart'][$idPd]['image'] = $infoPd['image_pd'];
				$_SESSION['cart'][$idPd]['qty'] = 1;

			} else {
				// kiem tra san pham them moi vao da ton tai trong gio hang chua. neu ton tai se cap nhap so luong chu khong them moi. nguoc lai them moi hoan toan
				if(isset($_SESSION['cart'][$idPd]) && $_SESSION['cart'][$idPd]['id'] = $idPd ){
					$_SESSION['cart'][$idPd]['qty'] += 1;
				} else {
					$_SESSION['cart'][$idPd]['id'] = $idPd;
					$_SESSION['cart'][$idPd]['name'] = $infoPd['name_pd'];
					$_SESSION['cart'][$idPd]['price'] = $infoPd['price_pd'];
					$_SESSION['cart'][$idPd]['image'] = $infoPd['image_pd'];
					$_SESSION['cart'][$idPd]['qty'] = 1;
				}
			}
			header('location:?c=cart');
		} else {
			echo "Not found data";
		}
	}
	public function delete(){
		$id = $_GET['id'] ?? '';
		$id = is_numeric($id) ? $id : 0;
		// xoa bo 1 san pham ra khoi gio hang
		if(isset($_SESSION['cart'][$id])){
			unset($_SESSION['cart'][$id]);
		}
		header('location:?c=cart');
	}
	public function deleteall(){
		if(isset($_SESSION['cart'])){
			unset($_SESSION['cart']);
		}
		header('location:?c=cart');
	}
	public function update(){
		if(isset($_POST['btnSub'])){
			$qty = $_POST['qty'] ?? '';
			foreach($_SESSION['cart'] as $key => $cart){
				// kiem tra xem san pham can sua co ton tai trong gio hang ko
				if(isset($qty[$key])){
					//cap nhat
					if($qty[$key] > 0 && $qty[$key] < 10){
						$_SESSION['cart'][$key]['qty'] = $qty[$key];
					}
				}
			}
			header('location:?c=cart');
			// echo "<pre>";
			// print_r($qty);
			//cap nhat lai so luong trong gio hang
		}
	}
	public function ajax_cart(){
		$data = [];
		$data['mess'] = '';
		$data['id'] ='';
		$data['qty'] = '';
		$data['money'] = 0;
		$data['totalMoney'] = 0;

		$id = $_POST['id'] ?? '';
		$id = is_numeric($id) ? $id : 0;
		$qty = $_POST['qty'];
		$qty = is_numeric($qty) ? $qty :0;
		if($id == 0 || $qty == 0){
			$data['mess'] = "ERR";
		} else {
			// update
			if(isset($_SESSION['cart'][$id])){
				$_SESSION['cart'][$id]['qty'] = $qty;
				$data['money'] = ($qty * $_SESSION['cart'][$id]['price']);
			}
			//tinh tong tien
			foreach($_SESSION['cart'] as $key => $val){
				$data['totalMoney'] += ($val['qty']*$val['price']);
			}

			$data['id'] = $id;
			$data['mess'] = 'OK';
			$data['qty'] = $qty;
			$data['money'] = number_format($data['money']);
			$data['totalMoney'] = number_format($data['totalMoney']);
		}
		echo json_encode($data);
	}
}
$cart = new CartController;
$method = $_GET['m'] ?? 'index';
$cart->$method();