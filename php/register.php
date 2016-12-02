<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/1
 * Time: 下午8:10
 */
header("Content-type:text/html;charset=utf-8");
require_once("data_valid.php");
require_once ("user_auth.php");
require_once ('database_connect.php');
date_default_timezone_set("Etc/GMT-8");

$user_name = $_POST['username'];
$user_password = $_POST['password'];

session_start();

try{
    if(!filled_out($_POST)){
        throw new Exception('You have not filled the form out correctly - please go back and try again.');
    }
    if((strlen($user_password) < 8) || (strlen($user_password) > 20)){
        throw new Exception('Your password must be between 8 and 20 characters. Please go back and try again.');
    }
    register($user_name,$user_password);
    $_SESSION['valid_user'] = $user_name;

    echo 'Your registeration was successful. Go to the members page to start setting up your profile!';
}
catch (Exception $e){
    var_dump($user_name);
    echo $e->getMessage();
    exit;
}

