<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/plan_layer.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />
<script src="/static/js/plan_mobile.js?v=<?php echo $cachekey; ?>"></script>


    <table class="toplist" cellspacing="0">
<?php if(is_array($list)){foreach($list AS $index=>$value) { ?>

    <tr>
        <td class="num">
          <?php if($value['num']<=3){?>
            <img src="/static/images/top<?php echo $value['num']; ?>.png" >
            <?php } else { ?>

            <span class="number"><?php echo $value['num']; ?></span>
            <?php }?>
        </td>
        <td class="info"  onclick="parent.user_detail(<?php echo $value['id']; ?>);">
            <img class="avatar" src="<?php echo $value['avatar']; ?>"/>
            <div class="user">
            <span class="title"><?php echo $value['plan_title']; ?></span>
                <span class="sign" style="width: 168px;">历史最高连中:<?php echo $value['plan_prizemax']; ?>期,<?php echo $value['rate']; ?>%中奖率</span>
            </div>


        </td>
        <td class="grade">
            <img src="/<?php echo $system['plan_logo_'.$value['plan_grade']]; ?>" title="<?php echo $plan_grade_arr[$value['plan_grade']]; ?>" />

        </td>

    </tr>

    <?php }}?>
</table>

<div class="nodata" style="text-align: center">
    只显示排名前50的计划员

</div>
<div style="height: 60px;">


</div>