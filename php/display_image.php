<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/10
 * Time: 上午9:39
 */

function display_image($email,$default='retro') {
    require_once ('Gravatar.php');
    $gravatar = new Gravatar($email,$default);
    echo $gravatar->toHTML();
}