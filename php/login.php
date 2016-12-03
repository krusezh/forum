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

$username = $_POST['username'];
$userpwd = $_POST['password'];

if ($username && $userpwd) {
    try {
        login($username, $userpwd);
        $_SESSION['valid_user'] = $username;
    }
    catch (Exception $e) {
        echo $e->getMessage();
        exit;
    }
}

check_valid_user();
?>
<html>
<body>
    <form action="profile.php" method="post">
        <table>
            <tr>
                <td><input type="text" name="username" value="<?php echo $_SESSION['valid_user']?>" /></td>
                <td><input type="submit" value="submit" /></td>
            </tr>
        </table>
    </form>
</body>
</html>
