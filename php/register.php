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

session_start();
display_head('注册');
display_top();

$username = $_POST['username'];
$userpwd = $_POST['password'];
if($username && $userpwd) {
    try{
        if(!filled_out($_POST)){
            throw new Exception('You have not filled the form out correctly - please go back and try again.');
        }
        if((strlen($userpwd) < 8) || (strlen($userpwd) > 20)){
            throw new Exception('Your password must be between 8 and 20 characters. Please go back and try again.');
        }

        display_wrapper('register',$username,$userpwd);
        $_SESSION['valid_user'] = $username;
    }
    catch (Exception $e){
        echo $e->getMessage();
        exit;
    }
    display_buttom();
    exit;
}
?>
<form action="register.php" method="post">
    <span>用户名</span>
    <br />
    <span><input type="text" name="username" /></span>
    <br />
    <span>密码</span>
    <br />
    <span><input type="password" name="password" /></span>
    <br />
    <span><input type="submit" value="注册" /></span>
</form>

<?php
display_buttom();
?>