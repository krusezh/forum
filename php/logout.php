<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/2
 * Time: 下午9:21
 */

session_start();

$old_user = $_SESSION['valid_user'];

unset($_SESSION['valid_user']);
$result_dest = session_destroy();

if(!empty($old_user)){
    if ($result_dest) {
        echo "Logged out.<br />";
    }
    else {
        echo "Could not log you out.<br />";
    }
}
else {
    echo "You were not logged in, and so have not been logged out.<br />";
}