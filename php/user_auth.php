<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/1
 * Time: 下午10:26
 */

function register($username, $password, $email){
    require_once ('Gravatar.php');
    $gravatar = new Gravatar($email,'retro');
    $image_url = $gravatar->getSrc();
    $password = password_hash($password, PASSWORD_DEFAULT);
    $date = date("Y-m-d H:i:s");
    $active_time = time()+60*60*24;
    $active_date = date("Y-m-d H:i:s",$active_time);
    $active_code = password_hash($username.$active_date,PASSWORD_DEFAULT);
    $active_code = addcslashes($active_code,'$');


    $conn = db_connect();
    $result = $conn->query("select * from userinfo where user_name='$username'");
    if(!$result){
        throw new Exception('Could not execute query');
    }
    if($result->num_rows>0){
        throw new Exception('That username is taken - go back and choose another one.');
    }

    $query = "insert into userinfo values (NULL,'$username','$password','$email','$image_url','$date',$active_time,0)";
    $result = $conn->query($query);

    if(!$result){
        throw new Exception('Could not register you in database1 - please try again later.');
    }

    send_email('active',$email,$active_code);

    $conn->close();
    return true;
}

function login($username, $password) {
    $username = stripslashes(trim($username));
    $conn = db_connect();
    $result = $conn->query("select * from userinfo where user_name='$username'");
    if(!$result) {
        throw new Exception('Could not log you in.');
    }

    if($result->num_rows>0){
        $row = $result->fetch_assoc();
        $hash = $row[password];
        if(password_verify($password,$hash)){
            $conn->close();
            return true;
        }
        else {
           throw new Exception('Could not log you in.');
        }
    }
    else {
        throw new Exception('Could not log you in.');
    }
}

function logout($old_user) {

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
}

function check_valid_user() {
    if(isset($_SESSION['valid_user'])) {
        return true;
    }
    else {
        return false;
    }
}

function set_extra_info() {
    $username = $_SESSION['valid_user'];

    if($_POST['personal_website'] || $_POST['signature'] || $_POST['e_mail']) {
        set_email($username);
        set_site_and_signature($username);
    }
    elseif($_POST['current_password'] || $_POST['new_password'] || $_POST['again_password']) {
        if($_POST['current_password'] && $_POST['new_password'] && $_POST['again_password']) {
            if($_POST['new_password'] != $_POST['again_password']) {
                throw new Exception('两次输入的密码不同');
            }

            if((strlen($_POST['new_password']) < 8) || (strlen($_POST['new_password']) > 20)){
                throw new Exception('Your password must be between 8 and 20 characters. Please go back and try again.');
            }
            change_pwd($username);
        }
        else {
            throw new Exception('密码未填写完整');
        }
    }
}

function change_pwd($username) {
    $conn = db_connect();
    $result = $conn->query("select * from userinfo where user_name='$username'");
    if(!$result) {
        throw new Exception('更改失败');
    }

    if($result->num_rows>0){
        $row = $result->fetch_assoc();
        $hash = $row[password];
        $password = $_POST['current_password'];
        if(password_verify($password,$hash)){
            $new_password = password_hash($_POST['new_password'],PASSWORD_DEFAULT);
            $query = "update userinfo set password='$new_password' where user_name='$username'";
            $reset_result = $conn->query($query);
            if(!$reset_result) {
                throw new Exception('更改失败');
            }
            if(!$conn->affected_rows) {
                throw new Exception('更改失败');
            }
        }
        else {
            throw new Exception('密码错误');
        }
    }
    else {
        throw new Exception('更改失败');
    }
}

function set_email($username) {
    $conn = db_connect();
    if($_POST['e_mail']) {
        $e_mail = $_POST['e_mail'];
        if(!filter_var($e_mail,FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Wrong e-mail format.');
        }

        $query = "update userinfo set e_mail='$e_mail' where user_name='$username'";
        $result= $conn->query($query);
        if(!$result) {
            throw new Exception('Could not execute query');
        }
        if(!$conn->affected_rows) {
            throw new Exception('设置失败');
        }
        $conn->close();
    }
}

function set_site_and_signature($username) {
    $conn = db_connect();
    $query = "select * from extra_user_info where user_name='$username'";
    $result=$conn->query($query);
    if(!$result) {
        throw new Exception('Could not execute query');
    }
    $num=$result->num_rows;

    if($_POST['personal_website']) {
        $personal_website = $_POST['personal_website'];
        if(!filter_var($personal_website,FILTER_VALIDATE_URL)) {
            throw new Exception('Wrong URL format.');
        }
        if($_POST['signature']) {
            $signature = $_POST['signature'];
            if($num>0) {
                $query = "update extra_user_info set personal_website='$personal_website',signature='$signature' where user_name='$username'";
            }
            else {
                $query = "insert into extra_user_info values ('$username','$personal_website','$signature')";
            }
        }
        else {
            if($num>0) {
                $query = "update extra_user_info set personal_website='$personal_website' where user_name='$username'";
            }
            else {
                $query = "insert into extra_user_info values ('$username','$personal_website','none')";
            }
        }

        $result= $conn->query($query);
        if(!$result) {
            throw new Exception('Could not execute query');
        }
        if(!$conn->affected_rows) {
            throw new Exception('设置失败');
        }
    }
    else {
        if($_POST['signature']) {
            $signature = $_POST['signature'];
            if($num>0) {
                $query = "update extra_user_info set signature='$signature' where user_name='$username'";
            }
            else {
                $query = "insert into extra_user_info values ('$username','none','$signature')";
            }
            $result= $conn->query($query);
            if(!$result) {
                throw new Exception('Could not execute query');
            }
            if(!$conn->affected_rows) {
                throw new Exception('设置失败');
            }
        }
    }
    $conn->close();
}

function send_pwd() {
    $username = $_POST['username'];
    $email = $_POST['email'];
    if($username && $email) {
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Wrong email format');
        }
        $result = get_use_info($username);

        $row = $result->fetch_row();

        if($email != $row[e_mail]) {
            throw new Exception('Wrong email');
        }

        $name_len = strlen($username);


    }
}