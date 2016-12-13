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
        echo "<a class=".(($tabname===$tab[0]) ? 'tab_current' : 'tab')." href='../forum/index.php?tab=$tab[0]'>$tab[0]</a>";
        for($i=1; $i<10; $i++) {
            echo "&nbsp;";
            echo "<a class=".(($tabname===$tab[$i]) ? 'tab_current' : 'tab')." href='../forum/index.php?tab=$tab[$i]'>$tab[$i]</a>";
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
        echo "<a href='./php/node.php?nodename=$row[node_name]'>$row[node_name]</a>";
        while($row=$result->fetch_assoc()) {
            echo "&nbsp;";
            echo "<a href='./php/node.php?nodename=$row[node_name]'>$row[node_name]</a>";
        }
    }
    $conn->close();
}

function display_title($tabname) {
    $conn = db_connect();
    $query = "select * from userinfo,article,article_info,node where article.author_id=userinfo.user_id and article.article_id=article_info.article_id ".
            "and article_info.node_id=node.node_id and node.node_id in (select node_id from tab where tab_name='$tabname') limit 20";
    $result = $conn->query($query);

    if(!$result) {
        throw new Exception('Could not execute query3.');
    }
    if($result->num_rows>0) {
        while($row=$result->fetch_assoc()) {
            echo "<div class='cell item'>";
            echo "<span style='float:left'><a href='./php/profile.php?username=$row[user_name]'>";
            echo "<img src='".display_image($row[user_name])."' width='48' height='48'>";
            echo "</a></span>";
            echo "<span><a style='font-size:18px;line-height:35px;' href='./php/article.php?username=$row[user_name]&articleid=$row[article_id]'>$row[title]</a></span>";
            echo "<br />";
            echo "<span><a class='node' href='./php/node.php?nodename=$row[node_name]'>$row[node_name]</a> &nbsp;&nbsp; &nbsp; •<a class='strong' href='./php/profile.php?username=$row[user_name]'>$row[user_name]&nbsp;</a>发表于&nbsp;&nbsp;$row[post_time]</span>&nbsp;&nbsp;&nbsp;&nbsp;回复数：";
            display_reply_num($row[article_id]);
            echo "</div>";
        }
    }
    $conn->close();
}

function display_specific_node($nodename) {
    $current_page = $_REQUEST['page'];

    $conn=db_connect();
    $query = "select * from article_info,node where article_info.node_id=node.node_id and node.node_name='$nodename'";
    $result=$conn->query($query);
    if(!$result) {
        throw new Exception('Could not execute query.');
    }
    $max_page = ceil($result->num_rows/20);

    if(!$current_page) {
        $current_page = 1;
    }
    elseif($current_page > $max_page) {
        throw new Exception('404: Not Found');
    }
    elseif($current_page < 1) {
        throw new Exception('404: Not Found');
    }
    ?>
    <div>
        <div>
            <span>NODE</span>
            <span> > </span>
            <span><?php echo $nodename?></span>
            <div>
                <span>主题总数</span>
                <span><?php echo $result->num_rows?></span>
            </div>
        </div>
        <div>
            <?php
            if($result->num_rows>0) {
                $place_begin = ($current_page-1)*20;
                $query = "select * from userinfo,article,article_info,node where article.author_id=userinfo.user_id and ".
                    "article.article_id=article_info.article_id and article_info.node_id=node.node_id and node.node_name='$nodename' limit $place_begin,20";
                $result = $conn->query($query);
                if(!$result) {
                    throw new Exception('Could not execute query');
                }
                while ($row=$result->fetch_assoc()) {
                    echo "<div class='cell item'>";
                    echo "<span style='float:left'><a href='profile.php?username=$row[user_name]'>";
                    echo "<img src='".display_image($row[user_name])."' width='48' height='48'>";
                    echo "</a></span>";
                    echo "<span><a style='font-size:18px;line-height:35px;' href='article.php?username=$row[user_name]&articleid=$row[article_id]'>$row[title]</a></span>";
                    echo "<br />";
                    echo "<span><a class='strong' href='profile.php?username=$row[user_name]'>$row[user_name]&nbsp;</a>发表于&nbsp;&nbsp;$row[post_time]</span>&nbsp;&nbsp;&nbsp;&nbsp;回复数：";
                    display_reply_num($row[article_id]);
                    echo "</div>";
                }
                if($max_page>1) {
                    echo "<div>";
                    echo "<span>";
                    echo "<a href='".$_SERVER['PHP_SELF']."?nodename=$nodename&page=1'>1</a>";
                    if($current_page<=3) {
                        for($i=2; $i<=$current_page+3 && $i<=$max_page; $i++) {
                            echo "&nbsp;";
                            echo "<a href='".$_SERVER['PHP_SELF']."?nodename=$nodename&page=$i'>$i</a>";
                        }
                    }
                    else {
                        echo "<span>...</span>";
                        for($i=$current_page-2; $i<=$current_page+3 && $i<=$max_page; $i++) {
                            echo "&nbsp;";
                            echo "<a href='".$_SERVER['PHP_SELF']."?nodename=$nodename&page=$i'>$i</a>";
                        }
                    }
                    if(($current_page+3) < $max_page) {
                        echo "&nbsp;";
                        echo "<span>...</span>";
                        echo "&nbsp;";
                        echo "<a href='".$_SERVER['PHP_SELF']."?nodename=$nodename&page=$max_page'>$max_page</a>";
                    }
                    echo "</span>";
                    echo "<span>";
                    echo "<a href='".$_SERVER['PHP_SELF']."?nodename=$nodename&page=$current_page-1'> < </a>";
                    echo "<a href='".$_SERVER['PHP_SELF']."?nodename=$nodename&page=$current_page+1'> > </a>";
                    echo "</span>";
                    echo "</div>";
                }
            }
            else {
                echo "尚无主题";
            }
            ?>
        </div>
    </div>
    <?php
}