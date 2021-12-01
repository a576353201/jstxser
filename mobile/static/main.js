var last_issue={};
function setCookie (name, value) {
    if (value) {
        var days = 1; //定义一天
        var exp = new Date();
        exp.setTime(exp.getTime() + days * 24 * 60 * 60 * 1000);
// 写入Cookie, toGMTString将时间转换成字符串
        document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString;
    }
}
function getloattey(id) {
    setCookie('gameid1',id);
    $.get("api/index.php?act=lotterylist",{lotteryId:id,current:page}, function(result){
        result=JSON.parse(result);
   //  console.log(result.data);
        if(result.data.records.length>0){
            if(page>1)
             $('#lottery_'+id).append(lotteryshow(result.data.records));
            else {
                last_issue[id]=result.data.records[0].issueNo;
                $('#lottery_'+id).html(lotteryshow(result.data.records));

            }
            page++;
            $('#tips_'+id).hide();
          //  layer.close(layer_loading);
            if(id==gameid){
                clearInterval(lotteryTime);
                lottime=parseInt(result.data.records[0]['lastsecond'])
                lotteryTime=   setInterval(function () {
                    setlotterytime();
                },1000);
            }

        }else{
           nodata(id);
        }

    });
}

function getlotteyupdate(id) {
    $.get("api/index.php?act=lotterylist",{lotteryId:id,current:1,pageSize:1}, function(result){
        result=JSON.parse(result);

        if(result.data.records.length>0){

            if( last_issue[id]<result.data.records[0].issueNo){
                $('#lottery_'+id).prepend(lotteryshow(result.data.records));
                last_issue[id]=result.data.records[0].issueNo;

                if(id==gameid){
                    clearInterval(lotteryTime);
                    lottime=parseInt(result.data.records[0]['lastsecond'])
                    lotteryTime=   setInterval(function () {
                        setlotterytime();
                    },1000);
                }

            }

        }

    });
}

var lotteryTime=null;
var lottime=0;
function lotteryshow(data) {

    var html='';
    for(var i=0;i<data.length;i++){
       // console.log(data[i]);
        var time= data[i]['predictedTime'].substr(5,14);
        var code=data[i]['openCode'].split(',');
        var ball='';
       var gametype=data[0]['gametype'];
        for(var j=0;j<code.length;j++){

            if(data[i]['gametype']=='k3'){

                ball+="<span class='"+data[i]['gametype']+" num_"+code[j]+"'></span>";
            }
            else if(data[i]['gametype']=='pk10'){

                    ball+="<span class='"+data[i]['gametype']+" num_"+code[j]+"'>"+code[j]+"</span>";
            }
            else
            ball+="<span class='ball "+data[i]['gametype']+"'>"+code[j]+"</span>";

        }
     if(data[i]['SX']>0) var sx="<span class='zx"+data[i]['SX']+"' style='font-size: 12px;float: right;'>组选"+data[i]['SX']+"</span>";
        else var sx="";
        html+='<div class="item" >';

        html+="<div><span class='issue'>"+data[i]['issueNo']+"期</span><span class='time'>"+time+"</span></div>";
        if(i==0){
            var code_loading='code_loading';

        }
        else var code_loading='';
        if(gametype=='ssc' || gametype=='ffc')
            html+="<div class='"+code_loading+"'>"+ball+sx+"</div>";
       else  if(gametype=='k3' )
            html+="<div class='"+code_loading+"' style='padding-left:72px;'>"+ball+"</div>";
            else
        html+="<div class='"+code_loading+"'>"+ball+"</div>";
        html+="</div>";


    }
  return html;
}

function setlotterytime() {
  var   lost_s=lottime;
    if(lost_s<=0){

        clearInterval(lotteryTime);

     $('#lottery_time').html("开奖中");
    }else{
        lottime--;
        var l_s=Math.floor(lost_s%60);
        var next_s=Math.floor(lost_s/60);
        var l_m=Math.floor(next_s%60);
        var next_m=Math.floor(next_s/60);
        var l_h=Math.floor(next_m%60);
        if(l_h-10<0){n_h="0"+(l_h);}else{n_h=(l_h);}
        if(l_m-10<0){n_m="0"+(l_m);}else{n_m=(l_m);}
        if(l_s-10<0){n_s="0"+(l_s);}else{n_s=(l_s);}
        if(n_h!='00') var hh = n_h+":";
        else var hh='';
        var str=hh+n_m+':'+n_s;

        $('#lottery_time').html(str);
    }


}


