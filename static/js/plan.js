function click_gameplan(id,type) {
    if(type=='ssc' || type=='ffc' || type=='11x5'){
        location.href="?id="+id;
    }else{
        layer.msg("正在研发中，敬请期待！",{ type: 1, anim: 2 ,time:1000});
    }

}
var lastsecond=0;
var lotteryTime=null;
function lottery_time(time) {
    if(time>0){
        lastsecond=time;
        time_step();
        clearInterval(lotteryTime);
        lotteryTime=setInterval(function () {
            time_step();
        },1000)

    }else{
        clearInterval(lotteryTime);
        get_lottery_number();

    }

}
function randomNum(minNum, maxNum) {
    switch (arguments.length) {
        case 1:
            return parseInt(Math.random() * minNum + 1, 10);
            break;
        case 2:
            return parseInt(Math.random() * ( maxNum - minNum + 1 ) + minNum, 10);
            //或者 Math.floor(Math.random()*( maxNum - minNum + 1 ) + minNum );
            break;
        default:
            return 0;
            break;
    }
}
function time_step() {
    var   lost_s=lastsecond;
    if(lost_s<0){

        clearInterval(lotteryTime);
        get_lottery_number();

    }else{
        lastsecond--;
        var l_s=Math.floor(lost_s%60);
        var next_s=Math.floor(lost_s/60);
        var l_m=Math.floor(next_s%60);
        var next_m=Math.floor(next_s/60);
        var l_h=Math.floor(next_m%60);
        if(l_h-10<0){var n_h="0"+l_h;}else{var n_h=l_h;}
        if(l_m-10<0){var n_m="0"+l_m;}else{var n_m=l_m;}
        if(l_s-10<0){var n_s="0"+l_s;}else{var n_s=l_s;}
        var str="";
        if(n_h!='00') {
            str+='<span class="num">'+n_h.toString().substr(0,1)+'</span><span class="num">'+n_h.toString().substr(1,1)+'</span><span class="exp">:</span>';
        }
        str+='<span class="num">'+n_m.toString().substr(0,1)+'</span><span class="num">'+n_m.toString().substr(1,1)+'</span><span class="exp">:</span>';
        str+='<span class="num">'+n_s.toString().substr(0,1)+'</span><span class="num">'+n_s.toString().substr(1,1)+'</span>';
        document.querySelector('.clock').innerHTML=str;

    }
}
var timer22=null;
var timer33=null;
var timer44=null;
var num1=0;
function get_lottery_number() {

    timer33=setInterval(function () {
        var dian='';
        for(var i=0;i<num1;i++){
            dian+='.';
        }
       num1++;
       if(num1>3)num1=0;

        document.querySelector('.clock').innerHTML="<div class='loading'>开奖中"+dian+"</div>";
    },500)

    timer44=setInterval(function () {
      var ball= document.querySelector('#lottery_num').querySelectorAll('.ball');
      for(var i=0;i<ball.length;i++){
          ball[i].innerHTML=randomNum(0,9);
      }
    },30)

    get_new_lot();
    clearInterval(timer22);
    timer22=setInterval(function () {
        get_new_lot();
    },3000)

}

function get_new_lot() {
    $.get("../api/index.php?act=lotterylist",{lotteryId:game_id,current:1,pageSize:1}, function(result){
        result=JSON.parse(result);
        if(result.data.records.length>0){
            var res=result.data.records[0];
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
            }
        }
    });
}

function plan_add() {
    if(parent.userid>0){

        if(parent.check_userlock()==false) return false;

        if(lastaddnum>0){

            var tips="<div style='text-align: center'>"+addtips+"<br>是否继续发布计划？</div>";
            var index=  layer.confirm(tips, {
                title:'发布提示',
                time: 20000, //20s后自动关闭
                btn: ['继续发布', '取消']
            },function () {
                //

                if(ismobile==1){

                    layer.open({
                        type: 2,
                        title: false,
                        shadeClose: false,shade: 0.6,
                        area: ['100vw', document.documentElement.clientHeight+'px'],
                        content: '/plan/add.php?from=layer&id='+game_id //iframe的url
                    });

                }else{
                    layer.open({
                        type: 2,
                        title: false,
                        shadeClose: false,shade: 0.6,
                        area: ['640px','600px'],
                        content: '/plan/add.php?from=layer&id='+game_id //iframe的url
                    });
                }

                layer.close(index);
            },function () {

            });
        }
        else{
            layer.msg(addtipsmsg,{ type: 1, anim: 2 ,time:1000});
        }

    }else{


        parent.showlogin();
    }



}
function plan_edit(id) {
    if(parent.check_userlock()==false) return false;

    layer.open({
        type: 2,
        title: false,
        shadeClose: false,shade: 0.6,
        area: ['640px','600px'],
        content: '/plan/edit.php?from=layer&id='+id //iframe的url
    });

}

function my_plan_add() {
    layer.open({
        type: 2,
        title: false,
        shadeClose: false,shade: 0.6,
        area: ['640px','520px'],
        content: '/plan/my_add.php?from=layer' //iframe的url
    });

}
function my_plan_reward(method) {
    layer.open({
        type: 2,
        title: false,
        shadeClose: false,shade: 0.6,
        area: ['640px','520px'],
        content: '/plan/my_reward.php?from=layer&method='+method //iframe的url
    });

}

function my_plan_action(method) {
    layer.open({
        type: 2,
        title: false,
        shadeClose: false,shade: 0.6,
        area: ['640px','520px'],
        content: '/plan/my_action.php?from=layer&method='+method //iframe的url
    });

}
function set_expect_num(max,defalut) {

    var html="";
    for(var i=1;i<=max;i++){
        if(i==defalut) var selected="selected";else var selected='';
      html+="<option value='"+i+"' "+selected+">"+i+"期</option>";
    }
    $('#expect_num').html(html);
    $('#tips_num').html(defalut);

}

function change_expect_num(value) {

    if(method==1){
        if(parseInt(value)>parseInt(document.querySelector('#period_num').value)){
            var option= document.querySelector('#expect_num').querySelectorAll('option');
            for(var i=0;i<option.length;i++){
                if(parseInt(option[i].value)==parseInt(document.querySelector('#tips_num').innerHTML))  option[i].selected=true;
                else  option[i].selected=false;
            }
            parent.layer.msg("最高连跟期数不能超过当前总期数",{ type: 1, anim: 2 ,time:1000});
        }
        else{

            $('#tips_num').html(value);
        }
    }
    else{

        $('#tips_num').html(value);
    }
    // for(var i=0;i<option.length;i++){
    //     if(parseInt(option[i].value)>=parseInt(document.querySelector('#expect_num').value))  option[i].style.display='';
    //     else option[i].style.display='none';
    // }
  }


  function change_period(value) {
    if(method==0){
        if(value>1){
            document.querySelector('#expect_box').style.display="";
            document.querySelector('#btn_add').style.display="inline-block";
            document.querySelector('#btn_public').style.display="none";
        }else{
            document.querySelector('#expect_box').style.display="none";
            document.querySelector('#btn_add').style.display="none";
            document.querySelector('#btn_public').style.display="inline-block";
        }
    }

      var index = parent.layer.getFrameIndex(window.name);
      parent.layer.iframeAuto(index);
  }

  function log(str) {
    var now=  new Date();;
     console.log(now.getHours()+":"+now.getMinutes()+":"+now.getSeconds(),str) ;
  }

  var isstart=true;
function change_game(id) {

    if(update_type=='edit') var id1=plan_id;
    else var id1=0;
    for(var i=0;i<gamelist.length;i++){
        if(id==gamelist[i].showkey) {
            if(gamelist[i].type=='ffc') gamelist[i].type='ssc';
            if(game_type!=gamelist[i].type){
                game_type=gamelist[i].type;
            if(update_type!='edit'){
                wf1='dwd';wf2=0;
            }
                init_wf1();
               change_wf(wf1);
            }

            break;
        }
    }
    $.post("../api/plan.php?act=planinfo",{gamekey:id,id:id1}, function(result){
        result=JSON.parse(result);
        var data=result.data;

        if(data!=false){

            game_id=data.id;
            var period=data.period;

            lasttime=period.lastsecond;
            lottery_period=period.period;
            lottery_list=JSON.parse(data.lottery);

          if(lottery_list[0]['period']==period.pre_period){
              isstart=true;
          }
          else{
              isstart=false;
              lasttime=0;
          }

            set_lotterynumber();
            listen_period();
            yilou();
            timeshow(lasttime);

            var qi_arr=data.qi_arr;
             var html="";
             for(var i=0;i<qi_arr.length;i++){

                 if(document.querySelector('#period').value==qi_arr[i])   var selected="selected";else  var selected='';
                 if(i<20)html+="<option value='"+qi_arr[i]+"' "+selected+">"+qi_arr[i]+"</option>";
             }

             $('#period').html(html);
            period_arr=qi_arr;
            var plan_num=data.plan_num;
            var html="";
            for(var i=0;i<plan_num.length;i++){
                if(document.querySelector('#period_num').value==plan_num[i])   var selected="selected";else  var selected='';
                html+="<option value='"+plan_num[i]+"' "+selected+">"+plan_num[i]+"期</option>";
            }
            $('#period_num').html(html);


        }
        else{

        }

    });

}



function get_nextplan(id) {
    if(update_type=='edit') var id1=plan_id;
    else var id1=0;

    $.post("../api/plan.php?act=planinfo",{gamekey:id,id:id1}, function(result){
        result=JSON.parse(result);
        var data=result.data;
        lottery_list=JSON.parse(data.lottery);
        var period=data.period;
        if(lottery_list[0]['period']==period.pre_period){
            isstart=true;
        }
        else{
            isstart=false;
        }

        set_lotterynumber();
        if(data!=false &&   isstart==true){
            clearInterval(timer66);
            clearInterval(timer44);
            period_temp=period.period;
            lasttime=period.lastsecond;

            listen_period();
            yilou();
            timeshow(lasttime);

             if(update_type=='edit'){
                 //更新计划状态

                     get_plan_status();

             }

        }
        else{

        }

    });
}
var lastnumber="";
function set_lotterynumber() {



    if(lastnumber!=lottery_list[0].number){
        clearInterval(timer44)
        lastnumber=lottery_list[0].number;
        var number=lastnumber.split(',');
        var str="";
        for(var i=0;i<number.length;i++){
           str+="<span class='ball'>"+number[i]+"</span>";
        }
        $('#lottery_num').html(str);
        $('#lottery_num').addClass('loading');
        setTimeout(function () {
           $('#lottery_num').removeClass('loading');
        },2000)
    }
    else{
        clearInterval(timer44)
        timer44=setInterval(function () {
            var ball= document.querySelector('#lottery_num').querySelectorAll('.ball');
            for(var i=0;i<ball.length;i++){
                ball[i].innerHTML=randomNum(0,9);
            }
        },30)

    }

}

