var xmlHttp;
function Sxmlhttprequest(){
    if(window.ActiveXObject){
        xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
    }
    else if(window.XMLHttpRequest){
        xmlHttp = new XMLHttpRequest();
    }

}

function is_mobile() {
    var ua = navigator.userAgent;

    var url = window.location.host;

    var ipad = ua.match(/(iPad).*OS\s([\d_]+)/),

        isIphone =!ipad && ua.match(/(iPhone\sOS)\s([\d_]+)/),

        isAndroid = ua.match(/(Android)\s+([\d.]+)/),

        isMobile = isIphone || isAndroid;
    return isMobile;
}


function  getlink(){

    $.get("api/index.php?act=getdata",{}, function(result){

        var res=JSON.parse(result);
        var data=res.data;
        sysdata=data;
     //   console.log(sysdata);
        localStorage.setItem('sdata',JSON.stringify(sysdata));
        data_init();

    });

    // Sxmlhttprequest();
    // xmlHttp.open('GET','api/index.php?act=getdata',true);
    // xmlHttp.onreadystatechange=function(){
    //     if(xmlHttp.readyState==1){
    //         //loading
    //     }
    //
    //     if(xmlHttp.readyState==4){
    //         var res=JSON.parse(xmlHttp.responseText);
    //         var data=res.data;
    //         sysdata=data;
    //         console.log(sysdata);
    //         localStorage.setItem('sdata',JSON.stringify(sysdata));
    //         data_init();
    //       //  console.log(sysdata);
    //     }
    //
    //
    // };
    // xmlHttp.send(null);

}

function  data_init(){

    var data=sysdata;
    try{
        if(data!= null){
           // console.log(sysdata);

            newsdata=data.news;
            setnews(newsdata);
            document.querySelector('.header').querySelector('.logo').style.background="url("+sysdata.system.logo+") 0 no-repeat";
            document.querySelector('.header').querySelector('.logo').style.backgroundSize="100% 100%";
            document.querySelector('title').innerHTML=sysdata.system.title;
            document.querySelector('.foot-fr').innerHTML=sysdata.system.footer;
            if(sysdata.system.leftopen==1){
                document.querySelector('.floatleftNav').innerHTML="<img src='"+sysdata.system.leftimg+"' onclick='golefturl();'>";
            }
            var html="";
            linklist=data.link;
           if(linklist.length>0){
               for(var i=0;i<linklist.length;i++){
                   if(linklist[i]['type']==1)
                       html+="<a  onclick='gotolink("+linklist[i]['id']+")' title='"+linklist[i]['title']+"'><div> <img src='"+linklist[i]['logo']+"'><p>"+linklist[i]['title']+"</p></div></a>";

               }

           }

            document.querySelector('.floatRightNav').innerHTML=html;


        }
    }catch (e){

    }


}
function golefturl() {
    window.open(sysdata.system.lefturl);
}

function  gotolink(id) {

    for(var i=0;i<linklist.length;i++){
       if(linklist[i]['id']==id){
       	window.open(linklist[i].url);
	   }

    }

}
var newsnav=[];
var newscontent='';
var apicontext='';
function  setnews(news) {
    newsnav[1]=[];
    themedata=[];
   for(var i=0;i<news[1].length;i++){

       if(i==0) var status=1;else var status=0;
       var temp={
           name:news[1][i].title,
           class: "new-btn",
           status:status
       }
       newsnav[1].push(temp);

       newscontent+='<div class="theme-con-text">'+news[1][i].content+'</div>';

       var other=news[1][i].other;
       themedata.push(other);

   }

    newsnav[2]=[];
    for(var i=0;i<news[2].length;i++){

        if(i==0) var status=1;else var status=0;
        var temp={
            name:news[2][i].title,
            status:status
        }
        newsnav[2].push(temp);

      apicontext+='<div class="api-con-text">'+news[2][i].content+'</div>';
        //
        // var other=news[1][i].other;
        // themedata.push(other);

    }

}

