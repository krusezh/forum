<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/6
 * Time: 下午1:00
 */

require_once ('functions.php');
session_start();
ob_start();

try {
    if(!isset($_REQUEST['nodename'])) {
        throw new Exception('404: Not Found');
    }
    display_head($_REQUEST['nodename']);
    display_top();
    display_wrapper('node',$_REQUEST['nodename']);
    display_buttom();
}
catch (Exception $e) {
    ob_end_clean();
    display_head($e->getMessage());
    echo $e->getMessage();
    exit;
}
