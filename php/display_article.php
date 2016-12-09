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
        if($row[parent_id]!=0) {
            throw new Exception('404: Not Found');
        }
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
        display_reply_of_article($articleid);
        display_reply_form($username,$articleid);
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
        throw new Exception('404: Not Found');
    }
}

function display_reply_of_article($articleid) {
    $conn = db_connect();
    $query = "select userinfo.user_name,article.post_time,article_content.article_content from userinfo,article,article_content where userinfo.user_id=article.author_id and ".
        "article.article_id=article_content.article_id and article.parent_id=$articleid";
    $result = $conn->query($query);
    if(!$result) {
        throw new Exception('404: Not Found');
    }
    if($result->num_rows>0) {
        ?>
        <div>
            <div>
            <span><?php echo $result->num_rows?> 回复</span>
            </div>
            <?php
            while($row=$result->fetch_assoc()){
                echo "<div>";
                    //回复者姓名
                    echo "<div>";
                        echo "<strong><a href='profile.php?username=$row[username]'>$row[username]</a></strong>";
                        echo "&nbsp";
                        //回复时间
                        echo "<span>$row[post_time]</span>";
                    echo "</div>";
                    //回复内容
                    echo "<div>";
                        $Parsedown = new Parsedown();
                        echo $Parsedown->text($row[article_content]);
                    echo "</div>";
                echo "</div>";
            }
            ?>
        </div>
        <?php
    }
    else {
        echo "<div>";
        echo "<div>";
        echo "<span>目前尚无回复</span>";
        echo "</div>";
        echo "</div>";
    }
}

function display_reply_form($username,$articleid) {
    $code = mt_rand(0,1000000);
    $_SESSION['once'] = $code;
    ?>
    <div>
        添加一条回复
    </div>
    <div>
        <form method="post" action="article.php?username=<?php echo $username;?>&articleid=<?php echo $articleid;?>">
            <textarea name="replycontent"></textarea>
            <input type="hidden" name="once" value="<?=$code?>">
            <input type="hidden" name="articleid" value="<?php echo $articleid?>">
            <input type="submit" value="回复">
        </form>
    </div>
    <?php
}