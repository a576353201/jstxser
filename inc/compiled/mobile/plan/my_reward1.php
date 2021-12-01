

<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/plan_layer.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />
<script src="/static/js/plan_mobile.js?v=<?php echo $cachekey; ?>"></script>



<div class="header" style="padding: 5px 0px;">
    <span class="back"onclick="history.back();" style="top:5px;"><i class="icon-left-open-3"></i></span>


    <ul class="nav" style="width: 60%;left: 20%;top:5px;" >
        <li class="item " onclick="location.href='?method=0'">我打赏的计划</li>
        <li class="item active"   >我收到的打赏</li>

    </ul>
</div>
<div style="height: 50px;"></div>


<?php if(count($list)>0){?>

<ul class="user_list" >


    <?php if(is_array($list)){foreach($list AS $index=>$item) { ?>
    <li>




        <div >
            <?php echo $item['nickname']; ?>
            <span  style=" float: right;color: #ff2600">
            ￥<?php echo $item['money']; ?>

        </span>
        </div>
        <div  style="color: #666;">
            <?php echo date('Y-m-d H:i:s',$item['time']); ?>


        </div>
        <div class="title">
            <?php if($item['isdel']==1){?>
            <span style="color: #666;" onclick="  layer.msg('该计划可能被计划员/管理员删除',{ type: 1, anim: 2 ,time:1000});"><?php echo $item['content']; ?></span>
            <?php } else { ?>
            <a  onclick="click_plan_detail(<?php echo $item['plan_id']; ?>);" style="color: #666;"><?php echo $item['content']; ?></a>
            <?php }?>
        </div>

    </li>

    <?php }}?>
</ul>

<div class="page">
    <?php echo $page_html; ?>

</div>
<?php } else { ?>

<div class="nodata" style="color: #666;text-align: center" >
    您还没有收到任何人的打赏，继续加油哦

</div>

<?php }?>

