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
        throw new Exception('404: Not Found1');
    }
    if($result->num_rows>0) {
        $row = $result->fetch_assoc();
        if($row[parent_id]!=0) {
            throw new Exception('404: Not Found2');
        }
        $user_result = get_use_info($username);
        $user_row = $user_result->fetch_assoc();
        ?>
        <!--头像-->
        <div class="user-photo">
            <a href="profile.php?username=<?php echo $username?>"><?php display_image($user_row[e_mail],73);?></a>
        </div>
        <!--标题-->
        <div>
            <h1 class="article-h1"><?php echo get_title($articleid)?></h1>
            <a href="javascript:;" class="node"><?php echo $row[node_name]?></a>
        </div>
        <small>
            作者：<a href="profile.php?username=<?php echo $username?>"><?php echo $username?></a>
            发表于：
            <?php
            echo $row[post_time];
            ?>
        </small>
        <!--正文-->
        <div class="article-content">
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
        throw new Exception('404: Not Found3');
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

function display_reply_of_article($articleid) {
    $conn = db_connect();
    $query = "select userinfo.user_name,article.post_time,article_content.article_content from userinfo,article,article_content where userinfo.user_id=article.author_id and ".
        "article.article_id=article_content.article_id and article.parent_id=$articleid";
    $result = $conn->query($query);
    if(!$result) {
        throw new Exception('404: Not Found5');
    }
    if($result->num_rows>0) {
        ?>
        <div>
            <div  style="text-align: right;padding-right: 40px;">
            <span>共<?php echo $result->num_rows?>条回复</span>
            </div>
            <?php
            while($row=$result->fetch_assoc()){
                $user_result = get_use_info($row[user_name]);
                $user_row = $user_result->fetch_assoc();
                echo "<div class='cell item'><span float:left>";
                display_image($user_row[e_mail],48);
                echo "</span>";
                echo "<div class='cell reply'>";
                    //回复内容
                    echo "<div style='font-size:14px'>";
                        $Parsedown = new Parsedown();
                        echo $Parsedown->text($row[article_content]);
                    echo "</div>";
                    //回复者姓名
                    echo "<div style='font-size:14px;margin-top: 10px;'>";
                        echo "<strong><a href='profile.php?username=$row[username]'>$row[user_name]</a></strong>";
                        echo "&nbsp";
                        //回复时间
                        echo "<span style='font-size:12px'>$row[post_time]</span>";
                    echo "</div>";
                echo "</div></div>";
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
            <input type="hidden" name="once" value="<?php echo $code?>">
            <input type="hidden" name="articleid" value="<?php echo $articleid?>">
            <input type="submit" value="回复">
        </form>
    </div>
    <?php
}