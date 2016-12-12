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

        display_wrapper('register',$username,$userpwd,0,$email);
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

<div class="wrapper" style="margin-top:25px;">
<div id="form_wrapper" class="form_wrapper" style="width: 350px; height: 385px;">
    <form action="register.php" method="post" class="login active">
        <h3><cufon class="cufon cufon-canvas" alt="Register" style="width: 106px; height: 25px;"><canvas width="122" height="28" style="width: 122px; height: 28px; top: -2px; left: 0px;"></canvas><cufontext>Register</cufontext></cufon></h3>
            <div>
                <label>Username:</label>
                <input type="text" name="username">
            </div>
            <div>
                <label>Email:</label>
                <input type="text" name="email">
            </div>
            <div>
                <label>Password:</label>
                <input type="password"  name="password">
            </div>
            <div class="bottom clearfix">
                <input type="submit" value="注册">
            </div>
    </form>
</div>
</div>
<?php
display_buttom();
?>