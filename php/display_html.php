<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/4
 * Time: 下午4:01
 */

function display_head($title) {
?>
    <!DOCTYPE html>
    <html lang="zh-CN">
    <head>
        <meta charset="UTF-8">
        <title><?php echo $title;?></title>
    </head>
    <body>
    </body>
    </html>
<?php
}

function display_top($place='') {
?>
    <div>
        <span><a href="http://localhost/phpstorm/forum/">首页</a></span>
        <?php
        if(check_valid_user()) {
            $username = $_SESSION['valid_user'];
            ?>
            <span><a href="<?php echo $place;?>profile.php?username=<?php echo $username;?>"><?php echo $username;?></a></span>
            <span><a href="<?php echo $place;?>write_article.php">创建新主题</a></span>
            <span><a href="<?php echo $place;?>logout.php">登出</a></span>
            <?php
        }
        else {
            ?>
            <span><a href="<?php echo $place;?>register.php">注册</a></span>
            <span><a href="<?php echo $place;?>login.php">登录</a></span>
            <?php
        }
        ?>
    </div>
<?php
}

function display_wrapper($flag,$username='none',$password='none',$articelid=0) {
?>
    <div>
        <?php
        display_right_bar();
        display_main($flag,$username,$password,$articelid);
        ?>
    </div>
<?php
}

function display_main($flag, $username, $password,$articleid) {
?>
    <div>
        <?php
        if($flag==='profile'){
            display_info($username);
        }
        elseif($flag==='index'){
            display_index();
        }
        elseif($flag==='logout'){
            logout($username);
        }
        elseif($flag==='login'){
            login($username,$password);
        }
        elseif($flag==='register'){
            register($username,$password);
        }
        elseif($flag==='article'){
            display_article($username,$articleid);
        }
        ?>
    </div>
<?php
}

function display_right_bar() {
    ?>
    <div>

    </div>
    <?php
}

function display_buttom() {
?>
    <div>

    </div>
<?php
}