function change_game(id) {
    game_id=gameid=id;

   // document.querySelector('.ifmbox').style='transform:translateX(-'+w+'vw);'
    document.querySelector('#trend_ifr').src="mobile/trend.php?id="+id;
    // var contentWindow= document.querySelector('#trend_ifr').contentWindow;
    // contentWindow.go_next(id);
    page=1;
    getloattey(id);

    var div='lottery_'+id;
document.getElementById(div).scrollTop='0px';
   // hide_trend();
clearInterval(timer);
 timer=   setInterval(function () {
        getlotteyupdate(id);
    },3000)
var num=0;
    for(var i=0;i<gamedata.length;i++){
     if(gamedata[i].id==id){
         $('#gamename').html(gamedata[i].title);
         $('#header_title').html(gamedata[i].title);

         num=i;
     }

    }
    var w=num*100;

    document.querySelector('.lotterybox').style='transform:translateX(-'+w+'vw);'
    document.querySelector('.gamenav').className='gamenav';
    document.querySelector('#gameicon').className='icon-down-open';

    if(game_id>27){
        $('#header_title').show();
        $('#header_nav').hide();
    }else {
        $('#header_title').hide();
        $('#header_nav').show();

    }


}

function gamenext(type) {
    var num=0;
    for(var i=0;i<gamedata.length;i++){

        if(gamedata[i]['id']==gameid){

            num=i+type;
            break;
        }
    }
    if(num<0) num=gamedata.length-1;
    if(num>=gamedata.length) num=0;
    gameid=gamedata[num].id;

    change_game(gameid,num)
}
function shownote() {

    var index= layer.open({
        type: 2,
        title: ["网站公告","background-color:#3388ff;color:#fff;"],
        shadeClose: true,
        shade: 0.6,
        area: ['350px','300px'],
        content: '/user/news.php?from=layer' //iframe的url
    });
}

function show_gamenav1() {

    if(document.querySelector('.gamenav').className=='gamenav'){

        document.querySelector('.gamenav').className='gamenav active'
        document.querySelector('#gameicon').className='icon-up-open';


    }else{
        document.querySelector('.gamenav').className='gamenav';
        document.querySelector('#gameicon').className='icon-down-open';
    }

}

function show_addnav() {
    if(document.querySelector('#addnav_0').className=='addnav'){
        document.querySelector('#addnav_0').className='addnav active';
        setTimeout(function () {
            document.querySelector('#addnav_0').className='addnav';
        },5000)
    }else{
        document.querySelector('#addnav_0').className='addnav';

    }

}

function show_addnav1() {
    if(document.querySelector('#addnav_1').className=='addnav'){
        document.querySelector('#addnav_1').className='addnav active';
        setTimeout(function () {
            document.querySelector('#addnav_1').className='addnav';
        },5000)
    }else{
        document.querySelector('#addnav_1').className='addnav';

    }

}
function  click_footer(num) {
    if(num==0){
       location.href='/mobile.php';
    }
    if(num==1){
        location.href='/plan/index.php';
    }

    if(num==2){

        if(userid>0){
            location.href='/chat/message.php';
        }else{

            showlogin();
        }
    }

    if(num==3){

        if(userid>0){

                location.href='/chat/index.php';
        }else{

            showlogin();
        }
    }


    if(num==4){
        usercneter();
    }

}
function usercneter() {

    if(userid>0){

        location.href='/user/index.php';
    }else{

        showlogin();
    }
}
function  menu_item(num) {
    var item=document.querySelector('.footer').querySelectorAll('.item');
    for(var i=0;i<item.length;i++){
           if(i==num) item[i].className='item active';
           else item[i].className='item';
    }

}

