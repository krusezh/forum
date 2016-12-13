<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/14
 * Time: 上午12:30
 */
header("Content-type:text/html;charset=utf-8");
require_once ('./php/functions.php');
session_start();

display_head("About",'.');
display_top('./php/');
display_wrapper('about');
display_buttom();