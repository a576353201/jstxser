<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>51cp/static/web/css/pk10/header-new.css?v=c167ceaa2357dd0f98caf9a7514f1ea5" type="text/css"/>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>51cp/static/web/css/pk10/history_new.css?v=c167ceaa2357dd0f98caf9a7514f1ea5" type="text/css"/>
<script language="javascript" type="text/javascript" src="<?php echo $HttpPath; ?>static/js/My97DatePicker/WdatePicker.js"></script>
<!--幸运飞艇 header-->

<div class="kj-nav fh"><ul class="fh-f1">
    <a id="home" href="home_<?php echo $gamekey; ?>.html">开奖</a>
    <a id="live" href="live_<?php echo $gamekey; ?>.html">直播</a>
    <?php if($gameinfo['type']!='kl8' && $gameinfo['type']!='pcdd'){?>

    <a style="position: relative;" id="zonghe" href="trend_<?php echo $gamekey; ?>.html">走势</a>
    <a id="miss" href="miss_<?php echo $gamekey; ?>.html">遗漏</a>
    <a id="long" href="long_<?php echo $gamekey; ?>.html">长龙</a>
    <a id="lz" href="rball_<?php echo $gamekey; ?>.html">路珠</a>
    <a id="hot" href="hot_<?php echo $gamekey; ?>.html">冷热</a>
    <a id="fx" href="analyze_<?php echo $gamekey; ?>.html">分析</a>
    <?php }?>
    <a id="plan" href="plan_<?php echo $gamekey; ?>.html">参考</a>


    <a id="rule" href="rule_<?php echo $gamekey; ?>.html">规则</a>
    <a  href="/app">APP下载</a>
</ul>
</div>




<div class="container xyft-header" style="padding: 10px 0px 0 0px;">


    <div class="kj-openinfo">
        <ul >
            <li class="fh"><span class="fh-f2"><font class="nextissue">--</font>期<a style="margin-left:2px;" class="nexttime"></a>剩余
                <b class="timer-box">


                    <div  id="cutdown-sec"  style="display:none">
       <span class="lg-minute">--</span>
                <span>:</span>
                <span class="lg-second">--</span>

</div>

                <div  id="cutdown-status" style="display: inline-block;width: 100%;text-align: center;">
                    正在开奖

                </div>

                <p class="lg-novoice" style="display: none"></p>

                </b></span>
                <span class="fh-f2">
                     <span id="total-issue" style="display: none"><?php echo $game_time['sum']; ?></span>
                    今日已开<a class="reset-issue" style="color:#35a4f0;"><?php echo $game_time['num']; ?></a>期
                    剩余<a id="last-issue" style="color:#35a4f0;"></a>期</span></li></ul>
        <ul class="fh"><li><font class="nowissue"><?php echo $game_number['period']; ?></font>期<a style="margin-left:5px;" class="nowtime"></a></li>
            <li class="fh fh-f1 fh-ac public-num">
                <span  id="opennum" class="<?php echo $openclass; ?>"></span></li></ul></div>

<!--幸运飞艇 header-->
<div class="container" style="background-color:#ffffff;position: relative;display: none">

    <div style="position: absolute;bottom: -33px;right:0px;color: #000000;font-size:16px;">
        <div class="lg-open-over">
            <span class="lg-waiting" style="margin-right:30px;display: none;"><a style="text-decoration: none;color: #ff0000;margin: 0 2px;" class="nextissue">--</a>期正在更新中,请稍后......</span>
            <span class="lg-over">数据更新至:<a style="text-decoration: none;color: #ff0000;margin: 0 2px;" class="nowissue">--</a>期</span>
        </div>
        <div class="lg-open-waiting" style="display: none;">
            <span class="lg-waiting" style="margin-right:30px;display: none;"><a style="text-decoration: none;color: #ff0000;margin: 0 2px;" class="nowissue">--</a>期正在更新中,请稍后......</span>
            <span class="lg-over">数据更新至:<a style="text-decoration: none;color: #ff0000;margin: 0 2px;" class="nowissue-info">--</a>期</span>
        </div>
    </div>
</div>
<script>
    var url = window.location.href;
    if(url.indexOf('gain')> -1){
        $("#gain").addClass('active');
    }else if(url.indexOf('snowball') > -1){
        $("#snowball").addClass('active');
    }else if(url.indexOf('follow-') > -1){
        $("#follow").addClass('active');
    }else if(url.indexOf('single') > -1){
        $("#single").addClass('active');
    }else if(url.indexOf('hot') > -1){
        $("#hot").addClass('active');
    }else if(url.indexOf('skill') > -1){
        $("#skill").addClass('active');
    }else if(url.indexOf('index/from/1/type/0') > -1){
        $("#zonghe").addClass('active');
    }else if(url.indexOf('index/from/1/type/1') > -1){
        $("#wz").addClass('active');
    }else if(url.indexOf('index/from/1/type/21') > -1){
        $("#gyh").addClass('active');
    }else if(url.indexOf('index/from/1/type/22') > -1){
        $("#lh").addClass('active');
    }else if(url.indexOf('miss') > -1){
        $("#miss").addClass('active');
    }else if(url.indexOf('follow') > -1){
        $("#followa").addClass('active');
    }else if(url.indexOf('shrink') > -1){
        $("#shrink").addClass('active');
    }else if(url.indexOf('history') > - 1){
        $("#history").addClass('active');
    }else if(url.indexOf('rule') > -1){
        $("#rule").addClass('active');
    }else if(url.indexOf('long') > - 1){
        $("#long").addClass('active');
    }else if(url.indexOf('analyze') > - 1){
        $("#fx").addClass('active');
    }else if(url.indexOf('rball') > - 1){
        $("#lz").addClass('active');
    }else if(url.indexOf('home') > - 1){
        $("#home").addClass('active');
    }else if(url.indexOf('live') > - 1){
        $("#live").addClass('active');
    }else if(url.indexOf('trend') > - 1){
        $("#zonghe").addClass('active');
    }
    else if(url.indexOf('plan') > - 1){
        $("#plan").addClass('active');
    }

</script>
<script>
    var DataInfo = '{"lottery":"<?php echo $gameinfo['type']; ?>","now":{"code":"<?php echo $gameinfo['showkey']; ?>","expect":"<?php echo $game_number['period']; ?>","opencode":"<?php echo $game_number['number']; ?>","opentime":"<?php echo date('Y-m-d H:i:s',$game_number['lottime']); ?>","codes":<?php echo $opencode; ?>,"timestamp":<?php echo $game_number['lottime']; ?>},"next":{"code":"<?php echo $gameinfo['showkey']; ?>","expect":"<?php echo $nextissue; ?>","opentime":"<?php echo date('Y-m-d H:i:s',$nexttime); ?>","timestamp":<?php echo $nexttime; ?>},"lasttime":<?php echo $lastsecond; ?>,"remain":<?php echo $game_num; ?>,"isopen":<?php echo $isopen; ?>}';
    var myinfo=DataInfo;
    DataInfo = JSON.parse(DataInfo);
</script>

<script type="text/javascript" src="<?php echo $HttpPath; ?>static/web/js/public/public-pk10.js?v=1111"></script>
<script>
    var  game_type='<?php echo $gameinfo['type']; ?>';
    var nowdate = utils.format((new Date()).getTime(),'yyyy-MM-dd');
    var myperiod = '';
    var istoday='<?php echo $istoday; ?>';
    $("#date-date").val(nowdate);



    //请求是否开奖 刷新也页面
    myinfoData = JSON.parse(myinfo);
    timer_cutdown();

    pk10issue(myinfoData);
    </script>