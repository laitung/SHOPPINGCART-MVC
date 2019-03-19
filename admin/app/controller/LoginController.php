<?php
namespace App\Controller;

if(!defined('APP_PATH')) {
    die('can not access');
}

require 'app/model/Login_model.php';
use App\Model\LoginModel;

class LoginController {
    private $loginDb;
    function __construct(){
        $this->loginDb = new LoginModel();
    }

    public function index(){
        require 'app/view/login/index_view.php';
    }

    public function logout(){
        // xoa cac session da login
        unset($_SESSION['username']);
        unset($_SESSION['id']);
        unset($_SESSION['email']);
        unset($_SESSION['role']);

        header("Location:?c=login");
    }

    public function handle(){
        if(isset($_POST['btnSubmit'])){
            $username = $_POST['username'] ?? '';
            $username = strip_tags($username);

            $password = $_POST['password'] ?? '';
            $password = strip_tags($password);

            if($username === '' OR $password === ''){
                header("Location:?c=login&state=err");
            } else {
                $checkLogin = $this->loginDb->checkLoginAdmin($username,$password);
                // kiem tra
                if(!empty($checkLogin) && isset($checkLogin['id'])){
                    // luu thong tin nguoi dung vao session
                    $_SESSION['username'] = $checkLogin['username'];
                    $_SESSION['id'] = $checkLogin['id'];
                    $_SESSION['email'] = $checkLogin['email'];
                    $_SESSION['role'] = $checkLogin['role'];
                    // di vao trang quan ly
                    header("Location:?c=dashboard");
                } else {
                    header("Location:?c=login&state=fail");
                }
            }
        }
    }

    function __call($r,$q){
        echo "Not Found Request";
    }
}
$login = new LoginController;
$method = $_GET['m'] ?? 'index';
$login->$method();