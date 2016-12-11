<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/10
 * Time: 上午9:39
 */

function display_image($email,$size,$default='retro') {
    require_once ('Gravatar.php');
    $gravatar = new Gravatar($email,$default);
    $gravatar->setSize($size);
    echo $gravatar->toHTML();
}