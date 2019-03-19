<?php
namespace App\Controller;
require 'app/core/MY_Controller.php';
require 'app/model/Product_model.php';
use App\Core\MY_Controller;
use App\Model\ProductModel;

class ProductController extends MY_Controller {
    private $pdModel;
    function __construct(){
        parent::__construct();
        $this->pdModel = new ProductModel();

        if(isset($_SESSION['errAddPd']) && !isset($_GET['state']))
        {
            unset($_SESSION['errAddPd']);
        }

        if(isset($_GET['state']) && $_GET['state'] !== 'exits'){
            unset($_SESSION['errNamePd']);
        }
    }

    public function index(){
        // xu ly du lieu o day
        $data = [];
        $keyword = $_GET['key'] ?? '';
        $keyword = strip_tags($keyword);
        $page = $_GET['page'] ?? '';
        $page = (is_numeric($page) && $page > 0) ? $page : 1;

        $links = [
            'c' => 'product',
            'm' => 'index',
            'page' => '{page}',
            'key' => $keyword
        ];
        $create_links = create_link($links);
        $allPd = $this->pdModel->getAllDataProducts($keyword);

        // xu ly phan trang
        $pagination = pagination($create_links, count($allPd), $page, ROW_LIMITS, $keyword);

        $dataPage = $this->pdModel->getAllDataProductsByPage($pagination['start'],$pagination['limit'], $keyword);

        $data['lstPd'] = $dataPage;
        $data['name'] = 'NVA';
        $data['age']  = 30;
        $data['key'] = $keyword;
        $data['pageHtml'] = $pagination['htmlPage'];
        $data['limit'] = $pagination['limit'];
        $data['page'] = $page;


        // load header
        $header = [];
        $header['title'] = "This is product";
        $header['content'] =" This is product";
        $this->loadHeader($header);
        // load content view
        $this->loadView('app/view/product/index_view.php',$data);
        //load footer
        $this->loadFooter();
    }

    public function delete(){
        $id = $_POST['id'] ?? '';
        $id = is_numeric($id) ? $id : 0;
        // thuc thi xoa san pham
        if($id > 0){
            $del = $this->pdModel->deleteProductById($id);
            if($del){
                echo "OK";
            } else {
                echo "ERR";
            }
        } else {
            echo "ERR";
        }
    }

    public function add(){
        // xu ly data
        $data = [];
        $data['lstCat'] = $this->pdModel->getAllDataCategories();
        $data['lstSize'] = $this->pdModel->getAllDataSizes();

        $data['errAd'] = $_SESSION['errAddPd'] ?? [];
        $data['state'] = $_GET['state'] ?? '';
        $data['errName'] = $_SESSION['errNamePd'] ?? '';

        // load header
        $header = [];
        $header['title'] = "This is adding product";
        $header['content'] = "This is adding product";
        $this->loadHeader($header);
        //load content view
        $this->loadView('app/view/product/add_view.php',$data);
        //load footer
        $this->loadFooter();
    }

    public function handleAdd(){
        if(isset($_POST['btnSubmit'])){
            $namePd = $_POST['namePd'] ?? '';
            $namePd = strip_tags($namePd);

            $catPd  = $_POST['slcCat'] ?? '';
            $catPd  = is_numeric($catPd) ? $catPd : 0;

            $sizePd = $_POST['slcSize'] ?? '';
            $sizePd  = is_numeric($sizePd) ? $sizePd : 0;

            $price  = $_POST['pricePd'] ?? '';
            $price = strip_tags($price);
            $price  = is_numeric($price) ? $price : 0;

            $qty = $_POST['qtyPd'] ?? '';
            $qty = strip_tags($qty);
            $qty  = is_numeric($qty) ? $qty : 0;

            $desPd = $_POST['des_pd'] ?? '';

            // xu ly upload file
            $imagePd = null;
            if(isset($_FILES['imagePd'])){
                $imagePd = uploadFileData($_FILES['imagePd']);
            }

            // truoc khi insert data vao db chung ta can validate data
            $dataErrors = validateAddProduct($namePd, $catPd, $sizePd, $price, $qty, $desPd, $imagePd);

            $checkAdd = true;
            foreach ($dataErrors as $key => $err) {
                if($err != ''){
                    $checkAdd = false;
                    break;
                }
            }
            // neu $checkAdd == true : chung to nguoi dung nhap du lieu hoan toan hop le - thi toi di insert vao db
            if($checkAdd){
                // can xoa bo di cac loi da luu o session
                if(isset($_SESSION['errAddPd'])){
                    unset($_SESSION['errAddPd']);
                }
                // can kiem tra ten san pham moi them vao da ton tai trong db chua ? neu chua thi cho them nguoc lai thi ko .
                $checkNamePd = $this->pdModel->checkNamePdExits($namePd);
                if($checkNamePd)
                {
                    // khong cho them - vi ten san pham bi trung
                    $_SESSION['errNamePd'] = $namePd;
                    header("Location:?c=product&m=add&state=exits");
                }
                else
                {
                    if(isset($_SESSION['errNamePd'])){
                        unset($_SESSION['errNamePd']);
                    }

                    $add = $this->pdModel->addDataProduct($namePd, $catPd, $sizePd, $price, $qty, $desPd, $imagePd);
                    if($add){
                        header("Location:?c=product");
                    } else {
                        header("Location:?c=product&m=add&state=err");
                    }
                }
            } else {
                // thong bao loi ra ngoai view - de nguoi dung biet ho nhap sai du lieu o dau ?
                $_SESSION['errAddPd'] = $dataErrors;
                header("Location:?c=product&m=add&state=fail");
            }
        }
    }
     public function seach(){
        $keyWord = $_POST['key'] ?? '';
        $keyWord = strip_tags($keyWord);

        $data = [];
        $data['lstPd'] = $this->pdModel->getAllDataProducts($keyWord);
        $this->loadView('app/view/product/seach_view.php',$data);
     }
    // edit product
    public function edit(){
        // can lay dc id cua tung san pham
        $idPd = $_GET['id'] ?? '';
        // can lay ra thong tin cua san pham theo id
        $idPd = is_numeric($idPd) ? $idPd : 0;
        $infoPd = $this->pdModel->getInoDataById($idPd);
        if(!empty($infoPd)){
            // xu ly hien thi thong tin
            $data = [];
            $data['info'] = $infoPd;
            $data['lstCat'] = $this->pdModel->getAllDataCategories();
            $data['lstSize'] = $this->pdModel->getAllDataSizes();

            // load header
            $header = [];
            $header['title'] = 'Edit Page';
            $header['content'] = 'Edit Page';
            $this->loadHeader($header);
            // load content view
            $this->loadView('app/view/product/edit_view.php',$data);
            // load footer
            $this->loadFooter();

        } else {
            // chung ta chuyen sang trang not found 404
            // load header
            $header = [];
            $header['title'] = 'Not found Page';
            $header['content'] = 'Error Page';
            $this->loadHeader($header);
            // load view content
            $this->loadView('app/view/error/error_view.php');
            //load footer
            $this->loadFooter();
        }
    }