function init_wf1() {
    var list=wanfa_arr[game_type];
    var str="";
    for(var ii in list){
        if(ii==wf1) var select="selected"; else var select='';
        if(arr_times(wanfa_vip,ii)>0) var str1="(高级)";else var str1="";
        str+="<option value='"+ii+"' "+select+">"+list[ii]+str1+"</option>";
    }

    $('#wanfa').html(str);
}

var timer55=null;
var timer66=null;
var timer77=null;
function get_plan_status() {
    $.post("../api/plan.php?act=plan_detail",{id:plan_id}, function(result){

        result=JSON.parse(result);
        if(result.code==200){
            var data=result.data;
            if(data.plantimes!=planinfo.plantimes){
                clearInterval(timer77);
                ///planinfo.plantimes=data.plantimes;
                planinfo=data;
                plan_status=data.status;
                set_plan_edidstatus();
            }
        }else{

        }


    });
}

function listen_period() {

    if(lasttime>0){
       clearInterval(timer55);
        timer55=setInterval(function () {
            daojishi1();
        },1000)
    }else{

    }
}
var period_temp='';
function  daojishi1() {

    if(lasttime>0){
        lasttime--;
        timeshow(lasttime);
    }else{

        period_temp=lottery_period;
        //parent.layer.msg("第"+lottery_period+"期已结束",{ type: 1, anim: 2 ,time:1000});
        var id=document.querySelector('#gamekey').value;

        change_game(id);

        clearInterval(timer55);
        clearInterval(timer66);
        timer66=setInterval(function () {
            var id=document.querySelector('#gamekey').value;
            get_nextplan(id);
        },2000)
    }

}
function timeshow(lost_s) {
    var l_s=Math.floor(lost_s%60);
    var next_s=Math.floor(lost_s/60);
    var l_m=Math.floor(next_s%60);
    var next_m=Math.floor(next_s/60);
    var l_h=Math.floor(next_m%60);
    if(l_h-10<0){var n_h="0"+l_h;}else{var n_h=l_h;}
    if(l_m-10<0){var n_m="0"+l_m;}else{var n_m=l_m;}
    if(l_s-10<0){var n_s="0"+l_s;}else{var n_s=l_s;}

    var str="";
    if(n_h!='00') {
        str+=n_h+':';
    }
    str+=n_m+':';
    str+=n_s;
    if(isstart==false){
        $('#showtime').html("(<span style='color:#2319dc;'>开奖中...</span>)")

    }else
    $('#showtime').html("(距下期还剩：<span style='color:#2319dc;'>"+str+"</span>)")

}
function change_wf(value) {
    var res=wanfa_json[game_type][value];
    if(vip==0){
        if(arr_times(wanfa_vip,value)>0){
            var index=  layer.confirm(wanfa_arr[game_type][value]+'为高级玩法，仅限VIP用户发布', {
                title:'提示',
                btn: ['成为VIP','取消'] //按钮
            }, function(){
                joinvip();
                var index = parent.layer.getFrameIndex(window.name);
                parent.layer.close(index);
            }, function(){
                document.querySelector('#wanfa').value=wf1;
            });

            return false;

        }

    }



    if(res==undefined){
        $('#wanfa1').hide();
        $('#wanfa1').html("");
    }else{
        $('#wanfa1').show();
        var str='';
        wf1=value;
        var click=0;
        for(var ii in res){
            var select='';
            if(update_type=='add' && click==0){
                wf2=ii;
                click++;
            }
            else if(update_type=='edit'){
                if(wf2==ii) select='selected';
            }
            //console.log(ii);
            if(arr_times(wanfa_vip,ii)>0) var str1="(高级)";else var str1="";
           str+="<option value='"+ii+"' "+select+">"+res[ii]+str1+"</option>";
        }

        $('#wanfa1').html(str);
        set_playhtml(wf1,wf2);


    }

}


function joinvip() {
    var index= parent.layer.open({
        type: 2,
        title: false,
        shadeClose: true,
        shade: 0.6,
        area: ['350px','260px'],
        content: "/user/joinvip.php"//iframe的url
    });
    var index = parent.layer.getFrameIndex(window.name);
    parent.layer.close(index);
}
function set_tools(num,type) {
   var ul=document.querySelector('.play_html').querySelectorAll('ul');
   ul=ul[num];
 var span=  ul.querySelector('.num').querySelectorAll('span');
 for(var i=0;i<span.length;i++){
     if(type=='all'){
         span[i].className='active';
     }
     if(type=='clear'){
         span[i].className='';
     }
     if(type=='other'){
         if( span[i].className=='')
         span[i].className='active';
         else  span[i].className='';
     }

 }
    count_num();

}

function showtools(num) {
    var html="<li>";

    html+="<span onclick='set_tools("+num+",\"all\")'>全</span>";
    html+="<span onclick='set_tools("+num+",\"other\")'>反</span>";
    html+="<span onclick='set_tools("+num+",\"clear\")'>清</span>";
    html+="</li>";

    return html;
}

function set_playhtml(value1,value2) {

    if(vip==0){
        if(arr_times(wanfa_vip,value2)>0){
            var index=  layer.confirm(wanfa_json[game_type][value1][value2]+'为高级玩法，仅限VIP用户发布', {
                title:'提示',
                btn: ['成为VIP','取消'] //按钮
            }, function(){
                joinvip();
                var index = parent.layer.getFrameIndex(window.name);
                parent.layer.close(index);
            }, function(){
                document.querySelector('#wanfa1').value=wf2;
            });

            return false;

        }

    }

    wf2=value2;
  //  console.log(value1,value2);
    var str="";
    if(number_trend=='loss') var trend_name='遗漏';else var trend_name='冷热';
    if(value1=='dwd'  || value1=='bdw' || value1=='rxfs'){
        var num=1;
        var title=wanfa_json[game_type][value1][value2];
        for(var i=0;i<num;i++){
            str+="<ul>";
            str+="<li><span>"+title+"</span><p class='trend'>"+trend_name+"</p></li>";
            str+="<li class='num'>";
            str+="<div>";
            if(game_type=='11x5'){
                for(var j=1;j<=11;j++){
                    if(j<10) var jj='0'+j;else var jj=j;
                    str+="<span onclick='click_num(this);'>"+jj+"</span>";
                }
            }
            else{
                for(var j=0;j<=9;j++){
                    str+="<span onclick='click_num(this);'>"+j+"</span>";
                }
            }

            str+="</div>";
            str+="<div>";
            if(game_type=='11x5'){
                for(var j=1;j<=11;j++){

                    str+="<p >0</p>";
                }
            }else{
                for(var j=0;j<=9;j++){
                    str+="<p >0</p>";
                }
            }

            str+="</div>";

            str+="</li>";
            str+=showtools(i);
            str+="</ul>";
        }
    }
   else  if(value2=='fs'){
       // var wei=['万位','千位','百位','十位','个位'];
        var wei=wanfa_json[game_type]['dwd'];

        if(value1=='4x1' || value1=='4x2'){
            var num=4;
            if(value1=='4x1') var from=0;
            else var from=1
        }
        if(value1=='3x1' || value1=='3x2' || value1=='3x3'){
            var num=3;
            if(value1=='3x1') var from=0;
            else if(value1=='3x3') var from=1;
            else var from=2;
        }
        if(value1=='2x1' || value1=='2x2'){
            var num=2;
            if(value1=='2x1') var from=0;
            else var from=3;
        }
        for(var i=0;i<num;i++){
             var pos=from+i;
            var title=wei[pos];
            str+="<ul>";
            str+="<li><span onclick='click_num(this);'>"+title+"</span><p class='trend'>"+trend_name+"</p></li>";
            str+="<li  class='num'>";
            str+="<div>";
            if(game_type=='11x5'){
                for(var j=1;j<=11;j++){
                    if(j<10) var jj='0'+j;else var jj=j;
                    str+="<span onclick='click_num(this);'>"+jj+"</span>";
                }
            }
            else{
                for(var j=0;j<=9;j++){
                    str+="<span onclick='click_num(this);'>"+j+"</span>";
                }
            }
            str+="</div>";
            str+="<div>";
            if(game_type=='11x5'){
                for(var j=1;j<=11;j++){

                    str+="<p >0</p>";
                }
            }else{
                for(var j=0;j<=9;j++){
                    str+="<p >0</p>";
                }
            }

            str+="</div>";
            str+="</li>";
            str+=showtools(i);
            str+="</ul>";
        }

    }
    else if(value2=='z3' || value2=='z6' || value2=='z24' || value2=='kd'){
       if(value2=='z3') var title='组三';
       else if(value2=='z24') var  title='组选24';
       else if(value2=='kd') var  title='跨度';
       else var title='组六';
        str+="<ul>";
        str+="<li><span>"+title+"</span><p class='trend'>"+trend_name+"</p></li>";
        str+="<li  class='num'>";
        str+="<div>";
        for(var j=0;j<=9;j++){
            str+="<span onclick='click_num(this);'>"+j+"</span>";
        }
        str+="</div>";
        str+="<div>";
        for(var j=0;j<=9;j++){
            str+="<p>0</p>";
        }
        str+="</div>";
        str+="</li>";
        str+=showtools(0);
        str+="</ul>";
    }

    else if(value2=='z12' ){

        str+="<ul>";
        str+="<li><span>二重号</span><p class='trend'>"+trend_name+"</p></li>";
        str+="<li  class='num'>";
        str+="<div>";
        for(var j=0;j<=9;j++){
            str+="<span onclick='click_num(this);'>"+j+"</span>";
        }
        str+="</div>";
        str+="<div>";
        for(var j=0;j<=9;j++){
            str+="<p>0</p>";
        }
        str+="</div>";
        str+="</li>";
        str+=showtools(0);
        str+="</ul>";

        str+="<ul>";
        str+="<li><span>单号</span><p class='trend'>"+trend_name+"</p></li>";
        str+="<li  class='num'>";
        str+="<div>";
        for(var j=0;j<=9;j++){
            str+="<span onclick='click_num(this);'>"+j+"</span>";
        }
        str+="</div>";
        str+="<div>";
        for(var j=0;j<=9;j++){
            str+="<p>0</p>";
        }
        str+="</div>";
        str+="</li>";
        str+=showtools(1);
        str+="</ul>";
    }
    else if(value2=='hz'){
      var title='和值';
        if(wf1=='2x1' || wf1=='2x2'){
            var max=18;
            var lines=2;
        }else {
            var max=27;
            var lines=3;
        }
        str+="<ul>";
        str+="<li><span>"+title+"</span><p class='trend'>"+trend_name+"</p></li>";
        str+="<li  class='num'>";
        for(var i=0;i<lines;i++){
            if(i>0) var style11="style='margin-top:10px;'";else var style11='';
            str+="<div "+style11+">";


            for(var j=0;j<=max;j++){
               if(j>=i*10 && j<(i+1)*10)
                str+="<span onclick='click_num(this);'>"+j+"</span>";
            }
            str+="</div>";
            str+="<div>";
            for(var j=0;j<=max;j++){
                if(j>=i*10 && j<(i+1)*10)
                str+="<p>0</p>";
            }
            str+="</div>";

        }

        str+="</li>";
        str+=showtools(0);
        str+="</ul>";
    }
    else if(value1=='lhh'){
        var wei=['万','千','百','十','个'];
        var arr=value2.split('-');
        var title=wei[arr[0]]+wei[arr[1]];
        str+="<ul>";
        str+="<li><span >"+title+"</span><p class='trend'>"+trend_name+"</p></li>";
        str+="<li  class='num'>";
        var pos=['龙','虎','和']

        str+="<div>";
        for(var j=0;j<pos.length;j++){
            str+="<span onclick='click_num(this);'>"+pos[j]+"</span>";
        }
        str+="</div>";
        str+="<div>";
        for(var j=0;j<pos.length;j++){
            str+="<p>0</p>";
        }
        str+="</div>";
        str+="</li>";
        str+="</ul>";
    }
    else if(value2=='ds'){
        str='<div class="ds">';
        str+='<div >';
        str+="<textarea id='input_value' onblur='count_num();' ></textarea>";
        str+="</div>";
        str+='<div >';
        str+="<p class='btns clear' onclick='clear_input();'><i class='icon-trash'></i>清空选号</p>";
        str+="<p class='btns ok' onclick='count_num();'><i class='icon-ok'></i>计算注数</p>";
        str+="<p class='btns plus' onclick=\"parent.parent.open_tools('"+game_type+"?star="+value1.substr(0,1)+"');\"><i class='icon-plus'></i>做号工具</p>";
        str+="</div>";
        str+="</div>";
    }



  $('.play_html').html(str);
    var index = parent.layer.getFrameIndex(window.name);
    parent.layer.iframeAuto(index);
    plan_num=0;
    $('#plan_num').html(plan_num);
    yilou();

    if(update_type=='edit'){
        $("#wanfa").attr("disabled","disabled");
        $("#wanfa1").attr("disabled","disabled");
    }
}

