<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/7
 * Time: 下午10:11
 */
header("Content-type:text/html;charset=utf-8");
date_default_timezone_set("Etc/GMT-8");
require_once ('functions.php');
session_start();
ob_start();

if($_POST['replycontent'] && $_POST['articleid'] && $_POST['once']){
    if($_SESSION['once'] == $_POST['once']) {
        try {
            publish_reply($_POST);
        }
        catch (Exception $e) {
            ob_end_clean();
            display_head($e->getMessage());
            echo $e->getMessage();
            exit;
        }
    }
    else {
        display_head('请不要刷新本页面或重复提交表单！');
        echo "请不要刷新本页面或重复提交表单！";
        exit;
    }
}

$username = $_GET['username'];
$articleid = $_GET['articleid'];
settype($articleid,'integer');

try {
    if(!$username || !$articleid) {
        throw new Exception('404: Not Found7');
    }
    else {
        $title = get_title($articleid);
        display_head($title);
        display_top();
        display_wrapper('article',$username,'none',$articleid);
        display_buttom();
    }
}
catch (Exception $e) {
    ob_end_clean();
    display_head($e->getMessage());
    echo $e->getMessage();
    exit;
}
?>

