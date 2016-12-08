<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/4
 * Time: 下午6:14
 */

function publish_article($date) {
    $title = $date['title'];
    $node = $date['node'];
    $content = $date['content'];
    $date = date("Y-m-d H:i:s");
    $username = $_SESSION['valid_user'];

    $result = get_use_info($username);
    $row = $result->fetch_assoc();
    $userid = $row['user_id'];

    $conn = db_connect();
    $query = "insert into article values (NULL,0,$userid,'$date')";
    $result = $conn->query($query);
    if(!$result) {
        throw new Exception('Could not publish your article1.');
    }

    $query = "insert into article_info values (NULL,'$title',0,$node)";
    $result = $conn->query($query);
    if(!$result) {
        throw new Exception('Could not publish your article2.');
    }

    $query = "insert into article_content values (NULL,'$content')";
    $result = $conn->query($query);
    if(!$result) {
        throw new Exception('Could not publish your article3.');
    }

    $conn->close();
}

function publish_reply() {

}