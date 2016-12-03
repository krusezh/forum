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

$username = $_REQUEST['username'];

try {
    if(!filled_out($_REQUEST)){
        throw new Exception('Wrong name, no info.');
    }
    display_info($username);
}
catch (Exception $e) {
    echo $e->getMessage();
    exit;
}



