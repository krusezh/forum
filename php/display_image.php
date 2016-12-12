<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/10
 * Time: 上午9:39
 */

function display_image($username) {
    $result = get_use_info($username);
    $row = $result->fetch_assoc();
    return $row['image_url'];
}