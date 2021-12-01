<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/plan_layer.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />
<script src="/static/js/plan.js?v=<?php echo $cachekey; ?>"></script>

<style>
    body {
        max-height:400px;
        overflow-y: scroll;
    }

</style>
<table class="toplist" cellspacing="0" style="position: fixed;top:0px;left: 0px;width: 100%">
    <tr>
        <th class="num">排名</th>
        <th class="info">计划员</th>
        <th class="grade" >段位</th>
        <th >操作</th>
    </tr>
</table>
    <table class="toplist" cellspacing="0" style="margin-top: 30px;border-radius: 8px;">
<?php if(is_array($list)){foreach($list AS $index=>$value) { ?>

    <tr>
        <td class="num">
          <?php if($value['num']<=3){?>
            <img src="/static/images/top<?php echo $value['num']; ?>.png" >
            <?php } else { ?>

            <span class="number"><?php echo $value['num']; ?></span>
            <?php }?>
        </td>
        <td class="info" style="cursor: pointer;" onclick="parent.parent.user_detail(<?php echo $value['id']; ?>);">
            <img class="avatar" src="<?php echo $value['avatar']; ?>"/>
            <div class="user">
            <span class="title"><?php echo $value['plan_title']; ?></span>
                <span class="sign">历史最高连中:<?php echo $value['plan_prizemax']; ?>期,<?php echo $value['rate']; ?>%中奖率</span>
            </div>


        </td>
        <td class="grade">
            <img src="/<?php echo $system['plan_logo_'.$value['plan_grade']]; ?>" title="<?php echo $plan_grade_arr[$value['plan_grade']]; ?>" />

        </td>
        <td>

            <span class="btn" onclick="parent.user_plan(<?php echo $value['id']; ?>);">TA的计划</span>
        </td>
    </tr>

    <?php }}?>
</table>


<div class="nodata" style="color:#666;text-align: center">
    只显示排名前50的计划员

</div>

<script>



    window.onload=function () {

        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.iframeAuto(index);
    }


</script>

<?php include_once template("footer");?>