    public function handleEdit(){
        if(isset($_POST['btnSubmit'])){
            // lay thong tin cua form gui len
            $namePd = $_POST['namePd'] ?? '';
            $namePd = strip_tags($namePd);

            $catPd  = $_POST['slcCat'] ?? '';
            $catPd  = is_numeric($catPd) ? $catPd : 0;

            $sizePd = $_POST['slcSize'] ?? '';
            $sizePd  = is_numeric($sizePd) ? $sizePd : 0;

            $price  = $_POST['pricePd'] ?? '';
            $price = strip_tags($price);
            $price  = is_numeric($price) ? $price : 0;

            $qty = $_POST['qtyPd'] ?? '';
            $qty = strip_tags($qty);
            $qty  = is_numeric($qty) ? $qty : 0;

            $desPd   = $_POST['des_pd'] ?? '';
            $satusPd = $_POST['statusPd'] ?? '';
            $satusPd = (is_numeric($satusPd) && in_array($satusPd,['0','1'])) ? $satusPd : 0;

            // lay thong tin cua san pham
            $id = $_GET['id'] ?? '';
            $id = is_numeric($id) ? $id : 0;
            $infoPd = $this->pdModel->getInoDataById($id);

            $nameImage = $infoPd['image_pd'];
            // neu nguoi dung muon thay doi anh - kiem tra
            if(isset($_FILES['imagePd']) && !empty($_FILES['imagePd']))
            {
                if(isset($_FILES['imagePd']['name']) && !empty($_FILES['imagePd']['name']))
                {
                    $nameImage = uploadFileData($_FILES['imagePd']);
                }
            }

            // validate data truoc khi update du lieu
            $dataErrors = validateAddProduct($namePd, $catPd, $sizePd, $price, $qty, $desPd, $nameImage);

            $checkEdit = true;
            foreach ($dataErrors as $key => $err) {
                if($err != ''){
                    $checkEdit = false;
                    break;
                }
            }

            //$checkEdit == true : cho update date
            if($checkEdit){
                // xoa bo session loi neu co
                if(isset($_SESSION['editErr'])){
                    unset($_SESSION['editErr']);
                }
                // kiem tra xem ten san pham can thay doi co ton tai trong db hay ko?
                //  neu no co - khong cho thay doi  va nguoc lai
                $checkEditNamePd = $this->pdModel->checkEditNameByIdExits($namePd, $id);
                if($checkEditNamePd){
                    // ten san pham da ton tai - chon ten khac ma thay doi
                    header("Location:?c=product&m=edit&id={$id}&state=err");
                } else {
                    // cho phep thay doi du lieu
                    $up = $this->pdModel->updateDataPdById($namePd, $catPd, $sizePd, $price, $qty, $desPd, $nameImage, $satusPd, $id);
                    if($up){
                        header("Location:?c=product");
                    } else {
                        header("Location:?c=product&m=edit&id={$id}&state=cancel");
                    }
                }
            } else {
                $_SESSION['editErr'] = $dataErrors;
                header("Location:?c=product&m=edit&id={$id}&state=fail");
            }
        }
    }

    public function search(){
        $keyword = $_POST['key'] ?? '';
        $keyword = strip_tags($keyword);

        echo $keyword;
    }
}

$pd = new ProductController;
$method = $_GET['m'] ?? 'index';
$pd->$method();