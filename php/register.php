<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/1
 * Time: 下午8:10
 */
header("Content-type:text/html;charset=utf-8");
require_once ('functions.php');
date_default_timezone_set("Etc/GMT-8");

$username = $_POST['username'];
$userpwd = $_POST['password'];

session_start();

try{
    if(!filled_out($_POST)){
        throw new Exception('You have not filled the form out correctly - please go back and try again.');
    }
    if((strlen($userpwd) < 8) || (strlen($userpwd) > 20)){
        throw new Exception('Your password must be between 8 and 20 characters. Please go back and try again.');
    }
    register($username,$userpwd);
    $_SESSION['valid_user'] = $username;

    echo 'Your registeration was successful. Go to the members page to start setting up your profile!';
}
catch (Exception $e){
    echo $e->getMessage();
    exit;
}

