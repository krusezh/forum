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
    <form action="login.php" method="post">
        <table border="0">
            <tr>
                <td>用户名</td>
            </tr>
            <tr>
                <td><input type="text" name="username"/></td>
            </tr>
            <tr>
                <td>密码</td>
            </tr>
            <tr>
                <td><input type="password" name="password"/></td>
            </tr>
            <tr>
                <td><input type="submit" value="登录"/></td>
            </tr>
        </table>
    </form>
<?php
}
display_buttom();
?>

