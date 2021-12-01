function click_gameplan(id,type) {
    if(type=='ssc' || type=='ffc'){
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
    $.get("../api/index.php?act=lotterylist",{lotteryId:game_id,current:1,pageSize:6}, function(result){
        result=JSON.parse(result);
        if(result.data.records.length>0){
            var res=result.data.records[0];
            if( lottery_period!=res.issueNo  && lottery_period.length>5){
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
                var history=result.data.records;
                var html='';
                for(var i=1;i<history.length;i++){
                    html+="<ul>";
                    html+=" <li>第<div style=\"display: inline-block;color:#2319dc !important;;\">"+history[i].issueNo+"</div>期</li>";
                    html+="<li>";
                    var opencode=history[i].openCode.split(',');
                    for(var j=0;j<opencode.length;j++){
                        html+="<span class='ball'>"+opencode[j]+"</span>\n";
                    }
                    html+="</li>";
                    html+="</ul>";
                }

                $('#history_bg').html(html);

            }
        }
    });
}


function plan_edit(id) {
    // layer.open({
    //     type: 2,
    //     title: false,
    //     shadeClose: false,shade: 0.6,
    //     area: ['600px','600px'],
    //     content: '/plan/edit.php?from=layer&id='+id //iframe的url
    // });

    location.href='/plan/edit.php?from=layer&id='+id ;
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
         // layer.msg("最高连跟期数不能超过当前总期数",{ type: 1, anim: 2 ,time:1000});
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
function change_game(id) {
    if(update_type=='edit') var id1=plan_id;
    else var id1=0;
    $.post("../api/plan.php?act=planinfo",{gamekey:id,id:id1}, function(result){

        result=JSON.parse(result);
        var data=result.data;
     //   console.log(result);
        if(data!=false){
            game_id=data.id;
            var period=data.period;
            lasttime=period.lastsecond;
            lottery_period=period.period;
            lottery_list=JSON.parse(data.lottery);
            listen_period();
            yilou();
            $('#open_time').html(period.end);
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

    });

}

function get_nextplan(id) {
    if(update_type=='edit') var id1=plan_id;
    else var id1=0;
    $.post("../api/plan.php?act=planinfo",{gamekey:id,id:id1}, function(result){
        result=JSON.parse(result);
        var data=result.data;
        if(data!=false && data.period.period!=period_temp){

            var period=data.period;
            period_temp=period.period;
            lottery_list=JSON.parse(data.lottery);
            yilou();
            clearInterval(timer66);
            if(update_type=='edit'){
                //更新计划状态
                clearInterval(timer77);
                timer77=setInterval(function () {
                    get_plan_status();
                },2000)
            }

        }

    });
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
    }else{
        period_temp=lottery_period;
      layer.msg("第"+lottery_period+"期已结束",{ type: 1, anim: 2 ,time:1000});
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

function change_wf(value) {

    var res=wanfa_json[value];
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
            str+="<option value='"+ii+"' "+select+">"+res[ii]+"</option>";
        }

        $('#wanfa1').html(str);
        set_playhtml(wf1,wf2);


    }

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
        if(type=='da'){
            if( parseInt(span[i].innerHTML)>4)
                span[i].className='active';
            else  span[i].className='';
        }
        if(type=='xiao'){
            if( parseInt(span[i].innerHTML)<=4)
                span[i].className='active';
            else  span[i].className='';
        }
        if(type=='dan'){
            if( parseInt(span[i].innerHTML)%2==1)
                span[i].className='active';
            else  span[i].className='';
        }
        if(type=='shuang'){
            if( parseInt(span[i].innerHTML)%2==0)
                span[i].className='active';
            else  span[i].className='';
        }
    }
    count_num();

}

function showtools(num) {
    var html="<div class='tools'>";

    html+="<span onclick='set_tools("+num+",\"all\")'>全</span>";
    html+="<span onclick='set_tools("+num+",\"other\")'>反</span>";
    html+="<span onclick='set_tools("+num+",\"da\")'>大</span>";
    html+="<span onclick='set_tools("+num+",\"xiao\")'>小</span>";
    html+="<span onclick='set_tools("+num+",\"dan\")'>单</span>";
    html+="<span onclick='set_tools("+num+",\"shuang\")'>双</span>";
    html+="<span onclick='set_tools("+num+",\"clear\")'>清</span>";
    html+="</div>";

    return html;
}

function set_playhtml(value1,value2) {
    wf2=value2;
    //  console.log(value1,value2);
    var str="";
    if(number_trend=='loss') var trend_name='遗漏';else var trend_name='冷热';
    if(value1=='dwd'){
        var num=1;
        var title=wanfa_json[value1][value2];
        for(var i=0;i<num;i++){
            str+="<ul>";
            str+="<li><span class='title'>"+title+"</span>"+showtools(i)+"</li>";
            str+="<li class='num'>";
            str+="<div>";
            for(var j=0;j<=9;j++){
                str+="<ol><span onclick='click_num(this);'>"+j+"</span></ol>";
            }
            str+="</div>";
            str+="<div>";
            for(var j=0;j<=9;j++){
                str+="<p >0</p>";
            }
            str+="</div>";

            str+="</li>";

            str+="</ul>";
        }
    }
    else  if(value2=='fs'){
        var wei=['万位','千位','百位','十位','个位']
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
            str+="<li><span class='title' onclick='click_num(this);'>"+title+"</span>"+showtools(i)+"</li>";
            str+="<li  class='num'>";
            str+="<div>";
            for(var j=0;j<=9;j++){
                str+="<ol><span onclick='click_num(this);'>"+j+"</span></ol>";
            }
            str+="</div>";
            str+="<div>";
            for(var j=0;j<=9;j++){
                str+="<p>0</p>";
            }
            str+="</div>";
            str+="</li>";
            str+="</ul>";
        }

    }
    else if(value2=='z3' || value2=='z6'){
        if(value2=='z3') var title='组三';
        else var title='组六';
        str+="<ul>";
        str+="<li><span class='title'>"+title+"</span>"+showtools(0)+"</li>";
        str+="<li  class='num'>";
        str+="<div>";
        for(var j=0;j<=9;j++){
            str+="<ol><span onclick='click_num(this);'>"+j+"</span></ol>";
        }
        str+="</div>";
        str+="<div>";
        for(var j=0;j<=9;j++){
            str+="<p>0</p>";
        }
        str+="</div>";
        str+="</li>";
        str+="</ul>";
    }
    else if(value1=='lhh'){
        var wei=['万','千','百','十','个'];
        var arr=value2.split('-');
        var title=wei[arr[0]]+wei[arr[1]];
        str+="<ul>";
        str+="<li style='width: 70px;clear: none;vertical-align: top;margin-top: 15px;margin-left:45px;'><span class='title' style='vertical-align: middle' >"+title+"</span></li>";
        str+="<li  class='num' style='width: 150px;clear: none'>";
        var pos=['龙','虎','和']

        str+="<div>";
        for(var j=0;j<pos.length;j++){
            str+="<ol><span onclick='click_num(this);'>"+pos[j]+"</span></ol>";
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
        for(var j=0;j<p.length;j++){
            if(wf1=='dwd')  p[j].innerHTML=getlou_num(j,0);
            else if(wf2=='fs'){
                var from=0;
                if(wf1=='4x2')  from=1;
                if(wf1=='3x3')  from=1;
                if(wf1=='2x2')  from=3;
                var pos=from+i;
                p[j].innerHTML=getlou_num(j,pos);
            }
            else if(wf1=='lhh'){
                p[j].innerHTML=getlou_num(j,0);
            }
            else if(wf2=='z3' || wf2=='z6'){
                var from=0;
                if(wf1=='4x2')  from=1;
                if(wf1=='3x2')  from=2;
                if(wf1=='3x3')  from=1;
                if(wf1=='2x2')  from=3;
                p[j].innerHTML=getlou_num(j,from);
            }

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

function getlou_num(num,pos) {
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
            else if(wf2=='fs'){
                if(number[pos]==num){
                    return sum;
                }else sum++;
            }
            else if(wf1=='lhh'){
                var arr=wf2.split('-');
                var cha=number[arr[0]]-number[arr[1]];
                if(num==0){
                    if(cha>0) return sum;
                    else sum++;
                }
                else if(num==1){
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
            else if(wf2=='fs'){
                if(number[pos]==num){
                    sum++;
                }
            }
            else if(wf1=='lhh'){
                var arr=wf2.split('-');
                var cha=number[arr[0]]-number[arr[1]];
                if(num==0){
                    if(cha>0) return sum++;

                }
                else if(num==1){
                    if(cha<0) return sum++;

                }
                else{
                    if(cha==0) return sum++;

                }
            }
            else  if(wf2=='z3'){
                if(number[pos]!=number[pos+1]  && number[pos]!=number[pos+2] && number[pos+1]!=number[pos+2]  ){
                    sum++;
                }else{
                    if(num==number[pos] || num==number[pos+1] || num==number[pos+2]){
                        return sum++;
                    }
                }

            }
            else  if(wf2=='z6'){
                if(number[pos]!=number[pos+1]  && number[pos]!=number[pos+2] && number[pos+1]!=number[pos+2]  ){
                    if(num==number[pos] || num==number[pos+1] || num==number[pos+2]){
                        return sum++;
                    }
                }
            }
        }
    }


    return sum;
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
    if(wf1=='dwd' || wf1=='lhh'){
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
    $('#plan_num').html(plan_num);
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
            // parent.parent.open_chatarea(0,admin_nickname,admin_logo);
            // document.querySelector('#diywf').checked=false;
            // layer.close(index);
            location.href='/chat/chatuser.php?id=0';
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
            // parent.parent.open_chatarea(0,admin_nickname,admin_logo);
            // document.querySelector('#diywf').checked=false;
            // layer.close(index);
            location.href='/chat/chatuser.php?id=0';
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
                str+=p[j].innerHTML;
            }

        }
    }

    return str;
}

function check_plannum() {
    var max=0;
    if(wf1=='dwd'){
        max=7;
    }
    else if(wf2=='ds' || wf2=='fs'){
        if(wf1=='4x1' || wf1=='4x2'){
            max=7000;
        }
        else if(wf1=='2x1' || wf1=='2x2'){
            max=70;
        }
        else max=700;

    }
    else if(wf2=='z3' || wf2=='z6'){
        max=56;
    }
    else if(wf1=='lhh'){
        max=2;
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

        if(parseInt(plan_num)!=parseInt(planinfo.num)  && wf2!='ds'){

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

            if(method==3 || wf2=='ds'){

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
    if(check_userlock()==false) return false;
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
       /// console.log(result);
        result=JSON.parse(result);
        if(result.code==200){
           layer.msg("发布成功",{ type: 1, anim: 2 ,time:1000});

           // console.log(parent.showtype);
         //   if(parent.showtype=='list') parent.get_plan_list();
            setTimeout(function () {
                window.location.href=document.referrer;
            },500)

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

            showplan_html(data);
        }else{

            if(ismobile==1){
                if(page==1)         $("#plan_list").html("<div class='nodata'>"+result.message+"</div>");
                else {
                    $("#loadmore").html("亲爱的，你滑到底了！");
                }

            }

            else{
                $("#plan_list").html("<div class='nodata'>"+result.message+"</div>");
            }


            //layer.msg(result.message,{ type: 1, anim: 2 ,time:1000});
        }


    });
}


function showplan_html(data) {
    var html="";
    if(ismobile==1){
        for(var i=0;i<data.length;i++){

            var item=data[i];

            if(item.status==2) var style="style='background-color:#eee'";
            else var style='';
            html+=' <div class="item" id="plan_'+item.id+'"  '+style+'>\n' +
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
        $('#plan_list').append(html);

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

            $('#plan_list').html(html);
            $('.plan_list .frist').html(data.list1);
            if(parseInt(data.prize_num)>0){
                var color1="style='color:#ff0000;'";
            }
            else var color1="";
            if(parseInt(data.lose_num)>0){
                var color2="style='color:green;'";
            }
            else var color2="";
            rate=parseInt(data.rate);
            plannum=parseInt(data.plannum);
            $('#plan_count').html("<td>"+data.plannum+"期</td><td>"+data.rate+"%</td><td "+color1+">"+data.prize_num+"</td><td>"+data.prize_max+"</td><td "+color2+">"+data.lose_num+"</td><td>"+data.lose_max+"</td>")
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


}

function  set_plan_content() {
    if(method!=1){
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

    }
    else{
        $('.area_box').hide();
    }


    var index = parent.layer.getFrameIndex(window.name);
    parent.layer.iframeAuto(index);
}

function  click_update() {
    if(check_userlock()==false) return false;
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
              layer.msg("最高连跟期数不能大于总期数",{ type: 1, anim: 2 ,time:1000});
                return false;
            }
        }

        if(plan_list.length<1){
           layer.msg("您还没有设置方案",{ type: 1, anim: 2 ,time:1000});
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
            layer.msg("更新成功",{ type: 1, anim: 2 ,time:1000});

            //console.log(update_type);
            setTimeout(function () {
                window.location.href='/plan/detail.php?id='+plan_id;
            },500)

        }
        else{
            parent.layer.msg(result.message,{ type: 1, anim: 2 ,time:1000});
        }
    });

}




function click_plan_detail(id) {
    // parent.window.open('/pc.php?url='+encodeURIComponent('/plan/detail.php?id='+id)+"#/plan");
    // var index = parent.layer.getFrameIndex(window.name);
    // parent.layer.close(index);

    location.href='/plan/detail.php?id='+id;
}
function click_plan_detail1(id) {
    // parent.window.open('/pc.php?url='+encodeURIComponent('/plan/detail.php?id='+id)+"#/plan");
    // var index = parent.layer.getFrameIndex(window.name);
    // parent.layer.close(index);

    parnet.location.href='/plan/detail.php?id='+id;
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


function user_plan(uid) {


        var index= layer.open({
            type: 2,
            title: false,
            shadeClose: false,
            closeBtn:false,
            shade: 0.6,
            area: ['100vw', document.documentElement.clientHeight+'px'],
            content: '/plan/user_plan.php?from=layer&id='+uid //iframe的url
        });


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

function click_head_nav(num) {
    var li=document.querySelector('#head_nav').querySelectorAll('.item');
    for(var i=0;i<li.length;i++){
        if(i==num) {
            li[i].className='item active';

        }
        else {
            li[i].className="item";
        }
    }

}

function plan_shownav() {
    task_close();
    toplist_close();
}
function task_close() {
    $('.planbox').show();
    $("#ifr").removeClass('active');
    click_head_nav(0);
}
function plan_task() {
    if(userid>0){
        click_head_nav(2);
      $('.planbox').hide();
      $("#ifr").attr('src','/plan/task.php?from=layer' );
      $("#ifr").addClass('active');
        toplist_close();

    }else{
          showlogin();
    }

}
function toplist_close() {

    $("#ifr1").removeClass('active');

}
function plan_toplist() {



    click_head_nav(1);
    $('.planbox').hide();
    $("#ifr1").attr('src','/plan/toplist.php?from=layer' );
    $("#ifr1").addClass('active');
    $("#ifr").removeClass('active');
}