

<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/plan_layer.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />
<script src="/static/js/plan_mobile.js?v=<?php echo $cachekey; ?>"></script>

<div class="header" style="padding: 5px 0px;">
    <span class="back" onclick="history.back();" style="top:5px;"><i class="icon-left-open-3"></i></span>

    <div class="title">
        我发布的计划
    </div>

</div>
<?php if(count($list)>0){?>

<ul class="user_list" style="margin-top: 50px">

    <?php if(is_array($list)){foreach($list AS $index=>$item) { ?>
    <li>

        <div > <a  onclick="click_plan_detail(<?php echo $item['id']; ?>);"><?php echo $item['othertitle1']; ?></a>

            <span class="color-<?php echo $item['status']; ?>"  style="float: right">
           <?php echo $plan_status[$item['status']]; ?>

        </span>
        </div>
        <div  >
            中奖率:<?php echo $item['rate']; ?>%   &nbsp;   期数:<?php echo $item['plannum']; ?>期
            <span  class="color-<?php echo $item['method']; ?>" >
              &nbsp;   <?php echo $plan_method[$item['method']]; ?>
            </span>
            <span class="color-<?php echo $item['status']; ?>"  style="float: right">
            <span class="btns ok" onclick="location.href='edit.php?id=<?php echo $item['id']; ?>';"><i class="icon-edit"></i>更新</span>
            <?php if($user['plan_grade']>0){?>
            <span class="btns clear" onclick="click_plan_delete(<?php echo $item['id']; ?>);"><i class="icon-cancel"></i>删除</span>
            <?php } else { ?>
            <span class="btns clear" onclick="click_plan_detail(<?php echo $item['id']; ?>);"><i class="icon-book"></i>查看</span>
            <?php }?>
            </span>
        </div>


    </li>

    <?php }}?>
</ul>

<div class="nodata" style="color: #666;text-align: center;line-height: 25px;height: 50px">
    您目前处于<span style="color: #2319dc"><?php echo $plan_grade_arr[$user['plan_grade']]; ?></span>计划<br>只能发布<span style="color: #2319dc"><?php echo $task[$user['plan_grade']]['addnum']; ?></span>条计划

    <?php if($user['plan_grade']==0){?>

    ,一旦发布禁止删除
    <?php }?>

</div>
<div class="page">
    <?php echo $page_html; ?>

</div>
<?php } else { ?>

<div class="nodata"  style="color: #666;">
    您还没发布任何计划,快去发布吧

</div>

<?php }?>

<?php include_once template("footer");?>