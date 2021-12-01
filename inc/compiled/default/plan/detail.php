

<?php include_once template("header");?>
<?php include_once template("plan/header");?>




<div class="planbox">

    <div>
 <ul class="plan_user">
     <li>
         <img src="<?php echo $userinfo['avatar']; ?>" />
     </li>
     <li>
        <div class="title">
            <?php echo $plan['title']; ?>
            <span id="online">
                   <?php if($plan['isonline']==1){?>
            <span class="online"><span class="dian"></span>在线</span>
                <?php } else { ?>
                   <span class="offline"><span class="dian"></span>离线</span>
                <?php }?>

            </span>

        </div>
         <div class="info">
             <?php if($plan['userid']==$_SESSION['userid']){?>
             <span class="btn"  onclick="my_plan_add();">我的计划</span>

             <?php } else { ?>
            <span class="btn"  onclick="user_plan(<?php echo $plan['userid']; ?>);"><?php if($userinfo['sex']==1){?>他<?php } else if($userinfo['sex']==2) { ?>她<?php } else { ?>TA<?php }?>的计划</span>
             <?php }?>
             <span id="useraction">
                      <?php if($isuseraction==1 || $plan['userid']==$_SESSION['userid']){?>
             <span class="btn"  onclick="parent.user_detail(<?php echo $plan['userid']; ?>);">名片</span>
                 <?php } else { ?>
             <span class="btn" onclick="click_useraction(<?php echo $plan['userid']; ?>);" >关注</span>
                 <?php }?>

             </span>


         </div>
     </li>
 </ul>

<span class="nav_other" id="nav1">
    <div class="navtitle">
        <span class="title" onclick="set_tabs2('nav1',0);">浏览记录</span>
        <span class="other" onclick="set_tabs2('nav1',1);" >付费记录</span>
    </div>
<ul>
<?php if(is_array($view_list)){foreach($view_list AS $index=>$value) { ?>
    <li onclick="location.href='?id=<?php echo $value['plan_id']; ?>';" title="<?php echo $value['showtitle']; ?>" <?php if($value['plan_id']==$plan['id']){?>class='active'<?php }?>   >
       <?php echo $value['showtitle']; ?>
    </li>
    <?php }}?>

</ul>


    <ul  style="display: none">
<?php if(is_array($reward)){foreach($reward AS $index=>$value) { ?>
    <li onclick="location.href='?id=<?php echo $value['id']; ?>';"  title="<?php echo $value['showtitle1']; ?>"  <?php if($value['id']==$plan['id']){?>class='active'<?php }?>  >
       <?php echo $value['showtitle1']; ?>
        </li>
        <?php }}?>

</ul>



</span>


        <span class="nav_other"  id="nav2">
            <div class="navtitle">
                <span class="title" onclick="set_tabs2('nav2',0);">推荐计划</span>
                <span class="other" onclick="set_tabs2('nav2',1);">其他彩种</span>
            </div>

            <ul id="game_nav1">
           <?php if(is_array($nav1)){foreach($nav1 AS $index=>$item) { ?>
<li  onclick="location.href='detail.php?id=<?php echo $item['id']; ?>'"><?php echo $item['showtitle']; ?></li>
                <?php }}?>
            </ul>

             <ul id="game_nav2" style="display: none">
           <?php if(is_array($nav2)){foreach($nav2 AS $index=>$item) { ?>
<li  onclick="location.href='detail.php?id=<?php echo $item['id']; ?>'"><?php echo $item['othertitle']; ?></li>
                 <?php }}?>

            </ul>

        </span>


            <?php include_once template("plan/banner");?>


    </div>

    <div>
        <?php include_once template("plan/top");?>


            <div class="plan_content" >
                <div class="plan_detail">



                </div>
                <div class="plan_title" >
                    <span style="float: left;font-size: 12px;display: none">编号:<?php echo $plan['id']; ?></span>
                   <?php echo $system['plan_welcome']; ?>

                    <span style="float: right"><i class="icon-eye"></i><span id="plan_view"><?php echo $plan['view']; ?></span></span>
                </div>
<div class="plan_list">
    <div class="frist">
        <?php echo $plan['list1']; ?>
    </div>
    <div class="tips">

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



                <div class="plan_time">
                    最后更新时间：<span id="updatetime"><?php echo date('Y-m-d H:i:s',$plan['updatetime']); ?></span>
                 &nbsp; 当天共<span id="lostnum"><?php echo $plan['lostnum']; ?></span>次断更
                </div>

    <?php if($plan['userid']==$_SESSION['userid']){?>
                <div class="plan_pay" onclick="plan_edit(<?php echo $plan['id']; ?>);"><i class="icon-edit"></i>立即更新</div>
    <?php } else { ?>
                <div class="plan_pay" onclick="click_pay('reward',<?php echo $plan['id']; ?>);"><i class="icon-money"></i>我要打赏</div>
    <?php }?>

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
</div>
<div class="page_container el-pagination is-background">
<div style="display: block;width: 430px;margin: 0px auto">
    <span class="btn" onclick="location.href='index.php?id=<?php echo $game['id']; ?>';" style="float: left;">
        <i class="icon-back"></i>返回大厅
    </span>
    <span class="btn" onclick="click_copy();"  style="float: right;">
        <i class="icon-edit"></i>一键复制
    </span>
</div>

</div>
<script>
    var gamekey='<?php echo $game['showkey']; ?>';

    var showtype='detail';
    var plan_id='<?php echo $plan['id']; ?>';
    var copyhtml="";
    var rate=parseInt(<?php echo $plan['rate']; ?>);
    var plannum=parseInt(<?php echo $plan['plannum']; ?>);
    var reward_expect=parseInt(<?php echo $system['reward_expect']; ?>);
    var reward_rate=parseInt(<?php echo $system['reward_rate']; ?>);
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
</script>
<style>

    .layui-layer {
        border-radius: 8px;
    }
    #ClCache{
        display: none;
    }
</style>

<?php include_once template("footer");?>