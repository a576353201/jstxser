function group_create() {

    if(ismobile==1){




          if(userid>0){
              if(check_userlock()==false) return false;
              if(issetname!=1){
                  var index=  layer.confirm('未设置昵称，不能创建群', {
                      title:'提示',
                      time: 20000, //20s后自动关闭
                      btn: ['去设置', '取消']
                  },function () {
                      location.href="/user/profile.php?from=create";
                  },function () {

                  });

                  return false;
              }
              var index=layer.open({
                  type: 2,
                  title: false,
                  shadeClose: false,
                  closeBtn:false,
                  shade: 0.6,
                  area: ['100%', document.documentElement.clientHeight+'px'],
                  content: '/chat/create.php?from=layer' //iframe的url
              });
          }else{

              return  showlogin();
          }
        var nav=document.querySelectorAll('.addnav');
          for(var i=0;i<nav.length;i++){
              nav[i].className='addnav';
          }

    }else{
        if(check_userlock()==false) return false;
        if(issetname!=1){
            var index=  layer.confirm('未设置昵称，不能创建群', {
                title:'提示',
                time: 20000, //20s后自动关闭
                btn: ['去设置', '取消']
            },function () {
                layer.close(index);
                user_edit();
            },function () {

            });

            return false;
        }
        var index=layer.open({
            type: 2,
            title: false,
            shadeClose: false,
            shade: 0.6,
            area: ['380px','410px'],
            content: '/chat/create.php?from=layer' //iframe的url
        });


    }

}

function group_detail(id) {


    if(ismobile==1){
        var index=layer.open({
            type: 2,
            title: false,
            shadeClose: false,shade: 0.6,
            closeBtn:0,
            area: ['100vw', document.documentElement.clientHeight+"px"],
            content: '/chat/detail.php?from=layer&id='+id //iframe的url
        });
    }else{
        var index=layer.open({
            type: 2,
            title: false,
            shadeClose: true,shade: 0.6,
            area: ['500px','400px'],
            content: '/chat/detail.php?from=layer&id='+id //iframe的url
        });
    }

}
function group_detail2(id) {

    var index=layer.open({
        type: 2,
        title: false,
        shadeClose: true,shade: 0.6,
        area: ['500px','400px'],
        content: '/chat/detail.php?from=layer&step=2&id='+id //iframe的url
    });
}

