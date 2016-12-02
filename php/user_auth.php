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