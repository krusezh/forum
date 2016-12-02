<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/1
 * Time: 下午9:40
 */

function filled_out($form_vars){
    foreach ($form_vars as $key => $value) {
        if((!isset($key)) || ($value=='')){
            return false;
        }
    }
    return true;
}

