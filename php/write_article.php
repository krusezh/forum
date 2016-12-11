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
display_head('创作新主题');
display_top();
?>
<div class="wrapper center">
    <div>
        <h1 class="article-h1">创作新主题</h1>
    </div>
    <form action="publish_article.php" method="post">
        <div>
            <h1 class="article-h1">主题标题</h1>
        </div>
        <div>
            <textarea style='height: 20px;line-height: 20px;' class="textarea" rows="1" maxlength="100" name="title" placeholder="请输入标题"></textarea>
        </div>
        <div>
            正文
        </div>
        <div>
            <textarea class="textarea" maxlength="20000" name="content"></textarea>
        </div>
        <div>
            <select name="node" style='height: 40px;'>
                <?php
                $conn = db_connect();
                $query = "select * from node";
                $result = $conn->query($query);
                while($row=$result->fetch_assoc()){
                    echo "<option value='".$row[node_id]."'>".$row[node_name]."</option>";
                }
                ?>
            </select>
            <input class="button button-royal" type="submit" value="发布主题" />
        </div>
    </form>

</div>
<?php
display_buttom();