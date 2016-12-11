<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/11
 * Time: 下午7:05
 */

function send_email($to, $code) {
    exec("python sendMail.py $to $code",$arr,$re);
}