var showchatModel=0;
function hide_chat1() {
    $('.footer_chat').removeClass('active');
    menu_item(menuid);
    showchatModel=0;
}
function show_chat1(){

    if(userid>0){
        menu_item(2);
        lastchat();
        $('.footer_chat').addClass('active');
        showchatModel=1;

    }else{

        showlogin();
    }

}

function showlogin() {
    var index= layer.open({
        type: 2,
        title: false,
        closeBtn:1,
        shadeClose: true,
        shade: 0.6,
        area: ['300px','300px'],
        content: '/user/login.php?from=layer' //iframe的url
    });
}
function userindx() {
    location.href='/user/index.php';
}

function user_edit() {
    if(userid>0){
        var index= layer.open({
            type: 2,
            title: false,
            shadeClose: true,
            shade: 0.6,
            area: ['500px','400px'],
            content: 'user/index.php?from=layer&step=1' //iframe的url
        });
    }else{


        showlogin();
    }
}


function quit_login() {

    var index=  layer.confirm('确认要退出登录么？', {
        title:'提示',
        time: 10000, //20s后自动关闭
        btn: ['确定', '取消']
    },function () {
        layer.close(index);
        $.get("/user/quit.php",{}, function(result){

            userid=0;
            layer.msg("退出成功",{ type: 1, anim: 2 ,time:2000});
            setTimeout(function () {
                location.reload();
            },1800)
            $('#navlogin').html('注册登录');
            $('.group_footer').hide();
            $('.footer_chat').hide();
        });
    },function () {

    });


}
var showloading=null;
function listen_scroll(id) {
  var div='lottery_'+id;
    document.getElementById(div).onscroll = function() {
        //var height = document.getElementById("divData").offsetHeight;//250
        //var height=$("#divData").height();//250
        var scrollHeight = document.getElementById(div).scrollHeight;//251
        var scrollTop = document.getElementById(div).scrollTop;//0-18
        var clientHeight = document.getElementById(div).clientHeight;//233

        if (scrollHeight - clientHeight - scrollTop<=100) {
            //滚动条滚到最底部
            // layer_loading= layer.load(1, {
            //     shade: [0.1,'#fff'] //0.1透明度的白色背景
            // });
          //   showloding(id);
            getloattey(id);
        }else{
            $('#tips_'+id).hide();
        }
    };


}
function  showloding(id) {
    $('#tips_'+id).show();
    document.querySelector('#tips_'+id).querySelector('img').style.display='';
    document.querySelector('#tips_'+id).querySelector('.tips').style.display='none';
}
function  nodata(id) {
    $('#tips_'+id).show();
    document.querySelector('#tips_'+id).querySelector('img').style.display='none';
    document.querySelector('#tips_'+id).querySelector('.tips').style.display='';
}

function show_trend() {
    document.querySelector('#menu_frm').className='menu_ifm active';
  document.querySelector('#menu_frm').querySelector('iframe').src='mobile/trend.php?id='+gameid;

  var item=  document.querySelector('.header').querySelectorAll('.item');
  for(var i=0;i<item.length;i++){
      if(i==1){
          item[i].className='item active';
      }
      else{
          item[i].className='item';
      }
  }
}
function hide_trend() {
    document.querySelector('#menu_frm').className='menu_ifm';
  //  document.querySelector('#menu_frm').querySelector('iframe').src='';

    var item=  document.querySelector('.header').querySelectorAll('.item');
    for(var i=0;i<item.length;i++){
        if(i==0){
            item[i].className='item active';
        }
        else{
            item[i].className='item';
        }
    }
}
var systemdata=[];
var linklist=[];
function  getdata() {
    $.get("api/index.php?act=getdata",{}, function(result){
        result=JSON.parse(result);
        systemdata=result.data;
        linklist=systemdata.link;
        try{
            var html='';
            html+="<div class='title'>平台推荐</div>";
            for(var i=0;i<linklist.length;i++){
                if(linklist[i]['type']==2)
                    html+="<a  onclick='gotolink("+linklist[i]['id']+")' title='"+linklist[i]['title']+"'><div> <img src='"+linklist[i]['logo']+"'><p>"+linklist[i]['title']+"</p></div></a>";

            }
            document.querySelector('.tipsmsg').querySelector('.content').innerHTML=html;
        }catch (e){

        }

    });
}

