<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/4
 * Time: 下午5:25
 */
header("Content-type:text/html;charset=utf-8");
require_once ('functions.php');
session_start();
?>
<div>
    <div>
        <span>创建新主题</span>
    </div>
    <form action="publish_aritle.php" method="post">
        <div>
            主题标题
        </div>
        <div>
            <textarea rows="1" maxlength="100" name="title" placeholder="请输入标题"></textarea>
        </div>
        <div>
            正文
        </div>
        <div>
            <textarea maxlength="20000" name="content"></textarea>
        </div>
        <div>
            <select name="node">
                <?php
                $conn = db_connect();
                $query = "select * from node";
                $result = $conn->query($query);
                while($row=$result->fetch_assoc()){
                    echo "<option value='".$row[node_id]."'>".$row[node_name]."</option>";
                }
                ?>
            </select>
            <input type="submit" value="发布主题" />
        </div>
    </form>

</div>
<?php
