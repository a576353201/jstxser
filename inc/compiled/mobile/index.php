
<?php include_once template("header");?>
<link rel="stylesheet" type="text/css" href="/mobile/static/css/main.css?v=<?php echo $cachekey; ?>" />
<div class="header">
    <div class="logo" >
<img src="/<?php echo $system['mobilelogo']; ?>" />
    </div>

    <div class="navright" onclick="show_addnav();" style="top:10px;">
        <i class="icon-plus-1" style="font-size: 28px"></i>
    </div>
    <div class="nav" style="left: 35%;width: 45%;" id="header_nav">
        <div class="item active" onclick="hide_trend();">开奖</div>
        <div class="item" onclick="show_trend();">走势</div>
        <div class="item" onclick="location.href='/plan/index.php?id='+gameid;" style="border-left:1px #2319dc solid;">计划</div>
    </div>

    <div class="title" id="header_title" style="display: none;padding-left: 30px;">


    </div>

</div>


<div class="addnav"  id="addnav_0">
    <?php if($user['isvip']==1){?>
    <li  onclick="plan_add();"><i class="icon-plus-circle"></i>发布计划</li>
    <?php } else { ?>
    <li class="button" onclick="plan_apply();">  <i class="icon-chart"></i>申请计划员</li>
    <?php }?>
    <li onclick="group_create();"><i class="icon-user-add"></i>创建群聊</li>
    <li onclick="if(userid>0)location.href='/user/recharge.php';else  showlogin();"><i class="icon-coin-of-dollar"></i>我要充值</li>
    <li onclick="if(userid>0)location.href='/user/plat.php';else  showlogin();"><i class="icon-cash"></i>我要提现</li>
</div>

<div class="looterytop">
    <div class="title" onclick="show_gamenav1();"> <span id="gamename"><?php echo $gamelist[0]['title']; ?></span><i id="gameicon" class="icon-down-open"></i></div>
    <div class="time"><i class="icon-clock" ></i><span id="lottery_time">00:00</span></div>
</div>
<div class="gamenav">
    <?php if(is_array($game_type_arr)){foreach($game_type_arr AS $key=>$value) { ?>
    <?php if(count($gamenav[$key])){?>
    <ul>
        <li><?php echo $value; ?></li>

        <li>
            <?php if(is_array($gamenav[$key])){foreach($gamenav[$key] AS $key1=>$value1) { ?>
        <a onclick="change_game(<?php echo $value1['id']; ?>)"><?php echo $value1['title']; ?></a>
            <?php }}?>
        </li>
    </ul>

    <?php }?>


    <?php }}?>

</div>

<div class="change_game left" onclick="gamenext(-1);"><i class="icon-left-open-1"></i></div>
<div class="change_game right" onclick="gamenext(1);"><i class="icon-right-open-1"></i></div>
<div id="menu_frm" class="menu_ifm" >

    <div class="ifmbox">

        <iframe  id="trend_ifr" src="mobile/trend.php?id=<?php echo $gamelist[0]['id']; ?>" scrolling="yes" style="display: block; overflow: scroll;"></iframe>



    </div>

</div>
<div class="contentbg">
    <div class="lotterybox">
        <?php if(is_array($gamelist)){foreach($gamelist AS $key=>$value) { ?>
        <div class="lotterybg">

            <div class="lotterylist" id="lottery_<?php echo $value['id']; ?>">

            </div>
            <div class="next_tips" id="tips_<?php echo $value['id']; ?>">
                <div class="tips">亲爱的，到底了！</div>
                <img src="mobile/static/img/loading.gif">
            </div>

        </div>

        <?php }}?>


    </div>


</div>
<script>
    var gameid='<?php echo $gameid1; ?>';
    var game_id=gameid;
    var gamedata=JSON.parse('<?php echo $gamejson; ?>');
     var shownode=<?php echo $shownode; ?>;
    var page=1;
    getloattey(gameid);
    change_game(gameid);
    <?php if($_GET['type']=='trend'){?>
    show_trend();

    <?php }?>

    <?php if(is_array($gamelist)){foreach($gamelist AS $key=>$value) { ?>
    listen_scroll(<?php echo $value['id']; ?>);
    <?php }}?>
    var timer=   setInterval(function () {
        getlotteyupdate(gameid);
    },3000)
    var menuid=0;

    getdata();
if(shownode==1)
shownote();
</script>
<?php include_once template("footer");?>