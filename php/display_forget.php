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
        <div>
            <span>通过电子邮件重设密码</span>
        </div>
        <div>
            <form action="forget_pwd.php" method="post">
                <div>
                    <span>用户名</span>
                    <span><input type="text" name="username"></span>
                </div>
                <div>
                    <span>注册邮箱</span>
                    <span><input type="url" name="email"></span>
                </div>
                <div>
                    <input type="hidden" name="once" value="$code">
                    <input type="submit" value="发送邮件">
                </div>
            </form>
        </div>
    </div>
    <?php
}