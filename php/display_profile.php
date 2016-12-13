<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/3
 * Time: 下午12:50
 */

function display_info($username) {
    $result = get_use_info($username);
    $row = $result->fetch_assoc();
?>
    <!--头像-->
<?php
    echo "<div class='user-photo'>";
    echo "<img src='".display_image($row[user_name])."' width='73' height='73'>";
    echo "</div>";
    echo "<span class='article-h1'>".$username."</span>";
    echo "<br />";
    echo "<span>论坛第".$row[user_id]."号会员，加入于".$row[reg_time]."</span>";
    echo "<br />";
    echo "<div style='font-size:14px;'>";
    echo $username."创建的主题<br />";
    display_topic($row[user_id],$username);

    echo "</div><br />";
    echo "<div >";
    echo $username."最近回复了<br />";
    display_reply($row[user_id]);
    echo "</div>";

}

function display_topic($userid, $username) {
    $conn = db_connect();
    $query = "select * from article, article_info, node where article.article_id=article_info.article_id and article.author_id=".$userid.
        " and article_info.node_id=node.node_id order by article.post_time desc limit 10";
    $result = $conn->query($query);
    if(!$result) {
        throw new Exception('Could not execute query.');
    }
    if($result->num_rows>0) {
        while($row=$result->fetch_assoc()){
            echo "<div class='cell item'>";
            echo "<a href='article.php?username=$username&articleid=$row[article_id]'><span style='font-size:18px;line-height:35px;'>$row[title]</span></a>";
            echo "<br />";
            echo "<span><a class='node'>$row[node_name]</a> $username $row[post_time]</span>";
            display_reply_num($row[article_id]);
            echo "</div>";
        }
    }
    $conn->close();
}

function display_reply_num($parent_id){
    $conn = db_connect();
    $query = "select * from article a1, article a2 where a1.article_id=a2.parent_id and a1.article_id=".$parent_id;
    $result = $conn->query($query);
    if(!$result) {
        throw new Exception('Could not execute query.');
    }
    if($result->num_rows>0){
        echo "<span>".$result->num_rows."</span>";
    }
    $conn->close();
}

function display_reply($userid) {
    $conn = db_connect();
    $query = "select * from article,article_content where parent_id<>0 and article.article_id=article_content.article_id and author_id=".$userid." order by article.post_time desc limit 10";
    $result = $conn->query($query);

    if(!$result){
        throw new Exception('Could not execute query.');
    }
    if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
            display_user_topic($row[parent_id]);
            echo $row[article_content];
            echo "<br />";
        }
    }
    $conn->close();
}

function display_user_topic($article_id){
    $conn = db_connect();
    $query = "select title, user_name from article_info,userinfo,article where userinfo.user_id=article.author_id and ".
        "article.article_id=article_info.article_id and article.article_id=".$article_id;
    $result = $conn->query($query);
    if(!$result){
        throw new Exception('Could not execute query.');
    }
    $row = $result->fetch_assoc();
    echo "<span>回复了".$row[user_name]."创建的主题 >".$row[title]."</span>";
    echo "<br/>";
    $conn->close();
}

function get_use_info($username) {
    $conn = db_connect();

    $query = "select * from userinfo where user_name='$username'";
    $result = $conn->query($query);
    if(!$result){
        throw new Exception('Could not execute query.');
    }
    if($result->num_rows === 0){
        throw new Exception('404: Not Found8');
    }
    return $result;
}