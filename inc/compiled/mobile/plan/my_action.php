

<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/plan_layer.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />
<script src="/static/js/plan_mobile.js?v=<?php echo $cachekey; ?>"></script>
<div class="header" style="padding: 5px 0px;">
    <span class="back" onclick="var index = parent.layer.getFrameIndex(window.name);parent.layer.close(index);" style="top:5px;"><i class="icon-left-open-3"></i></span>


    <ul class="nav" style="width: 60%;left: 20%;top:5px;" >
        <li class="item "  onclick="location.href='?method=1'">我的关注</li>
        <li class="item active" >我的收藏</li>

    </ul>
</div>
<?php if(count($list)>0){?>

<ul class="user_list" style="margin-top: 50px;">

    <?php if(is_array($list)){foreach($list AS $index=>$item) { ?>
    <li>

        <div > <a  onclick="click_plan_detail(<?php echo $item['id']; ?>);"><?php echo $item['showtitle1']; ?></a>

            <span class="color-<?php echo $item['status']; ?>"  style="float: right">
            <?php echo $plan_status[$item['status']]; ?>

        </span>

        </div>

        <div ><?php echo date('Y-m-d H:i',$item['updatetime']); ?>

            <span style="float: right">
            <span class="btns clear" onclick="click_action(<?php echo $item['id']; ?>);"><i class="icon-cancel"></i>取消收藏</span>

        </span>
        </div>



    </li>

    <?php }}?>
</ul>

<div class="page">
    <?php echo $page_html; ?>

</div>
<?php } else { ?>

<div class="nodata" style="color: #666;margin-top: 60px;" >
    您还没收藏任何计划

</div>

<?php }?>

<script>
    function click_action(plan_id) {

            $.post("../api/plan.php?act=action",{id:plan_id}, function(result){

                result=JSON.parse(result);
                if(result.code==200){

                   location.reload();

                }
                else{
                    layer.msg(result.message,{ type: 1, anim: 2 ,time:1000});
                }
            });

    }

</script>

