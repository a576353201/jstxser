<?php
include_once '../inc/common.php';
$system=get_system();
if($_SESSION['userid'])
{
    echo "<script>window.location='index.php';</script>";
    exit();
}

?>
<!DOCTYPE html>
<html lang=en>

<head>
    <meta charset=utf-8>
    <meta http-equiv=X-UA-Compatible content="IE=edge">
    <meta name=viewport content="width=device-width,initial-scale=1,user-scalable=no">
    <link rel=icon href='favicon.ico'>

    <title><?php echo $system['title'];?></title>
    <meta name="description" content="<?php echo $system['description'];?>" />
    <meta name="keywords" content="<?php echo $system['keywords'];?>" />
    <link href=style/common.css rel=stylesheet>
    <link href=style/home.css rel=stylesheet>

    <link href="../static/fontello.css" rel=stylesheet>
    <script src="/static/layui/layui.all.js"></script>
    <script src="/static/js/jquery-1.11.1.min.js"></script>
    <script src="/static/js/socket.js?v=<?php echo $cachekey;?>"></script>
    <script src="/static/js/message.js?v=<?php echo $cachekey;?>"></script>
</head>

<body>

<div class="login_box">
<iframe src="../user/login.php"></iframe>

</div>
<div class="footer_box">
    <li>
        <a href="down.php" target="_blank">下载地址</a>
    </li>

    <li>
        <a href="about.php" target="_blank">隐私条款</a>
    </li>
    <li>
        <a href="about.php?type=1" target="_blank">用户协议</a>
    </li>

</div>

<script>
    var userid='';
    var websocketUrl='<?php echo $websocket;?>';
    $(document).ready(function(){
        ws_join();

    })
</script>
</body>

</html>