<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>51cp/static/web/css/pk10/header-new.css?v=c167ceaa2357dd0f98caf9a7514f1ea5" type="text/css"/>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>51cp/static/web/css/pk10/history_new.css?v=c167ceaa2357dd0f98caf9a7514f1ea5" type="text/css"/>
<script language="javascript" type="text/javascript" src="<?php echo $HttpPath; ?>static/js/My97DatePicker/WdatePicker.js"></script>
<!--幸运飞艇 header-->
<style>
    body{
        background-color: #e9e9e9;
    }

</style>
<div class="container" style="padding: 10px 0px 0 0px;">
    <div class="xyft-header">
        <ul>
            <li>
                <a href="home_<?php echo $gameinfo['showkey']; ?>.html"><img src="<?php echo $HttpPath; ?><?php echo $gameinfo['logo']; ?>"/></a>
            </li>
        </ul>
        <ul>
            <li><span><?php echo $gameinfo['title']; ?></span><span>
                    第<font class="nowissue"><?php echo $game_number['period']; ?></font>期<a style="margin-left:5px;" class="nowtime"></a> 已开</span></li>
            <li>
                <div  id="opennum" class="<?php echo $openclass; ?>"></div>
            </li>
            <li>
                <span>每日<span id="total-issue"><?php echo $game_time['sum']; ?></span>期 今日已开<a class="reset-issue"><?php echo $game_time['num']; ?></a>期
                    今日剩余<a id="last-issue"><?php echo $game_time['num']; ?></a>期</span></li>
        </ul>
        <ul>
            <li class="nowrap-1"><span>距离<font class="nextissue">--</font>期<a style="margin-left:2px;" class="nexttime"></a>开奖还有</span></li>
            <li>

<div  id="cutdown-sec"  style="display:none">
    <p class="lg-hour" style="display: none">00</p>
    <p class="lg_hour1" style="display: none">:</p>
    <p class="lg-minute">00</p>
    <p>:</p>
    <p class="lg-second">00</p>

    <p class="lg-novoice"></p>

</div>

                <div  id="cutdown-status" style="display: inline-block;width: 100%;text-align: center;height: 40px;line-height: 40px;font-size: 20px;">
                    正在开奖

                </div>

            </li>
        </ul>
        <ul>
            <li><p class="fh fh-ac">开奖直播</p><p>&nbsp;</p></li>
            <li>
                <!--图片尺寸80*80-->
                <a  href="live_<?php echo $gamekey; ?>.html" target="_blank"><?php if($gameinfo['flash_ico']){?><img src="/<?php echo $gameinfo['flash_ico']; ?>" style="height: 80px;" /><?php } else { ?><img src="<?php echo $HttpTemplatePath; ?>51cp/static/web/images/tv.jpg" /><?php }?></a>
            </li>
            <li>
                <!--图片尺寸300*80-->
                <a href="/app" target="_self"><img src="<?php echo $HttpTemplatePath; ?>51cp/static/web/images/pk10-app.jpg" /></a>
            </li>
        </ul>
    </div>
</div>
<!--幸运飞艇 header-->
<div class="container" style="background-color:#ffffff;position: relative;">
    <ul class="lottery-meun-tab fh fh-pj">
        <li class="fh-f4">
            <p>计划推荐</p>
            <p>
                <a id="plan" href="plan_<?php echo $gamekey; ?>.html">免费参考</a>

            </p>
        </li>
        <li class="fh-f4">
            <p>综合</p>
            <p>

                <a id="home" href="home_<?php echo $gamekey; ?>.html">历史开奖</a>
                <?php if($gameinfo['type']!='kl8' && $gameinfo['type']!='pcdd'){?>
                <span>|</span>
                <a style="position: relative;" id="zonghe" href="trend_<?php echo $gamekey; ?>.html">走势图<b style="position: absolute;top:-20px;"><img src="<?php echo $HttpTemplatePath; ?>51cp/static/web/images/newicon.png"></b></a><span>|</span>
                <a id="miss" href="miss_<?php echo $gamekey; ?>.html">遗漏</a><span>|</span>
                <a id="long" href="long_<?php echo $gamekey; ?>.html">长龙</a><span>|</span>
                <a id="lz" href="rball_<?php echo $gamekey; ?>.html">路珠</a><span>|</span>
                <a id="hot" href="hot_<?php echo $gamekey; ?>.html">冷热</a><span>|</span>
                <a id="fx" href="analyze_<?php echo $gamekey; ?>.html">分析</a>
                <?php }?>

               <span>|</span>

                <a id="live" href="live_<?php echo $gamekey; ?>.html" target="_blank">直播</a>
            </p>
        </li>

        <li class="fh-f4">
            <p>其他</p>
            <p>
                <a id="rule" href="rule_<?php echo $gamekey; ?>.html">玩法规则</a>
                <span>|</span>

                <a  href="/app">APP下载</a>
            </p>
        </li>

    </ul>
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

    //window.localStorage.setItem('countfw',JSON.stringify(myObj));
     var arr={};
      arr.<?php echo $gameinfo['showkey']; ?>='<?php echo $gameinfo['title']; ?>';

    for(var ii in gameplay){
      if(ii!='<?php echo $gameinfo['showkey']; ?>') arr[ii]=gameplay[ii];

    }


    window.localStorage.setItem('gameplay',JSON.stringify(arr));


    setTimeout(function () {
        var a= document.getElementById('public_header_tab').querySelectorAll('a');
        for(var i=0;i<a.length;i++){

            if(a[i].href.indexOf('<?php echo $gameinfo['showkey']; ?>')>-1) a[i].style.color='#ff0000';

        }

    },500)


</script>
<script>
    var DataInfo = '{"lottery":"<?php echo $gameinfo['type']; ?>","now":{"code":"<?php echo $gameinfo['showkey']; ?>","expect":"<?php echo $game_number['period']; ?>","opencode":"<?php echo $game_number['number']; ?>","opentime":"<?php echo date('Y-m-d H:i:s',$game_number['lottime']); ?>","codes":<?php echo $opencode; ?>,"timestamp":<?php echo $game_number['lottime']; ?>},"next":{"code":"<?php echo $gameinfo['showkey']; ?>","expect":"<?php echo $nextissue; ?>","opentime":"<?php echo date('Y-m-d H:i:s',$nexttime); ?>","timestamp":<?php echo $nexttime; ?>},"lasttime":<?php echo $lastsecond; ?>,"remain":<?php echo $game_num; ?>,"isopen":<?php echo $isopen; ?>}';
    var myinfo=DataInfo;
    DataInfo = JSON.parse(DataInfo);
</script>

<script type="text/javascript" src="<?php echo $HttpPath; ?>static/web/js/public/public-pk10.js?v=1234"></script>
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