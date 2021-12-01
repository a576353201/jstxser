

<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/plan_layer.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />
<script src="/static/js/plan.js?v=<?php echo $cachekey; ?>"></script>
<ul class="layer_nav">
    <li class="active">我关注的计划</li>

</ul>
<?php if(count($list)>0){?>

<ul class="user_list">

    <li>

        <div class="title">标题</div>
        <div>状态</div>
        <div>操作</div>
    </li>
    <?php if(is_array($list)){foreach($list AS $index=>$item) { ?>
    <li>

        <div class="title"> <a  onclick="click_plan_detail(<?php echo $item['id']; ?>);"><?php echo $item['showtitle']; ?></a></div>
        <div class="color-<?php echo $item['status']; ?>">
            <?php echo $plan_status[$item['status']]; ?>

        </div>

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
    您还没关注任何计划

</div>

<?php }?>

<?php include_once template("footer");?>