<?php if($userid>0){?>
<script src="/static/js/group_mobile.js?v=<?php echo $cachekey; ?>"></script>
<script src="/static/js/socket.js"></script>
<script src="/static/js/message.js?v=<?php echo $cachekey; ?>"></script>
<link rel="stylesheet" type="text/css" href="/template/mobile/static/css/footer.css?v=<?php echo $cachekey; ?>"/>
<div class="msgtips">
    <div class="message">
        <div class="avatar"><img src="#"/></div>
        <div class="info">
            <div class="nickname"><i></i><div class="time"></div></div>
            <div class="text"></div>
        </div>
    </div>

</div>


<div class="footer_chat " >

    <div class="content">

            <div class="header">
                <span class="back" onclick="hide_chat1();"><i class="icon-left-open-3"></i></span>
                <div class="navright" onclick="show_addnav1();">
                    <i class="icon-plus-1" style="font-size: 28px"></i>
                </div>
                <span id="msg_title">消息</span>

            </div>
            <div class="msglist">

            </div>

    </div>
    <div class="addnav"  id="addnav_1" style="top:47px;">
        <?php if($user['isvip']==1){?>
        <li  onclick="plan_add();"><i class="icon-plus-circle"></i>发布计划</li>
        <?php } else { ?>
        <li class="button" onclick="plan_apply();">  <i class="icon-chart"></i>申请计划员</li>
        <?php }?>
        <li onclick="group_create();"><i class="icon-user-add"></i>创建群聊</li>
        <li onclick="location.href='/user/recharge.php';"><i class="icon-coin-of-dollar"></i>我要充值</li>
        <li onclick="location.href='/user/plat.php';"><i class="icon-cash"></i>我要提现</li>
    </div>
</div>
<div class="chat_area minus close" >
    <div class="header" style="display: none"><span onclick="open_current_chat();"></span>
        <i class="close icon-left-open-2" onclick="close_chatarea('close');" title="关闭"></i>
        <i class="moreinfo icon-ellipsis" onclick="close_chatarea('close');" ></i>
    </div>
    <div class="leftbar" style="display: none"></div>
    <div class="area"></div>
</div>
<audio src="/static/voice/chat.mp3" id="voice_chat" preload="preload" style="display: none"></audio>
<audio src="/static/voice/friend.mp3" id="voice_msg" preload="preload" style="display: none"></audio>

<script>


    var websocketUrl='<?php echo $websocket; ?>';
    ws_join();

    lastchat();
    var hh=document.documentElement.clientHeight;
   window.onload=function () {
        hh=document.documentElement.clientHeight;
   }
</script>

<?php }?>