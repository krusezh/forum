<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/5
 * Time: 下午2:39
 */

function display_index($tabname='技术') {
    $tab=array('技术','创意','好玩','Apple','酷工作','交易','城市','问与答','最热','全部');
    if(isset($_REQUEST['tab'])) {
        if(in_array($tabname,$tab)) {
            $tabname = $_REQUEST['tab'];
        }
        else {
            throw new Exception('404: Not Found');
        }
    }
?>
    <div class="inner">
        <!--标签-->
        <?php
        echo "<a class='tab_current' href='http://localhost/phpstorm/forum/index.php?tab=$tab[0]'>$tab[0]</a>";
        for($i=1; $i<10; $i++) {
            echo "&nbsp";
            echo "<a class='tab' href='http://localhost/phpstorm/forum/index.php?tab=$tab[$i]'>$tab[$i]</a>";
        }
        ?>
    </div>
    <div class="cell">
        <!--节点-->
        <?php
        display_node($tabname);
        ?>
    </div>
<?php
    display_title($tabname);
}

function display_node($tabname) {
    $conn = db_connect();
    $query = "select * from tab,node where tab.tab_name='$tabname' and tab.node_id=node.node_id";
    $result = $conn->query($query);
    if(!$result) {
        throw new Exception('Could not execute query3.');
    }
    if($result->num_rows>0) {
        $row=$result->fetch_assoc();
        echo "<a href='display_node.php?nodename=$row[node_name]'>$row[node_name]</a>";
        while($row=$result->fetch_assoc()) {
            echo "&nbsp";
            echo "<a href='display_node.php?nodename=$row[node_name]'>$row[node_name]</a>";
        }
    }
    $conn->close();
}

function display_specific_node($nodeid) {

}

function display_title($tabname) {
    $conn = db_connect();
    $query = "select * from userinfo,article,article_info,node where article.author_id=userinfo.user_id and article.article_id=article_info.article_id ".
            "and article_info.node_id=node.node_id and node.node_id in (select node_id from tab where tab_name='$tabname')";
    $result = $conn->query($query);

    if(!$result) {
        throw new Exception('Could not execute query3.');
    }
    if($result->num_rows>0) {
        while($row=$result->fetch_assoc()) {
            echo "<div class='cell item'>";
            echo "<span><a style='font-size:18px;line-height:35px;' href='./php/article.php?username=$row[user_name]&articleid=$row[article_id]'>$row[title]</a></span>";
            echo "<br />";
            echo "<span><a class='node' href=''>$row[node_name]</a><a class='strong' href='./php/profile.php?username=$row[user_name]'> &nbsp;•&nbsp; $row[user_name]&nbsp;</a>发表于&nbsp;&nbsp;$row[post_time]</span>&nbsp;&nbsp;&nbsp;&nbsp;回复数：";
            display_reply_num($row[article_id]);
            echo "</div>";
        }
    }
    $conn->close();
}
