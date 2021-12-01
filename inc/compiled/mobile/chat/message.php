

<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/group.css" type="text/css" media="screen" />
<script src="/static/js/group_mobile.js"></script>

<div class="header" style="padding: 5px 0px;">
    <span class="back" onclick="history.back();" style="top:5px;"><i class="icon-left-open-3"></i></span>
    <div class="navright" onclick="show_addnav1();" style="top:5px;">
        <i class="icon-plus-1" style="font-size: 28px"></i>
    </div>
    <span class="title" id="msg_title">消息</span>

</div>
<div class="addnav"  id="addnav_1" style="top:47px;">
    <?php if($user['isvip']==1){?>
    <li  onclick="plan_add();"><i class="icon-plus-circle"></i>发布计划</li>
    <?php } else { ?>
    <li class="button" onclick="plan_apply();">  <i class="icon-chart"></i>申请计划员</li>
    <?php }?>
    <li onclick="group_create();"><i class="icon-user-add"></i>创建群聊</li>
    <li onclick="if(userid>0)location.href='/user/recharge.php';else  showlogin();"><i class="icon-coin-of-dollar"></i>我要充值</li>
    <li onclick="if(userid>0)location.href='/user/plat.php';else  showlogin();"><i class="icon-cash"></i>我要提现</li>
</div>
<div class="msglist">

</div>


<script>
    var act='top';
    var page=1;
    var menuid=2;
    lastchat();
setInterval(function () {

    lastchat();
},5000)
</script>



<?php include_once template("footer");?>