<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/4
 * Time: 下午4:37
 */
header("Content-type:text/html;charset=utf-8");
date_default_timezone_set("Etc/GMT-8");
require_once ('functions.php');
session_start();
?>
<div>
<?php
try {
    if(!filled_out($_POST)){
        throw new Exception('You have not filled the form out correctly - please go back and try again.');
    }
    publish_article($_POST);
}
catch (Exception $e){
    echo $e->getMessage();
    exit;
}
echo "发布成功！";
?>
</div>
<?php