function yilou() {

    var lines = document.querySelector('.play_html').querySelectorAll('.num');

    for(var i=0;i<lines.length;i++){
       var p= lines[i].querySelectorAll('p');
        var span= lines[i].querySelectorAll('span');
       for(var j=0;j<p.length;j++){
           if(wf1=='dwd')  p[j].innerHTML=getlou_num(span[j].innerHTML,0,i);
           else if(wf2=='fs'){
                   var from=0;
                   if(wf1=='4x2')  from=1;
               if(wf1=='3x3')  from=1;
                   if(wf1=='2x2')  from=3;
                   var pos=from+i;
                   p[j].innerHTML=getlou_num(span[j].innerHTML,pos,i);
           }
           else if(wf1=='lhh'){
               p[j].innerHTML=getlou_num(span[j].innerHTML,0);
           }
           else if(wf2=='z3' || wf2=='z6' || wf2=='z12' || wf2=='z24' || wf2=='hz' || wf2=='kd'){
               var from=0;
               if(wf1=='4x2')  from=1;
               if(wf1=='3x2')  from=2;
               if(wf1=='3x3')  from=1;
               if(wf1=='2x2')  from=3;
               p[j].innerHTML=getlou_num(span[j].innerHTML,from,i);
           }
           else if(wf1=='bdw')p[j].innerHTML=getlou_num(span[j].innerHTML,wf2,i);
           else if(wf1=='rxfs')p[j].innerHTML=getlou_num(span[j].innerHTML,wf2,i);

       }
    }
    for(var i=0;i<lines.length;i++){
        var p= lines[i].querySelectorAll('p');

        var max=0;
        var min=100;
        for(var j=0;j<p.length;j++){
           p[j].className='';
            if(parseInt(p[j].innerHTML)<min) min=p[j].innerHTML;
            if(parseInt(p[j].innerHTML)>max) max=p[j].innerHTML;
        }
        for(var j=0;j<p.length;j++){
            if(p[j].innerHTML==max) p[j].className='max';
            if(p[j].innerHTML==min) p[j].className='min';
        }
    }

}

function getlou_num(num,pos,wei) {
    var sum=0;
    if(number_trend=='loss'){
        for(var i=0;i<lottery_list.length;i++){

            var number=lottery_list[i].number.split(',');
            if(wf1=='dwd')
            {
                if(number[wf2]==num){
                    return sum;
                }else sum++;
            }
            else if(wf1=='bdw'){
                var arr=[number[pos],number[pos+1],number[pos+2]];
                if(arr_times(arr,num)>0) return sum;else sum++;
            }

            else if(wf1=='rxfs'){

                if(arr_times(number,num)>0) return sum;else sum++;
            }
            else if(wf2=='fs'){
                if(number[pos]==num){
                    return sum;
                }else sum++;
            }
            else if(wf1=='lhh'){
                var arr=wf2.split('-');
                var cha=number[arr[0]]-number[arr[1]];
                if(num=='龙'){
                    if(cha>0) return sum;
                    else sum++;
                }
                else if(num=='虎'){
                    if(cha<0) return sum;
                    else sum++;
                }
                else{
                    if(cha==0) return sum;
                    else sum++;
                }
            }
            else  if(wf2=='z3'){
                if(number[pos]!=number[pos+1]  && number[pos]!=number[pos+2] && number[pos+1]!=number[pos+2]  ){
                    sum++;
                }else{
                    if(num==number[pos] || num==number[pos+1] || num==number[pos+2]){
                        return sum;
                    }else{
                        sum++;
                    }
                }

            }
            else  if(wf2=='z6'){
                if(number[pos]!=number[pos+1]  && number[pos]!=number[pos+2] && number[pos+1]!=number[pos+2]  ){
                    if(num==number[pos] || num==number[pos+1] || num==number[pos+2]){
                        return sum;
                    }else{
                        sum++;
                    }
                }else{
                    sum++;
                }

            }
            else if (wf2=='kd'){
                var kd=number[pos]-number[pos+1];
                if(kd<0) kd=-kd;
                if(kd==num) return sum;else sum++;
            }
            else if (wf2=='hz'){

                if(wf1.substr(0,1)==2)
                    var hz=parseInt(number[pos])+parseInt(number[pos+1]);
                else  var hz=parseInt(number[pos])+parseInt(number[pos+1])+parseInt(number[pos+2]);

                if(hz==num) return sum;else sum++;
            }
            else if (wf2=='z24'){
                var arr=[number[pos],number[pos+1],number[pos+2],number[pos+3]];

                var  arr1=unique(arr);
                if(arr1.length==4){
                    if(arr_times(arr,num)==1) return sum;else sum++;
                }else{
                    sum++;
                }

            }

            else if (wf2=='z12'){
                var arr=[number[pos],number[pos+1],number[pos+2],number[pos+3]];
                var   arr1=unique(arr);
                if(arr1.length==3){

                    if(wei==0){
                        if(arr_times(arr,num)==2) return sum;else sum++;
                    }else{
                        if(arr_times(arr,num)==1) return sum;else sum++;
                    }

                }else{
                    sum++;

                }

            }
        }

    }else{
        for(var i=0;i<lottery_list.length;i++){

            var number=lottery_list[i].number.split(',');
            if(wf1=='dwd')
            {
                if(number[wf2]==num){
                   sum++;
                }
            }
            else if(wf1=='bdw'){
                var arr=[number[pos],number[pos+1],number[pos+2]];
                if(arr_times(arr,num)>0) sum++;
            }

            else if(wf1=='rxfs'){

                if(arr_times(number,num)>0)  sum++;
            }
            else if(wf2=='fs'){
                if(number[pos]==num){
                    sum++;
                }
            }
            else if(wf1=='lhh'){
                var arr=wf2.split('-');
                var cha=number[arr[0]]-number[arr[1]];
                if(num=='龙'){
                    if(cha>0)  sum++;

                }
                else if(num=='虎'){
                    if(cha<0)  sum++;

                }
                else{
                    if(cha==0)  sum++;

                }
            }
            else  if(wf2=='z3'){
                if(number[pos]!=number[pos+1]  && number[pos]!=number[pos+2] && number[pos+1]!=number[pos+2]  ){
                    sum++;
                }else{
                    if(num==number[pos] || num==number[pos+1] || num==number[pos+2]){
                         sum++;
                    }
                }

            }
            else  if(wf2=='z6'){
                if(number[pos]!=number[pos+1]  && number[pos]!=number[pos+2] && number[pos+1]!=number[pos+2]  ){
                    if(num==number[pos] || num==number[pos+1] || num==number[pos+2]){
                         sum++;
                    }
                }
            }
            else if (wf2=='kd'){
                var kd=number[pos]-number[pos+1];
                if(kd<0) kd=-kd;
                if(kd==num) sum++;
            }
            else if (wf2=='hz'){

                if(wf1.substr(0,1)==2)
                    var hz=parseInt(number[pos])+parseInt(number[pos+1]);
                else  var hz=parseInt(number[pos])+parseInt(number[pos+1])+parseInt(number[pos+2]);

                if(hz==num)  sum++;
            }
            else if (wf2=='z24'){
                var arr=[number[pos],number[pos+1],number[pos+2],number[pos+3]];

                var  arr1=unique(arr);
                if(arr1.length==4){
                    if(arr_times(arr,num)==1)  sum++;
                }else{
                    sum++;
                }

            }

            else if (wf2=='z12'){
                var arr=[number[pos],number[pos+1],number[pos+2],number[pos+3]];
                var   arr1=unique(arr);
                if(arr1.length==3){

                    if(wei==0){
                        if(arr_times(arr,num)==2)  sum++;
                    }else{
                        if(arr_times(arr,num)==1)  sum++;
                    }

                }else{
                    sum++;

                }

            }
        }
    }


    return sum;
}
function unique(arr) {
    return Array.from(new Set(arr))
}
function arr_times(arr,str){
    var isin=0;
    for(var i=0;i<arr.length;i++){
        if(arr[i]==str) isin++;
    }
    return isin;
}
function click_trend(num) {
  var li=  document.getElementsByName('number_trend');
   if(li[num].checked==false) return false;
   for(var i=0;i<li.length;i++){
       if(i==num) li[i].checked=true;
       else li[i].checked=false;
   }
  if(num==0) number_trend='loss';
    else number_trend='hot';
    if(number_trend=='loss') var trend_name='遗漏';else var trend_name='冷热';
    yilou();
   var ul= document.querySelector('.play_html').querySelectorAll('ul');
   for(var i=0;i<ul.length;i++){
  ul[i].querySelector('.trend').innerHTML=trend_name;
   }
}