function layerlogin() {
   if(userid>0){
         userindx();
   }else{


       showlogin();
   }
}
function showlogin() {
    var index= layer.open({
        type: 2,
        title: false,

        shadeClose: true,
        shade: 0.6,
        area: ['350px','300px'],
        content: '/user/login.php?from=layer' //iframe的url
    });
}

function showreg() {
    var index= layer.open({
        type: 2,
        title: false,

        shadeClose: true,
        shade: 0.6,
        area: ['350px','300px'],
        content: '/user/login.php?from=layer&type=reg' //iframe的url
    });
}
function userindx() {
    var index= layer.open({
        type: 2,
        title: false,
        shadeClose: true,
        shade: 0.6,
        area: ['500px','500px'],
        content: '/user/index.php?from=layer' //iframe的url
    });
}

function user_edit() {
    if(userid>0){
        var index= layer.open({
            type: 2,
            title: false,
            shadeClose: true,
            shade: 0.6,
            area: ['500px','400px'],
            content: '/user/index.php?from=layer&step=1' //iframe的url
        });
    }else{


        showlogin();
    }
}
function plan_task() {
    if(userid>0){
        var index= layer.open({
            type: 2,
            title: false,
            shadeClose: true,
            shade: 0.6,
            area: ['450px','500px'],
            content: '/plan/task.php?from=layer' //iframe的url
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
       location.href='/user/quit.php';
    },function () {

    });
}
function click_recharge(money) {
    if(userid>0){
        var index= layer.open({
            type: 2,
            title: false,
            shadeClose: true,
            shade: 0.6,
            area: ['500px','500px'],
            content: '/user/recharge.php?from=layer&money='+money //iframe的url
        });
    }else{


        showlogin();
    }
}

function click_plat() {
    if(userid>0){
        var index= layer.open({
            type: 2,
            title: false,
            shadeClose: true,
            shade: 0.6,
            area: ['500px','500px'],
            content: '/user/plat.php?from=layer' //iframe的url
        });
    }else{


        showlogin();
    }
}
function  click_invite(method) {

    if(userid>0){
        var index= parent.layer.open({
            type: 2,
            title: false,
            shadeClose: true,
            shade: 0.6,
            area: ['450px','400px'],
            content: "/user/invite.php?method="+method//iframe的url
        });
    }else{


        showlogin();
    }
}
function click_money() {
    if(userid>0){
        var index= layer.open({
            type: 2,
            title: false,
            shadeClose: true,
            shade: 0.6,
            area: ['500px','500px'],
            content: '/user/money.php?from=layer' //iframe的url
        });
    }else{


        showlogin();
    }
}

function click_plan_title(id) {
    if(document.querySelector("#nav_plan").className.indexOf('active')>-1){
        document.querySelector('.iframe').src="plan/detail.php?id="+id;
    }else{
        document.querySelector('#nav_plan').click();
        setTimeout(function () {
            document.querySelector('.iframe').src="plan/detail.php?id="+id;
        },1000)
    }

}

function click_plan_delete(id) {
    var index=  layer.confirm("是否要删除该计划？", {
        title:'提示',
        time: 20000, //20s后自动关闭
        btn: ['删除', '取消']
    },function () {
        $.post("../api/plan.php?act=plan_delete",{id:id}, function(result){
            result=JSON.parse(result);
            if(result.code==200){

              layer.msg(result.message,{ type: 1, anim: 2 ,time:1000});

            }
            else{
               layer.msg(result.message,{ type: 1, anim: 2 ,time:1000});
            }
        });
        layer.close(index);
    },function () {

    });

}


function click_plan_update(id) {

    layer.open({
        type: 2,
        title: false,
        shadeClose: false,shade: 0.6,
        area: ['600px','600px'],
        content: '/plan/edit.php?from=layer&id='+id //iframe的url
    });
    if(document.querySelector("#nav_plan").className.indexOf('active')>-1){
        setTimeout(function () {
            document.querySelector('#nav_plan').click();
        },1000)
    }

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
                open_chatarea(admin_id,admin_nickname,admin_logo,0);

                layer.close(index);
            },function () {

            });
        }

        return false;
    }else{
        return true;
    }

}
