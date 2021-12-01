

<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/group.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />

<style>

    .detail > div:last-child .info > ul > li:first-child{
        width: 112px;
    }
</style>



<div class="detail">

    <div>
        <div class="info">

            <img src="<?php echo $user['avatar']; ?>" class="avatar"/>
            <div class="title"><?php echo $user['nickname']; ?>


            </div>
            <?php if($user['nickname']!==$user['showname']){?>

            <div  style="font-size: 14px;color: #eee;height: 25px;line-height: 25px;display: none">昵称：<?php echo $user['showname']; ?></div>
            <?php }?>



            <div class="number">
              ID：  <?php if($user['isfriend'] || $fromgroup==0 ||  ($group.no_add!=1 || $myinfo.type=='owner' || $myinfo.type=='manager')){?>
                <?php echo $user['number']; ?>
                <?php } else { ?>
                <?php echo substr($user['number'],0,1); ?>****
                <?php }?>
                <?php if($user['vip']>0){?>

                <img src="/static/images/vip1.png" style="width: 20px;height: 18px;" >
                <?php }?>
            </div>
            <?php if($user['isvip']==1){?>
            <span id="useraction"  style="margin-top: -5px;">
        <?php if($isuseraction==1){?>
        <span class="btn"  onclick="click_useraction(<?php echo $user['id']; ?>);"><i class="icon-star"></i>取消关注</span>
                <?php } else { ?>
        <span class="btn" onclick="click_useraction(<?php echo $user['id']; ?>);" ><i class="icon-star-2"></i>关注</span>
                <?php }?>
        </span>
            <?php }?>
        </div>


        <?php if($_SESSION['userid']==$user['id']){?>

        <div class="chatbtn" onclick="parent.user_edit();"><i class="icon-edit"></i>编辑资料</div>
        <?php } else { ?>

           <?php if($user['isfriend']){?>
        <span class="chatbtn"   onclick="parent.open_chatarea(<?php echo $user['id']; ?>,'<?php echo $user['nickname']; ?>','<?php echo $user['avatar']; ?>',0);var index = parent.layer.getFrameIndex(window.name);parent.layer.close(index);"><i class="icon-chat"></i>发送消息</span>
           <?php } else { ?>

      <?php if($fromgroup==0 ||  ($group.no_add!=1 || $myinfo.type=='owner' || $myinfo.type=='manager')){?>
        <span class="chatbtn"   onclick="AddFriend();"><i class="icon-plus"></i>加为好友</span>
        <?php }?>

        <?php }?>
        <?php }?>


    </div>
    <div>

        <div class="menu">
            <li class="active" onclick="change_tab(0);">首页</li>
            <li onclick="change_tab(1);">群印象</li>
            <?php if($user['isfriend']){?>
            <li onclick="change_tab(2);">设置</li>
            <?php }?>
        </div>

        <div class="step info" style="height: calc(100vh - 20px)">
            <?php if($user['isvip']==1){?>
            <img class="isvip" src="/template/default/static/img/isvip2.png"></img>
            <?php }?>
            <ul>
                <li>用户ID：</li>
                <li>
                    <?php if($user['isfriend'] || $fromgroup==0 ||  ($group.no_add!=1 || $myinfo.type=='owner' || $myinfo.type=='manager')){?>
                    <?php echo $user['number']; ?>
                    <?php } else { ?>
                    <?php echo substr($user['number'],0,1); ?>****
                   <?php }?>


                    <?php if($group['is_owner']==1){?>
                    <span class="btn_yellow">群主</span>
                    <?php }?>
                    <?php if($group['is_manager']==1){?>
                    <span class="btn_green">管理员</span>
                    <?php }?>


                </li>
            </ul>
            <ul>
                <li>昵称：</li>
                <li><?php echo $user['showname']; ?></li>
            </ul>
            <?php if($user['sex']==1){?>
            <ul>
                <li>性别：</li>
                <li>男</li>
            </ul>
            <?php }?>
            <?php if($user['sex']==2){?>
            <ul>
                <li>性别：</li>
                <li>女</li>
            </ul>
            <?php }?>

            <?php if($user['city']  && $user['city']!='城市'){?>
            <ul>
                <li>所在地：</li>
                <li><?php echo $user['province']; ?> <?php echo $user['city']; ?></li>
            </ul>
            <?php }?>
            <?php if($user['sign']){?>
            <ul>
                <li>个性签名：</li>
                <li><?php echo $user['sign']; ?></li>
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
            <?php if($user['from']){?>
            <ul>
                <li>来源：</li>
                <li><?php echo $user['from']; ?></li>
            </ul>
            <?php }?>
            <?php if($user['isvip']==0  && ($user['city']=='城市' || !$user['city']) && !$user['sex']){?>

            <div style="height: 40px;line-height: 40px;text-align: center;color: #666;">
                这个人很懒  什么都没写

            </div>

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
        </div>

        <div class="step info" style="display: none;height: calc(100vh - 20px)">
            <?php if(count($user['logout_words'])>0  && $user['logout_words']!=array()){?>
            <div class="words">
                <?php if(is_array($user['logout_words'])){foreach($user['logout_words'] AS $index=>$value) { ?>
                  <div class="word"><div class="title"><?php echo $value['title']; ?></div> </div>

                <?php }}?>


            </div>

            <?php } else { ?>
             <div class="nodata">
                 该用户暂时没有群印象
             </div>
            <?php }?>
        </div>
        <div class="step info" style="display: none;height: calc(100vh - 20px)">

            <ul>
                <li>备注：</li>
                <li>
                    <input name="remark" id="remark" value="<?php echo $user['nickname']; ?>" class="input" style="width: 80px;height:30px;line-height: 30px;    padding: 0px 10px;
    font-size: 14px;
    background-color: transparent;
    color: #222;
    border: 1px solid #ccc;
    border-radius: 5px;" maxlength="7" >

                    <input class="btn" type="button" onclick="sub_rename();" value="确认" style="padding:0px 10px;height: 30px;line-height: 30px;border-radius: 5px;color: #fff;background-color: #2319dc;border: 0px;">
                </li>
            </ul>



            <ul style="margin-top: 10px;">
                <li>置顶：</li>
                <li>
                   <input type="radio" name="istop" value="1" <?php if($msgtop){?>checked<?php }?> onclick="setmsgtop(true);">置顶  &nbsp;&nbsp;&nbsp;

                    <input type="radio" name="istop" value="0" <?php if(!$msgtop){?>checked<?php }?> onclick="setmsgtop(false);">取消置顶
                </li>
            </ul>


            <ul style="margin-top: 10px">
                <li>免打扰：</li>
                <li>
                    <input type="radio" name="notip" value="1" <?php if($msgnotip){?>checked<?php }?> onclick="setmsgnotip(true);">开启  &nbsp;&nbsp;&nbsp;

                    <input type="radio" name="notip" value="0" <?php if(!$msgnotip){?>checked<?php }?> onclick="setmsgnotip(false);">关闭
                </li>
            </ul>

            <?php if($user['from']!='system'){?>
            <ul style="margin-top: 10px;text-align: center">

                 <a style="color: #2319DC;text-decoration: underline" onclick="return delete_friend();">删除好友</a>
            </ul>
            <?php }?>



        </div>

    </div>
</div>


<script>
    var userid=parseInt('<?php echo $_SESSION['userid']; ?>');
    var issetname=parseInt('<?php echo $issetname; ?>');
    function change_tab(num) {
        var step=document.querySelectorAll('.step');
        var li=document.querySelector('.menu').querySelectorAll('li');
        for(var i=0;i<li.length;i++){
            if(i==num) {
                li[i].className='active';
                step[i].style.display='';
            }
            else {
                li[i].className='';
                step[i].style.display='none';
            }
        }

//       var index = parent.layer.getFrameIndex(window.name);
//       parent.layer.iframeAuto(index);
    }

    function setmsgtop(status) {


        var  data = {cache_key:'U<?php echo $user['id']; ?>',userid:userid,istop:status};


        $.get("../api/group.php?act=set_msgtop",data, function(result){
               parent.lastchat();
        });

    }
    function setmsgnotip(status) {


        var  data = {cache_key:'U<?php echo $user['id']; ?>',userid:userid,notip:status};


        $.get("../api/group.php?act=set_msgnotip",data, function(result){

        });

    }
    function sub_rename(){

        if($('#remark').val()=='') {
            layer.msg('请输入备注名称',{ type: 1, anim: 2 ,time:1000});
            return false;
        }
        var  data = {friend_uid:<?php echo $user['id']; ?>,userid: userid,mark:$('#remark').val()};

        $.post("../api/user.php?act=setmark",data, function(result){

            result=JSON.parse(result);

            if(result.code==200){
                layer.msg('备注成功',{ type: 1, anim: 2 ,time:1000});
                setTimeout(function () {
                  // location.reload()
                },800)
            }
            else{
                layer.msg(result.message,{ type: 1, anim: 2 ,time:1000});
            }
        });


    }
    function  delete_friend() {
        var index=  layer.confirm('是否确认删除好友', {
            title:'提示',
            time: 20000, //20s后自动关闭
            btn: ['确认删除', '取消']
        },function () {

            $.post("../api/user.php?act=deleteFriend",{friendid:<?php echo $user['id']; ?>,userid:userid}, function(result){

                result=JSON.parse(result);

                if(result.code==200){
                    layer.close(index);
                    layer.msg('删除成功',{ type: 1, anim: 2 ,time:1000});
                    parent.lastchat();
                    setTimeout(function () {
                        var index = parent.layer.getFrameIndex(window.name);
                        parent.layer.close(index);
                    },1000)
                }
                else{
                    layer.msg(result.message,{ type: 1, anim: 2 ,time:1000});
                }
            });
        },function () {

        });

    }


    function AddFriend() {
        if(parent.check_userlock()==false) return false;
        if(issetname!=1){
            var index=  layer.confirm('未设置昵称，不能申请添加好友', {
                title:'提示',
                time: 20000, //20s后自动关闭
                btn: ['去设置', '取消']
            },function () {

                layer.close(index);
                parent.user_edit();
                setTimeout(function () {
                    var index = parent.layer.getFrameIndex(window.name);
                    parent.layer.close(index);
                },1000)
            },function () {

            });

            return false;
        }

        if(userid>0){

                parent.friend_apply(<?php echo $user['id']; ?>,'<?php echo $_GET['from']; ?>');

        }else{
            parent.layerlogin();
            var index = parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);

        }
    }


    function click_useraction(touid) {

        if(userid>0){
            $.post("../api/plan.php?act=useration",{touid:touid}, function(result){

                result=JSON.parse(result);

                if(result.code==200){
                    if(result.data==1){
                        var html='<span class="btn"  onclick="click_useraction('+touid+');"><i class="icon-star"></i>取消关注</span>';

                    }else{
                        var html='<span class="btn"  onclick="click_useraction('+touid+');"><i class="icon-star-2"></i>关注</span>';

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

<style>
    .words{

        width: 100%;
        text-align: center;
    }

    .words .word{
        display: inline-block;
        margin: 5px 8px;

    }
    .words .word .title{
        height: 25px; line-height:25px;
        padding: 0px 5px;
        min-width: 70px;

        border-radius: 5px;
        border: 1px #2319dc solid;
        color: #fff;
        background-color: #2319dc;
    }

</style>
<?php include_once template("footer");?>