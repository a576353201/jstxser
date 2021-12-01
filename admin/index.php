<?php

require_once('../inc/common.php');
include_once 'inc/check_login.php';
$system=get_system();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $system['title'];?>管理后台</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
    <meta name="renderer" content="webkit" title="360浏览器强制开启急速模式-webkit内核" />

    <link href="style/static/css/main.css" rel="stylesheet" type="text/css" />


    <script src="<?php echo $AdminHttpPath;?>style/js/jquery1.8.1.js" type="text/javascript"></script>

    <script src="<?php echo $HttpPath;?>static/layui/layui.all.js" type="text/javascript"></script>
    <script src="style/js/socket.js?v=111" type="text/javascript"></script>

    <script>
        var websocketUrl="<?php echo $websocket ;?>";
        var userid=parseInt('<?php echo $_SESSION['adminid'];?>');
        var roomid='admin';
        join_room(roomid);
    </script>
</head>
<body>
<style>
    .readnum{
        height: 16px;
        line-height: 16px;
        width: 16px;
        background-color: #ff0000;
        color: #fff;
        font-size: 12px;
        text-align: center;
        border-radius: 50%;
        margin-left: 3px;
        display: inline-block;
    }
    a{cursor: pointer}
</style>


<div id="header" <?php $admin_color=$_COOKIE['admin_color'];if($admin_color) echo "style='background-color:{$admin_color}'";?>>
    <div id="logo"><a href="http://wpa.qq.com/msgrd?v=3&uin=649398262&site=qq:649398262&menu=yes" target='_blank' title="起始页"><?php echo $system['title'];?>管理后台</a></div>

    <div id="top_nav">
        <a
            onclick="layer.open({
                    type: 2,
                    title: '手动充值',
                    maxmin: true,
                    shadeClose: true, //点击遮罩关闭层
                    area : ['450px' , '270px'],
                    content: 'user/money_add.php?from=parent'
                    });"> 手动充值
        </a>
        <a onclick="openurl('money/index.php')">账单流水</a>
        <a onclick="openurl('user/message.php')">用户私信<span class="readnum" style="display: none" id="message_num">0</span> </a>
        <a onclick="openurl('money/recharge.php')">充值记录<span  class="readnum"  style="display: none" id="recharge_num">0</span> </a>
        <a onclick="openurl('money/plat.php')">提现记录<span  class="readnum"  style="display: none" id="plat_num">0</span> </a>

        <a onclick="openurl('user/report.php')">投诉记录<span  class="readnum"  style="display: none" id="report_num">0</span> </a>





        <a href="../" target="_blank" ><i class="icon-squares"></i>浏览首页</a>

        <a href=""   target='iframe-main'><i class="icon-user"></i><?php echo $_SESSION['adminname'];?></a>

        <a href="quit.php" ><i class="icon-logout"></i>退出</a>



    </div>

</div>

<div id="nav">

    <ul >



        <?php

$row=$db->exec("select * from ".tname('role')." where id='{$_SESSION['admingroup']}'");

$role='|'.$row['content'].'|';

foreach($admin_menu1  as $key=>$value){

foreach($admin_menu2[$key] as $key2=>$value2){

if(strpos($role,$value2['url'])!==false  and $value2['nav']==1){



}
else{
	unset($admin_menu2[$key][$key2]);

}


}

}




        $i=0;
        foreach($admin_menu1 as $key=>$value){

            ?>


            <li class="level_1" id="menu_<?php echo $i?>">

                <p  onclick="show_tabs(<?php echo $i?>);" ><em><?php echo $value?></em>

                    <span class="triangle"></span>
                </p>


                <ul class="level_2">


                    <?php foreach ($admin_menu2[$key] as $key1=>$value1) {


                        ?>

                        <li onClick="openurl('<?php echo $value1['url']?>');set_li(this);" name="menuli" ><?php echo $value1['title']?></li>

                        <?php

                    }?>





                </ul>


            </li>




            <?php   $i++; }?>








    </ul>




</div>
<div class="dislpayArrow" onClick="show_navs();">
    <div class="icon"></div>

</div>

<div class="ifm_container">
    <?php
$row=$db->exec("select * from ".tname('role')." where id='{$_SESSION['admingroup']}'");

$role=explode('|',$row['content']);
?>




        <iframe src="<?php echo $role[0];?>" id="iframe-main"   name="iframe-main"  frameborder='0' style="height: 100%" scrolling="auto" ></iframe>




