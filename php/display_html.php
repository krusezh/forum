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
                <span><a href="http://redfolder.cn/forum/">首页</a></span>
                <?php
                if(check_valid_user()) {
                    $username = $_SESSION['valid_user'];
                    ?>
                    <span><a href="<?php echo $place;?>profile.php?username=<?php echo $username;?>"><?php echo $username;?></a></span>
                    <span><a href="<?php echo $place;?>setting.php">设置</a></span>
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

function display_main($flag, $name, $password,$articleid,$email) {
?>
    <div class="content-main">
        <?php
        if($flag==='profile') {
            display_info($name);
        }
        elseif($flag==='index') {
            display_index();
        }
        elseif($flag==='logout') {
            logout($name);
        }
        elseif($flag==='login') {
            login($name,$password);
        }
        elseif($flag==='register') {
            register($name,$password,$email);
        }
        elseif($flag==='article') {
            display_article($name,$articleid);
        }
        elseif($flag==='node') {
            display_specific_node($name);
        }
        elseif($flag==='setting') {
            display_setting();
        }
        elseif($flag==='avatar') {
            set_avatar($name);
        }
        elseif($flag==='forget') {
            display_forget();
        }
        elseif($flag==='about') {
            display_about();
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
            <div class="right-islogin">
                <div>
                    <a href="<?php echo $place;?>profile.php?username=<?php echo $_SESSION['valid_user']?>">
                        <?php echo "<img src='".display_image($user_row[user_name])."' width='48' height='48'>";?>
                    </a>
                    <span>
                        <a style='display: block;margin: 5px;' href="<?php echo $place;?>profile.php?username=<?php echo $_SESSION['valid_user']?>"><?php echo $_SESSION['valid_user'];?></a>
                    </span>
                </div>
                <div>
                    <a href="<?php echo $place;?>write_article.php"><img style="margin:-7px 3px" src="https://www.v2ex.com/static/img/flat_compose.png?v=7d21f0767aeba06f1dec21485cf5d2f1" width="25" height="25"></a>
                    <a class="button-login" href="<?php echo $place;?>write_article.php">创作新主题</a>
                </div>
            </div>
            <?php
        }
        else {
            ?>
            <div class="right-not-login">
            <a href="<?php echo $place;?>register.php" class='button-pill'>现在注册</a><br>
            已注册用户请
            <a href="<?php echo $place;?>login.php" class='button-login'>登录</a>
            </div>
            <?php
        }
        echo "<div class='web-status'>";
            echo "<div>";
            echo "<span class='status-tip'>论坛运行状况</span>";
            echo "</div>";
            echo "<div>";
            $conn = db_connect();
            $query = "select * from userinfo";
            $result = $conn->query($query);
            echo "<span class='status-wrapper'><div>注册会员</div><div>$result->num_rows</div></span>";
            $query = "select * from article where parent_id=0";
            $result = $conn->query($query);
            echo "<span class='status-wrapper'><div>主题</div><div>$result->num_rows</div></span>";
            $query = "select * from article where parent_id<>0";
            $result = $conn->query($query);
            echo "<span class='status-wrapper'><div>回复</div><div>$result->num_rows</div></span>";
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
                <div><strong>
                        <a href="http://redfolder.cn/forum/about.php" class="dark" target="_self">关于</a>
                        &nbsp;
                        <a href="https://www.v2ex.com/" target="_blank">V2EX</a>
                        &nbsp;
                        <a href="https://github.com/livid/v2ex" target="_blank">源码</a>
                    </strong>
                </div>
                <div>张熹微&nbsp;2014211719</div>
                <div>沈文森&nbsp;2014211716</div>
                <div>乔玉鹏&nbsp;2014211739</div>
                <br />
                <div>创意工作者们的社区</div>
                <br />
                <div>World is powered by solitude</div>
                <div><span>♥ Do have faith in what you're doing.</span></div>
                <br />
                <span><a href="http://www.miibeian.gov.cn/" target="_blank" rel="nofollow">苏ICP备16060739号</a></span>
            </div>
        </div>
    </div>
<?php
}

function display_about() {
    ?>
    <br />
    <h1>关于</h1>
    这是一个临摹V2EX的网站
    <br />
    结构是按着v2的样子做的
    <br/>
    代码是自己写的
    <br />
    还有很多东西没写出来
    <br />
    之后再写
    <br />
    <br />
    注：在看v2关于页面html文件的时候
    <br />
    发现V2EX的源代码被托管到了GitHub上
    <br />
    然而后台全是py，看了也没什么乱用
    <?php
}