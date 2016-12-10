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

$username = stripslashes(trim($_POST['username']));
$userpwd = trim($_POST['password']);
$email = trim($_POST['email']);

if($username && $userpwd && $email) {
    try{
        if(!filled_out($_POST)){
            throw new Exception('You have not filled the form out correctly - please go back and try again.');
        }
        if((strlen($userpwd) < 8) || (strlen($userpwd) > 20)){
            throw new Exception('Your password must be between 8 and 20 characters. Please go back and try again.');
        }
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Wrong e-mail format.');
        }

        display_wrapper('register',$username,$userpwd);
        $_SESSION['valid_user'] = $username;

    }
    catch (Exception $e){
        echo $e->getMessage();
        exit;
    }
    display_buttom();
    $url = "../index.php";
    echo "<script type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
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
    <span>电子邮件</span>
    <br />
    <span><input type="text" name="email"></span>
    <br />
    <span><input type="submit" value="注册" /></span>
</form>

<?php
display_buttom();
?>