</div>
<audio src="/static/voice/tikuan.mp3" id="voice_plat" preload="preload" style="display: none"></audio>
<audio src="/static/voice/msg.wav" id="voice_message" preload="preload" style="display: none"></audio>
<audio src="/static/voice/planer.mp3" id="voice_plan" preload="preload" style="display: none"></audio>
<script type="text/javascript">
  function  openurl(url) {
      document.getElementById('iframe-main').src=url;

  }
    function  show_navs() {
        var pos='170px';
        var nav=document.getElementById('nav');
        var content=document.querySelector('.ifm_container');
        var dislpayArrow=document.querySelector('.dislpayArrow');

        if(nav.style.width=='0px'){
            nav.style.width=pos;
            content.style.left=pos;
            dislpayArrow.style.left=pos;
            dislpayArrow.querySelector('.icon1').className='icon';
        }
        else{

            nav.style.width='0px';
            content.style.left='0px';
            dislpayArrow.style.left='0px';
            dislpayArrow.querySelector('.icon').className='icon1';
        }




    }


    function show_tabs(num){
        var list =  document.querySelector('#nav').querySelectorAll('.level_1');
        for(var i=0;i<list.length;i++){
            if(i==num){


                if( document.getElementById('menu_'+i).className=='level_1 current')
                    document.getElementById('menu_'+i).className='level_1';
                else
                    document.getElementById('menu_'+i).className='level_1 current'


            }
            else{

                try{
                    document.getElementById('menu_'+i).className='level_1';
                }
                catch (e){

                }


            }
        }
    }

    function set_li(div){
        var li=document.getElementsByName('menuli');
        for(var i=0;i<li.length;i++){
            li[i].className='';

        }
        div.className='cur';

    }

    var message_num=0;
    var plat_num=0;
    var plan_num=0;
    var recharge_num=0;
    var report_num=0;

  function voice_play(type) {
      try {
          document.querySelector('#voice_'+type).pause();
      }catch (e){

      }

      document.querySelector('#voice_'+type).currentTime=0;
      document.querySelector('#voice_'+type).play();
  }
    function get_unreadnum() {
        $.get("ajax.php",{}, function(result){
            result=JSON.parse(result);
            $('#plat_num').html(result.plat);
            if(result.plat>0) {
                if(plat_num<result.plat){

                    layer.open({
                        type: 1,
                        title: '提现提示',
                        closeBtn: 1, //不显示关闭按钮
                        shade: [0],
                        area: ['220px', '150px'],
                        offset: 'rb', //右下角弹出
                        time: 5000, //2秒后自动关闭
                        anim: 2,
                        shadeClose:true,
                        content: "<div style='text-align:center;margin-top:30px;cursor: pointer;font-size: 16px;'  onclick=\"openurl('money/plat.php')\">您有<span style='color:#ff0000;'>"+result.plat+"</span>条未处理的提现</div>", //iframe的url，no代表不显示滚动条

                    });
                    voice_play('plat');
                }

                $('#plat_num').show();
            }else{
                $('#plat_num').hide();
            }

            $('#recharge_num').html(result.recharge);
            if(result.recharge>0) {
                if(recharge_num<result.recharge){

                    layer.open({
                        type: 1,
                        title: '充值提醒',
                        closeBtn: 1, //不显示关闭按钮
                        shade: [0],
                        area: ['220px', '150px'],
                        offset: 'rb', //右下角弹出
                        time: 5000, //2秒后自动关闭
                        anim: 2,
                        shadeClose:true,
                        content: "<div style='text-align:center;margin-top:30px;cursor: pointer;font-size: 16px;'  onclick=\"openurl('money/recharge.php')\">您有<span style='color:#ff0000;'>"+result.recharge+"</span>条未处理的充值申请</div>", //iframe的url，no代表不显示滚动条

                    });
                    voice_play('plan');
                }

                $('#recharge_num').show();
            }else{
                $('#recharge_num').hide();
            }



            $('#report_num').html(result.report);
            if(result.report>0) {
                if(report_num<result.report){

                    layer.open({
                        type: 1,
                        title: '充值提醒',
                        closeBtn: 1, //不显示关闭按钮
                        shade: [0],
                        area: ['220px', '150px'],
                        offset: 'rb', //右下角弹出
                        time: 5000, //2秒后自动关闭
                        anim: 2,
                        shadeClose:true,
                        content: "<div style='text-align:center;margin-top:30px;cursor: pointer;font-size: 16px;'  onclick=\"openurl('user/report.php')\">收到<span style='color:#ff0000;'>"+result.recharge+"</span>条投诉信息</div>", //iframe的url，no代表不显示滚动条

                    });
                    voice_play('plan');
                }

                $('#report_num').show();
            }else{
                $('#report_num').hide();
            }

            $('#message_num').html(result.message);
            if(result.message>0) {
                $('#message_num').show();
                if(message_num<result.message){

                    layer.open({
                        type: 1,
                        title: '消息提示',
                        closeBtn: 1, //不显示关闭按钮
                        shade: [0],
                        area: ['220px', '150px'],
                        offset: 'rb', //右下角弹出
                        time: 5000, //2秒后自动关闭
                        anim: 2,
                        shadeClose:true,
                        content: "<div style='text-align:center;margin-top:30px;cursor: pointer;font-size: 16px;'  onclick=\"openurl('user/message.php')\">您收到<span style='color:#ff0000;'>"+result.message+"</span>条用户私信</div>", //iframe的url，no代表不显示滚动条

                    });
                    voice_play('message');
                }
            }else{
                $('#message_num').hide();
            }
            plat_num=result.plat;
            recharge_num=result.recharge;
            report_num=result.report;
            message_num=result.message;
            console.log(result);
        });


        setTimeout(function () {
            get_unreadnum();
        },5000)
    }


   get_unreadnum();


</script>


<div id="sound_bg" style='display:none;' ></div>


<script type="text/javascript">

    //初始化相关元素高度
    function init(){
        $("body").height($(window).height()-80);
        $("#iframe-main").height($(window).height()-40);

    }

    $(function(){
        init();
        $(window).resize(function(){
            init();
        });
    });

    // This function is called from the pop-up menus to transfer to
    // a different page. Ignore if the value returned is a null string:
    function goPage (newURL) {
        // if url is empty, skip the menu dividers and reset the menu selection to default
        if (newURL != "") {
            // if url is "-", it is this page -- reset the menu:
            if (newURL == "-" ) {
                resetMenu();
            }
            // else, send page to designated URL
            else {
                document.location.href = newURL;
            }
        }
    }

    // resets the menu selection upon entry to this page:
    function resetMenu() {
        document.gomenu.selector.selectedIndex = 2;
    }


    // uniform使用示例：
    // $.uniform.update($(this).attr("checked", true));
</script>
</body>
</html>
