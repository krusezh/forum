<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/4
 * Time: 下午4:01
 */

function display_head($title,$place='..') {
?>
    <!DOCTYPE html>
    <html lang="zh-CN">
    <head>
        <meta charset="UTF-8">
        <title><?php echo $title;?></title>
        <link rel="stylesheet" href="<?php echo $place?>/static/styles/reset.css">
        <link rel="stylesheet" href="<?php echo $place?>/static/styles/main.css">
    </head>
    <body>
    </body>
    </html>
<?php
}

function display_top($place='') {
?>
    <div class="header">
        <div class="wrapper clearfix">
        <div class="header-logo">FORUM</div>
            <div class="header-nav">
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
        </div>
    </div>    
<?php
}

function display_wrapper($flag,$username='none',$password='none',$articelid=0,$email='none') {
?>
    <div class="content">
        <div class="wrapper clearfix">
            <?php
            display_right_bar($flag);
            display_main($flag,$username,$password,$articelid,$email);
            ?>
        </div>
    </div>
<?php
}

function display_main($flag, $username, $password,$articleid,$email) {
?>
    <div class="content-main">
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
            register($username,$password,$email);
        }
        elseif($flag==='article'){
            display_article($username,$articleid);
        }
        ?>
    </div>
<?php
}

function display_right_bar($flag,$place='') {
    if($flag === 'index') {
        $place = './php/';
    }
    ?>
    <div class="content-right">
        <?php
        if(check_valid_user()) {
            $user_result = get_use_info($_SESSION['valid_user']);
            $user_row = $user_result->fetch_assoc();
            ?>
            <div>
                <div>
                    <a href="<?php echo $place;?>profile.php?username=<?php echo $_SESSION['valid_user']?>">
                        <?php display_image($user_row[e_mail],48)?>
                    </a>
                    <span>
                        <a href="<?php echo $place;?>profile.php?username=<?php echo $_SESSION['valid_user']?>"><?php echo $_SESSION['valid_user'];?></a>
                    </span>
                </div>
                <div>
                    <a href="<?php echo $place;?>write_article.php"><img src="https://www.v2ex.com/static/img/flat_compose.png?v=7d21f0767aeba06f1dec21485cf5d2f1" width="25" height="25"></a>
                    <a href="<?php echo $place;?>write_article.php">创作新主题</a>
                </div>
            </div>
            <?php
        }
        else {
            ?>
            <div>
            <a href="<?php echo $place;?>register.php">现在注册</a>
            已注册用户请
            <a href="<?php echo $place;?>login.php">登录</a>
            </div>
            <?php
        }
        echo "<div>";
            echo "<div>";
            echo "<span>论坛运行状况</span>";
            echo "</div>";
            echo "<div>";
            $conn = db_connect();
            $query = "select * from userinfo";
            $result = $conn->query($query);
            echo "<span>注册会员&nbsp&nbsp$result->num_rows</span>";
            $query = "select * from article where parent_id=0";
            $result = $conn->query($query);
            echo "<span>主题&nbsp&nbsp$result->num_rows</span>";
            $query = "select * from article where parent_id<>0";
            $result = $conn->query($query);
            echo "<span>回复&nbsp&nbsp$result->num_rows</span>";
            echo "</div>";
        echo "</div>";
        ?>
    </div>
    <?php
}

function display_buttom() {
?>
    <div class="footer">
        <div class="content wrapper">
            <div class="inner">
                <div class="sep10"></div>
                    <div class="fr">
                    </div>
                    <strong><a href="/about" class="dark" target="_self">关于</a> &nbsp; <span class="snow">·</span> &nbsp; <a href="/faq" class="dark" target="_self">FAQ</a> &nbsp; <span class="snow">·</span> &nbsp; <a href="/p/7v9TEc53" class="dark" target="_self">API</a> &nbsp; <span class="snow">·</span> &nbsp; <a href="/mission" class="dark" target="_self">我们的愿景</a> &nbsp; <span class="snow">·</span> &nbsp; <a href="/ip" class="dark" target="_self">IP 查询</a> &nbsp; <span class="snow">·</span> &nbsp; <a href="/advertise" class="dark" target="_self">广告投放</a> &nbsp; <span class="snow">·</span> &nbsp; <a href="/advertise/2015.html" class="dark" target="_self">鸣谢</a> &nbsp; <span class="snow">·</span> &nbsp; <a href="/start" class="dark" target="_blank">上网首页</a> &nbsp; <span class="snow">·</span> &nbsp; 1198 人在线</strong> &nbsp; <span class="fade">最高记录 2399</span> &nbsp; <span class="snow">·</span> &nbsp;
                    <div class="sep20"></div>
                    创意工作者们的社区
                    <div class="sep5"></div>
                    World is powered by solitude
                    <div class="sep20"></div>
                    <span class="small fade">VERSION: 3.9.7.5 · 31ms · UTC 05:44 · PVG 13:44 · LAX 21:44 · JFK 00:44<br>♥ Do have faith in what you're doing.</span>
                    <div class="sep20"></div>
                    <span class="f12 gray"><a href="http://www.miibeian.gov.cn/" target="_blank" rel="nofollow">苏ICP备16060739号</a></span>
                <div class="sep10"></div>
            </div>
        </div>
    </div>
<?php
}
