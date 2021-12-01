

<?php include_once template("header");?>

<?php include_once template("plan/header");?>

<div class="header" style="padding: 5px 0px;">
    <span class="back" onclick="location.href='index.php?id=<?php echo $game['id']; ?>';" style="top:5px;"><i class="icon-left-open-3"></i></span>
    <div class="navright" onclick="show_addnav1();" style="top:5px;">
        <i class="icon-plus-1" style="font-size: 28px"></i>
    </div>
    <div class="title">
        <?php echo $plan['title']; ?>

    </div>

</div>
<div class="addnav"  id="addnav_1" style="top:47px;">

    <?php if($user['isvip']==1){?>
    <li  onclick="plan_add();"><i class="icon-plus"></i>发布计划</li>
    <li onclick="location.href='/plan/my_add.php';"><i class="icon-user"></i>我的发布</li>
    <?php } else { ?>
    <li class="button" onclick="plan_apply();">  <i class="icon-chart"></i>申请计划员</li>
    <?php }?>

    <li onclick="my_plan_reward(0);"><i class="icon-money"></i>打赏记录</li>
    <li onclick="my_plan_action(0);"><i class="icon-star"></i>我的关注</li>

</div>

<div class="planbox">


    <div>
        <?php include_once template("plan/top");?>




                <div class="plan_title" style="display: none" >


                    <span style="float: right"><i class="icon-eye"></i><span id="plan_view"><?php echo $plan['view']; ?></span></span>
                </div>
<div class="plan_list">
    <div class="frist">
        <?php echo $plan['list1']; ?>
    </div>
    <div class="tips">
        <span id="online">
                   <?php if($plan['isonline']==1){?>
            <span class="online"><span class="dian"></span>计划员在线</span>
            <?php } else { ?>
                   <span class="offline"><span class="dian"></span>计划员离线</span>
            <?php }?>

            </span>
         <i class="icon-clock"></i><span id="updatetime"><?php echo date('m-d H:i:s',$plan['updatetime']); ?></span>
        &nbsp; 共<span id="lostnum" style="color:#2319dc"><?php echo $plan['lostnum']; ?></span>次断更

        <span id="title_btn"></span>
        <br>
        <?php echo $userinfo['plan_sign']; ?><br>
        <?php echo $system['plan_tips']; ?>
    </div>

    <div id="plan_list" class="list">
        <?php if(is_array($plan['list2'])){foreach($plan['list2'] AS $index=>$value) { ?>
        <div>
            <?php echo $value; ?>
        </div>


        <?php }}?>
    </div>

</div>


                <table class="plan_conut" cellspacing="0">
                    <tr>

                        <th>当天计划</th>
                        <th>中奖概率</th>
                        <th>当前连中</th>
                        <th>最大连中</th>
                        <th>当前连挂</th>
                        <th>最大连挂</th>
                    </tr>
                    <tr id="plan_count">
                        <td >
                            <?php echo $plan['plannum']; ?>期
                        </td>
                        <td ><?php echo $plan['rate']; ?>%</td>
                        <td ><?php echo $plan['prize_num']; ?></td>
                        <td><?php echo $plan['prize_max']; ?></td>
                        <td><?php echo $plan['lose_num']; ?></td>
                        <td><?php echo $plan['lose_max']; ?></td>
                    </tr>

                </table>
            </div>


    </div>


<ul class="plan_bottom">
<li>
<div class="nav">
    <?php if($plan['userid']==$_SESSION['userid']){?>

    <div  onclick="my_plan_add();">
        <p> <i class="icon-chart"></i></p>
        <p>我的计划</p>
    </div>
    <?php } else { ?>
    <div  onclick="user_plan(<?php echo $plan['userid']; ?>);">
        <p> <i class="icon-chart"></i></p>
        <p><?php if($userinfo['sex']==1){?>他<?php } else if($userinfo['sex']==2) { ?>她<?php } else { ?>TA<?php }?>的计划</p>
    </div>

    <?php }?>

    <div id="useraction">
        <?php if($isuseraction==1 || $plan['userid']==$_SESSION['userid']){?>
        <p onclick="user_detail(<?php echo $plan['userid']; ?>);"><i class="icon-credit-card"></i></p><p>名片</p>

        <?php } else { ?>
        <p onclick="click_useraction(<?php echo $plan['userid']; ?>);"><i class="icon-heart"></i></p><p>关注</p>

        <?php }?>

    </div>

    <div  id="action_btn" onclick="click_action();">
        <?php if($isaction==1){?>
       <p><i class="icon-star" style="color:#2319dc;"></i></p><p>取消收藏</p>
        <?php } else { ?>
        <p><i class="icon-star"></i></p><p>收藏</p>
        <?php }?>
    </div>
