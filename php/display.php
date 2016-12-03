<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/3
 * Time: 下午12:50
 */

function display_info($username) {
    $conn = db_connect();
    $query = "select user_id, user_name, reg_time from userinfo where user_name = '".$username."'";
    $result = $conn->query($query);
    if(!$result){
        throw new Exception('Could not execute query.');
    }
    if($result->num_rows == 0){
        throw new Exception('No member named '.$username);
    }
    $row = $result->fetch_assoc();
?>


    <!--头像-->


<?php
    echo "<span>".$username."</span>";
    echo "<br />";
    echo "<span>论坛第".$row[user_id]."号会员，加入于".$row[reg_time]."</span>";
    echo "<br />";

    echo $username."创建的主题<br />";
    display_topic($conn,$row[user_id],$username);

    echo "<br />";

    echo $username."最近回复了<br />";
    display_reply($row[user_id]);

    $conn->close();
}

function display_topic($conn, $userid, $username) {
    $query = "select * from aritle, aritle_info, node where aritle.aritle_id=aritle_info.aritle_id and aritle.author_id=".$userid.
        " and aritle_info.node_id=node.node_id limit 10";
    $result = $conn->query($query);
    if(!$result) {
        throw new Exception('Could not execute query.');
    }
    if($result->num_rows>0) {
        while($row=$result->fetch_assoc()){
            echo "<span>".$row[title]."</span>";
            echo "<br />";
            echo "<span>".$row[node_name]." ".$username." ".$row[post_time]."</span>";
            display_reply_num($row[aritle_id]);
        }
    }
}

function display_reply_num($parent_id){
    $conn = db_connect();
    $query = "select * from aritle a1, aritle a2 where a1.aritle_id=a2.parent_id and a1.aritle_id=".$parent_id;
    $result = $conn->query($query);
    if(!$result) {
        throw new Exception('Could not execute query.');
    }
    if($result->num_rows>0){
        echo $result->num_rows;
    }
    $conn->close();
}

function display_reply($userid) {
    $conn = db_connect();
    $query = "select * from aritle,aritle_content where parent_id<>0 and aritle.aritle_id=aritle_content.aritle_id and author_id=".$userid." limit 10";
    $result = $conn->query($query);

    if(!$result){
        throw new Exception('Could not execute query.');
    }
    if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
            display_user_topic($row[parent_id]);
            echo $row[aritle_content];
            echo "<br />";
        }
    }
    $conn->close();
}

function display_user_topic($aritle_id){
    $conn = db_connect();
    $query = "select title, user_name from aritle_info,userinfo,aritle where userinfo.user_id=aritle.author_id and ".
        "aritle.aritle_id=aritle_info.aritle_id and aritle_id=".$aritle_id;
    $result = $conn->query($query);
    if(!$result){
        throw new Exception('Could not execute query.');
    }
    $row = $result->fetch_assoc();
    echo "回复了".$row[user_name]."创建的主题 >".$row[title];
    echo "<br />";
    $conn->close();
}