function  gotolink(id) {

    for(var i=0;i<linklist.length;i++){
        if(linklist[i]['id']==id){
            window.open(linklist[i].url);
        }

    }

}

function showmsg() {
    if( document.querySelector('.tipsmsg').className=='tipsmsg active')
        document.querySelector('.tipsmsg').className='tipsmsg';
    else
    document.querySelector('.tipsmsg').className='tipsmsg active';
}

function plan_apply() {
    if(userid>0){
        if(check_userlock()==false) return false;

        $.post("../api/user.php?act=ismobile",{}, function(result){

            result=JSON.parse(result);
            if(result.code==200){
                var index= layer.open({
                    type: 2,
                    title: false,
                    shadeClose: true,
                    shade: 0.6,
                    area: ['310px','250px'],
                    content: '/plan/apply.php?from=layer' //iframe的url
                });

            }
            else{
                    var index=  layer.confirm("您还没有绑定手机号，不能申请计划员", {
                        title:'提示',
                        time: 20000, //20s后自动关闭
                        btn: ['绑定手机', '取消']
                    },function () {
                        location.href='/user/mobile.php' ;

                },function () {

                });
            }
        });




    }else{


       showlogin();
    }

}

function plan_add() {
    if(userid>0){
        if(check_userlock()==false) return false;
        if(lastaddnum>0){

            var tips="<div style='text-align: center'>"+addtips+"<br>是否继续发布计划？</div>";
            var index=  layer.confirm(tips, {
                title:'发布提示',
                time: 20000, //20s后自动关闭
                btn: ['继续发布', '取消']
            },function () {
                try{
                    location.href='/plan/add.php?from=layer&id='+game_id ;
                }catch (e){
                    location.href='/plan/add.php?from=layer' ;
                }


            },function () {

            });
        }
        else{
            layer.msg(addtipsmsg,{ type: 1, anim: 2 ,time:1000});
        }

    }else{

        showlogin();
    }

}
function click_pay(type,id) {


if(userid>0){
    if(check_userlock()==false) return false;
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
    showlogin();
}
}

function click_action() {

    if(userid>0){
        if(check_userlock()==false) return false;
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
        showlogin();
    }
}

function click_useraction(touid) {

    if(userid>0){
        if(check_userlock()==false) return false;
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
        showlogin();
    }
}
function my_plan_add() {
    layer.open({
        type: 2,
        title: false,
        shadeClose: false,shade: 0.6,
        closeBtn:false,
        area: ['100vw', document.documentElement.clientHeight+'px'],
        content: '/plan/my_add.php?from=layer' //iframe的url
    });

}
function my_plan_reward(method) {
    layer.open({
        type: 2,
        title: false,
        shadeClose: false,shade: 0.6,  closeBtn:false,
        area: ['100vw', document.documentElement.clientHeight+'px'],
        content: '/plan/my_reward.php?from=layer&method='+method //iframe的url
    });

}

function my_plan_action(method) {
    layer.open({
        type: 2,
        title: false,
        shadeClose: false,shade: 0.6,closeBtn:false,
        area: ['100vw', document.documentElement.clientHeight+'px'],
        content: '/plan/my_action.php?from=layer&method='+method //iframe的url
    });

}
function  check_userlock() {

    if(islock==1){
        var timestamp = Date.parse(new Date())/1000;
        if(timestamp>=locktime){
            return true;
        }else {
            var index=  layer.confirm("您的账号已被<span style='color: #2319dc'>冻结</span> <br>无法完成<span style='color: #2319dc'>此项操作</span><br>如有疑问请<span style='color: #2319dc'>联系客服</span>", {
                title:'提示',
                time: 20000, //20s后自动关闭
                btn: ['联系客服', '取消']
            },function () {
                //
                location.href='/chat/chatuser.php?id=0';

                layer.close(index);
            },function () {

            });
        }

        return false;
    }else{
        return true;
    }

}
