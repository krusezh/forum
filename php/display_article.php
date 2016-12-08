<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/7
 * Time: 下午10:03
 */

function display_article($username,$articleid) {
    $conn = db_connect();
    $query = "select * from article,article_info,article_content,node where article.article_id=article_info.article_id and ".
        "article.article_id=article_content.article_id and article_info.node_id=node.node_id and article.article_id=$articleid";
    $result = $conn->query($query);
    if(!$result) {
        throw new Exception('404: Not Found');
    }
    if($result->num_rows>0) {
        $row = $result->fetch_assoc();
        ?>
        <!--标题-->
        <div>
            <a href=""><?php echo $row[node_name]?></a>
            <h1><?php echo get_title($articleid)?></h1>
        </div>
        <small>
            <a href="profile.php?username=<?php echo $username?>"><?php echo $username?></a>
            <?php
            echo $row[post_time];
            ?>
        </small>
        <!--正文-->
        <div>
            <?php
            $Parsedown = new Parsedown();
            echo $Parsedown->text($row[article_content]);
            ?>
        </div>
        <?php
    }
}

function get_title($articleid) {
    $conn = db_connect();
    $query = "select * from article_info where article_id=$articleid";
    $result = $conn->query($query);
    if(!$result) {
        throw new Exception('404: Not Found');
    }
    if($result->num_rows>0) {
        $row=$result->fetch_assoc();
        $conn->close();
        return $row[title];
    }
    else {
        throw new Exception('404: Not Found4');
    }
}



