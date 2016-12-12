<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/11
 * Time: 下午9:00
 */

require_once ('functions.php');
session_start();
ob_start();
display_head('邮箱激活');
display_top();
$code = stripslashes(trim($_REQUEST['verify']));
$username = $_SESSION['valid_user'];
try {
    if(!$code) {
        throw new Exception('404: Not Found');
    }
    if(!check_valid_user()) {
        throw new Exception('用户未登录');
    }

    $result = get_use_info($username);
    $row = $result->fetch_assoc();
    $str = $row[user_name].$row[reg_time];

    if($row['active_staus']) {
        throw new Exception('用户邮箱已经验证');
    }

    if(time()>$row['active_time']) {
        throw new Exception('验证邮件已经过期，进入设置重新发送验证邮件');
    }

    if(!password_verify($str,$code)){
        throw new Exception('验证用户错误');
    }
    $conn = db_connect();
    $query = "update userinfo set active_status=1 where user_name='$username'";
    $result = $conn->query($query);
    if(!$result) {
        throw new Exception('激活失败');
    }
    echo "邮箱激活成功";
    display_buttom();
}
catch (Exception $e) {
    ob_end_clean();
    display_head($e->getMessage());
    display_top();
    echo $e->getMessage();
    exit;
}
