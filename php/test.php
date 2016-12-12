<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/12
 * Time: 下午2:57
 */

$str = "$2y$10$.POrgMfgZd7WchTkvuVcL.Y4YXcZamj3qCiWPNkHXqYKxzkvnP3.6";

// Outputs: Is your name O\'Reilly?
echo addcslashes($str, '$');
?>
