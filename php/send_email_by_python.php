<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/11
 * Time: 下午7:05
 */

function send_email($action, $to, $code) {
    if($action=='active') {
        exec("python sendMail.py $to $code",$arr,$re);
        if($re==1) {
            throw new Exception('邮件发送失败');
        }
    }
    elseif($action=='chpwd') {
        exec("python sendMail.py $to $code",$arr,$re);
        if($re==1) {
            throw new Exception('邮件发送失败');
        }
    }
}