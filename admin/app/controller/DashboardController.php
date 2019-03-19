<?php
namespace App\Controller;
require 'app/core/MY_Controller.php';
use App\Core\MY_Controller;

if(!defined('APP_PATH')) {
    die('can not access');
}

class DashboardController extends MY_Controller {
    function __construct(){
        parent::__construct();
    }

    public function index(){
        // load xu ly du lieu

        // load header
        $header = [];
        $header['title'] = 'This is dashboard';
        $header['content'] = 'This is dashboard';
        $this->loadHeader($header);

        // load content view
        $this->loadView('app/view/dashboard/index_view.php');

        // load footer
        $this->loadFooter();
    }
}

$dash = new DashboardController;
$method = $_GET['m'] ?? 'index';
$dash->$method();