<div class="gameinfo">

    <div>
        <img src="/<?php echo $gamelist[0]['logo']; ?>"/>

    </div>

    <div style="padding-left: 10px">
        <div class="title"><?php echo $game['title']; ?></div>
        <div class="time" >
            第<span id="lottery_period"><?php echo $lottery['period']; ?></span>期

        </div>
    </div>
    <div id="lottery_num">
        <?php if(is_array($number)){foreach($number AS $index=>$value) { ?>
        <span class="ball"><?php echo $value; ?></span>
        <?php }}?>
    </div>
    <div style="width: 70px;text-align: center;font-size: 12px;">
        距下期开奖<br>
        倒计时
    </div>
    <div style="text-align: center">


        <div class="clock">
            <span class="num">0</span><span class="num">0</span><span class="exp">:</span><span class="num">0</span><span class="num">0</span>
        </div>

    </div>

    <div style="width: 80px;padding-right: 15px;">
        <?php if($showtype=='detail'){?>

        <div class="button" id="action_btn" onclick="click_action();">
        <?php if($isaction==1){?>
            <i class="icon-star" style="color:#00FF00;"></i>取消收藏
        <?php } else { ?>
      <i class="icon-star"></i>收藏计划
        <?php }?>
    </div>
        <?php } else { ?>
        <div class="button" onclick="my_plan_action(1);">  <i class="icon-star"></i>我的收藏</div>
        <?php }?>

        <?php if($user['isvip']==1){?>
        <div class="button" onclick="plan_add();">  <i class="icon-plus"></i>发布计划</div>
        <?php } else { ?>
        <div class="button" onclick="plan_apply();">  <i class="icon-chart"></i>申请计划员</div>
        <?php }?>


    </div>

</div>

<script>
    var game_id=<?php echo $game['id']; ?>;
    var gamekey='<?php echo $game['showkey']; ?>';
    var gametype='<?php echo $game['type']; ?>';
    var lottery_period='<?php echo $lottery['period']; ?>';
    lottery_time(<?php echo $period['lastsecond']; ?>);
    var page=1;
    var userid=parseInt(<?php echo $_SESSION['userid']; ?>);
</script>

<div class="notes">
    <div >
        <div class="button" style="width: 55px;" onclick="parent.window.open('/pc.php?lotteryId=<?php echo $game['id']; ?>#/lottery?lotteryId=<?php echo $game['id']; ?>');"><i class="icon-trophy" style="font-size: 12px;color: #fff;"></i>开奖</div>
        <div class="button" style="width: 55px;margin-left: 5px;" onclick="open_trend()"><i class="icon-chart" style="font-size: 12px;color: #fff;"></i>走势</div>
    </div>

    <div class="msglist" id="msglist">
<div class="list1">

    <?php echo rewardlist(); ?>
</div>
<div class="list2">


</div>

    </div>

</div>

<script>

    setInterval(function () {
        set_updown1('msglist');
    },5000)


    var addtips="您目前处于<span style=\"color: #2319dc\"><?php echo $plan_grade_arr[$user['plan_grade']]; ?></span>计划员<br>还可以发布<span style=\"color: #2319dc\"><?php echo $lastaddnum; ?></span>条计划";
    <?php if($task_delete!=1){?>
    addtips+='<br>一旦发布后<span style="color: #2319dc">禁止删除</span>'
    <?php }?>
   var lastaddnum=parseInt(<?php echo $lastaddnum; ?>);
    var addtipsmsg="您是<?php echo $plan_grade_arr[$user['plan_grade']]; ?>计划员，最低只能发布<?php echo $task[$user['plan_grade']]['addnum']; ?>条计划,已经没有剩余了";
    var ismobile=0;
    function open_trend() {
        parent.layer.open({
            type: 2,
            title: false,
            shadeClose: true,
            closeBtn:true,
            shade: 0.6,
            area: ['1180px', '800px'],
            content: "/trend/index.php?id="+game_id //iframe的url
        });
    }

    function lottery_update(data) {
        for(var i=0;i<data.length;i++){
            var item=data[i];
            if(item.gamekey.toLowerCase() == gamekey.toLowerCase()){

              var res =dataformat(item);
                if( lottery_period!=res.issueNo){
                    lottery_period=res.issueNo;
                    document.querySelector('#lottery_period').innerHTML=lottery_period;
                    clearInterval(timer44);
                    var opencode=res.openCode.split(',');
                    var str='';
                    for(var i=0;i<opencode.length;i++){
                        str+="<span class='ball'>"+opencode[i]+"</span>\n";
                    }
                    $('#lottery_num').html(str);
                    $('#lottery_num').addClass('loading');
                    setTimeout(function () {
                        $('#lottery_num').removeClass('loading');
                    },2000)

                    lottery_time(res.lastsecond);
                    if(showtype=='list') get_plan_list();
                    else {
                        setTimeout(function () {
                            get_plan_detail();
                        },1000)
                    }

                    // console.log(showtype);
                    clearInterval(timer22);
                    clearInterval(timer33);
                    console.log(res);
                }
                break;
            }

        }

    }
  function dataformat(item){
      var data={};
      data.gametype=gametype;
      data.issueNo=item.expect;
      data.openCode=item.number;
      if(item.lasttime>parseInt((new Date()).getTime() / 1000))
          data.lastsecond=item.lastsecond - parseInt((new Date()).getTime() / 1000)
      else
          data.lastsecond=item.lasttime;
      data.predictedTime=timestampToTime(item.time);
      data.SX=24;
      return data;
  }
  function timestampToTime(timestamp) {
      var date = new Date(timestamp * 1000);//时间戳为10位需*1000，时间戳为13位的话不需乘1000
      var Y = date.getFullYear() ;
      var M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1);
      var D = date.getDate();
      var h = date.getHours();
      var m = date.getMinutes();
      var s = date.getSeconds();
      if(D<10) D='0'+D;
      if(h<10) h='0'+h;
      if(m<10) m='0'+m;
      if(s<10) s='0'+s;
      return Y+'-'+M+'-'+D+' '+h+':'+m+':'+s;
  }
</script>