<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/plan_layer.css?v=<?php echo time(); ?>" type="text/css" media="screen" />
<script src="/static/js/plan_mobile.js?v=<?php echo time(); ?>"></script>
<style>
    body{
        max-height: 600px !important;
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
        <li class="">追号模式</li>
        <li class="" >智能模式</li>
        <li class="active">普通模式</li>
        <li class="" >自定义模式</li>
    </ul>

</div>

<ul class="addline" style="margin-top: 50px;">
    <li>选择彩种：</li>
    <li>
        <select id="gamekey" onchange="change_game(this.value);" disabled="disabled"  style="width: 100px">
            <?php if(is_array($gamelist)){foreach($gamelist AS $index=>$value) { ?>
            <option value="<?php echo $value['showkey']; ?>" <?php if($game['id']==$value['id']){?>selected<?php }?>><?php echo $value['title']; ?></option>
            <?php }}?>

        </select>
        (<span id="open_time" style="color: #2319dc;"><?php echo $period['end']; ?></span>开奖)
    </li>
</ul>
<ul class="addline" id="period_line">
    <li id="period_name">起始期号：</li>
    <li>
        <select id="period" style="width: 130px">
            <?php if(is_array($qi_arr)){foreach($qi_arr AS $index=>$value) { ?>
            <?php if($index<20){?>
            <option value="<?php echo $value; ?>" ><?php echo $value; ?></option>
            <?php }?>
            <?php }}?>
        </select>


        <span id="period_max">
          <span id="period_name1">共：</span>
          <select id="period_num" style="width: 70px" onchange="change_period(this.value);">
          <?php if(is_array($plan_num)){foreach($plan_num AS $index=>$value) { ?>
            <option value="<?php echo $value; ?>" <?php if($value==10){?>selected<?php }?> ><?php echo $value; ?>期</option>
              <?php }}?>
        </select>

      </span>
        <div id="period_tips" style="height: 20px;line-height: 20px;color: #666;"></div>

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
            <input type="checkbox" id="payopen" onclick="set_paymoney(this.checked);"  <?php if($plan['money']>0){?>checked<?php }?>>
            <div class="slider round"></div>
        </label>

        <span class="money" id="paymoney" <?php if($plan['money']>0){?>style='display:inline-block';<?php }?>><?php echo $plan['money']; ?></span>
    </li>
</ul>

<ul class="addline">
    <li>选择玩法：</li>
    <li>
        <select id="wanfa" onchange="change_wf(this.value);"  style="width: 80px" >
            <?php if(is_array($wanfa_arr[$game['type']])){foreach($wanfa_arr[$game['type']] AS $index=>$value) { ?>
            <option value="<?php echo $index; ?>" <?php if($index==$plan['wf1']){?>selected<?php }?>><?php echo $value; ?></option>
            <?php }}?>
        </select>


        <select id="wanfa1" style="display: none;width: 70px;" onchange="set_playhtml(wf1,this.value);">

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
    <div id="btn_public" class="btn public" style="display: none;" onclick="click_update();"><i class="icon-ok"></i>确认更新</div>
    <div class="count" style="margin-left: 10px;">
        共<span class="num" id="content_num">0</span>套方案
       <span id="content_tips"></span>

    </div>
</div>

<div class="area_box">
    <ul>
        <li id="fnname">方案</li>  <li>玩法</li> <li>内容</li>   <li>注数</li> <li>操作</li>
    </ul>

</div>

<div class="plan_bottom">
    <div class="tips">
        每个方案最高连跟<span class="num" id="tips_num"></span>期，中奖后自动切换到下一方案

    </div>
    <div style="height: 40px;line-height: 40px;">
    <div class="btns ok" onclick="click_update();" ><i class="icon-ok"></i>确认更新</div>
    <div class="btns clear" onclick="destroy_box();" id="clear_btn"><i class="icon-trash"></i>清空</div>
    </div>
</div>

<script>
    var game_id=<?php echo $game['id']; ?>;
    var plan_id=<?php echo $plan['id']; ?>;
    var update_type='edit';
    var plan_status=parseInt('<?php echo $plan['status']; ?>');
    var lasttime=parseInt('<?php echo $period['lastsecond']; ?>');
    var lottery_period='<?php echo $period['period']; ?>';
    listen_period();
    var wanfa_json=JSON.parse('<?php echo json_encode($wanfa_arr1); ?>');
    var wanfa1_json=JSON.parse('<?php echo json_encode($wanfa_arr[$game['type']]); ?>');
    var wf1='<?php echo $plan['wf1']; ?>';
    var wf2='<?php echo $plan['wf2']; ?>';
    var paymoney='<?php echo $plan['money']; ?>';
    var plan_num=0;
    var lottery_list=JSON.parse('<?php echo $lottery; ?>');
    var buynum=0;

    var method=parseInt('<?php echo $plan['method']; ?>');
    var period_arr=JSON.parse('<?php echo json_encode($qi_arr); ?>');
    var number_trend='loss';
    var planinfo=<?php echo json_encode($plan); ?>;
    var addmax=parseInt(<?php echo $addmax; ?>);
    var grade_name='<?php echo $gradename; ?>';
    change_tab(method);
    change_wf(wf1);

    //set_playhtml(wf1,wf2);
    window.onload=function () {

        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.iframeAuto(index);
        selected('expect_num',<?php echo $plan['expect_num']; ?>);

     if(method==1){
            selected('number_type','<?php echo $plan['number_type']; ?>');
            selected('buynum','<?php echo $plan['buynum']; ?>');
            $('#buynum').attr('disabled','distabled');
    }
        set_plan_edidstatus();
        set_plan_content();

    }
    //var plantimes=<?php echo $plan.plantimes; ?>;
   // var plan_content=JSON.parse('<?php echo $plan.content; ?>');


</script>