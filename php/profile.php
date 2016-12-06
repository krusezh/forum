<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/2
 * Time: 下午9:34
 */
header("Content-type:text/html;charset=utf-8");
require_once ('functions.php');
session_start();
ob_start();

$username = $_REQUEST['username'];


try {
    if(!$username) {
        throw new Exception('404: Not Found');
    }
    else {
        display_head($username);
        display_top();
        display_wrapper('profile',$username);
        display_buttom();
    }
}
catch (Exception $e) {
    ob_end_clean();
    display_head($e->getMessage());
    echo $e->getMessage();
    exit;
}



