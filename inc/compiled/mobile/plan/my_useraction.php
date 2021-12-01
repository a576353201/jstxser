

<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/plan_layer.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />
<script src="/static/js/plan_mobile.js?v=<?php echo $cachekey; ?>"></script>


<div class="header" style="padding: 5px 0px;">
    <span class="back" onclick="var index = parent.layer.getFrameIndex(window.name);parent.layer.close(index);" style="top:5px;"><i class="icon-left-open-3"></i></span>


    <ul class="nav" style="width: 60%;left: 20%;top:5px;" >
        <li class="item active">我的关注</li>
        <li class="item "  onclick="location.href='?method=1'">我的收藏</li>

    </ul>
</div>

<?php if(count($list)>0){?>
<table class="toplist" cellspacing="0"  style="margin-top: 45px;">


    <?php if(is_array($list)){foreach($list AS $index=>$value) { ?>

    <tr>

        <td class="info" style="padding-left: 10px">
            <img class="avatar" src="<?php echo $value['avatar']; ?>"  onclick="parent.user_detail(<?php echo $value['id']; ?>);"/>
            <div class="user">
                <span class="title"><?php echo $value['plan_title']; ?></span>
                <span class="sign"><?php echo $value['plan_sign']; ?></span>
            </div>


        </td>
        <td class="grade">
            <img src="/<?php echo $system['plan_logo_'.$value['plan_grade']]; ?>" title="<?php echo $plan_grade_arr[$value['plan_grade']]; ?>" />

        </td>
        <td>

            <span class="btn" onclick="parent.user_plan(<?php echo $value['id']; ?>);">TA的计划</span>

            <span class="btn clear" onclick="click_action(<?php echo $value['id']; ?>);"><i class="icon-cancel"></i>取消关注</span>
        </td>
    </tr>

    <?php }}?>
</table>

<div class="page">
    <?php echo $page_html; ?>

</div>
<?php } else { ?>

<div class="nodata" style="color: #666;margin-top: 50px;text-align: center" >
    您还没关注任何计划

</div>

<?php }?>
<script>
    function click_action(touid) {

        $.post("../api/plan.php?act=useration",{touid:touid}, function(result){

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
<?php include_once template("footer");?>