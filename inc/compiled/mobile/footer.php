<div class="footer">

    <div class="item <?php if(strpos($_SERVER['REQUEST_URI'],'mobile.php')!==false){?>active<?php }?>" onclick="click_footer(0);">
        <div> <i class="icon-history"></i></div>
        <div>开奖</div>
    </div>
    <div class="item   <?php if(strpos($_SERVER['REQUEST_URI'],'/plan')!==false){?>active<?php }?>" onclick="click_footer(1);">
        <div> <i class="icon-chart-area"></i></div>
        <div>计划</div>
    </div>

    <div class="item  <?php if(strpos($_SERVER['REQUEST_URI'],'/chat/message')!==false){?>active<?php }?>" onclick="click_footer(2);">
        <div> <i class="icon-chat"></i><span class="num" id="footmenu_unread">0</span></div>
        <div>消息</div>
    </div>
    <div class="item <?php if(strpos($_SERVER['REQUEST_URI'],'/chat/index')!==false){?>active<?php }?>"  onclick="click_footer(3);">
        <div> <i class="icon-users"></i></div>
        <div>聊天室</div>
    </div>

    <div class="item <?php if(strpos($_SERVER['REQUEST_URI'],'/user')!==false || strpos($_SERVER['REQUEST_URI'],'mygroup')!==false){?>active<?php }?>" onclick="click_footer(4);">
        <div> <i class="icon-user"></i></div>
        <div>我的</div>
    </div>

</div>
<div class="tipsmsg" onclick="showmsg();">
    <div class="content">

    </div>

</div>
<style>

    .layui-layer {
        border-radius: 0px;
    }
    #ClCache{
        display: none;
    }
</style>
<script>
    var userid=<?php echo $userid; ?>;


    var layer_name=null;
    var layer_loading=null;
    var issetname=parseInt('<?php echo $user['issetname']; ?>');
    var addtips="您目前处于<span style=\"color: #2319dc\"><?php echo $plan_grade_arr[$user['plan_grade']]; ?></span>计划员<br>还可以发布<span style=\"color: #2319dc\"><?php echo $lastaddnum; ?></span>条计划";
    <?php if($task_delete!=1){?>
    addtips+='<br>一旦发布后<span style="color: #2319dc">禁止删除</span>'
    <?php }?>
    var lastaddnum=parseInt(<?php echo $lastaddnum; ?>);
    var addtipsmsg="您是<?php echo $plan_grade_arr[$user['plan_grade']]; ?>计划员，最低只能发布<?php echo $task[$user['plan_grade']]['addnum']; ?>条计划,已经没有剩余了";



</script>
<!--<div id="button" onclick="showmsg();">-->
<!--    发现-->
<!---->
<!--</div>-->


<?php include_once template("userjoin");?>
</body>
</html>