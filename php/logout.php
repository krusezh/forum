<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/2
 * Time: 下午9:21
 */
require_once ('functions.php');
session_start();

$old_user = $_SESSION['valid_user'];

unset($_SESSION['valid_user']);

display_head('登出');
display_top();
display_wrapper('logout',$old_user);
display_buttom();