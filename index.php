<?php
if(file_exists('app/route/web.php')){
    define('APP_PATH', 'index.php');
    require 'app/route/web.php';
} else {
    echo "Website dang duoc nang cap";
}