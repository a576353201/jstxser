

<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/group.css" type="text/css" media="screen" />
<script src="/mobile/static/main.js"></script>
<style>
    body{
        background-color: #fafafa;
    }

    .detail > div:last-child .info > ul > li:first-child{
         width: 125px;
     }
    #useraction .btn_green{
         padding: 5px 6px;
     }
</style>


    <span class="back" onclick="close_layer();" style="position:fixed;top:5px;left:5px;color: #fff;font-size: 24px;z-index: 10000;"><i class="icon-left-open-3"></i></span>

<?php if($user['isvip']==1){?>
<div class="usertop" style="background-image: url('/<?php echo $system['vip_banner']; ?>');">

</div>
<?php } else { ?>
<div class="usertop" style="background-image: url('/<?php echo $system['user_banner']; ?>');">

</div>
<?php }?>
<div  class="userdetail">

    <ul>
        <li>
            <img src="<?php echo $user['avatar']; ?>" class="avatar">

        </li>
        <li>
            <div ><span style="font-size: 16px;font-weight: 600;color:#fff;"><?php echo $user['nickname']; ?></span>




                <?php if($group['is_owner']==1){?>
                <span class="btn_yellow">群主</span>
                <?php }?>
                <?php if($group['is_manager']==1){?>
                <span class="btn_green">管理员</span>
                <?php }?>
                <?php if($user['isvip']==1){?>
                <div class="btn_blue">计划员</div>
                <?php }?>


            </div>
            <div>ID:<?php echo $user['number']; ?>


                <?php if($_SESSION['userid']!==$user['id'] && $user['isvip']==1){?>
                <span id="useraction"  onclick="click_useraction(<?php echo $user['id']; ?>);">
        <?php if($isuseraction==1){?>
        <span class="btn_green" ><i class="icon-cancel"></i>取消关注</span>
                    <?php } else { ?>
        <span class="btn_green"  ><i class="icon-plus-circle"></i>关注</span>
                    <?php }?>
        </span>
                <?php }?>
            </div>


        </li>

    </ul>


</div>

<div class="detail">


    <div>
        <div class="info">
            <?php if($user['city']  && $user['city']!='城市'){?>
            <ul>
                <li>所在地：</li>
                <li >
                    <?php echo $user['province']; ?> <?php echo $user['city']; ?>
                </li>
            </ul>

            <?php }?>
            <?php if($user['sex']>0){?>
            <ul>
                <li>性别：</li>
                <li >
                    <?php if($user['sex']==1){?> 男<?php } else { ?>女<?php }?>
                </li>
            </ul>
            <?php }?>
            <?php if($jointime){?>
            <ul>
                <li>加群时间：</li><li><?php echo $jointime; ?></li>
            </ul>

            <?php }?>
            <?php if($chattime){?>
            <ul>
                <li>最近发言：</li><li><?php echo $chattime; ?></li>
            </ul>
            <?php }?>
            <?php if($user['isvip']==1){?>
            <ul>
                <li>段位：</li>
                <li><?php echo $plan_grade_arr[$user['plan_grade']]; ?></li>
            </ul>
            <ul>
                <li>当天最高中奖率：</li>
                <li><?php echo $rate1; ?>%</li>
            </ul>
            <ul>
                <li>历史最高中奖率：</li>
                <li><?php echo $rate2; ?>%</li>
            </ul>

            <ul>
                <li>历史最大连中：</li>
                <li><?php echo $user['plan_prizemax']; ?>期</li>
            </ul>
            <?php if($gameshow!=''){?>
            <ul>
                <li>主攻彩种：</li>
                <li class="tagshow">
                    <?php echo $gameshow; ?>
                </li>
            </ul>
            <?php }?>
            <?php if($tags!=''){?>
            <ul>
                <li>主攻玩法：</li>
                <li class="tagshow">
                    <?php echo $tags; ?>
                </li>
            </ul>
            <?php }?>
            <?php }?>


            <?php if($user['sign']){?>
            <ul>
                <li>个性签名：</li><li><?php echo $user['sign']; ?></li>
            </ul>

            <?php }?>
        </div>
        <?php if($_SESSION['userid']==$user['id']){?>

        <div class="chatbtn" onclick="parent.location.href='/user/profile.php'"><i class="icon-edit"></i>编辑资料</div>
        <?php }?>

    </div>
</div>

<script>
    var userid=parseInt('<?php echo $_SESSION['userid']; ?>');

    function apply_group(no_invite) {
        if(userid>0){
            //不需要审核，直接进进群
            var data={type:'Join_Group',userid:userid,group_id:'<?php echo $group['id']; ?>'};
            parent.send_data(JSON.stringify(data));
            parent.layer_loading=layer.load(1, {
                shade: [0.1,'#fff']
            });
            parent.layer_name= parent.layer.getFrameIndex(window.name);;

            return false;

        }else{
            parent.layerlogin();
            var index = parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);

        }
    }

    function close_layer() {
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.close(index);
    }

    function click_useraction(touid) {

        if(userid>0){
            $.post("../api/plan.php?act=useration",{touid:touid}, function(result){

                result=JSON.parse(result);

                if(result.code==200){
                    if(result.data==1){
                        var html='<span class="btn_green" ><i class="icon-cancel"></i>取消关注</span>';

                    }else{
                        var html='<span class="btn_green"  ><i class="icon-plus-circle"></i>关注</span>';

                    }
                    $('#useraction').html(html);
                    layer.msg(result.message,{ type: 1, anim: 2 ,time:1000});
                }
                else{
                    layer.msg(result.message,{ type: 1, anim: 2 ,time:1000});
                }
            });
        }else{
            parent.layerlogin();
        }
    }
</script>


