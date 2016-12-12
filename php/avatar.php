<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/13
 * Time: 上午12:42
 */
require_once ('functions.php');
session_start();
ob_start();

if(isset($_SESSION['once']) && isset($_POST['once'])) {
    if($_SESSION['once'] == $_POST['once']) {
        try {
            if(isset($_FILES['avatar'])) {
                mv_avatar($_FILES['avatar']);
            }
            else {
                throw new Exception('没有上传文件');
            }
        }
        catch (Exception $e) {
            ob_end_clean();
            display_head($e->getMessage());
            echo $e->getMessage();
            exit;
        }
    }
    else {
        $url = "avatar.php";
        echo "<script type='text/javascript'>";
        echo "window.location.href='$url'";
        echo "</script>";
    }
}

try {
    if(!check_valid_user()) {
        throw new Exception('404: Not Found');
    }
    $username = $_SESSION['valid_user'];
    display_head('上传头像');
    display_top();
    display_wrapper('avatar',$username);
    display_buttom();
}
catch (Exception $e) {
    ob_end_clean();
    display_head($e->getMessage());
    echo $e->getMessage();
    exit;
}