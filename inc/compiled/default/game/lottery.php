<?php include_once template("header");?>

<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>51cp/static/web/css/public/lottery.css?v=c167ceaa2357dd0f98caf9a7514f1ea5"
      type="text/css"/>
<div class="bodybox ">





<div class="middbox1" id="toRMC">
    <div class="leftmenu">
        <ul>
            <?php if(is_array($game_type_list)){foreach($game_type_list AS $index=>$value) { ?>
            <li <?php if($index=='hot'){?>class="lisesected"<?php }?> onclick="set_menu(this);">
                <a href="#to<?php echo $index; ?>"  class="atoRMC"><?php echo $value; ?></a><i></i></li>
            <?php }}?>

        </ul>
    </div>

</div>
<?php if(is_array($game_type_list)){foreach($game_type_list AS $index=>$value) { ?>
    <div class="middbox" id="to<?php echo $index; ?>">
    <div class="title">
        <dl>
            <dt><?php echo $value; ?><!--<span> 共87个彩种</span>--></dt>
            <?php if($index=='hot'){?>
            <dd>
                <a href="javascript:show_all();" class="showallbtn">显示全部</a>
            </dd>
            <?php }?>
        </dl>
    </div>
    <div class="tablehead">
        <ul>
            <li class="head" style="background: rgb(229, 229, 229);">
                <span class="cz">彩种</span>
                <span class="kjhm">开奖号码</span>
                <span class="kjsj">开奖时间</span>
                <span class="czlast">操作</span>
            </li>
        </ul>

        <ul class="lg-index-lottery-ul" id="open-<?php echo $index; ?>">



</ul>
    </div>
</div>
<?php }}?>


</div>





<script>
    var
    pjaxClick = 0,
        homeTimer = {},
        lowTimer = {},
        tab = 1;
    function  get_IndexList(type) {
    $.get("LotteryList_"+type+".html",{},function(result){
        document.querySelector('#open-'+type).innerHTML=result;
        set_opentime(); gamelist_show();
    });
    }


function  set_menu(div) {
  var li=  document.querySelector('.leftmenu').querySelectorAll('li');
  for(var i=0;i<li.length;i++){
      li[i].className='';
  }
  div.className='lisesected';
}
var game_hide=new Array();
    function hide_game(type,gamekey) {
        game_hide[game_hide.length]=type+'_'+gamekey;
        gamelist_show();
    }
    function show_all() {
        game_hide=new Array();
        gamelist_show();
    }
    function gamelist_show() {
       var div= document.querySelectorAll('.lg-index-lottery-div');
       for(var i=0;i<div.length;i++){
           var id=div[i].id;
           if(game_hide.indexOf(id)>-1) div[i].style.display='none';
           else  div[i].style.display='';
       }
    }

    function set_opentime() {

        var li=document.querySelectorAll('.lg-index-lottery-div');

        for(var i=0;i<li.length;i++){
            var gamekey=li[i].querySelector('#gamekey').value;
            var period=document.querySelector('#period_'+gamekey).value;
            var pre_period=document.querySelector('#pre_period_'+gamekey).value;

            var now_period=document.querySelector('#now_period_'+gamekey).innerHTML;
            //等待开奖
            if(pre_period!=now_period){
                li[i].querySelector('.index-waiting-over').style.display='none';
                li[i].querySelector('.index-waiting-open').style.display='inline-block';
                ajax_get_gamedata(gamekey);
            }
            else{
                //倒计时
                li[i].querySelector('.index-waiting-over').style.display='inline-block';
                li[i].querySelector('.index-waiting-open').style.display='none';
                timer_cutdown(gamekey);
            }



        }
    }

    function ajax_get_gamedata(gamekey) {
        clearInterval(lowTimer[gamekey]);
        lowTimer[gamekey]=  setInterval(function () {
            $.post("/ajax/game.php",{action:'number',gamekey:gamekey},function(result){
                var  gk=result.gamekey;

                document.getElementById('period_'+gk).value=result.period;
                document.getElementById('pre_period_'+gk).value=result.pre_period;
                document.getElementById('lastsecond_'+gk).value=result.lastsecond;
                document.querySelector('#now_period_'+gk).innerHTML=result.lastnumber.period;

                if(result.lastnumber.period==result.pre_period){
                    clearInterval(lowTimer[gamekey]);
                    document.querySelector('#now_lottime_'+gk).innerHTML=result.begin.toString().substr(0,5);
                    var nexttime=document.querySelectorAll('#nexttime_'+gk);
                    for(var i=0;i<nexttime.length;i++){
                        nexttime[i].innerHTML=" 距<span style=\"color: #f1010a;\">"+result.period.toString()+"</span>期 开奖时间";

                    }


                    var box=document.querySelectorAll('#'+gamekey+'_box');
                    for(var i=0;i<box.length;i++){
                        box[i].querySelector('.index-waiting-over').style.display='inline-block';
                        box[i].querySelector('.index-waiting-open').style.display='none';
                    }

                    timer_cutdown(gk);
                }
                else{
                    var nexttime=document.querySelectorAll('#nexttime_'+gk);
                    for(var i=0;i<nexttime.length;i++){
                        nexttime[i].innerHTML=" 第<span style=\"color: #f1010a;\">"+result.pre_period.toString()+"</span>期 等待开奖";

                    }

                }
                //  console.log(gk,result.lastnumber.period);

            },'json');
        },2000)

    }

    function timer_cutdown(gamekey) {
        clearInterval(lowTimer[gamekey]);
        var lastsecond= parseInt(document.getElementById('lastsecond_'+gamekey).value);
        document.getElementById(gamekey+'_box').querySelector('.index-waiting-over').innerHTML=show_timer(lastsecond);
        lowTimer[gamekey]=  setInterval(function () {
            lastsecond--;
            if(lastsecond>0){
                document.getElementById('lastsecond_'+gamekey).value=lastsecond;
                var box=document.querySelectorAll('#'+gamekey+'_box');
                for(var i=0;i<box.length;i++){
                    box[i].querySelector('.index-waiting-over').innerHTML=show_timer(lastsecond);

                }

            }
            else{
                clearInterval(lowTimer[gamekey]);
                var box=document.querySelectorAll('#'+gamekey+'_box');
                for(var i=0;i<box.length;i++){
                    box[i].querySelector('.index-waiting-over').style.display='none';
                    box[i].querySelector('.index-waiting-open').style.display='inline-block';
                }

                ajax_get_gamedata(gamekey);
            }

        },1000)


    }
    function show_timer(lost_s) {
        var l_s=Math.floor(lost_s%60);
        var next_s=Math.floor(lost_s/60);
        var l_m=Math.floor(next_s%60);
        var next_m=Math.floor(next_s/60);
        var l_h=Math.floor(next_m%60);
        if(l_h-10<0){n_h="0"+(l_h);}else{n_h=(l_h);}
        if(l_m-10<0){n_m="0"+(l_m);}else{n_m=(l_m);}
        if(l_s-10<0){n_s="0"+(l_s);}else{n_s=(l_s);}

        var str='<b class="hour-box">'+n_h+'</b>:<b class="minute-box">'+n_m+'</b>:<b class="second-box">'+n_s+'</b>';
        return str;
    }

    <?php if(is_array($game_type_list)){foreach($game_type_list AS $index=>$value) { ?>


    get_IndexList('<?php echo $index; ?>');
    <?php }}?>

</script>






<?php include_once template("footer");?>