function click_num(div) {
     if(div.className==''){
         div.className='active';
     }else{
         div.className='';
     }
    count_num();
}

function  count_num() {

   //定位胆 龙虎和
    if(wf1=='dwd' || wf1=='lhh' || wf2=='hz' || wf2=='kd' || wf1=='bdw'){
     var span = document.querySelector('.play_html').querySelector('.num').querySelectorAll('.active');
       plan_num=span.length;
    }
    else if(wf2=='z3'){
        var span = document.querySelector('.play_html').querySelector('.num').querySelectorAll('.active');
        plan_num=span.length*(span.length-1);

    }
    else if(wf2=='z6'){
        var span = document.querySelector('.play_html').querySelector('.num').querySelectorAll('.active');
        var len=span.length;
        if(len>=3){
            plan_num=len*(len-1)*(len-2)/6
        }else
        plan_num=0;
    }
    else if(wf1=='rxfs'){
        var span = document.querySelector('.play_html').querySelector('.num').querySelectorAll('.active');
        var len=span.length;
        if(wf2=='1-1') plan_num=len;
        else  {
            var arr1=wf2.split('-');
            if(len>=arr1[0]){
                var a=1;
                var b=1;
                for(var i=len;i>len-arr1[0];i--){
                    a=a*i;
                }
                for(var i=1;i<=arr1[0];i++){
                    b=b*i;
                }
                plan_num=a/b;

            }else plan_num=0;
        }

    }
    else if(wf2=='z24'){
        var span = document.querySelector('.play_html').querySelector('.num').querySelectorAll('.active');
        var len=span.length;
        if(len>=4){
            plan_num=len*(len-1)*(len-2)*(len-3)/24
        }else
            plan_num=0;
    }
    else if(wf2=='z12'){

        var a=0;var b=0;
        var sele_count= new Array('0','1','3','6','10','15','21','28','36');
        var selectlist=[[],[]]
        var num = document.querySelector('.play_html').querySelectorAll('.num');
        for(var k=0;k<num.length;k++){

            var item= num[k].querySelectorAll('.active');
            for(var ii in item){
                if(parseInt(item[ii].innerHTML)>=0){
                    selectlist[k].push(parseInt(item[ii].innerHTML));
                    if(k==0) a++;else b++;
                }

            }


        }
     console.log(selectlist);
        var anum=0;var bnum=0;var c;var d;
        var num=sames(selectlist[0],selectlist[1]);

        if(b-1>=0){c=b-1}else{c=0;};
        if(b-2>=0){d=b-2}else{d=0;};
        if(num-1>=0){
            if(selectlist[0].length-num==0){c=b-2;anum=sele_count[c]*selectlist[0].length;}
            if(selectlist[0].length-num>0){c=b-2;anum=sele_count[c]*num;anum=anum+sele_count[b-1]*(selectlist[0].length-num);}
        }else{if(b-1>=0){c=b-1}else{c=0;};anum=sele_count[c]*selectlist[0].length;}
        plan_num=parseInt(anum);
    }
    else if(wf2=='fs'){
        var num = document.querySelector('.play_html').querySelectorAll('.num');
        var temp=1;
        for(var i=0;i<num.length;i++){
            var span=num[i].querySelectorAll('.active');
            temp=temp*span.length
        }
        plan_num=temp;
    }
    else if(wf2=='ds'){
        var input_value=$('#input_value').val();
        if(game_type=='11x5'){
            input_value=input_value.replace(/：/g,',');
            input_value=input_value.replace(/:/g,',');
            input_value=input_value.replace(/；/g,',');
            input_value=input_value.replace(/;/g,',');
            input_value=input_value.replace(/，/g,',');
            input_value=input_value.replace(/,/g,',');
            input_value=input_value.replace(/、/g,',');
            input_value=input_value.replace(/。/g,',');
            input_value=input_value.replace(/\./g,',');
            input_value=input_value.replace(/\n/g,',');
            input_value=input_value.replace(/  /g,' ');
            // console.log(input_value);
            var  arr=input_value.split(',');
            var num=0;
            var lines='';
            var temp=['01','02','03','04','05','06','07','08','09','10','11'];
            for(var i=0;i<arr.length;i++){
                if(arr[i].length==this.wf1.substr(0,1)*3-1){
                    var arr1=arr[i].split(' ');
                    var len=0;
                    if(arr1.length==this.wf1.substr(0,1)){
                        for(var k=0;k<arr1.length;k++){
                            if( arr1[k].length==2 && arr_times(temp,arr1[k])){
                                len++;
                            }
                        }
                    }
                    if(len==wf1.substr(0,1)){
                        num++;
                        if(lines!='') lines+=',';
                        lines+=arr[i];
                    }

                }

            }
            $('#input_value').val(lines);
            plan_num=num;
        }else{


            input_value=input_value.replace(/：/g,' ');
            input_value=input_value.replace(/:/g,' ');
            input_value=input_value.replace(/；/g,' ');
            input_value=input_value.replace(/;/g,' ');
            input_value=input_value.replace(/，/g,' ');
            input_value=input_value.replace(/,/g,' ');
            input_value=input_value.replace(/、/g,' ');
            input_value=input_value.replace(/。/g,' ');
            input_value=input_value.replace(/\./g,' ');
            input_value=input_value.replace(/\n/g,' ');
            input_value=input_value.replace(/  /g,' ');
            // console.log(input_value);
            var  arr=input_value.split(' ');
            var num=0;
            var lines='';
            for(var i=0;i<arr.length;i++){
                if(/(^[0-9]\d*$)/.test(arr[i]) && arr[i].length==wf1.substr(0,1) && lines.indexOf(arr[i])<=-1){
                    num++;
                    if(lines!='') lines+=' ';
                    lines+=arr[i];
                }
            }
            $('#input_value').val(lines);
            plan_num=num;

        }


        }

    $('#plan_num').html(plan_num);
}

function  sames(a,b){
    var num=0;
    for (var i=0;i<a.length;i++)
    {
        var zt=0;
        for (var j=0;j<b.length;j++)
        {
            if(a[i]-b[j]==0){
                zt=1;
            }
        }
        if(zt==1){
            num+=1;
        }
    }
    return num;
}

function  clear_input() {
    if(wf2=='ds')
    $('#input_value').val('');
    else{
        var lines = document.querySelector('.play_html').querySelectorAll('.num');
        for(var i=0;i<lines.length;i++){
            var span= lines[i].querySelectorAll('span');
            for(var j=0;j<span.length;j++){
              span[j].className='';

            }

        }
    }
    plan_num=0;
    $('#plan_num').html(plan_num);
}

function diywf(checked) {
    if(checked==true){
        var index=  layer.confirm("您没有定制任何玩法<br>如需定制请先联系彩匠客服<br>定制属于VIP收费服务", {
            title:'提示',
            time: 20000, //20s后自动关闭
            btn: ['联系客服', '取消定制']
        },function () {
            //
            parent.parent.open_chatarea(0,admin_nickname,admin_logo);
            document.querySelector('#diywf').checked=false;
            layer.close(index);
        },function () {
            document.querySelector('#diywf').checked=false;
        });
    }



}

function set_paymoney(checked) {

    if(checked==true){
        var index=  layer.confirm("付费查看模块正在征求意见中<br>如果您有好的提议，请联系客服", {
            title:'提示',
            time: 20000, //20s后自动关闭
            btn: ['联系客服', '取消']
        },function () {
            //
            parent.parent.open_chatarea(admin_id,admin_nickname,admin_logo,0);
            document.querySelector('#payopen').checked=false;
            layer.close(index);
        },function () {
            document.querySelector('#payopen').checked=false;
        });
    }
    return false;

    if(checked==true){
       var index1= parent.layer.prompt(
            {
                title:'请输入金额:',
                maxlength: 5,
                btn2: function() {//这里就是你要的
                    document.querySelector('#payopen').checked=false;
                    paymoney=0;
                    $('#paymoney').hide();
                },

            },
            function(val, index){
            //layer.msg('得到了'+val);
                if(val>0 && /(^[1-9]\d*$)/.test(val)){
                    paymoney=val;
                    $('#paymoney').html(paymoney+'元');
                    $('#paymoney').show();
                    parent.layer.close(index1);
                }
                else{
                    parent.layer.msg("您输入的金额不正确",{ type: 1, anim: 2 ,time:1000});
                    // paymoney=0;
                    // $('#paymoney').hide();
                }

        }
           );
    }else{
        paymoney=0;
        $('#paymoney').hide();
    }
}

function buylist() {
    var str='';
    if(wf2=='ds'){
        count_num();
        str=$("#input_value").val();
    }else{
        var lines = document.querySelector('.play_html').querySelectorAll('.num');
        for(var i=0;i<lines.length;i++){
            var p= lines[i].querySelectorAll('.active');

            if(str!='') str+=',';
            for(var j=0;j<p.length;j++){
                if(game_type=='11x5' && str!='' && j>0) str+=' ';
                str+=p[j].innerHTML;
            }

        }
    }

    return str;
}

function check_plannum() {
    var max=0;
    if(wf1=='dwd'){
       if(game_type=='11x5')
           max=8;
       else
           max=7;

    }
    else if(wf2=='ds' || wf2=='fs'){
     if(wf1=='4x1' || wf1=='4x2'){
         max=7000;
     }
     else if(wf1=='2x1' || wf1=='2x2'){
         if(game_type=='11x5')
             max=80;
         else
         max=70;
     }
     else {
         if(game_type=='11x5')
             max=800;
         else max=700;
             }

    }
    else if(wf2=='z3' || wf2=='z6'){
        max=56;
    }
    else if(wf1=='lhh'){
        max=2;
    }
    else if(wf1=='bdw'){
        max=2;
    }
    else if(wf1=='rxfs'){
        if(wf2=='1-1') max=8;
        if(wf2=='2-2') max=28;
        if(wf2=='3-3') max=56;
        if(wf2=='4-4') max=70;
        if(wf2=='5-5') max=56;
        if(wf2=='6-5') max=28;
        if(wf2=='7-5') max=8;
        if(wf2=='8-5') max=1;
    }
    else if(wf2=='hz'){
        if(wf1=='2x1' || wf1=='2x2'){
            max=15;
        }
        else max=24;
    }
    else if(wf2=='z12'){
        max=288;
    }
    else if(wf2=='z24'){
        max=126;
    }
   if(parseInt(plan_num)>parseInt(max)){
       var wfname=document.querySelector('#wanfa').options[document.querySelector('#wanfa').selectedIndex].text+document.querySelector('#wanfa1').options[document.querySelector('#wanfa1').selectedIndex].text;
       parent.layer.msg(wfname+"最多只能选择"+max+"注",{ type: 1, anim: 2 ,time:1000});
       return false;
   }
    if(wf1=='lhh'){
        var buylist1=buylist();
        if(buylist1.indexOf('龙')>-1 && buylist1.indexOf('虎')>-1 ){
            parent.layer.msg("不可以同时选择龙虎",{ type: 1, anim: 2 ,time:1000});
            return false;
        }
    }
    if(update_type=='edit'){

        if(parseInt(plan_num)!=parseInt(planinfo.num) && wf2!='ds'){

            parent.layer.msg("此计划更新只能"+planinfo.num+"注",{ type: 1, anim: 2 ,time:1000});
            return false;
        }

    }

   return true;
}

