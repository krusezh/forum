<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/1
 * Time: 下午10:26
 */

function register($username, $password){
    $password = password_hash($password, PASSWORD_DEFAULT);
    $date = date("Y-m-d H:i:s");
    $conn = db_connect();
    $result = $conn->query("select * from userinfo where user_name='".$username."'");
    if(!$result){
        throw new Exception('Could not execute query');
    }
    if($result->num_rows>0){
        throw new Exception('That username is taken - go back and choose another one.');
    }

    $query = "insert into userinfo values (NULL,'".$username."','".$password."','".$date."')";
    $result = $conn->query($query);

    if(!$result){
        throw new Exception('Could not register you in database - please try again later.');
    }


    return ture;
}

function login($username, $password) {
    $conn = db_connect();

    $result = $conn->query("select * from userinfo where user_name='".$username."'");
    if(!$result) {
        throw new Exception('Could not log you in.');
    }

    if($result->num_rows>0){
        $row = $result->fetch_assoc();
        $hash = $row[password];
        if(password_verify($password,$hash)){
            return true;
        }
        else {
           throw new Exception('Could not log you in.');
        }
    }
    else {
        throw new Exception('Could not log you in');
    }
}

function check_valid_user() {
    if(isset($_SESSION['valid_user'])) {
        echo "Logged in as ".$_SESSION['valid_user'];
    }
    else {
        echo 'You are not logged in.';
        exit;
    }
}