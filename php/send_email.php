<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/10
 * Time: 下午2:26
 */

function active_account_email($username,$email) {
    require_once ('../vendor/autoload.php');
    $mail = new PHPMailer();

    $mail->isSMTP();
    $mail->Host = "smtp.126.com";
    $mail->SMTPAuth = true;
    $mail->Username = "redfolder@126.com";
    $mail->Password = "159357oIl";
    $mail->SMTPSecure = "tls";
    $mail->Port = 587;

    $mail->setFrom("redfolder@126.com","redfolder");
    $mail->addAddress($email,$username);

    $mail->CharSet = "UTF-8";
    $mail->SMTPDebug = 2;

    $mail->isHTML(true);

    $mail->Subject = 'Here is the subject';
    $mail->Body = 'This is the HTML message body <b>in bold!</b>';
        /*"$username ：<br />点击链接激活你的账号：<br /><a href='http://redfolder.cn/php/active.php?verify=$active_code' target='_blank'>".
                "http://redfolder.cn/php/active.php?verify=$active_code</a><br/>如果以上链接无法点击，将它复制到你的浏览器地址栏中进入访问，该链接24小时内有效。";
        */
    if(!$mail->send()) {
        echo '验证邮件发送失败。';
    }
    else {
        echo "发送成功";
    }
}

function change_pwd_email() {

}