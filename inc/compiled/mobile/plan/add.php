<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/plan_layer.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />
<script src="/static/js/plan_mobile.js?v=<?php echo $cachekey; ?>"></script>
<style>
    body{

        overflow-y: scroll;
        display: inline-block;
    }
    body::-webkit-scrollbar{
        display: none;
    }
</style>

<div class="header" style="padding: 5px 0px;">
    <span class="back" onclick="history.back();" style="top:5px;"><i class="icon-left-open-3"></i></span>

    <ul class="nav1" style="width: 80%;left: 13%;top:5px;position: absolute">
        <li class="" onclick="change_tab(0);">追号模式</li>
        <li class="" onclick="change_tab(1);">智能模式</li>
        <li class="active" onclick="change_tab(2);">普通模式</li>
        <li class="" onclick="change_tab(3);">自定义模式</li>
    </ul>

</div>


<ul class="addline" style="margin-top: 40px;">
    <li>选择彩种：</li>
    <li>
    <select id="gamekey" onchange="change_game(this.value);" style="width: 100px">
        <?php if(is_array($gamelist)){foreach($gamelist AS $index=>$value) { ?>
     <option value="<?php echo $value['showkey']; ?>" <?php if($game['id']==$value['id']){?>selected<?php }?>><?php echo $value['title']; ?></option>
    <?php }}?>

    </select>
        (<span id="open_time" style="color: #2319dc;"><?php echo $period['end']; ?></span>开奖)
    </li>
</ul>
<ul class="addline" >
    <li>起始期号：</li>
    <li>
       <select id="period" style="width: 130px">
            <?php if(is_array($qi_arr)){foreach($qi_arr AS $index=>$value) { ?>
               <?php if($index<20){?>
            <option value="<?php echo $value; ?>" ><?php echo $value; ?></option>
              <?php }?>
            <?php }}?>
        </select>


      <span style="padding-left: 10px;" id="period_max">
          共：
          <select id="period_num" style="width: 70px" onchange="change_period(this.value);">
          <?php if(is_array($plan_num)){foreach($plan_num AS $index=>$value) { ?>
            <option value="<?php echo $value; ?>" <?php if($value==10){?>selected<?php }?> ><?php echo $value; ?>期</option>
          <?php }}?>
        </select>


    </li>
</ul>
<ul class="addline" id="expect_box">
    <li>连跟期数：</li>
    <li>
        <select id="expect_num" style="width: 70px" onchange="change_expect_num(this.value);">
        </select>
            （不中奖最高跟号期数）
    </li>
</ul>
<ul class="addline">
    <li>付费查看：</li>
    <li>
        <label class="switch">
            <input type="checkbox" id="payopen" onclick="set_paymoney(this.checked);">
            <div class="slider round"></div>
        </label>

        <span class="money" id="paymoney">0</span>


        <span style="margin-left: 30px;">

            高级玩法：
        </span>
        <label class="switch">
            <input type="checkbox" id="diywf" onclick="diywf(this.checked);">
            <div class="slider round"></div>
        </label>

    </li>
</ul>

<ul class="addline">
    <li>选择玩法：</li>
    <li>
   <select id="wanfa" style="width:80px" onchange="change_wf(this.value);" >
       <?php if(is_array($wanfa_arr[$game['type']])){foreach($wanfa_arr[$game['type']] AS $index=>$value) { ?>
      <option value="<?php echo $index; ?>"><?php echo $value; ?></option>
       <?php }}?>
   </select>


        <select id="wanfa1" style="display: none;width: 70px" onchange="set_playhtml(wf1,this.value);">

        </select>
        <span id="trend_type">
            <input type="checkbox" name="number_trend" value="loss" checked onclick="return click_trend(0);" >遗漏
        &nbsp;
        <input type="checkbox" name="number_trend" value="hot" onclick="return click_trend(1);">冷热<i class="icon-help-circled" style="cursor: pointer;font-size: 18px;color: #2319dc;"
           onclick="layer.tips('遗漏：表示该号码从上次开出至今有多少期未出现<br>冷热：表示在最近100期该号码在这个位置上出现的次数', '.icon-help-circled', {tips:[3,'rgba(0,0,0,0.8)']});"></i>

        </span>

    </li>
</ul>
<ul class="addline" id="method_20" style="display: none">
    <li>出号方式：</li>
    <li>
        <select id="number_type"  >
            <option value="1">出某杀某</option>
            <option value="2">杀最冷</option>
            <option value="3">杀最热</option>
            <option value="4">杀最大遗漏</option>
            <option value="0">随机</option>
        </select>
    </li>
</ul>
<ul class="addline" id="method_21" style="display: none">
    <li>购买注数：</li>
    <li>
        <select id="buynum">
            <?php for($i=1;$i<=7;$i++){ ?>
            <option value="<?php echo $i; ?>" <?php if($i==5){?>selected<?php }?>><?php echo $i; ?>注</option>

            <?php } ?>

        </select>
    </li>
</ul>

<div class="play_html">


</div>

<div class="add_area">


    <div class="count">
        已选<span class="num" id="plan_num">0</span>注
    </div>
    <div id="btn_add" class="btn" onclick="addbox();"><i class="icon-plus"></i><span>添加到方案</span></div>
    <div id="btn_public" class="btn public" style="display: none;" onclick="click_public();"><i class="icon-ok"></i>发布</div>
    <div class="count" style="margin-left: 10px;">
        共<span class="num" id="content_num">0</span>套方案
    </div>
</div>

<div class="area_box" style="display: none">
    <ul>
        <li id="fnname">方案</li>  <li>玩法</li> <li>内容</li>   <li>注数</li> <li>操作</li>
    </ul>

</div>
<div style="height: 60px;">


</div>

<div class="plan_bottom">
    <div class="tips">
     每个方案最高连跟<span class="num" id="tips_num"></span>期，中奖后自动切换到下一方案

    </div>
    <div style="height: 40px;line-height: 40px;">
        <div class="btns clear" onclick="destroy_box();"><i class="icon-trash"></i>清空</div>
        <div class="btns ok" onclick="click_public();"><i class="icon-ok"></i>发布</div>


    </div>


</div>

<script>
    var game_id=<?php echo $game['id']; ?>;
    var update_type='add';
    var plan_status=0;
    var lasttime=parseInt('<?php echo $period['lastsecond']; ?>');
    var lottery_period='<?php echo $period['period']; ?>';
    listen_period();
    var wanfa_json=JSON.parse('<?php echo json_encode($wanfa_arr1); ?>');
    var wf1=document.querySelector('#wanfa').value;
    var wf2='';
    var paymoney=0;
    var plan_num=0;
    var lottery_list=JSON.parse('<?php echo $lottery; ?>');
    var buynum=0;
    var method=2;
    var period_arr=JSON.parse('<?php echo json_encode($qi_arr); ?>');
    var number_trend='loss';
    var addmax=parseInt(<?php echo $addmax; ?>);
    var grade_name='<?php echo $gradename; ?>';
    var admin_logo='/<?php echo $system['admin_logo']; ?>';
    var admin_nickname='<?php echo $system['admin_nickname']; ?>';
    change_tab(method);
    change_wf(wf1);
window.onload=function () {
    set_expect_num(3,3);
//    var index = parent.layer.getFrameIndex(window.name);
//    parent.layer.iframeAuto(index);
}
</script>