var plan_list=[];
function  addbox() {
    var buylist1=buylist();
    if(plan_num<1){
        parent.layer.msg("请先选择号码",{ type: 1, anim: 2 ,time:1000});
        return false;

    }else{

       if(check_plannum()==false) return false;
        if(method==2){

            if(plan_list.length>=addmax){

                parent.layer.msg(grade_name+"计划员每个计划最多只能添加"+addmax+"套方案",{ type: 1, anim: 2 ,time:1000});
                return false;
            }

        }
        if(plan_list.length==0)
        buynum=plan_num;
        else{

            if(method==3  || wf2=='ds'){

            }else{
                if(buynum!=plan_num){
                    parent.layer.msg("不同方案的注数必须相同",{ type: 1, anim: 2 ,time:1000});
                    return false;
                }
                else{
                    // for(var i=0;i<plan_list.length;i++){
                    //     if(plan_list[i].content==buylist1){
                    //         parent.layer.msg("该方案已存在，不能重复添加",{ type: 1, anim: 2 ,time:1000});
                    //         clear_input();
                    //         return false;
                    //     }
                    // }
                }
            }

        }
    }


    var wfname=document.querySelector('#wanfa').options[document.querySelector('#wanfa').selectedIndex].text+document.querySelector('#wanfa1').options[document.querySelector('#wanfa1').selectedIndex].text;
     plan_list.push({wf1:wf1,wf2:wf2,num:plan_num,content:buylist1});
    var html="<ul id='box_"+plan_list.length+"'>";
    if(method==3){
        html+="<li class='fnname'>第"+plan_list.length+"期</li>";
    }else
    html+="<li class='fnname'>方案"+plan_list.length+"</li>";
    html+="<li>"+wfname+"</li>";
     html+="<li title='"+buylist1+"'>"+buylist1+"</li>";
    html+="<li>"+plan_num+"</li>";
    html+="<li class='fndelete'><i class='icon-trash' title='删除该方案' onclick='delete_addbox(plan_list.length);'></i> </li>";
    html+="</ul>";
    $('.area_box').append(html);
    if(method==3){
        set_tips3();

    }
    clear_input();
    set_boxarea();
}

function delete_addbox(num) {
    $('#box_'+num).remove();
    var arr=[];
    for(var i=0;i<plan_list.length;i++){
        if(i!=num-1) arr.push(plan_list[i]);
    }
    plan_list=arr;
    var ul= document.querySelector('.area_box').querySelectorAll('ul');
    for(var i=1;i<ul.length;i++){
        ul[i].id='box_'+i;

        if(method==3){
            ul[i].querySelector('.fnname').innerHTML="第"+i+"期";
        }else
            ul[i].querySelector('.fnname').innerHTML="方案"+i;
        ul[i].querySelector('.fndelete').innerHTML="<i class='icon-trash' title='删除该方案' onclick='delete_addbox("+i+");'></i>";
    }
    if(method==3){
        set_tips3();

    }
    set_boxarea();

}

function destroy_box() {
    for(var i=0;i<plan_list.length;i++){
       var num=i+1;
        $('#box_'+num).remove();
    }
    plan_list=[];
    set_boxarea();
    if(method==3){
        set_tips3();

    }
}

function set_boxarea() {

    if(update_type=='add'){
        var option= document.querySelector('#period_num').querySelectorAll('option');
        $("#content_num").html(plan_list.length);
        if(plan_list.length==0){
            buynum=0;

                $("#gamekey").attr("disabled",false);
                $("#wanfa").attr("disabled",false);
                $("#wanfa1").attr("disabled",false);


            $('.plan_bottom').hide();
            $('.area_box').hide();
            if(method==0){

                for(var i=0;i<option.length;i++){
                    if(parseInt(option[i].value)>=parseInt(document.querySelector('#expect_num').value))  option[i].style.display='';
                    else option[i].style.display='none';
                }
            }else{
                for(var i=0;i<option.length;i++){

                    option[i].style.display='';
                }
            }

        }
        else {
            $("#gamekey").attr("disabled","disabled");
            $("#wanfa").attr("disabled","disabled");
            $("#wanfa1").attr("disabled","disabled");
            document.querySelector('.plan_bottom').style.display='block';
            document.querySelector('.area_box').style.display='block';
            if(method==0){

                for(var i=0;i<option.length;i++){

                    if(parseInt(option[i].value)<parseInt(document.querySelector('#period_num').value)) option[i].style.display='none';
                }
            }
            else{
                for(var i=0;i<option.length;i++){

                    option[i].style.display='';
                }
            }

        }


    }
   else{
        $("#gamekey").attr("disabled","disabled");
       if(method!=1)  $('.plan_bottom').show();
        $("#content_num").html(plan_list.length);
    }
    var index = parent.layer.getFrameIndex(window.name);
    parent.layer.iframeAuto(index);
}

function change_tab(num) {
    var li= document.querySelector('.nav1').querySelectorAll('li');
    for(var i=0;i<li.length;i++){
        if(i==num){
            li[i].className='active';
        }
        else li[i].className='';
    }
    method=num;
    clear_input();
    destroy_box();
    if(num==0){
       $('#period_max').show();
       $('#expect_box').show();
        $('.play_html').show();
        $('#trend_type').show();
        $("#wanfa").attr("disabled",false);
        $('.add_area .count').show();
        $('#method_20').hide();
        $('#method_21').hide();
        document.querySelector('#btn_add').style.display="inline-block";
        document.querySelector('#btn_public').style.display="none";
        $('#btn_add span').html('添加方案');
        $("#fnname").html('方案');
       $('.plan_bottom .tips').html("每个方案最高连跟<span class=\"num\" id=\"tips_num\">"+$('#tips_num').html()+"</span>期，中奖后自动切换到下一方案");
        set_expect_num(10,3);
    }
    else if(num==1){
        $('#period_max').show();
        $('#expect_box').show();
        $('.play_html').hide();
        $('#trend_type').hide();
        document.querySelector('#btn_add').style.display="none";
        document.querySelector('#btn_public').style.display="inline-block";
        $('#method_20').show();
        $('#method_21').show();
        $('.add_area .count').hide();
        var option= document.querySelector('#wanfa').querySelectorAll('option');
        for(var i=0;i<option.length;i++){
            if(option[i].value=='dwd') option[i].selected=true;
            else option[i].selected=false;
        }
        change_wf('dwd');
        $("#fnname").html('方案');

        set_expect_num(3,1);
        $("#wanfa").attr("disabled","disabled");

    }
    else if(num==2){
        $('#period_max').hide();
        $('#expect_box').show();
        $('.play_html').show();
        $('#method_20').hide();
        $('#method_21').hide();
        $('#trend_type').show();
        document.querySelector('#btn_add').style.display="inline-block";
        document.querySelector('#btn_public').style.display="none";
        $("#fnname").html('方案');
        $('#btn_add span').html('添加方案');
        $('.plan_bottom .tips').html("每个方案最高连跟<span class=\"num\" id=\"tips_num\">"+$('#tips_num').html()+"</span>期，中奖后自动切换到下一方案");
        $("#wanfa").attr("disabled",false);
        $('.add_area .count').show();
        set_expect_num(3,3);
    }
    else if(num==3){
        $('#period_max').show();
        $('#expect_box').hide();
        $('.play_html').show();
        $('#method_20').hide();
        $('#method_21').hide();
        $('#trend_type').show();
        $('.add_area .count').show();
        document.querySelector('#btn_add').style.display="inline-block";
        document.querySelector('#btn_public').style.display="none";
        $("#fnname").html('期数');
        set_tips3();
        $('#btn_add span').html('添加第1期');
        $("#wanfa").attr("disabled",false);
    }

    var index = parent.layer.getFrameIndex(window.name);
    parent.layer.iframeAuto(index);
}

function  set_tips3() {

    if(update_type=='edit'){
        if(plan_list.length<1){
            var content=JSON.parse(planinfo.content)
            var len=content.length;
        }
        else var len=plan_list.length;
        if(plan_status==1){
            var sum=parseInt(document.querySelector('#period_num').value)+parseInt(planinfo.expect_sum);
        }else{
            var sum=parseInt(document.querySelector('#period_num').value);
        }

        var num=sum-len;
        if(num>0)
            $('.plan_bottom .tips').html("您一共设置了<span class='num'>"+sum+"</span>期,还需添加<span class=\"num\" id=\"tips_num\">"+num+"</span>期方案");
        else {
            if(update_type=='add') $('.plan_bottom .tips').html("方案添加完成，请点击右侧的发布按钮");
            else $('.plan_bottom .tips').html("方案添加完成，请点击右侧的更新按钮");
        }

        var nestnum=plan_list.length+1;
        $('#btn_add span').html('添加第'+nestnum+'期');

    }else
    {
        var num=parseInt(document.querySelector('#period_num').value)-parseInt(plan_list.length);
        if(num>0)
            $('.plan_bottom .tips').html("您一共设置了<span class='num'>"+$('#period_num').val()+"</span>,还需添加<span class=\"num\" id=\"tips_num\">"+num+"</span>期方案");
        else {
            if(update_type=='add') $('.plan_bottom .tips').html("方案添加完成，请点击右侧的发布按钮");
            else $('.plan_bottom .tips').html("方案添加完成，请点击右侧的更新按钮");
        }
        var nestnum=plan_list.length+1;
        $('#btn_add span').html('添加第'+nestnum+'期');

    }

}

//

