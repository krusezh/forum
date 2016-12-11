<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/2
 * Time: 下午8:13
 */
header("Content-type:text/html;charset=utf-8");
require_once ('functions.php');
session_start();

display_head('登录');
display_top();

$username = $_POST['username'];
$userpwd = $_POST['password'];

if ($username && $userpwd) {
    try {
        display_wrapper('login',$username,$userpwd);
        $_SESSION['valid_user'] = $username;
    }
    catch (Exception $e) {
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

if(check_valid_user()){
    echo "You have already logged in.";
}
else {
    ?>
    <div class="wrapper">
    <div id="form_wrapper" class="form_wrapper" style="width: 350px; height: 385px;">
                <form class="login active"  action="login.php" method="post">
                    <h3><cufon class="cufon cufon-canvas" alt="Login" style="width: 73px; height: 25px;"><canvas width="84" height="28" style="width: 84px; height: 28px; top: -2px; left: 0px;"></canvas><cufontext>Login</cufontext></cufon></h3>
                    <div>
                        <label>Username:</label>
                        <input name="username" type="text">
                    </div>
                    <div>
                        <label>Password:</label>
                        <input type="password" name="password">
                    </div>
                    <div class="bottom">
                        <input type="submit" value="登录">
                        <div class="clear"></div>
                    </div>
                </form>
        </div>
    </div>
<?php
}
display_buttom();
?>

