<?php
include_once '../inc/common.php';

if(!$_SESSION['userid'])
{
    echo "<script>window.location='login.php';</script>";
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
    <link href=style/common.css?v=<?php echo $cachekey;?> rel=stylesheet>
    <link href=style/home.css rel=stylesheet>

    <link href="../static/fontello.css" rel=stylesheet>
    <script src="/static/layui/layui.all.js"></script>
    <script src="/static/js/jquery-1.11.1.min.js"></script>
    <script src="/static/js/funcs.js"></script>
    <script src="/static/js/socket.js?v=<?php echo $cachekey;?>"></script>
    <script src="/static/js/message.js?v=<?php echo $cachekey;?>"></script>

    <script src="/static/js/group.js?v=<?php echo $cachekey;?>"></script>

    <?php
    $flink=$db->fetch_all("select * from ".tname('flink')." where showtype like '%PcWeb%'");

    ?>
</head>

<body>

<div class="index_box">
<div id="menu_0" style="position: relative">
    <div class="lines">
        <img src="<?php echo $user['avatar'];?>" class="avatar" onclick="user_detail(<?php echo $_SESSION['userid']?>,0);">

    </div>
     <div class="lines" onclick="change_tab(0)">
         <i class="icon icon-chat active" title="聊天"></i>
         <span id="msg_unread" class="num" style="display: none"></span>
     </div>
    <div class="lines" onclick="change_tab(1)">
        <i class="icon icon-contacts" title="通信录"></i>
    </div>

    <div class="lines" onclick="change_tab(2)">
        <i class="icon icon-users" title="群聊大厅"></i>
    </div>


    <div class="lines" onclick="userindx()">
        <i class="icon icon-user" title="用户中心"></i>
    </div>

    <div class="lines" onclick="shownote()">
        <i class="icon icon-speaker-5" title="通知公告"></i>
    </div>
    <?php
    if(count($flink)>0){
        foreach ($flink as $item){
            ?>

            <div class="lines" onclick="window.open('<?php echo $item['url'];?>')" title="<?php echo $item['title']?>">
                <img src="/<?php echo $item['logo'];?>" />
            </div>
        <?php
        }
    }
    ?>


    <div class="lines" onclick="quit_login();"  style="position: absolute;bottom: 0px;left: 18px;">
        <i class="icon icon-logout" title="退出登录"></i>
    </div>

</div>
<div id="menu_1">
    <div class="msglist">

    </div>
<iframe src="/chat/contact.php"></iframe>
    <iframe src="/chat/index.php"></iframe>
</div>
<div >

    <img src="/<?php echo $system['logo']?>" class="showlogo">

    <div class="chat_area">
        <div class="leftbar" style="display: none"></div>
        <div class="header" style="display: none"><span onclick="open_current_chat();"></span>
            <i class="close icon-cancel-1" onclick="close_chatarea('close');" title="关闭"></i>

        </div>
        <div class="area" style="width: 100%">

        </div>
    </div>

</div>
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
<audio src="/static/voice/chat.mp3" id="voice_chat" preload="preload" style="display: none"></audio>
<audio src="/static/voice/friend.mp3" id="voice_msg" preload="preload" style="display: none"></audio>
<?php

$user=userinfo($_SESSION['userid']);
$msgnotip=array();
$list=$db->fetch_all("select * from ".tname('msgnotip')." where userid='{$_SESSION['userid']}'");
if(count($list)>0){
    foreach ($list as $value){
        $msgnotip[]=$value['cache_key'];
    }
}
$msgnotip=json_encode($msgnotip);
//$msglist=json_encode(lastchat($_SESSION['userid']),true);

?>
<script>
    var msgnotip=JSON.parse('<?php echo $msgnotip;?>');


    var ismobile=0;
    var islock='<?php echo $user['islock'];?>';
    var issetname=parseInt('<?php  echo  $user['issetname'];?>');
    var userid='<?php echo $_SESSION['userid'];?>';
    var websocketUrl='<?php echo $websocket;?>';
    $(document).ready(function(){
        ws_join();
        lastchat();
    })

    function shownote() {

        var index= layer.open({
            type: 2,
            title: ["网站公告","background-color:#3388ff;color:#fff;"],
            shadeClose: true,
            shade: 0.6,
            area: ['650px','500px'],
            content: '/user/news.php?from=layer' //iframe的url
        });
    }


    function change_tab(num) {
        var iframe=document.querySelector('#menu_1').querySelectorAll('iframe');
        if(num==0){
            for(var i=0;i<iframe.length;i++){
                     iframe[i].style.display='none';
            }
            $('.msglist').show();
        }

        if(num==1){
            for(var i=0;i<iframe.length;i++){
               if(i==num-1) iframe[i].style.display='block';
               else  iframe[i].style.display='none';
            }
            iframe[0].src='/chat/contact.php?rand='+Math.random();
            $('.msglist').hide();
        }

        if(num==2){
            for(var i=0;i<iframe.length;i++){
                if(i==num-1) iframe[i].style.display='block';
                else  iframe[i].style.display='none';
            }
            iframe[num-1].src='/chat/index.php?rand='+Math.random();
            $('.msglist').hide();
        }
        var icon=document.querySelector('#menu_0').querySelectorAll('.icon');

        for(var i=0;i<icon.length;i++){
            if(i==num){
                if(icon[i].className.indexOf('active')<=-1) icon[i].className+=" active";
            }
            else{
             icon[i].className=icon[i].className.replace('active','');
            }
        }
    }

</script>
<style>
    .layui-layer {
        border-radius: 8px;
    }
    #ClCache{
        display: none;
    }
    .layui-layer::-webkit-scrollbar{
        display: none;
    }
</style>
</body>

</html>