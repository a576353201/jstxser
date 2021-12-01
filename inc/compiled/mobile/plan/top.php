<div class="gameinfo">

<ul>

    <li  onclick="show_gamenav1();">
        <span id="gamename"><?php echo $game['title']; ?></span><i id="gameicon" class="icon-down-open"></i>
    </li>

    <li>

        距下期还剩        <span class="clock">
            <span class="num">0</span><span class="num">0</span><span class="exp">:</span><span class="num">0</span><span class="num">0</span>
        </span>

    </li>
</ul>

    <ul  onclick="show_history();">

        <li>
            第<div style="display: inline-block;color:#2319dc !important;;" id="lottery_period"><?php echo $lottery['period']; ?></div>期

            <span id="history_tab" >历史</span>
        </li>

            <li id="lottery_num">
                <?php if(is_array($number)){foreach($number AS $index=>$value) { ?>
                <span class="ball"><?php echo $value; ?></span>
                <?php }}?>
            </li>
    </ul>


    <div style="width: 80px;padding-right: 15px;display: none">
        <?php if($showtype=='detail'){?>


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
<div class="gamenav">
    <?php if(is_array($game_type_arr)){foreach($game_type_arr AS $key=>$value) { ?>
    <?php if(count($gamenav[$key])){?>
    <ul>
        <li><?php echo $value; ?></li>

        <li>
            <?php if(is_array($gamenav[$key])){foreach($gamenav[$key] AS $key1=>$value1) { ?>
            <a href="index.php?id=<?php echo $value1['id']; ?>" <?php if($game['id']==$value1['id']){?>class='active'<?php }?>><?php echo $value1['title']; ?></a>
            <?php }}?>
        </li>
    </ul>

    <?php }?>


    <?php }}?>
</div>
<div class="expect_bg">
    <div id="history_bg">
        <?php if(is_array($lotterylist)){foreach($lotterylist AS $index=>$value) { ?>
        <ul>
            <li>
                第<div style="display: inline-block;color:#2319dc !important;;"><?php echo $value['period']; ?></div>期
            </li>
            <li >
                <?php if(is_array(explode(',',$value['number']))){foreach(explode(',',$value['number']) AS $index1=>$value1) { ?>
                <span class="ball"><?php echo $value1; ?></span>
                <?php }}?>
            </li>
        </ul>
        <?php }}?>


    </div>

    <div class="btns">
        <span onclick="location.href='/mobile.php?id=<?php echo $id; ?>';"><i class="icon-history"></i>更多开奖</span>
        <span  onclick="location.href='/mobile.php?type=trend&id=<?php echo $id; ?>';"><i class="icon-chart"></i>开奖走势</span>
    </div>
</div>
<script>
    var game_id=<?php echo $game['id']; ?>;
    var lottery_period='<?php echo $lottery['period']; ?>';

    setTimeout(function () {
        $('#lottery_period').html(lottery_period);
    },500)

    lottery_time(<?php echo $period['lastsecond']; ?>);
    var page=1;
    var userid=parseInt(<?php echo $_SESSION['userid']; ?>);

    function show_history() {
         if(document.querySelector('.expect_bg').className.indexOf('active')>-1){
             $('.expect_bg').removeClass('active');
             $("#history_tab").html("历史");
         }
         else{
             $('.expect_bg').addClass('active');
             $("#history_tab").html("收起");
         }

    }
</script>



<script>




    var ismobile=1;
</script>