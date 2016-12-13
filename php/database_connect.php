<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/1
 * Time: 下午10:27
 */


function db_connect(){
    $host = 'localhost';
    //$host = 'redfolder.cn';
    $result = new mysqli($host,'registeruser','1234567890,.?','forumdatabase');
    $result->query("SET NAMES UTF8");
    if(!$result){
        throw new Exception('Could not connect to database server');
    }
    else{
        return $result;
    }
}