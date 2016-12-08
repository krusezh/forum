<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/7
 * Time: 下午10:11
 */
header("Content-type:text/html;charset=utf-8");
require_once ('functions.php');
session_start();
ob_start();

$username = $_REQUEST['username'];
$articleid = $_REQUEST['articleid'];
settype($articleid,'integer');

try {
    if(!$username || !$articleid) {
        throw new Exception('404: Not Found');
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