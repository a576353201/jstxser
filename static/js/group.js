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
            area: ['550px','400px'],
            content: '/chat/detail.php?from=layer&id='+id //iframe的url
        });
    }

}

function  user_invite(id) {
    var index=parent.layer.open({
        type: 2,
        title: false,
        shadeClose: true,shade: 0.6,
        area: ['450px','340px'],
        content: '/chat/invite.php?from=layer&groupid='+id //iframe的url
    });
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
            area: ['530px','380px'],
            content: '/user/detail.php?from=layer&id='+id+"&group_id="+group_id  //iframe的url
        });

    }

}

function user_detail1(id,from) {


        var index=layer.open({
            type: 2,
            title: false,
            shadeClose: true,shade: 0.6,
            area: ['530px','380px'],
            content: '/user/detail.php?from=layer&id='+id+"&from="+from  //iframe的url
        });

}

function chat_apply(id) {
    if(parent.check_userlock()==false) return false;
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

function friend_apply(id,from) {
    if(parent.check_userlock()==false) return false;
    if(ismobile==1){

        var index=layer.open({
            type: 2,
            title: false,
            shadeClose: true,shade: 0.6,
            area: ['80vw','300px'],
            content: '/user/apply.php?from=layer&id='+id+'&from='+from //iframe的url
        });
    }else{

        var index=layer.open({
            type: 2,
            title: false,
            shadeClose: true,shade: 0.6,
            area: ['450px','220px'],
            content: '/user/apply.php?from=layer&id='+id+'&from='+from //iframe的url
        });
    }

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
    $('.chat_area .header').hide();

        $('.chat_area .area').html("");
        $('.chat_area .leftbar').html("");
        reading_id=0;
        reading_cachekey='';

    isreading=0;
    setread_active();

}
function open_chatarea1(id,name,avatar,isgroup) {
    if(close_id!=id)open_chatarea(id,name,avatar,isgroup)
}
function open_chatarea2() {

    if(sender.cache_key.indexOf("G")>-1) var isgroup=1;
    else var isgroup=0;

 open_chatarea(sender.id,sender.nickname,sender.avatar,isgroup);
}

function open_current_chat() {
    if(reading_id<2) retur
    if(reading_cachekey.indexOf('G')>-1){
        group_detail(reading_id);
    }else{
        user_detail(reading_id,0);
    }
}

var reading_id=0;
var isreading=0;
var reading_cachekey='';

function  setread_active() {
    var msglist=document.querySelector('.msglist').querySelectorAll('li');
    console.log(reading_cachekey)
    for(var i=0;i<msglist.length;i++){
        if(msglist[i].id=="msg_"+reading_cachekey){
            msglist[i].className='active';
        }else{
            msglist[i].className='';
        }
    }
}
function  open_chatarea(id,name,avatar,isgroup) {

    close_id=-1;
    isreading=1;
    reading_id=id;

    $('.chat_area').removeClass('close');
    $('.chat_area').removeClass('min');
    $('.chat_area .header').show();
    $('.chat_area .header span').html(name);

    if(ismobile==1){

        var height="style='height:"+document.documentElement.clientHeight+"px'";
              //  alert(height);
    }
    else var height="";
    if(isgroup==1) var cache_key='G'+id;
    else var cache_key='U'+id;
    reading_cachekey=cache_key;

  setread_active();
   var iframe= document.querySelector('.chat_area').querySelector('.area').querySelectorAll('iframe');

       if(parseInt(id)==1){
           var area="<iframe id='group_"+cache_key+"' src='/chat/request.php?id="+id+"&rand="+Math.random()+"' "+height+"></iframe>";
       }else{
           var area="<iframe id='group_"+cache_key+"' src='/chat/chat.php?isgroup="+isgroup+"&id="+id+"' "+height+"></iframe>";

       }

   var leftbar="<li id='menu_"+cache_key+"' title='"+name+"' class='active' onclick=\"open_chatarea1("+id+",'"+name+"','"+avatar+"','"+isgroup+"');\"><img src='"+avatar+"'/><span class='unread'>0</span><i class='icon-cancel-circle' onclick='close_chatone("+id+")' title='关闭'></i></li>";
   if(iframe.length==0){

       document.querySelector('.chat_area').querySelector('.area').innerHTML=area;
       document.querySelector('.chat_area').querySelector('.leftbar').innerHTML=leftbar;

   }
   else{
       var li= document.querySelector('.chat_area').querySelector('.leftbar').querySelectorAll('li');
       var isin=0;

       for(var i=0;i<iframe.length;i++){
           if(iframe[i].id=='group_'+cache_key ){
               iframe[i].style.display="";
               isin=1;

               //如果有未读消息，滑动到最底部
               if(parseInt(document.querySelector('#menu_'+cache_key).querySelector('.unread').innerHTML)>0){
                   var contentWindow=iframe[i].contentWindow;
                   contentWindow.scrolltobottom();
               }
             if(cache_key=='U1'){
                 iframe[i].src="/chat/request.php?id=1&rand="+Math.random();
             }

           }else{
               iframe[i].style.display="none";
           }
       }

       for(var i=0;i<li.length;i++){
           if(li[i].id=='menu_'+cache_key){
               li[i].className="active";
               li[i].querySelector('.unread').innerHTML='0';
               li[i].querySelector('.unread').style.display='none';
           }else{

               li[i].className="";
           }
       }
       if(isin==0){
           $('.chat_area .area').prepend(area);
           $('.chat_area .leftbar').prepend(leftbar);
       }

   }
    $.post("../api/group.php?act=setReadTime",{group_id:id,isgroup:isgroup}, function(result){

        var res=JSON.parse(result);
        if(res.code=='200'){
            var li= document.querySelector('.chat_area').querySelector('.leftbar').querySelectorAll('li');
            for(var i=0;i<iframe.length;i++){
                if(li[i].id=='menu_'+cache_key){

                    li[i].querySelector('.unread').innerHTML=res.data;
                    if(parseInt(res.data)>0)
                        li[i].querySelector('.unread').style.display='inline-block';
                        else
                    li[i].querySelector('.unread').style.display='none';
                    break;
                }
            }
        }

    });
    sender={id:id,name:name,avatar:avatar,cache_key:cache_key};
    lastchat();
    var iframe= document.querySelector('.chat_area').querySelector('.area').querySelectorAll('iframe');
    if(iframe.length<2){
        $('.chat_area').removeClass('minus');
    }else{
        $('.chat_area').addClass('minus');
    }

}
var close_id=-1;
function close_chatone(id,isgroup) {

    var iframe= document.querySelector('.chat_area').querySelector('.area').querySelectorAll('iframe');
   if(iframe.length<=1) return close_chatarea('close');
    close_id=id;
    var isactive=0;
    if(isgroup==1) var cache_key='G'+id;
    else var cache_key='U'+id;
    for(var i=0;i<iframe.length;i++){
        if(iframe[i].id=='group_'+cache_key){
            if(iframe[i].style.display=='') {
                isactive=1;
            }
            $('#group_'+cache_key).remove();
            $('#menu_'+cache_key).remove();
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
        return  ((String(H).length == 1 ? '0' : '') + H) + ':' + ((String(i).length == 1 ? '0' : '') + i);
    } else {
        var newDate = new Date( (curTimestamp - 86400) * 1000 ); // 参数中的时间戳加一天转换成的日期对象
        if ( newDate.getFullYear() == Y && newDate.getMonth()+1 == m && newDate.getDate() == d ) {
            return '昨天 ' ;
        } else if ( curDate.getFullYear() == Y ) {
            return  ((String(m).length == 1 ? '0' : '') + m) + '月' + ((String(d).length == 1 ? '0' : '') + d) + '日 ';
        } else {
            return  Y + '/' + ((String(m).length == 1 ? '0' : '') + m) + '/' + ((String(d).length == 1 ? '0' : '') + d) ;
        }
    }
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

function lastchat() {
       if(isreading==1 && reading_id>-1){
           var read_id=reading_id;
       }
       else var read_id=-1
    $.get("../api/group.php?act=lastchat",{reading_id:read_id,cache_key:reading_cachekey}, function(result){

        var res=JSON.parse(result);

        if(res.code=='200'){
            showmsglist(res);
            showunreadnum();
            setread_active();
        }



    });
}

function showmsglist(res) {
    unreadnum=0;
    if(res.unread>0){
        if(res.unread>99) var unread='99+';
        else var unread=res.unread;
        $('#msg_unread').html(unread);
        $('#msg_unread').show();
    }
    else {
        $('#msg_unread').html("");
        $('#msg_unread').hide();
    }
    var html='';

    for(var i=0;i<res.data.length;i++){
        var item=res.data[i];
        if(item.unread>0){
            if(item.unread>99) item.unread='99+';
            var unread="<span class='num' style='display: inline-block'>"+item.unread+"</span>";
            unreadnum+=parseInt(item.unread);
        }

        else var unread="<span class='num' >0</span>";
        if(item.isgroup==0){
            if(item.group.kefu==1)
                var gx="<span class='btn_green' style='margin-left: 5px;border-radius: 8px;'>客服</span>";
            else if(item.group.kefu==2)
                var gx="<span class='btn_green' style='margin-left: 5px;border-radius: 8px;'>官方</span>";
            else if(item.group.kefu==3)
                var gx="<span class='btn_green' style='margin-left: 5px;border-radius: 8px;'>上级</span>";
            else var gx="";
        }
        else  var  gx='';

        var avatar=item.group.avatar;
        if(avatar.indexOf('http')<=-1){
            avatar="/"+avatar;
        }
        if(item.istop) var classname='istop'; else var classname='';
        if(item.isgroup==1) var cache_key='G'+item.group.id;
        else var cache_key='U'+item.group.id;
       // reading_cachekey=cache_key;

        html+=' <li id="msg_'+cache_key+'" class="'+classname+'" onclick=\'open_chatarea('+item.group.id+',"'+item.group.nickname+'","'+item.group.avatar+'","'+item.isgroup+'");\'>\n' +
            '            <div class="avatar">'+unread+'\n' +
            '                <img src="'+avatar+'" onerror="this.src=\'../uploads/group.jpg\'"/>\n' +
            '            </div>\n' +
            '            <div class="info">\n' +
            '                <div class="title"><span class="nickname">'+item.group.nickname+gx+'</span><span class="time">'+timestampFormat(item.addtime)+'</span></div>\n' +
            '                <div class="message">'+item.showcontent+'</div>\n' +
            '            </div>\n' +
            '        </li>';

    }



    $('.msglist').html(html);


    if(isreading!=1 && unreadnum>0){
        for(var i=0;i<res.data.length;i++){

            if(res.data[i].unread>0){
                sender=res.data[i].group;
                sender.cache_key=res.data[i].cache_key;
                break;
            }
        }



    }
}

function showunreadnum() {


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
         if(i==2) document.querySelector('#step'+i).src="/chat/contact.php?v="+Math.random();
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

