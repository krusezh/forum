<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/13
 * Time: 下午5:07
 */

header("Content-type:text/html;charset=utf-8");
require_once ('functions.php');
session_start();
ob_start();

if(isset($_SESSION['once']) && isset($_POST['once'])) {
    if($_SESSION['once'] == $_POST['once']) {
        try {
            if(check_valid_user()) {
                throw new Exception('404: Not Found');
            }
            send_pwd();
        }
        catch (Exception $e) {
            ob_end_clean();
            display_head($e->getMessage());
            echo $e->getMessage();
            exit;
        }
    }
    else {
        $url = "forget_pwd.php";
        echo "<script type='text/javascript'>";
        echo "window.location.href='$url'";
        echo "</script>";
    }
}
else {
    try {
        if(check_valid_user()) {
            throw new Exception('404: Not Found');
        }
        display_head('通过邮件重设密码');
        display_top();
        display_wrapper('forget');
        display_buttom();
    }
    catch (Exception $e) {
        ob_end_clean();
        display_head($e->getMessage());
        echo $e->getMessage();
        exit;
    }
}