function  group_note(id) {

    var index=layer.open({
        type: 2,
        title: false,
        shadeClose: true,shade: 0.6,
        area: ['500px','400px'],
        content: '/chat/note.php?from=layer&id='+id //iframe的url
    });

    
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

function chat_apply(id) {
    if(check_userlock()==false) return false;
    if(ismobile==1){

        var index=layer.open({
            type: 2,
            title: false,
            shadeClose: true,shade: 0.6,
            area: ['80vw','300px'],
            content: '/chat/apply.php?from=layer&id='+id //iframe的url
        });
    }else{

        var index=layer.open({
            type: 2,
            title: false,
            shadeClose: true,shade: 0.6,
            area: ['450px','220px'],
            content: '/chat/apply.php?from=layer&id='+id //iframe的url
        });
    }

}

function chat_apply1(id) {

    if(check_userlock()==false) return false;
        var index=layer.open({
            type: 2,
            title: false,
            shadeClose: true,shade: 0.6,
            area: ['80vw','300px'],
            content: '/chat/apply1.php?from=qrcode&id='+id //iframe的url
        });


}
var showchatModel=0;
function show_chat() {
    if(userid>0){
        $('.group_footer').hide();
        $('.footer_chat').addClass('active');
        showchatModel=1;
    }else{


        showlogin();
    }

}

function hide_chat() {
    $('.group_footer').show();
    $('.footer_chat').removeClass('active');
    showchatModel=0;
}

function close_chatarea(type) {
    if(type=='close'){
        $('.chat_area .area').html("");
        $('.chat_area .leftbar').html("");

    }
    else{
        //最小化
        $('.msgbox').show();
        var li= document.querySelector('.chat_area').querySelector('.leftbar').querySelectorAll('li');
        for(var i=0;i<li.length;i++){
            if(li[i].className=='active'){

                document.querySelector('.msgbox').querySelector('img').src=li[i].querySelector('img').src;
                $('.msgbox .unread').html(unreadnum);
                if(unreadnum>0){
                    $('.msgbox .unread').show();
                }else{
                    $('.msgbox .unread').hide();
                }
                break;
            }
        }

    }
    $('.chat_area').addClass(type);
    isreading=0;

}
function open_chatarea1(id,name,avatar) {
    if(close_id!=id)open_chatarea(id,name,avatar)
}
function open_chatarea2(id,name,avatar) {
 open_chatarea(sender.id,sender.nickname,sender.avatar)
}

function open_current_chat() {
    if(reading_id>0 ){
        group_detail(reading_id);
    }
}

var reading_id=-1;
var isreading=0;
function  open_chatarea(id,name,avatar) {

    close_id=-1;
    isreading=1;
    reading_id=id;


   if(parseInt(id)>0) {
       if(parseInt(id)==1){
           var url="/chat/request.php?id="+id;
       }else var url="/chat/chat.php?id="+id;
   }
   else var url="/chat/chatuser.php?id="+id
     location.href=url;
    $.post("../api/group.php?act=setReadTime",{group_id:id}, function(result){

        var res=JSON.parse(result);
        if(res.code=='200'){

        }

    });

    lastchat();

}
var close_id=-1;
function close_chatone(id) {

    var iframe= document.querySelector('.chat_area').querySelector('.area').querySelectorAll('iframe');
   if(iframe.length<=1) return close_chatarea('close');
    close_id=id;
    var isactive=0;
    for(var i=0;i<iframe.length;i++){
        if(iframe[i].id=='group_'+id){
            if(iframe[i].style.display=='') {
                isactive=1;
            }
            $('#group_'+id).remove();
            $('#menu_'+id).remove();
        }
    }
    isreading=0;
    if(isactive==1){
        setTimeout(function () {
            var li= document.querySelector('.chat_area').querySelector('.leftbar').querySelectorAll('li');
            li[0].click();
            close_id=-1;
        },100)

    }

    if(iframe.length<=2)   $('.chat_area').removeClass('minus');
}
function  timestampFormat( timestamp ) {
    var  curTimestamp = parseInt(new Date().getTime() / 1000), //当前时间戳
        timestampDiff = curTimestamp - timestamp, // 参数时间戳与当前时间戳相差秒数
        curDate = new Date( curTimestamp * 1000 ), // 当前时间日期对象
        tmDate = new Date( timestamp * 1000 ),  // 参数时间戳转换成的日期对象
        Y = tmDate.getFullYear(),
        m = tmDate.getMonth() + 1, d = tmDate.getDate(),
        H = tmDate.getHours(), i = tmDate.getMinutes(),
        s = tmDate.getSeconds();
    if ( timestampDiff < 60 ) { // 一分钟以内
        return "刚刚";
    } else if( timestampDiff < 3600 ) { // 一小时前之内
        return Math.floor( timestampDiff / 60 ) + "分钟前";
    } else if ( curDate.getFullYear() == Y && curDate.getMonth()+1 == m && curDate.getDate() == d ) {
        return '今天 ' + ((String(H).length == 1 ? '0' : '') + H) + ':' + ((String(i).length == 1 ? '0' : '') + i);
    } else {
        var newDate = new Date( (curTimestamp - 86400) * 1000 ); // 参数中的时间戳加一天转换成的日期对象
        if ( newDate.getFullYear() == Y && newDate.getMonth()+1 == m && newDate.getDate() == d ) {
            return '昨天 ' + ((String(H).length == 1 ? '0' : '') + H) + ':' + ((String(i).length == 1 ? '0' : '') + i);
        } else if ( curDate.getFullYear() == Y ) {
            return  ((String(m).length == 1 ? '0' : '') + m) + '月' + ((String(d).length == 1 ? '0' : '') + d) + '日 ' + ((String(H).length == 1 ? '0' : '') + H) + ':' + ((String(i).length == 1 ? '0' : '') + i);
        } else {
            return  Y + '年' + ((String(m).length == 1 ? '0' : '') + m) + '月' + ((String(d).length == 1 ? '0' : '') + d) + '日 ' + ((String(H).length == 1 ? '0' : '') + H) + ':' + ((String(i).length == 1 ? '0' : '') + i);
        }
    }
}
function lastchat() {
       if(isreading==1 && reading_id>-1){
           var read_id=reading_id;
       }
       else var read_id=-1
    $.post("../api/group.php?act=lastchat",{reading_id:read_id}, function(result){

        var res=JSON.parse(result);
        if(res.code=='200'){
            unreadnum=res.unread;



          var html='';

          for(var i=0;i<res.data.length;i++){
              var item=res.data[i];
              if(item.unread>0){
                  if(item.unread>99) item.unread='99+';
                  var unread="<span class='num' style='display: inline-block'>"+item.unread+"</span>";
              }
              else var unread="<span class='num' >0</span>";

              if(item.groupid==0){
                 var gx="<span class='btn_green' style='margin-left: 5px;border-radius: 8px;'>官方</span>";
              }
              else  var  gx='';
              var avatar=item.group.avatar;
              if(avatar.indexOf('http')<=-1){
                  avatar="/"+avatar;
              }
              html+=' <li onclick=\'open_chatarea('+item.groupid+',"'+item.group.name+'","'+item.group.avatar+'");\'>\n' +
                  '            <div class="avatar">'+unread+'\n' +
                  '                <img src="'+avatar+'" onerror="this.src=\'../uploads/group.jpg\'"/>\n' +
                  '            </div>\n' +
                  '            <div class="info">\n' +
              '                <div class="title">'+item.group.name+gx+'<span class="time">'+timestampFormat(item.addtime)+'</span></div>\n' +
                  '                <div class="message">'+item.showcontent+'</div>\n' +
                  '            </div>\n' +
                  '        </li>';

          }


          if(menuid==2){
              if(res.unread>0) $('#msg_title').html("消息("+res.unread+")");
              else $('#msg_title').html("消息");
              $('.msglist').html(html);
          }



            if(isreading!=1 && unreadnum>0){
                for(var i=0;i<res.data.length;i++){
                    if(res.data[i].unread>0){
                        sender=res.data[i].group;
                        break;
                    }
                }
                if(ismobile==0){

                    document.querySelector('.msgbox').querySelector('img').src=sender.avatar;
                    $('.msgbox .unread').html(unreadnum);
                    if(unreadnum>0){
                        $('.msgbox .unread').show();
                    }else{
                        $('.msgbox .unread').hide();
                    }
                    $('.msgbox').show();
                }


            }
            showunreadnum();

        }



    });
}
function showunreadnum() {

    if(ismobile==1){

        $('#footmenu_unread').html(unreadnum);

        if(menuid!=5){
            if(unreadnum>0){

                document.querySelector('#footmenu_unread').style.display='inline-block';
            }else{

                $('#footmenu_unread').hide();
            }
        }


    }else{
        $('.group_footer .unread_num').html(unreadnum);
        $('#footmenu_unread').html(unreadnum);
        if(unreadnum>0){
            document.querySelector('.group_footer').querySelector('.unread_num').style.display='inline-block';
            document.querySelector('#footmenu_unread').style.display='inline-block';
        }else{
            $('.group_footer .unread_num').hide();
            $('#footmenu_unread').hide();
        }
    }

}

var menu_num=0;
function footmenu(num) {
    menu_num=num;
 var li=   document.querySelector('.footmenu').querySelectorAll('li');
 for(var i=0;i<3;i++){
     if(i==num){
         li[i].className="active";
         document.querySelector('#step'+i).style.display='';
         if(i==1) document.querySelector('#step'+i).src="/chat/index.php?v="+Math.random();
         if(i==2) document.querySelector('#step'+i).src="/chat/mygroup.php?v="+Math.random();
     }
     else {
         li[i].className='';
         document.querySelector('#step'+i).style.display='none';
     }

 }

}

function  show_emoji() {
    if(document.querySelector('.emoji').style.display=='inline-block'){
        document.querySelector('.emoji').style.display='none';
    }else{
        document.querySelector('.emoji').style.display='inline-block';
    }
}

function set_emotion(value) {

    document.querySelector('#input_area').value+="["+value+"]";
    msgtype='emotion';
    $('.emoji').hide();

    if(ismobile==1){

        input_value(document.querySelector('#input_area').value) ;
    }

}
var layer_img=null;
function setthisheight() {

    setTimeout(function () {

        layer.iframeAuto(layer_img);
    },1000)

}

