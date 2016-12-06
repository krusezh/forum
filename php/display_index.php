<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/5
 * Time: 下午2:39
 */

function display_index($nodeid=1) {
    if(isset($_REQUEST['nodeid'])) {
        if(is_numeric($_REQUEST['nodeid']) && $_REQUEST['nodeid']<=10) {
            $nodeid = $_REQUEST['nodeid'];
        }
        else {
            throw new Exception('404: Not Found');
        }
    }
?>
    <div>
        <!--节点-->
        <?php
        display_node();
        ?>
    </div>
    <div>
        <!--子节点-->
        <?php
        display_son_node($nodeid);
        ?>
    </div>
<?php
    display_title($nodeid);
}

function display_node(){
    $conn = db_connect();
    $query = "select * from node limit 10";
    $result = $conn->query($query);

    if(!$result) {
        throw new Exception('Could not execute query1.');
    }
    if($result->num_rows>0){
        while ($row=$result->fetch_assoc()) {
            echo "<a href='http://localhost/phpstorm/forum/index.php?nodeid=$row[node_id]'>$row[node_name]</a>";
        }
    }
    $conn->close();
}

function display_son_node($nodeid) {
    $conn = db_connect();
    $query = "select * from node, node_related where node.node_id=node_related.son_node_id and node_related.parent_node_id=$nodeid";
    $result = $conn->query($query);
    if(!$result) {
        throw new Exception('Could not execute query2.');
    }
    if($result->num_rows>0) {
        while($row=$result->fetch_assoc()) {
            echo "<a href='display_node.php?nodeid=$row[node_id]'>$row[node_name]</a>";
        }
    }
    $conn->close();
}

function display_specific_node($nodeid) {

}

function display_title($nodeid) {
    $conn = db_connect();
    $query = "select user_id,user_name,aritle.aritle_id,post_time,title from userinfo,aritle,aritle_info where userinfo.user_id=aritle.author_id and ".
            "aritle.aritle_id=aritle_info.aritle_id and aritle.parent_id=0 and aritle_info.node_id=$nodeid limit 50";
    $result = $conn->query($query);

    if(!$result) {
        throw new Exception('Could not execute query3.');
    }
    if($result->num_rows>0) {
        while($row=$result->fetch_assoc()) {
            echo "<span>".$row[title]."</span>";
            echo "<br />";
            echo "<span>".$row[node_name]." ".$row[user_name]." ".$row[post_time]."</span>";
            display_reply_num($row[aritle_id]);
        }
    }
    $conn->close();
}