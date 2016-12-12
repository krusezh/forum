<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/4
 * Time: 下午6:14
 */

function publish_article($data) {
    $title = $data['title'];
    $node = $data['node'];
    $content = $data['content'];
    $date = date("Y-m-d H:i:s");
    $username = $_SESSION['valid_user'];

    $result = get_use_info($username);
    $row = $result->fetch_assoc();
    $userid = $row['user_id'];

    $conn = db_connect();
    $query = "insert into article values (NULL,0,$userid,'$date')";
    //测试

    $result = $conn->query($query);

    if(!$result) {
        throw new Exception('Could not publish your article1.');
    }

    $delarticle = "delete from article where post_time='$date' and author_id=$userid";

    $query = "select article_id from article where post_time='$date' and author_id=$userid";
    $result = $conn->query($query);
    if(!$result) {
        $conn->query($delarticle);
        throw new Exception('Could not publish your article.');
    }
    $row=$result->fetch_assoc();
    $articleid=$row[article_id];



    $query = "insert into article_info values ($articleid,'$title',0,$node)";


    $result = $conn->query($query);


    if(!$result) {
        $conn->query($delarticle);
        throw new Exception('Could not publish your article2.');
    }

    $delarticle_info = "delete from article_info where article_id=$articleid";

    $query = "insert into article_content values ($articleid,'$content')";


    $result = $conn->query($query);

    if(!$result) {
        $conn->query($delarticle);
        $conn->query($delarticle_info);
        throw new Exception('Could not publish your article3.');
    }
    $url = "../index.php";
    echo "<script type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
    $conn->close();
}

function publish_reply($data) {
    $reply_content = $data['replycontent'];
    $article_id = $data['articleid'];
    settype($article_id,'integer');
    $date = date("Y-m-d H:i:s");
    $username = $_SESSION['valid_user'];

    if(!check_valid_user()) {
        throw new Exception('登录后才能评论');
    }

    $result = get_use_info($username);
    $row = $result->fetch_assoc();
    $userid = $row['user_id'];

    $conn =db_connect();
    $query = "insert into article values (NULL,$article_id,$userid,'$date')";
    $result = $conn->query($query);
    if(!$result) {
        throw new Exception('Could not publish your reply1.');
    }

    $delreply = "delete from article where post_time='$date' and author_id=$userid";

    $query = "select article_id from article where post_time='$date' and author_id=$userid";
    $result = $conn->query($query);
    if(!$result) {
        $conn->query($delreply);
        throw new Exception('Could not publish your reply2.');
    }
    $row=$result->fetch_assoc();
    $articleid=$row[article_id];

    $query = "insert into article_content values ($articleid,'$reply_content')";
    $result = $conn->query($query);
    if(!$result) {
        $conn->query($delreply);
        throw new Exception('Could not publish your reply3.');
    }

    $conn->close();
}