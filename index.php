<?php
header("Content-type:text/html;charset=utf-8");
require_once ('./php/functions.php');
session_start();
ob_start();

try {
    display_head("FORUM",'.');
    display_top('./php/');
    display_wrapper('index');
    display_buttom();
}
catch (Exception $e) {
    ob_end_clean();
    display_head($e->getMessage());
    echo $e->getMessage();
    exit;
}