function  click_public() {
    if(parent.parent.check_userlock()==false) return false;
    if(method==0 || method==2){
        if(method==0){
            var num=parseInt(document.querySelector('#expect_num').value)-parseInt(document.querySelector('#period_num').value);
            if(num>0){
                parent.layer.msg("最高连跟期数不能大于总期数",{ type: 1, anim: 2 ,time:1000});
                return false;
            }
        }

          if(plan_list.length<1){
              parent.layer.msg("您还没有设置方案",{ type: 1, anim: 2 ,time:1000});
              return false;
          }
    }
    else if(method==1){

    }
    else if(method==3){
        var num=parseInt(document.querySelector('#period_num').value)-parseInt(plan_list.length);
        if(num>0){
            parent.layer.msg("您一共设置了<span class='num'>"+$('#period_num').val()+"</span>,还需添加<span class=\"num\" id=\"tips_num\">"+num+"</span>期方案,才可发布",{ type: 1, anim: 2 ,time:1000});
            return false;
        }
    }

    var tips='计划将从<span style="color:#2319dc">'+document.querySelector('#period').value+'</span>期开始生效';
    if(method!=2){
        //document.querySelector('#period_num').value
        var from=0;
        for(var i=0;i<period_arr.length;i++){
            if(period_arr[i]==document.querySelector('#period').value){
                from=i;
                break;
            }
        }
        var to=from+parseInt(document.querySelector('#period_num').value);
        if(period_arr[to]){
            tips+="<br>截止到第<span style=\"color:#2319dc\">"+period_arr[to]+"</span>期 , 共<span style=\"color:#2319dc\">"+document.querySelector('#period_num').value+"</span>期";
        }

    }
    if(method==2){
        var a=document.querySelector('#expect_num').value;
        var b=plan_list.length;
        if(a>1){
            var c=a*b;
            tips+="<br>此方案预计可跟<span style=\"color:#2319dc\">"+b+'</span>至<span style="color:#2319dc">'+c+'</span>期';

        }

        else
            tips+="<br>此方案预计可跟<span style=\"color:#2319dc\">"+b+'</span>期';

    }
    tips+="<br>是否确认发布此计划？";
    tips="<div style='text-align: center'>"+tips+"</div>";

    var index=  layer.confirm(tips, {
        title:'发布提示',
        time: 20000, //20s后自动关闭
        btn: ['确认发布', '取消']
    },function () {
        //
        plan_public();
        layer.close(index)
    },function () {

    });
}

function  plan_public() {
    var data={method:method,gamekey:document.querySelector('#gamekey').value,money:paymoney,expect_from:document.querySelector('#period').value,wf1:wf1,wf2:wf2}
    if(method!=2) data.expect_sum=document.querySelector('#period_num').value;//总期数

    if(method!=3) data.expect_num=document.querySelector('#expect_num').value;//跟号期数
    else data.expect_num=1;
    if(method==1){
        data.number_type=document.querySelector('#number_type').value;//出号方式
        data.buynum=document.querySelector('#buynum').value;//购买注数
    }
    else{
        data.content=JSON.stringify(plan_list);//方案内容
    }
    $.post("../api/plan.php?act=add",data, function(result){
        console.log(result);
        result=JSON.parse(result);
        if(result.code==200){
            parent.layer.msg("发布成功",{ type: 1, anim: 2 ,time:1000});
            console.log(parent.showtype);
            if(parent.showtype=='list') parent.get_plan_list();
             setTimeout(function () {
                 var index = parent.layer.getFrameIndex(window.name);
                 parent.layer.close(index);
             },100)

        }
        else{
            parent.layer.msg(result.message,{ type: 1, anim: 2 ,time:1000});
        }
    });

}

function copy(text) {
    console.log(text);
    Clipboard.copy(text);
}
window.Clipboard = (function(window, document, navigator) {
    var textArea,
        copy;

    // 判断是不是ios端
    function isOS() {
        return navigator.userAgent.match(/ipad|iphone/i);
    }
    //创建文本元素
    function createTextArea(text) {
        textArea = document.createElement('textArea');
        textArea.innerHTML = text;
        textArea.value = text;
        document.body.appendChild(textArea);
    }
    //选择内容
    function selectText() {
        var range,
            selection;

        if (isOS()) {
            range = document.createRange();
            range.selectNodeContents(textArea);
            selection = window.getSelection();
            selection.removeAllRanges();
            selection.addRange(range);
            textArea.setSelectionRange(0, 999999);
        } else {
            textArea.select();
        }
    }

    //复制到剪贴板
    function copyToClipboard() {
        try{
            if(document.execCommand("Copy")){

                layer.msg('复制成功',{ type: 1, anim: 2 ,time:1000});
            }else{

                layer.msg('复制失败！请手动复制！',{ type: 1, anim: 2 ,time:1000});
            }
        }catch(err){

            layer.msg('复制错误！请手动复制！',{ type: 1, anim: 2 ,time:1000});

        }
        document.body.removeChild(textArea);
    }

    copy = function(text) {
        createTextArea(text);
        selectText();
        copyToClipboard();
    };

    return {
        copy: copy
    };
})(window, document, navigator);
function get_plan_list() {
  ////  var loading=layer.load(1);
    $.post("../api/plan.php?act=plan_list",{gamekey:gamekey,page:page,order:order,wanfa:wanfa,fee:fee,isonline:isonline}, function(result){
  /// layer.close(loading);
        result=JSON.parse(result);
          if(result.code==200){
            var data=result.data;
         //   console.log(data);
              showplan_html(data);
          }else{

              if(ismobile==1){
                  $("#loadmore").html("亲爱的，你滑到底了！");
              }

                  else{
                  $("#plan_list").html("<div class='nodata'>"+result.message+"</div>");
              }


              //layer.msg(result.message,{ type: 1, anim: 2 ,time:1000});
          }
          maxpage=result.maxpage;
          setpagehtml();

    });
}


function showplan_html(data) {
    var html="";
    if(ismobile==1){
        for(var i=0;i<data.length;i++){

            var item=data[i];
            html+=' <div class="item" id="plan_'+item.id+'">\n' +
                '                    <div class="title"  onclick="open_plan('+item.id+')">'+item['title']+'<span style="margin-left:8px;color: #eee;font-size: 12px;font-weight: normal;display: none" >'+item['num']+item['numshow']+'</span></div>\n' +
                '                    <div class="info"  onclick="open_plan('+item.id+')"><span class="wanfa">'+item['wanfa']+'</span> ['+item['num']+item['numshow']+'] ['+item['donum']+'/'+item['expect_num']+'期]</div>\n' +
                '                    <div class="info"  onclick="open_plan('+item.id+')">当前连中：'+item['prize_num']+',中奖率：'+item['rate']+'%</div>\n';
            if(item.buyinfo!='quit'){

                html+=' <div class="info"><span id="content_'+item.id+'">'+item.content+'</span></div>\n' ;

            }

            else html+='<div class="info">计划员近'+item.offline+'期未更新</div>';

            html+= '                    <div class="tools"> <i class=" icon-eye"></i>'+item.view+'</div>\n' +
                '     </div>';
        }

        $("#loadmore").html("加载更多...");

    }else{

        for(var i=0;i<data.length;i++){

            var item=data[i];
            html+=' <div class="item" id="plan_'+item.id+'">\n' +
                '                    <div class="title"  onclick="open_plan('+item.id+')">'+item['title']+'<span style="margin-left:8px;color: #eee;font-size: 12px;font-weight: normal;display: none" >'+item['num']+item['numshow']+'</span></div>\n' +
                '                    <div class="info"  onclick="open_plan('+item.id+')"><span class="wanfa">'+item['wanfa']+'</span> [ '+item['num']+item['numshow']+' ]［'+item['donum']+'/'+item['expect_num']+'期］</div>\n' +
                '                    <div class="info"  onclick="open_plan('+item.id+')">当前连中：'+item['prize_num']+'，中奖率：'+item['rate']+'%</div>\n';
            if(item.buyinfo!='quit'){

                html+=' <div class="info"><span id="content_'+item.id+'">'+item.content+'</span></div>\n' ;

            }

            else html+='<div class="info">计划员近'+item.offline+'期未更新</div>';

            html+= '                    <div class="tools"> <i class=" icon-eye"></i>'+item.view+'</div>\n' +
                '     </div>';
        }

    }
    if(page==1)
        $('#plan_list').html(html);
        else
    $('#plan_list').html(html);

}

function copy_item(id) {

    for(var i=0;i<plandata.length;i++){
        if(id==plandata[i].id){
            copy(plandata[i].buyinfo);
        }
    }
}
function open_plan(id) {

    return location.href="detail.php?id="+id;


    $('#plan_list').hide();
    $('#menulist').hide();
    $('.navlist').show();
    $('.page_container').hide();
    $('#newifr').show();
    $("#gamelist").hide();
    var isin=0;
    var ifr=document.querySelector('#newifr').querySelectorAll('iframe');

    for(var i=0;i<ifr.length;i++){

        if(ifr[i].id=='ifr_'+id){
            isin=1;
            ifr[i].style.display='';
        }
        else{
            ifr[i].style.display='none';
        }
    }

    if(isin==0){
        var html=" <iframe id='ifr_"+id+"' src='detail.php?id="+id+"'></iframe>";
        $("#newifr").append(html);
        var title=document.querySelector('#plan_'+id).querySelector('.title').innerHTML+'-'+document.querySelector('#plan_'+id).querySelector('.wanfa').innerHTML;
        $(".navlist p").append("<li class='active' id='nav_"+id+"' title='"+title+"' ><span onclick='open_plan("+id+");'>"+title+"</span><i class='icon-cancel-1' onclick='nav_close("+id+");' title='关闭'></i></li>")

    }
    else{

    }
    var li=document.querySelector('.navlist').querySelectorAll('li');
    for(var i=0;i<li.length;i++){
        if(li[i].id=='nav_'+id){
            li[i].className='active';
            if(i>5){
                var left= 120*i;
                li[i].scrollLeft=left+'px';
            }

        }else{
            li[i].className='';
        }
    }
}

function nav_close(id) {


    var ifr=document.querySelector('#newifr').querySelectorAll('iframe');
    if(ifr.length>1){
        for(var i=0;i<ifr.length;i++){

            if(ifr[i].id=='ifr_'+id){
                if(i>0)
                    ifr[i-1].style.display='';
                else
                    ifr[i+1].style.display='';
            }

        }
    }else{
        nav_closeall('close')
    }
    $("#nav_"+id).remove();
    $("#ifr_"+id).remove();

}

function nav_closeall(type) {
    $('#plan_list').show();
    $('#menulist').show();
    $('.navlist').hide();
    $('.page_container').show();
    $("#gamelist").show();
    $('#newifr').hide();
      if(type=='close'){
          $("#newifr").html("");
          $(".navlist p").html("");

      }
}


