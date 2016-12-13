<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/13
 * Time: 下午5:21
 */
function display_forget() {
    $code = mt_rand(0,1000000);
    $_SESSION['once'] = $code;
    ?>
    <div>
        <div class="setting-header">
            <span>通过电子邮件重设密码</span>
        </div>
        <div class="setting-form">
            <form action="forget_pwd.php" method="post">
                <div>
                    <span class="setting-left">用户名</span>
                    <span class="seeting-right"><input type="text" class="sl" name="username"></span>
                </div>
                <div>
                    <span class="setting-left">注册邮箱</span>
                    <span class="seeting-right"><input type="email" class="sl" name="email"></span>
                </div>
                <div>
                    <input type="hidden" name="once" value="<?php echo $code;?>">
                    <input class="button button-setting button-save" type="submit" value="发送邮件">
                </div>
            </form>
        </div>
    </div>
    <?php
}