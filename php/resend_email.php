<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/13
 * Time: 下午3:08
 */

header("Content-type:text/html;charset=utf-8");
require_once ('functions.php');
date_default_timezone_set("Etc/GMT-8");
session_start();

try {
    if(!check_valid_user()) {
        $url = "setting.php";
        echo "<script type='text/javascript'>";
        echo "window.location.href='$url'";
        echo "</script>";
    }
    else {
        $result = get_use_info($_SESSION['valid_user']);
        $row = $result->fetch_assoc();
        $active_status = $row[active_status];
        if($active_status) {
            $url = "setting.php";
            echo "<script type='text/javascript'>";
            echo "window.location.href='$url'";
            echo "</script>";
        }

        $username = $row[user_name];
        $email = $row[e_mail];
        $active_time = time()+60*60*24;
        $active_date = date("Y-m-d H:i:s",$active_time);
        $active_code = password_hash($username.$active_date,PASSWORD_DEFAULT);
        $active_code = addcslashes($active_code,'$');

        send_email('active',$email,$active_code);

        $conn = db_connect();
        $query = "update userinfo set active_time=$active_time where user_name='$username'";
        $result = $conn->query($query);
        if(!$result) {
            throw new Exception('更改数据库失败');
        }
    }
}
catch (Exception $e) {
    display_head($e->getMessage());
    echo $e->getMessage();
    exit;
}

display_head('重发验证邮件');
display_top();
echo "重发成功";
display_buttom();