function setpagehtml() {
    if(ismobile==1){

        $('.page_container').hide();
    }else{

        if(maxpage==0){
            $('.page_container').hide();
        }
        else{
            $('.page_container').show();
            if(1==page) var active="active";
            else var active='';
            var html='<li class="number '+active+'" onclick="go_page(1);">1</li>';
            if(maxpage>1){
                var from=page-2;
                var more1=0;
                var more2=0;
                if(from<=2) from=2;
                else{
                    more1=1;
                }
                var to=from+4;
                if(to>=maxpage) to=maxpage;
                else {
                    more2=1;
                }
                if(more1==1) html+="<li class='number'>...</li>";
                for(var i=from;i<=to;i++){
                    if(i==page) var active="active";
                    else var active='';
                    html+="<li class='number "+active+"' onclick='go_page("+i+")'>"+i+"</li>";
                }
                if(more2==1) html+="<li class='number'>...</li>";

                if(to!=maxpage)html+="<li class='number' onclick='go_page("+maxpage+")'>"+maxpage+"</li>";
            }
            $('.el-pager').html(html);
        }

    }

}
function page_num(num) {
  page=page+num;
  if(page<1) page=1;
  if(page>maxpage) page=maxpage;
    get_plan_list();
}
function go_page(num) {
    page=num;
    get_plan_list();
}
function user_detail(id,group_id) {

    if(ismobile==1){

        var index=layer.open({
            type: 2,
            title: false,
            shadeClose: false,shade: 0.6,
            closeBtn:0,
            area: ['100vw', document.documentElement.clientHeight+'px'],
            content: '/user/detail.php?from=layer&id='+id+"&group_id="+group_id //iframe的url
        });

    }else{
        var index=layer.open({
            type: 2,
            title: false,
            shadeClose: true,shade: 0.6,
            area: ['500px','350px'],
            content: '/user/detail.php?from=layer&id='+id+"&group_id="+group_id  //iframe的url
        });

    }

}

function get_plan_detail() {


    $.post("../api/plan.php?act=plan_detail",{id:plan_id}, function(result){

        result=JSON.parse(result);
        if(result.code==200){
            var data=result.data;

            var html="";
            for(var i=0;i<data.list2.length;i++){
                var item=data.list2[i];
                html+="<div>"+item+"</div>";

            }
            rate=parseInt(data.rate);
            plannum=parseInt(data.plannum);
            $('#plan_list').html(html);
            $('.plan_list .frist').html(data.list1);
            $('#plan_count').html("<td>"+data.plannum+"期</td><td>"+data.rate+"%</td><td>"+data.prize_num+"</td><td>"+data.prize_max+"</td><td>"+data.lose_num+"</td><td>"+data.lose_max+"</td>")
            if(ismobile==1){
                $("#updatetime").html(formatTime(data.updatetime,'M-D h:m:s'));
                $("#title_btn").html(data.title_btn);
            }

                else
                $("#updatetime").html(formatTime(data.updatetime,'Y-M-D h:m:s'));
            $("#lostnum").html(data.lostnum);
            $("#plan_view").html(data.view);


    // console.log(data);
            if(data.isonline!=isonline){
                if(data.isonline==0){

                    layer.msg("计划员已下线",{ type: 1, anim: 2 ,time:1000});
                }else{
                   layer.msg("计划员上线了",{ type: 1, anim: 2 ,time:1000});
                }
            }
            isonline=data.isonline;
            if(ismobile==1) var str="计划员";
            else var str="";
            if(isonline==1){
                $('#online').html('<span class="online"><span class="dian"></span>'+str+'在线</span>');
            }
            else{
                $('#online').html('<span class="offline"><span class="dian"></span>'+str+'离线</span>');
            }

            var nav1=result.nav1;
            var html="";
            if(nav1.length>0){
                for(var i=0;i<nav1.length;i++){
                    html+="<li  onclick=\"location.href='detail.php?id="+nav1[i]['id']+"'\" title='" + nav1[i]['showtitle'] + "'>"+nav1[i]['showtitle']+"</li>";
                }
            }

            $('#game_nav1').html(html);


        }else{

        }

    });
}
function get_other_nav() {


    $.post("../api/plan.php?act=othertitle",{id:plan_id}, function(result){

        result=JSON.parse(result);
        if(result.code==200){
            var data=result.data;

            // // move_top();
              var nav1=result.nav2;
              var html="";
              if(nav1.length>0) {
                  for (var i = 0; i < nav1.length; i++) {
                      html += "<li  onclick=\"location.href='detail.php?id=" + nav1[i]['id'] + "'\" title='" + nav1[i]['othertitle'] + "'>" + nav1[i]['othertitle'] + "</li>";
                  }
              }
              $('#game_nav2').html(html);

        }else{

        }

    });
}

function plan_search() {

    $.post("../api/plan.php?act=searchid",{keyword:$('#keyword').val()}, function(result){

        result=JSON.parse(result);
        if(result.code==200){
            var data=result.data;
            location.href='detail.php?id='+data;

        }else{
            layer.msg(result.message,{ type: 1, anim: 2 ,time:1000});
        }

    });
}


function move_top() {
    var speed=200;
    var demo=document.querySelector('#game_nav1');
    var demo1=demo.querySelector('.con1');
    var demo2=demo.querySelector('.con2');

    demo2.innerHTML=demo1.innerHTML
    function Marquee(){
        console.log(demo2.offsetTop,demo.scrollTop,demo1.offsetHeight);
        if(demo2.offsetTop-demo.scrollTop<=30)
            demo.scrollTop-=demo1.offsetHeight
        else{
            demo.scrollTop++
        }
    }
    clearInterval(MyMar)
    var MyMar=setInterval(Marquee,speed)
    demo.onmouseover=function() {clearInterval(MyMar)}
    demo.onmouseout=function() {
        clearInterval(MyMar);
        MyMar=setInterval(Marquee,speed)}
}
function formatTime(number,format) {

    var formateArr  = ['Y','M','D','h','m','s'];
    var returnArr   = [];

    var date = new Date(number * 1000);
    returnArr.push(date.getFullYear());
    returnArr.push(formatNumber(date.getMonth() + 1));
    returnArr.push(formatNumber(date.getDate()));

    returnArr.push(formatNumber(date.getHours()));
    returnArr.push(formatNumber(date.getMinutes()));
    returnArr.push(formatNumber(date.getSeconds()));

    for (var i in returnArr)
    {
        format = format.replace(formateArr[i], returnArr[i]);
    }
    return format;
}

//数据转化
function formatNumber(n) {
    n = n.toString()
    return n[1] ? n : '0' + n
}

var layer11=null;
function show_ds_detail(content) {
   var html="<div class='ds_content'>"+content+"</div><div class='ds_bottom'><span class='btns cancel' onclick='layer.close(layer11);'><i class='icon-cancel'></i>关闭</span><span class='btns ok' onclick='copy(\""+content+"\")'><i class='icon-edit'></i>复制</span></div>"
   if(ismobile==1){
       layer11= layer.open({
           type: 1,
           title: false,
           closeBtn: 1,
           shadeClose: true,
           area:['90%','250px'],
           content: html
       });

   }else{

       layer11= layer.open({
           type: 1,
           title: false,
           closeBtn: 1,
           shadeClose: true,
           area:['450px','250px'],
           content: html
       });
   }

}

function selected(id,value) {
    var option=document.querySelector('#'+id).querySelectorAll('option');
    for(var i=0;i<option.length;i++){
        if(option[i].value==value) option[i].selected=true;
        else option[i].selected=false;
    }
}

function  set_plan_edidstatus() {
    if(plan_status==1){
        $('#period_name').html("新增期数：")
        $("#period_name1").hide();
        $("#period").hide();
    }else{
        $('#period_name').html("起始期号：")
        $("#period_name1").show();
        $("#period").show();

    }

    if(method==2 ){

        if(plan_status==0){
            $('#content_tips').html(",未开始")
        }else if(plan_status==1){

             if(method==2) {
                 var lastnum=parseInt(planinfo.dosum);
                 $('#content_tips').html(",已进行<span style='color: #ff4d51'>"+lastnum+"</span>套");
             }
             else{
                 var lastnum=parseInt(planinfo.plantimes);
                 $('#content_tips').html(",已进行<span style='color: #ff4d51'>"+lastnum+"</span>期");
             }


        }
        else  if(plan_status==2){
            $('#content_tips').html("方案跟完则计划结束");
            $('#period_tips').html("已完结，请更新")
        }
    }else{


        if(plan_status==0){
            $('#period_tips').html("未开始")
        }else if(plan_status==1){
            var lastnum=parseInt(planinfo.expect_sum)-parseInt(planinfo.plantimes);
            $('#period_tips').html("剩余<span style='color: #ff4d51'>"+lastnum+"</span>期");

        }
        else  if(plan_status==2){
            $('#period_tips').html("已完结，请更新")
        }
        change_expect_num(document.querySelector('#expect_num').value);

    }

    if(plan_status==1){
        $('#clear_btn').hide();
    }
    else{
        $('#clear_btn').show();
    }
    if(method==2 && plan_status==1){
        $('#period_line').hide();
    }
    else{
        $('#period_line').show();
    }

}

function  set_plan_content() {
    if(method!=1){

        try{
            var content=JSON.parse(planinfo.content);

            $('#content_num').html(content.length);
            buynum=planinfo.num;
            for(var i=0;i<content.length;i++){
                var item=content[i];

                var wfname=document.querySelector('#wanfa').options[document.querySelector('#wanfa').selectedIndex].text+document.querySelector('#wanfa1').options[document.querySelector('#wanfa1').selectedIndex].text;
                plan_list.push({wf1:item.wf1,wf2:item.wf2,num:item.num,content:item.content});
                var html="<ul id='box_"+plan_list.length+"'>";
                if(method==3){
                    html+="<li class='fnname'>第"+plan_list.length+"期</li>";
                }else
                    html+="<li class='fnname'>方案"+plan_list.length+"</li>";
                html+="<li>"+wfname+"</li>";
                html+="<li title='"+item.content+"'>"+item.content+"</li>";
                html+="<li>"+item.num+"</li>";
                if(method==2 && plan_status==1 && i<= planinfo.dosum-1){
                    html+="<li></li>";
                }
                else if(method==3 && plan_status==1 && i<= planinfo.plantimes-1){
                    html+="<li></li>";
                }
                else
                    html+="<li class='fndelete'><i class='icon-trash' title='删除该方案' onclick='delete_addbox(plan_list.length);'></i> </li>";
                html+="</ul>";
                $('.area_box').append(html);
            }

            $('.area_box').show();

        }catch(e){

        }

    }
    else{
        $('.area_box').hide();
    }


    var index = parent.layer.getFrameIndex(window.name);
    parent.layer.iframeAuto(index);
}

