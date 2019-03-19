<?php

if(!defined('APP_PATH')) {
    die('can not access');
}

function uploadFileData($file){
    // xu ly upload
    if($file['error'] == 0){
        $tmpName = $file['tmp_name'];
        $nameFile = $file['name'];
        if($tmpName !== ''){
            if(move_uploaded_file($tmpName, PATH_IMAGE . $nameFile)){
                return $nameFile;
            }
        }
    }
    return;
}

function validateAddProduct($namePd, $catId, $sizeId, $price, $qty, $desPd, $image)
{
    $error = [];

    $error['namepd'] = ($namePd == '') ? 'Enter name product' : '';
    $error['catid']  = ($catId <= 0) ? 'Enter Categories' : '';
    $error['sizeid'] = ($sizeId <= 0) ? 'Enter Sizes' : '';
    $error['price']  = ($price <=0 ) ? 'Enter Price' : '';
    $error['qty']    = ($qty <=0 ) ? 'Enter Quanity' : '';
    $error['desPd']  = ($desPd == '') ? 'Enter Description' : '';
    $error['image']  = ($image == '') ? 'Enter Image' : '';

    return $error;
}

// viet ham bo tro cho viec phan trang
// toi muon biet ban can phan trang cho module nao?
// can tim link phan trang cho cac module co dinh dang nhu the nao?
function create_link($data = []){
    $urlLinks = '';
    foreach ($data as $key => $val) {
        $urlLinks .= "{$key}={$val}&";
    }
    return ($urlLinks != '') ? BASE_URL . "?" . rtrim($urlLinks,'&') : BASE_URL;
}

function pagination($link, $totalRecord, $currentPage, $limit = 2, $keyword = ''){
    // can tinh duoc total page
    $totalPage = ceil($totalRecord/$limit);
    // can thiet lai cai pham vi cua current page
    if($currentPage < 1){
        $currentPage = 1;
    }
    elseif($currentPage > $totalPage){
        $currentPage = $totalPage;
    }
    // tinh start
    $start = ($currentPage - 1) * $limit;

    // xay dung template phan trang bang bootstrap
    $html = '';
    $html .= "<nav aria-label='...'>";
    $html .= "<ul class='pagination'>";
    // xu ly hien thi nut prev
    if($currentPage > 1 && $currentPage <= $totalPage){
        $html .= "<li class='page-item'> <a class='page-link' href='".str_replace('{page}',$currentPage-1,$link)."' tabindex='-1'>Previous</a></li>";
    }
    // hien thi cho cac trang o giua
    for($i = 1; $i <= $totalPage; $i++){
        // kiem tra xem dau la trang hien tai
        if($i == $currentPage){
            // active mau sac de bao hieu day la trang hien tai
            $html .= "<li class='page-item active'> <a class='page-link'>".$currentPage."</a></li>";
        } else {
            $html .= "<li class='page-item'><a class='page-link' href='".str_replace('{page}', $i, $link)."'>".$i."</a></li>";
        }
    }
    // xu ly cho nut next
    if($currentPage < $totalPage && $currentPage >= 1){
        $html .= "<li class='page-item'><a class='page-link' href='".str_replace('{page}', $currentPage+1, $link)."'>Next</a></li>";
    }
    $html .= "</ul>";
    $html .= "</nav>";

    return [
        'start' => $start,
        'page' => $currentPage,
        'htmlPage' => $html,
        'limit' => $limit
    ];
}