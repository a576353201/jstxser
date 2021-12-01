

<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/plan_layer.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />
<script src="/static/js/plan.js?v=<?php echo $cachekey; ?>"></script>

<?php if($user['isvip']==1){?>


<div class="header" style="padding: 5px 0px;">
    <span class="back" onclick="var index = parent.layer.getFrameIndex(window.name);parent.layer.close(index);" style="top:5px;"><i class="icon-left-open-3"></i></span>


    <ul class="nav" style="width: 60%;left: 20%;top:5px;" >
        <li class="item active">我打赏的计划</li>
        <li class="item "  onclick="location.href='?method=1'" >我收到的打赏</li>

    </ul>
</div>
<?php } else { ?>
<div class="header" style="padding: 5px 0px;">
    <span class="back" onclick="var index = parent.layer.getFrameIndex(window.name);parent.layer.close(index);" style="top:5px;"><i class="icon-left-open-3"></i></span>

    <div class="title">
        我打赏的计划
    </div>

</div>
<?php }?>
<div style="height: 50px;"></div>
<?php if(count($list)>0){?>

<ul class="user_list" >


    <?php if(is_array($list)){foreach($list AS $index=>$item) { ?>
    <li>
        <div  >
            <?php echo date('Y-m-d H:i',$item['time']); ?>

            <span  style=" float: right;color: #ff2600">
            ￥<?php echo $item['money']; ?>

        </span>


        </div>


        <div >
            <?php if($item['isdel']==1){?>
            <span style="color: #666;" onclick="  layer.msg('该计划可能被计划员/管理员删除',{ type: 1, anim: 2 ,time:1000});"><?php echo $item['content']; ?></span>
            <?php } else { ?>
            <a  onclick="parent.location.href='/plan/detail.php?id=<?php echo $item['plan_id']; ?>';"><?php echo $item['content']; ?></a>
          <?php }?>
        </div>

    </li>

    <?php }}?>
</ul>

<div class="page">
    <?php echo $page_html; ?>

</div>
<?php } else { ?>

<div class="nodata" style="color: #666" >
    您还没打赏任何计划

</div>

<?php }?>