function  click_update() {
    if(parent.parent.check_userlock()==false) return false;
    if(plan_status==1 && method!=1){
        if(document.querySelector('#period_num').value<1){
            layer.msg("不能更新0期",{ type: 1, anim: 2 ,time:1000});
            return false;
        }

    }

    if((method==0 || method==2) && plan_status!=1){
        if(method==0){
            var num=parseInt(document.querySelector('#expect_num').value)-parseInt(document.querySelector('#period_num').value);
            if(num>0){
                parent.layer.msg("最高连跟期数不能大于总期数",{ type: 1, anim: 2 ,time:1000});
                return false;
            }
        }

        if(plan_list.length<1){
            parent.layer.msg("您还没有设置方案",{ type: 1, anim: 2 ,time:1000});
            return false;
        }
    }
    else if(method==1){

    }
    else if(method==3){
        if(plan_list.length<1){
            var content=JSON.parse(planinfo.content)
            var len=content.length;
        }
        else var len=plan_list.length;

        if(plan_status!=1){
            var num=parseInt(document.querySelector('#period_num').value)-len;
            if(num>0){
                parent.layer.msg("您一共设置了<span class='num'>"+$('#period_num').val()+"</span>,还需添加"+num+"期方案,才可更新",{ type: 1, anim: 2 ,time:1000});
                return false;
            }

        }else{
            var sum=parseInt(document.querySelector('#period_num').value)+parseInt(planinfo.expect_sum);
            var num=sum-len;
            if(num>0){
                parent.layer.msg("您一共增加了<span class='num'>"+sum+"</span>,还需添加"+num+"期方案,才可更新",{ type: 1, anim: 2 ,time:1000});
                return false;
            }

        }

    }
    if(plan_status!=1)
    var tips='计划将从<span style="color:#2319dc">'+document.querySelector('#period').value+'</span>期开始生效';
    else var tips="计划将从下期开始生效";
    if(method!=2  && plan_status!=1){
        //document.querySelector('#period_num').value
        var from=0;
        for(var i=0;i<period_arr.length;i++){
            if(period_arr[i]==document.querySelector('#period').value){
                from=i;
                break;
            }
        }
        var to=from+parseInt(document.querySelector('#period_num').value);
        if(period_arr[to]){
            tips+="<br>截止到第<span style=\"color:#2319dc\">"+period_arr[to]+"</span>期 , 共<span style=\"color:#2319dc\">"+document.querySelector('#period_num').value+"</span>期";
        }

    }
    if(method==2){
        var a=document.querySelector('#expect_num').value;
        var b=plan_list.length;
        if(a>1){
            var c=a*b;
            tips+="<br>此方案预计可跟<span style=\"color:#2319dc\">"+b+'</span>至<span style="color:#2319dc">'+c+'</span>期';

        }

        else
            tips+="<br>此方案预计可跟<span style=\"color:#2319dc\">"+b+'</span>期';

    }

    tips+="<br>是否确认更新此计划？";
    tips="<div style='text-align: center'>"+tips+"</div>";

    var index=  layer.confirm(tips, {
        title:'更新提示',
        time: 20000, //20s后自动关闭
        btn: ['确认更新', '取消']
    },function () {
        //
        plan_update();
        layer.close(index)
    },function () {

    });
}

function  plan_update() {
    var data={id:plan_id,money:paymoney,expect_from:document.querySelector('#period').value}
    if(method!=2) data.expect_sum=document.querySelector('#period_num').value;//总期数
    if(method!=3) data.expect_num=document.querySelector('#expect_num').value;//跟号期数
    else data.expect_num=1;
    if(method==1){
        data.number_type=document.querySelector('#number_type').value;//出号方式
        data.buynum=document.querySelector('#buynum').value;//购买注数
    }
    else{
        data.content=JSON.stringify(plan_list);//方案内容
    }

    $.post("../api/plan.php?act=edit",data, function(result){

        result=JSON.parse(result);
        if(result.code==200){
            parent.layer.msg("更新成功",{ type: 1, anim: 2 ,time:1000});

              //console.log(update_type);
            if(parent.showtype=='detail') parent.get_plan_detail();
            if(parent.showtype=='list') parent.get_plan_list();
            setTimeout(function () {
                var index = parent.layer.getFrameIndex(window.name);
                parent.layer.close(index);
            },100)

        }
        else{
            parent.layer.msg(result.message,{ type: 1, anim: 2 ,time:1000});
        }
    });

}


function click_action() {

    if(userid>0){
        $.post("../api/plan.php?act=action",{id:plan_id}, function(result){

            result=JSON.parse(result);
            if(result.code==200){

                if(ismobile==1){

                    if(result.data==1){
                        var html='<p><i class="icon-star" style="color:#2319dc;"></i></p><p>取消收藏</p>';
                    }else{
                        var html='<p><i class="icon-star"></i></p><p>收藏</p>'
                    }
                }
                else{
                    if(result.data==1){
                        var html='<i class="icon-star" style="color:#00FF00;"></i>取消收藏';
                    }else{
                        var html='<i class="icon-star" ></i>收藏计划'
                    }
                }

               $('#action_btn').html(html);

            }
            else{
               layer.msg(result.message,{ type: 1, anim: 2 ,time:1000});
            }
        });
    }else{
        parent.layerlogin();
    }
}

function click_useraction(touid) {

    if(userid>0){
        $.post("../api/plan.php?act=useration",{touid:touid}, function(result){

            result=JSON.parse(result);
            console.log(result);
            if(result.code==200){
                if(ismobile==1){
                    if(result.data==1){
                        var html=' <p onclick="user_detail('+touid+');"><i class="icon-credit-card"></i></p><p>名片</p>';

                    }else{
                        var html='<p onclick="click_useraction('+touid+');"><i class="icon-heart"></i></p><p>关注</p>';

                    }

                }else{
                    if(result.data==1){
                        var html='<span class="btn"  onclick="parent.user_detail('+touid+');">名片</span>';

                    }else{
                        var html='<span class="btn"  onclick="click_useraction('+touid+');">关注</span>';

                    }

                }

                $('#useraction').html(html);
                layer.msg(result.message,{ type: 1, anim: 2 ,time:1000});
            }
            else{
                layer.msg(result.message,{ type: 1, anim: 2 ,time:1000});
            }
        });
    }else{
        parent.layerlogin();
    }
}


function click_plan_detail(id) {
  parent.window.open('/pc.php?url='+encodeURIComponent('/plan/detail.php?id='+id)+"#/plan");
    var index = parent.layer.getFrameIndex(window.name);
    parent.layer.close(index);
}

function click_plan_delete(id) {

    var index=  layer.confirm("删除将会影响用户打赏或付费，请问是否继续删除？", {
        title:'提示',
        time: 20000, //20s后自动关闭
        btn: ['继续删除', '取消']
    },function () {
        $.post("../api/plan.php?act=plan_delete",{id:id}, function(result){
            result=JSON.parse(result);
            console.log(result);
            if(result.code==200){

                parent.layer.msg(result.message,{ type: 1, anim: 2 ,time:1000});
                location.reload();
            }
            else{
                parent.layer.msg(result.message,{ type: 1, anim: 2 ,time:1000});
            }
        });
        layer.close(index);
    },function () {

    });



}

function plan_buy(id) {
   click_pay('plat_buy',id);
}

function click_pay(type,id) {

    if(parent.userid>0){
        if(type=='reward'){
            if(rate>=reward_rate && plannum>=reward_expect){


            }else{

                layer.msg("中奖率>="+reward_rate+'%,当日期数>='+reward_expect+',才能进行打赏',{ type: 1, anim: 2 ,time:1500});
                return false;
            }


        }
        var index= layer.open({
            type: 2,
            title: false,
            shadeClose: true,
            shade: 0.6,
            area: ['300px','300px'],
            content: '/user/pay.php?from=layer&type='+type+"&id="+id //iframe的url
        });

    }
    else{
        parent.showlogin();
    }


}

function user_plan(uid) {

    if(parent.userid>0){
        var index= layer.open({
            type: 2,
            title: false,
            shadeClose: true,
            shade: 0.6,
            area: ['500px','520px'],
            content: '/plan/user_plan.php?from=layer&id='+uid //iframe的url
        });

    }else{


        parent.showlogin();
    }


}

function plan_apply() {
    if(parent.userid>0){

        $.post("../api/user.php?act=ismobile",{}, function(result){

            result=JSON.parse(result);
            if(result.code==200){
                var index= layer.open({
                    type: 2,
                    title: false,
                    shadeClose: true,
                    shade: 0.6,
                    area: ['380px','500px'],
                    content: '/plan/apply.php?from=layer' //iframe的url
                });

            }
            else{
                var index=  layer.confirm("您还没有绑定手机号，不能申请计划员", {
                    title:'提示',
                    time: 20000, //20s后自动关闭
                    btn: ['绑定手机', '取消']
                },function () {
                    parent.layer.open({
                        type: 2,
                        title: false,

                        shadeClose: true,
                        shade: 0.6,
                        area: ['500px','500px'],
                        content: 'user/index.php?from=layer&step=2' //iframe的url
                    });

                 layer.close(index);
                },function () {

                });
            }
        });


    }else{


        parent.showlogin();
    }

}
function set_updown(id) {
    var li=  document.querySelector('#'+id).querySelectorAll('li');
    if(li.length>1){

        for(var i=0;i<li.length;i++){
            //  console.log(li[i].className);

            if(li[i].className=='active'){

                li[i].className='up'
                if(i==li.length-1) var num=0;
                else var  num=i+1;
                li[num].className='active';
                break;
            }
        }

        setTimeout(function () {
            for(var i=0;i<li.length;i++){
                li[i].style.display='block';
                if(li[i].className=='up'){
                    li[i].style.display='none';
                    li[i].className=''
                }
            }
        },1000)

    }

}


function set_updown1(id) {
    var ul= document.querySelector('#'+id);
    var list1=  document.querySelector('#'+id).querySelector('.list1');
    var list2=  document.querySelector('#'+id).querySelector('.list2');
    list2.innerHTML=list1.innerHTML;
    if(ul.scrollTop>=list1.offsetHeight) ul.scrollTop=0;
    for(var i=1;i<=30;i++){

        setTimeout(function () {
            ul.scrollTop++;
        },10*i)
    }
  //

}

function plan_task() {
    if(parent.userid>0){
        var index= layer.open({
            type: 2,
            title: false,
            shadeClose: true,
            shade: 0.6,
            area: ['450px','500px'],
            content: '/plan/task.php?from=layer' //iframe的url
        });

    }else{


        parent.showlogin();
    }

}

function plan_toplist() {

        var index= layer.open({
            type: 2,
            title: false,
            shadeClose: true,
            shade: 0.6,
            area: ['500px','500px'],
            content: '/plan/toplist.php?from=layer' //iframe的url
        });


}