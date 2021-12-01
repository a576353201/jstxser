<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/plan_layer.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />
<script src="/static/js/plan.js?v=<?php echo $cachekey; ?>"></script>
<ul class="nav1">
    <?php if(is_array($plan_grade_arr)){foreach($plan_grade_arr AS $index=>$value) { ?>
    <?php if($index>0){?>
    <li class="" onclick="change_tab(<?php echo $index; ?>);">
        <img src="/<?php echo $system['plan_logo_'.$index]; ?>" style="height: 30px;vertical-align: middle">
        <?php echo $value; ?>任务</li>
    <?php }?>
    <?php }}?>
</ul>


<?php if(is_array($plan_grade_arr)){foreach($plan_grade_arr AS $index=>$value) { ?>
<?php if($index>0){?>
<div class="tasklist" <?php if($grade==$index){?>style='display:inline-block;'<?php } else { ?>style='display:none;'<?php }?>>


<div class="title">
    <span>任务要求</span>
</div>
<div class="content">

连续<span class="num"><?php echo $task[$index]['day']; ?></span>天每天最少发布<span class="num"><?php echo $task[$index]['expect']; ?></span>期计划，<br>
并且中奖率达到<span class="num"><?php echo $task[$index]['rate']; ?>%</span>即可完成<?php echo $value; ?>任务。<br>
每完成1天奖励<span class="sum"><?php echo $task[$index]['reward']; ?></span>元，完成<?php echo $value; ?>任务再奖励<span class="sum"><?php echo $task[$index]['rewardsum']; ?></span>元
</div>
<?php if($index==$grade){?>
<?php if($tasks[$index]=='doing'){?>
<img src="/static/images/doing.png" class="ico" />


<div class="title">
    <span>任务进度</span>
</div>

<ul class="rate">

    <li>共<?php echo $task[$index]['day']; ?>天</li>
    <li>
        <div class="bar">
           <div class="process" style="width:<?php echo $process; ?>%"></div>
        </div>
    </li>
    <li>
        已完成<span style="color: #ff6a00"><?php echo $user['task_day']; ?></span>天
    </li>
</ul>

<div class="btns">
    <?php if($complete==0){?>
<span class="cancel" >今日已完成<?php echo $plan_num; ?>/<?php echo $task[$index]['expect']; ?>期，当日最高中奖概率<?php echo $rate; ?>%</span>
    <?php } else if($complete==1) { ?>
    <span class="ok" onclick="task_money();"><i class="icon-money"></i>领取<?php echo $task[$index]['reward']; ?>元奖励</span>
    <?php } else if($complete==2) { ?>
    <span class="cancel" >今日任务已完成，请明天继续</span>
    <?php } else if($complete==3) { ?>
    <span class="ok" onclick="task_money();"><i class="icon-money"></i>升级<?php echo $value; ?>计划员，领取<?php echo $task[$index]['rewardsum']; ?>元奖励</span>
    <?php } else { ?>

    <?php }?>
</div>

<?php } else if($tasks[$index]=='fail') { ?>
<img src="/static/images/taskfail.png" class="ico" />
<div class="btns">

    <span class="ok" onclick="task_apply(<?php echo $index; ?>);"><i class="icon-gift"></i>昨日未完成，重新领取任务</span>
</div>


<?php } else if($tasks[$index]=='ok') { ?>
<img src="/static/images/complete.png" class="ico">
<?php } else if($tasks_id!=$grade) { ?>
<div class="btns">

<span class="ok" onclick="task_apply(<?php echo $index; ?>);"><i class="icon-gift"></i>领取任务</span>
</div>
<?php } else { ?>

<?php }?>

<?php } else { ?>
<?php if($tasks[$index]=='ok'){?>

<img src="/static/images/complete.png" class="ico">

<?php } else { ?>

<div class="btns">

<span class="cancel">
<?php echo $plan_grade_arr[$index-1]; ?>计划员可申请
</span>
</div>
<?php }?>

<?php }?>


</div>

<?php }?>
<?php }}?>
<div class="tasklist">

<?php if(count($msgshow)>0){?>
    <div class="lists" id="msglist">
        <?php if(is_array($msgshow)){foreach($msgshow AS $index=>$value) { ?>
        <li class="<?php if($index==0){?>active<?php }?>"><?php echo $value; ?></li>
        <?php }}?>
    </div>
<?php }?>
    <?php if($system['task_note']){?>
    <div class="title" style="margin-top: -4px">
        <span>任务声明</span>
    </div>
    <div class="content" style="line-height: 25px;">
       <?php echo $system['task_note']; ?>
    </div>
    <?php }?>

</div>

<script>
    var grade=parseInt(<?php echo $grade; ?>);
    function task_apply(task_id) {

        if(parent.parent.check_userlock()==false) return false;
        if(task_id==grade){

            $.post("../api/plan.php?act=task_apply",{id:task_id}, function(result){
                result=JSON.parse(result);
                if(result.code==200){
                    parent.layer.msg("任务领取成功",{ type: 1, anim: 2 ,time:1000});
                    location.reload();
                }
                else{
                    parent.layer.msg(result.message,{ type: 1, anim: 2 ,time:1000});
                }
            });

        }else{
            parent.layer.msg("您无法领取该等级的任务",{ type: 1, anim: 2 ,time:1000});
        }
    }
   function task_money() {
       if(parent.parent.check_userlock()==false) return false;
       $.post("../api/plan.php?act=task_money",{}, function(result){
           result=JSON.parse(result);
           if(result.code==200){
               parent.layer.msg(result.message,{ type: 1, anim: 2 ,time:1000});
               location.reload();
           }
           else{
               parent.layer.msg(result.message,{ type: 1, anim: 2 ,time:1000});
           }
       });
   }
    function change_tab(num) {
        num=num-1;
        var li=document.querySelector('.nav1').querySelectorAll('li');
        var div=document.querySelectorAll('.tasklist');
        for(var i=0;i<li.length;i++){
            if(i==num) {
                li[i].className='active';
            div[i].style.display='inline-block';
            }
            else {
                li[i].className="";
                div[i].style.display='none';
            }
        }
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.iframeAuto(index);
    }



    <?php if(count($msgshow)>0){?>
    setInterval(function () {
        set_updown('msglist');
    },5000)
    <?php }?>


    window.onload=function () {
        change_tab(grade);
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.iframeAuto(index);
    }

</script>

<?php include_once template("footer");?>