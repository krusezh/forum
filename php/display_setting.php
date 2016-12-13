<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/12
 * Time: 下午7:41
 */

function display_setting() {
    $username = $_SESSION['valid_user'];
    $result = get_use_info($username);
    $row = $result->fetch_assoc();

    $code = mt_rand(0,1000000);
    $_SESSION['once'] = $code;
    ?>
    <div>
        <div class="setting-header">
            设置
        </div>
        <div class="setting-form">
            <form method="post" action="setting.php">
                <div>
                    <span class="setting-left">用户名</span>
                    <span class="seeting-right"><?php echo $row[user_name]?></span>
                </div>
                <div>
                    <span class="setting-left">电子邮件</span>
                    <span class="seeting-right"><input type="email" class="sl" name="email" value="<?php echo $row[e_mail]?>"></span>
                    <span><input onclick="location.href='resend_email.php'" value="重发验证邮件" type="button"></span>
                </div>
                <div>
                    <span class="setting-left">个人网站</span>
                    <span class="seeting-right"><input type="url" class="sl" name="personal_website"></span>
                </div>
                <div>
                    <span class="setting-left">签名</span>
                    <span class="seeting-right"><input type="text" class="sl" name="signature"></span>
                </div>
                <div>
                    <input type="hidden" name="once" value="<?php echo $code?>">
                    <span><input type="submit" value="保存设置"></span>
                </div>
            </form>
        </div>
    </div>

    <div>
        <div>
            头像上传
        </div>
        <div>
            <span>当前头像</span>
            <span><?php echo "<img src='".display_image($row[user_name])."' width='73' height='73'>";?></span>
            &nbsp;
            <span><?php echo "<img src='".display_image($row[user_name])."' width='48' height='48'>";?></span>
            &nbsp;
            <span><?php echo "<img src='".display_image($row[user_name])."' width='24' height='24'>";?></span>
        </div>
        <div>
            <input onclick="location.href='avatar.php'" value="上传新头像" type="button">
        </div>
    </div>

    <div>
        <div>
            更改密码
        </div>
        <div>
            <form method="post" action="setting.php">
                <div>
                    <span>当前密码</span>
                    <span><input type="password" name="current_password"></span>
                </div>
                <div>
                    <span>新密码</span>
                    <span><input type="password" name="new_password"></span>
                </div>
                <div>
                    <span>再次输入新密码</span>
                    <span><input type="password" name="again_password"></span>
                </div>
                <div>
                    <input type="hidden" name="once" value="<?php echo $code?>">
                    <input type="submit" value="更改密码">
                </div>
            </form>
        </div>

    </div>
    <?php
}