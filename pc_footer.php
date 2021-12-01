
<div class="msgtips">
<div class="message">
    <div class="avatar"><img src="#"/></div>
    <div class="info">
        <div class="nickname"><i></i><div class="time"></div></div>
        <div class="text"></div>
    </div>
</div>

</div>


<div class="group_footer" onclick="show_chat();">
    <i class="icon-chat"></i>聊天室<span class="unread_num">0</span>

</div>

<div class="footer_chat " >

<div class="content">
    <div id="step0">
     <div class="header">
         <span id="msg_title">消息</span>
         <i class="icon-minus" style="float: left" onclick="hide_chat();" title="最小化"></i>
     </div>
        <div class="msglist">

        </div>

    </div>

<iframe src="/chat/index.php" id="step1" style="display: none" ></iframe>
 <iframe src="/chat/contact.php" id="step2" style="display: none" ></iframe>

</div>



    <ul class="footmenu">
        <li class="active" onclick="footmenu(0);">

            <div><i class="icon-chat"></i></div>
            <div>消息</div>
            <span class="num" id="footmenu_unread">0</span>
        </li>

        <li onclick="footmenu(1);">
            <div><i class="icon-menu"></i></div>
            <div>大厅</div>
        </li>
        <li onclick="footmenu(2);">
            <div><i class="icon-users"></i></div>
            <div>联系人</div>
        </li>
        <li onclick="group_create();">
            <div><i class="icon-user-add"></i></div>
            <div>新建</div>
        </li>

    </ul>

</div>


<div class="chat_area minus close">
<div class="header"><span onclick="open_current_chat();"></span>
    <i class="close icon-cancel-1" onclick="close_chatarea('close');" title="关闭"></i>
    <i class="close icon-minus-1"  onclick="close_chatarea('min');" title="最小化"></i>
</div>
    <div class="leftbar">



    </div>

    <div class="area">


    </div>


</div>
<div class="msgbox" onclick="open_chatarea2();">
    <div class="unread">0</div>
   <img src="" />
</div>



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

    var layer_name=null;
    var layer_loading=null;
    var issetname=parseInt('<?php  echo  $user['issetname'];?>');
    var msgnotip=JSON.parse('<?php echo $msgnotip;?>');
//var msglist=JSON.parse(JSON.stringify(<?php //echo $msglist;?>//));
//
//   console.log(msglist.data)
//showmsglist(msglist);
//    showunreadnum();

        var cleft=0;
        var ctop=0;
        var isdown=0;
        var startx=0;
        var starty=0;
        document.querySelector('.chat_area').querySelector('.header').addEventListener('mousedown',function (e) {
            isdown=1;
            startx=e.screenX;
            starty=e.screenY;
            cleft=document.querySelector('.chat_area').offsetLeft;
            ctop=document.querySelector('.chat_area').offsetTop;
            document.querySelector('.chat_area').style.transition='0s';

        })
        document.body.addEventListener('mouseup',function (e) {
            document.querySelector('.chat_area').style.transition='0.5s';
            isdown=0;
            isdown1=0;
        })

        document.body.addEventListener('mousemove',function (e) {
            if(isdown==1){
                var x=cleft+e.screenX-startx;
                var y=ctop+e.screenY-starty
                document.querySelector('.chat_area').style.left=x+'px';
                document.querySelector('.chat_area').style.top=y+'px';
            }
        })


    lastchat();


    function shownote() {

        var index= layer.open({
            type: 2,
            title: ["网站公告","background-color:#3388ff;color:#fff;"],
            shadeClose: true,
            shade: 0.6,
            area: ['650px','500px'],
            content: 'user/news.php?from=layer' //iframe的url
        });
    }
    <?php
    if(!isset($_SESSION['newsshow']) || $_SESSION['newsshow']!=1){

    $note=$db->exec("select * from ".tname('news')." where type1='9'");
    if($note['id']>0){
    ?>
    shownote();
<?php
$_SESSION['newsshow']=1;
}
}

?>
</script>