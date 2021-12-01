

<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/plan_layer.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />
<script src="/static/js/plan_mobile.js?v=<?php echo $cachekey; ?>"></script>



<div class="header" style="padding: 5px 0px;">
    <span class="back" onclick="var index = parent.layer.getFrameIndex(window.name);parent.layer.close(index);" style="top:5px;"><i class="icon-left-open-3"></i></span>

    <div class="title">
        <?php echo $userinfo['plan_title']; ?>
    </div>

</div>

<?php if(count($list)>0){?>

<ul class="user_list" style="margin-top: 40px">


    <?php if(is_array($list)){foreach($list AS $index=>$item) { ?>

    <li>

        <div > <a  onclick="parent.location.href='/plan/detail.php?id=<?php echo $item['id']; ?>';"><?php echo $item['othertitle1']; ?></a>

            <span class="color-<?php echo $item['status']; ?>"  style="float: right">
           <?php echo $plan_status[$item['status']]; ?>

        </span>
        </div>
        <div  >
            <span style="color: #666;">中奖率:</span><span style="color: #ff2600"><?php echo $item['rate']; ?>% </span>  &nbsp;

            <span  style="float: right;color: #666;font-size: 12px;">
              最后更新时间：<?php echo date('Y-m-d H:i',$item['updatetime']); ?>
            </span>
        </div>


    </li>

    <?php }}?>
</ul>

<div class="page">
    <?php echo $page_html; ?>

</div>
<?php } else { ?>

<div class="nodata" style="color: #666;margin-top: 40px;text-align: center" >
    TA还没有发布任何计划

</div>

<?php }?>

<div style="height: 60px;">

</div>
<?php include_once template("footer");?>
