<?php
namespace App\Core;

class MY_Controller {

    function __construct(){
        $this->checkLoginAdmins();
    }

    protected function checkLoginAdmins() {
        $username = $this->getSessionUser();
        $id = $this->getSessionId();
        if($username === '' || $id === 0){
            header("Location:?c=login");
            die();
        }
    }

    protected function loadHeader($header = []){
        $title = $header['title'] ?? '';
        $content = $header['content'] ?? '';
        $username = $this->getSessionUser();
        require_once 'app/view/partials/header_view.php';
    }

    protected function loadFooter(){
        require_once 'app/view/partials/footer_view.php';
    }

    protected function loadView($pathView, $data = []){
        require $pathView;
    }

    protected function getSessionUser(){
        $user = $_SESSION['username'] ?? '';
        return $user;
    }

    protected function getSessionId(){
        $id = $_SESSION['id'] ?? '';
        $id = is_numeric($id) ? $id : 0;
        return $id;
    }
    protected function getSessionEmail(){
        $email = $_SESSION['email'] ?? '';
        return $email;
    }
    protected function getSessionRole(){
        $role = $_SESSION['role'] ?? '';
        $role = is_numeric($role) ? $role : 0;
        return $role;
    }
}