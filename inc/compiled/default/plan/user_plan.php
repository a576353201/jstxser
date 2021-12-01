

<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/plan_layer.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />
<script src="/static/js/plan.js?v=<?php echo $cachekey; ?>"></script>
<ul class="layer_nav">
    <li class="active"><?php echo $userinfo['plan_title']; ?></li>

</ul>
<?php if(count($list)>0){?>

<ul class="user_list">

    <li>

        <div class="title" style="width: 40%">标题</div>
        <div style="width: 80px;">中奖率</div>
        <div style="width: 120px;">最后更新时间</div>
        <div>操作</div>
    </li>
    <?php if(is_array($list)){foreach($list AS $index=>$item) { ?>
    <li>

        <div class="title" style="width: 40%"> <a  onclick="click_plan_detail(<?php echo $item['id']; ?>);"><?php echo $item['othertitle1']; ?></a></div>
<div style="width: 80px;"><?php echo $item['rate']; ?>%</div>
        <div style="font-size: 12px;color: #666;width: 120px;" ><?php echo date('Y-m-d H:i',$item['updatetime']); ?></div>
        <div>
            <span class="btns clear" onclick="click_plan_detail(<?php echo $item['id']; ?>);"><i class="icon-book"></i>查看</span>


        </div>

    </li>

    <?php }}?>
</ul>

<div class="page">
    <?php echo $page_html; ?>

</div>
<?php } else { ?>

<div class="nodata" style="color: #666" >
    TA还没有发布任何计划

</div>

<?php }?>
<?php include_once template("footer");?>