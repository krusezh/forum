<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 2016/12/13
 * Time: 上午1:46
 */
function set_avatar($username) {
    $code = mt_rand(0,1000000);
    $_SESSION['once'] = $code;

    $result = get_use_info($username);
    $row = $result->fetch_assoc();
    ?>
    <div>
        <div>
            <span>设置</span>
            &nbsp;
            <span>></span>
            &nbsp;
            <span>头像上传</span>
        </div>
        <div>
            <form method="post" action="avatar.php" enctype="multipart/form-data">
                <div>
                    <span>当前头像</span>
                    <span><?php echo "<img src='".display_image($row[user_name])."' width='73' height='73'>";?></span>
                    &nbsp;
                    <span><?php echo "<img src='".display_image($row[user_name])."' width='48' height='48'>";?></span>
                    &nbsp;
                    <span><?php echo "<img src='".display_image($row[user_name])."' width='24' height='24'>";?></span>
                </div>
                <div>
                    <span>选择一个图片文件</span>
                    <span><input name="avatar" type="file"></span>
                </div>
                <div>
                    <input type="hidden" name="once" value="<?php echo $code?>">
                    <input type="submit" value="开始上传">
                </div>
            </form>
        </div>
    </div>
    <?php
}

function mv_avatar($image) {
    $uploads_dir = "../avatar/";
    if ($image['error'] == UPLOAD_ERR_OK) {
        $tmp_name = $image["tmp_name"];
        $name = $image["name"];
        $current_place = $uploads_dir.$name;
        $status = move_uploaded_file($tmp_name, $current_place);
        var_dump($tmp_name);
        if(!$status) {
            throw new Exception("移动头像失败$status");
        }
    }
    else {
        throw new Exception('上传失败');
    }
    upload_avatar($current_place,$name);
}

function upload_avatar($current_place,$name) {
    $url = 'https://sm.ms/api/upload';
    $image = curl_file_create(realpath($current_place), 'image/jpg', $name);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, ['smfile' => $image]);
    $data = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($data,true);
    if($data['code']=='error') {
        throw new Exception('上传图床失败');
    }
    $image_url = $data['data']['url'];

    $username=$_SESSION['valid_user'];
    $conn = db_connect();
    $query = "update userinfo set image_url='$image_url' where user_name='$username'";
    $result = $conn->query($query);
    if(!$result) {
        throw new Exception('插入图像链接失败');
    }

    if(!unlink($current_place)) {
        throw new Exception('删除本地图像失败');
    }
}
