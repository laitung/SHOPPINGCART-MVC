<?php
if(file_exists('app/route/web.php')){
    define('APP_PATH', 'index.php');
    require_once 'app/route/web.php';
} else {
    echo "Ban khong co quyen truy cap";
}