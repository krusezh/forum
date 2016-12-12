<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/12
 * Time: 下午7:40
 */
header("Content-type:text/html;charset=utf-8");
require_once ('functions.php');
session_start();
ob_start();

if(isset($_SESSION['once']) && isset($_POST['once'])) {
    if($_SESSION['once'] == $_POST['once']) {
        try {
            if(!check_valid_user()) {
                throw new Exception('404: Not Found');
            }
            set_extra_info();
        }
        catch (Exception $e) {
            ob_end_clean();
            display_head($e->getMessage());
            echo $e->getMessage();
            exit;
        }
    }
    else {
        $url = "setting.php";
        echo "<script type='text/javascript'>";
        echo "window.location.href='$url'";
        echo "</script>";
    }
}

try {
    if(!check_valid_user()) {
        throw new Exception('404: Not Found');
    }
    display_head('设置');
    display_top();
    display_wrapper('setting');
    display_buttom();
}
catch (Exception $e) {
    ob_end_clean();
    display_head($e->getMessage());
    echo $e->getMessage();
    exit;
}