</div>
</li>
    <li style="width: 55%;">
         <div class="btns">
             <span onclick="click_copy();"  ><i class="icon-edit"></i>一键复制</span>
             <?php if($plan['userid']==$_SESSION['userid']){?>
             <span onclick="plan_edit(<?php echo $plan['id']; ?>);"><i class="icon-edit"></i>立即更新</span>
             <?php } else { ?>
             <span  onclick="click_pay('reward',<?php echo $plan['id']; ?>);"><i class="icon-money"></i>我要打赏</span>
             <?php }?>

         </div>



    </li>

</ul>
<div class="page_container el-pagination is-background">


</div>
<script>
    var gamekey='<?php echo $game['showkey']; ?>';

    var showtype='detail';
    var plan_id='<?php echo $plan['id']; ?>';
    var rate=parseInt(<?php echo $plan['rate']; ?>);
    var plannum=parseInt(<?php echo $plan['plannum']; ?>);
    var reward_expect=parseInt(<?php echo $system['reward_expect']; ?>);
    var reward_rate=parseInt(<?php echo $system['reward_rate']; ?>);
    var copyhtml="";
    get_plan_detail();

    function click_copy() {
        var html="                                   <?php echo $plan['title']; ?>\n";
      //  copyhtml+=$(".plan_list .tips").html();
        var list=document.querySelector('#plan_list').querySelectorAll('div');
        var len=list.length-1;
        if(len>10)len=10;
        for(var i=len;i>=0;i--){
            html+=list[i].querySelector('p').innerHTML.replace(/<[^<>]+>/g,'')+"\n";
        }
        if($('.plan_list .frist').html().indexOf('p')>-1)    html+=$('.plan_list .frist p').html()+"\n";
      if($('.plan_list .frist').html().indexOf('ds_html')>-1)  html+=$('.plan_list .frist .ds_html').html()+"\n";
        html+="<?php echo $userinfo['plan_sign']; ?>\n" +
            "<?php echo $system['plan_tips']; ?>";
        copy(html);
    }

    function set_tabs2(div,num) {
        var span=document.querySelector('#'+div).querySelector('.navtitle').querySelectorAll('span');
        var ul=document.querySelector('#'+div).querySelectorAll('ul');
        for(var i=0;i<span.length;i++){
            if(i==num){
                span[i].className='title';
                ul[i].style.display='';
            }
            else{
                span[i].className='other';
                ul[i].style.display='none';
            }
        }

        if(num==1 && div=='nav2'){
            get_other_nav();
        }
    }

    var isonline=parseInt(<?php echo $plan['isonline']; ?>);
    var addtips="您目前处于<span style=\"color: #2319dc\"><?php echo $plan_grade_arr[$user['plan_grade']]; ?></span>计划员<br>还可以发布<span style=\"color: #2319dc\"><?php echo $lastaddnum; ?></span>条计划";
    <?php if($user['plan_grade']==0){?>
    addtips+='<br>一旦发布后<span style="color: #2319dc">禁止删除</span>'
    <?php }?>
    var lastaddnum=parseInt(<?php echo $lastaddnum; ?>);
    var addtipsmsg="您是<?php echo $plan_grade_arr[$user['plan_grade']]; ?>计划员，最低只能发布<?php echo $task[$user['plan_grade']]['addnum']; ?>条计划,已经没有剩余了";

</script>
<style>

    .layui-layer {
        border-radius: 0px;
    }
    #ClCache{
        display: none;
    }
</style>

