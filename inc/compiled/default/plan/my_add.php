

<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/plan_layer.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />
<script src="/static/js/plan.js?v=<?php echo $cachekey; ?>"></script>
<ul class="layer_nav">
    <li class="active">我发布的计划</li>

</ul>
<?php if(count($list)>0){?>

<ul class="user_list">

    <li>
        <div style="width: 30px;">序号</div>
        <div class="title" style="width:35%">标题</div>
        <div style="width: 60px;">模式</div>
        <div style="width: 50px;">中奖率</div>
        <div  style="width: 40px;">期数</div>
        <div  style="width: 60px;">状态</div>
        <div>操作</div>
    </li>
    <?php if(is_array($list)){foreach($list AS $index=>$item) { ?>
    <li>
        <div  style="width: 30px;">
            <?php echo $index+1;?>
        </div>
        <div class="title" style="width:35%"> <a  onclick="click_plan_detail(<?php echo $item['id']; ?>);"><?php echo $item['othertitle1']; ?></a></div>
        <div  style="width: 60px;" class="color-<?php echo $item['method']; ?>" >
            <?php echo $plan_method[$item['method']]; ?>
        </div>
        <div  style="width: 50px;">
            <?php echo $item['rate']; ?>%
        </div>
        <div  style="width:40px;">
            <?php echo $item['plannum']; ?>期
        </div>
        <div class="color-<?php echo $item['status']; ?>"  style="width: 60px;">
           <?php echo $plan_status[$item['status']]; ?>

        </div>

        <div>

            <span class="btns ok" onclick="location.href='edit.php?id=<?php echo $item['id']; ?>';"><i class="icon-edit"></i>更新</span>

            <?php if($task_delete==1){?>
            <span class="btns clear" onclick="click_plan_delete(<?php echo $item['id']; ?>);"><i class="icon-cancel"></i>删除</span>
            <?php } else { ?>
            <span class="btns clear" onclick="click_plan_detail(<?php echo $item['id']; ?>);"><i class="icon-book"></i>查看</span>
            <?php }?>


        </div>

    </li>

    <?php }}?>
</ul>

<div class="nodata" style="color: #666;">
    您目前处于<span style="color: #2319dc"><?php echo $plan_grade_arr[$user['plan_grade']]; ?></span>计划员，只能发布<span style="color: #2319dc"><?php echo $task[$user['plan_grade']]['addnum']; ?></span>条计划

    <?php if($task_delete!=1){?>

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