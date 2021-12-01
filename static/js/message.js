
function sockect_message(data) {
    data=JSON.parse(data);
   var type=data.type;

   if(type=='chat'){
       //收到聊天记录


       if(ismobile==1)
           message_chat_mobile(data.data);
           else
       message_chat(data.data);
   }
   else if(type=='apply_response'){
       //申请入群相应
       apply_response(data.data);
   }
   else if(type=='deal_response'){
         //同意进群，通知群主和管理员
      deal_response(data.data);
   }
   else if(type=="group_update"){
       //更新群数据
       group_update(data.data);
   }
   else if(type=='delete_Group'){
       //删群或者退群

       deleteGroup(data.data)
   }
   else if(type=='ping'){
       var data={type:'pong'};
       send_data(JSON.stringify(data));
   }
   else if(type=='group_response'){
       layer.msg(data.data,{ type: 1, anim: 2 ,time:1000});
   }
   else if (type=='sendlottery'){
       lottery_update(data.data);
   }
   else if(type=='otherlogin'){
       console.log(data);
       layer.msg("该账号已经在其他设备登录",{ type: 1, anim: 2 ,time:1000});
       setTimeout(function () {
           $.get("/user/quit.php",{}, function(result){

               userid=0;

               setTimeout(function () {
                   location.reload();
               },1000)

           });
       },500)


   }

    else console.log(data);
}
var unreadnum=0;
var sender='';

function message_chat_mobile(data) {

    var id=data.group_id;
    if(id==reading_id){

        message_add(data);
        $.post("../api/group.php?act=setReadTime",{group_id:id}, function(result){
            var res=JSON.parse(result);
            if(res.code=='200'){

            }
        });
    }else{
        if(data.message.type!='tips' || parseInt(data.tip_uid)==parseInt(userid)){
            if(parseInt(reading_id)>0)
                voice_play('chat');
            else{
                voice_play('msg');
               // toast_msgtips(data);
            }
        }
        lastchat();
    }

}

function  message_chat(data) {


       //   console.log(data);
          var cache_key=data.cache_key;
          if(cache_key.indexOf('U')>-1){
              var chattype='friend';
          }
          else {
              var chattype='group';
          }
        var group_id=cache_key.substr(1,cache_key.length-1);
        var iframe= document.querySelector('.chat_area').querySelector('.area').querySelectorAll('iframe');
        var isin=0;
        var li= document.querySelector('.chat_area').querySelector('.leftbar').querySelectorAll('li');
        if(iframe.length>0){
            for(var i=0;i<iframe.length;i++){
                if(iframe[i].id=='group_'+cache_key){
                    var contentWindow=iframe[i].contentWindow;
                    contentWindow.message_add(data);

                    break;
                }
            }

            for(var i=0;i<li.length;i++){

                if(li[i].id=='menu_'+cache_key){
                    if(isreading!=1 || reading_id!=group_id){
                        unreadnum++;
                        li[i].querySelector('.unread').innerHTML++;
                        li[i].querySelector('.unread').style.display='inline-block';
                    }
                    else{
                        isin=1;
                    }
                    var html=li[i].outerHTML;
                    $('#menu_'+cache_key).remove();
                    $('.chat_area .leftbar').prepend(html)
                    break;
                }

            }

        }

        sender=data.receiver;
        if(isin==0) {
            unreadnum++;

            if(data.message.type!='tips' || parseInt(data.tip_uid)==parseInt(userid)){
                var istip=1;
                for(var k=0;k<msgnotip.length;k++){
                    if(msgnotip[k]==cache_key){
                        istip=0;
                        break;
                    }
                }

                if(istip==1){
                    if(parseInt(group_id)>0)
                        voice_play('chat');
                    else{
                        voice_play('msg');
                        toast_msgtips(data);
                    }
                    }

            }



            if(isreading!=1 && ismobile==0){


                $('.chat_area .header span').html(sender.nickname);

              
                $('.chat_area').removeClass('close');
                $('.chat_area').addClass('min');
            }

        }
    //测回消息
    if(data.message.type=='tips' && (data.message.msg_type=="chat_back" || data.message.msg_type=="delete_chat" ) ){


        chat_back(data.message.data.msg_id,data.cache_key);
    }

    lastchat();


}

function  chat_back(id,cache_key) {

    var iframe= document.querySelector('.chat_area').querySelector('.area').querySelectorAll('iframe');
    for(var i=0;i<iframe.length;i++){
        if(iframe[i].id=='group_'+cache_key){

            var contentWindow=iframe[i].contentWindow;
            contentWindow.chat_back(id);

            break;
        }
    }
}

function toast_msgtips(data) {
    if(showchatModel==0){
        $('.msgtips').addClass('active');
        console.log(data);
        document.querySelector('.msgtips').querySelector('.avatar').querySelector('img').src=data.avatar;
        document.querySelector('.msgtips').querySelector('.nickname').querySelector('i').innerHTML=data.nickname;
        document.querySelector('.msgtips').querySelector('.time').innerHTML=timestampFormat(data.timestamp);

        if(data.message.type=='apply'){

            document.querySelector('.msgtips').querySelector('.text').innerHTML=data.message.content.text;
        }

            else
        document.querySelector('.msgtips').querySelector('.text').innerHTML=data.message.content;
        setTimeout(function () {
            $('.msgtips').removeClass('active');
        },3000)
    }

}
function voice_play(type) {
    try {
        document.querySelector('#voice_'+type).pause();
    }catch (e){

    }

    document.querySelector('#voice_'+type).currentTime=0;
    document.querySelector('#voice_'+type).play();
}
function apply_response(data) {
    //成功入群
    if(data.code==1){
       layer.close(layer_name);
       layer.close(layer_loading);
       var group=data.group;
       open_chatarea(group['id'],group['name'],group['avatar'],1);
       layer.msg(data.message,{ type: 1, anim: 2 ,time:1000});

    } else{
        //进群失败
        layer.close(layer_loading);
        layer.msg(data.message,{ type: 1, anim: 2 ,time:1000});
    }

}

function deal_response(data) {

    //通知自己操作通知
    if(userid==data.from_uid){
          if(data.message)
        layer.msg(data.message,{ type: 1, anim: 2 ,time:1000});
    }
    if(ismobile==1){
        if(reading_id==0)update_apply(data.apply);
        if(reading_id==data.apply.group_id) get_userlist();

    }else{
        layer.close(layer_name);
        layer.close(layer_loading);
        //通知管理员，更新审核状态
        var iframe= document.querySelector('.chat_area').querySelector('.area').querySelectorAll('iframe');
        if(iframe.length>0) {
            for (var i = 0; i < iframe.length; i++) {
                if (iframe[i].id == 'group_G0') {

                    var contentWindow = iframe[i].contentWindow;
                    contentWindow.update_apply(data.apply);
                    break;
                }
            }


            for (var i = 0; i < iframe.length; i++) {
                if (iframe[i].id == 'group_G'+data.apply.group_id) {

                    var contentWindow = iframe[i].contentWindow;
                    contentWindow.group_update();
                    break;
                }
            }
        }
    }

}


function group_update(data) {
    if(ismobile==1){
        if(reading_id==data.id) get_userlist();

    }else{
        var iframe= document.querySelector('.chat_area').querySelector('.area').querySelectorAll('iframe');
        if(iframe.length>0) {
            for (var i = 0; i < iframe.length; i++) {
                if (iframe[i].id == 'group_G'+data.id) {
                    $('.chat_area .header span').html(data.name);
                    var contentWindow = iframe[i].contentWindow;
                    contentWindow.group_update();
                    break;
                }
            }
        }
    }

    lastchat();
}

function  deleteGroup(data) {
    var iframe= document.querySelector('.chat_area').querySelector('.area').querySelectorAll('iframe');
    if(iframe.length>0) {
        for (var i = 0; i < iframe.length; i++) {
            if (iframe[i].id == 'group_G'+data.id) {
                close_chatone(data.id)
                break;
            }
        }
    }
    lastchat();
    footmenu(menu_num);
}


function lottery_update(data) {
     if(ismobile==0){
         if(document.querySelector('#nav_lottery').className.indexOf('active')>-1){
             // var gamename= document.querySelector('#menu_nav').querySelector('.active').innerHTML;
             // var li= document.querySelector('#menu_nav').querySelectorAll('li');
             // var num=0;
             // for(var i=0;i<li.length;i++){
             //     if(li[i].className=='active') {
             //         num=i;
             //         break;
             //     }
             // }
             // var gamekey='';
             // var gametype='ffc';
             // for(var i=0;i<gamejson.length;i++){
             //     var item=gamejson[i];
             //     if(item.title==gamename){
             //         gamekey=item.showkey;
             //         gametype=item.showtype;
             //     }
             // }
             // for(var i=0;i<data.length;i++){
             //     var item=data[i];
             //     if(item.gamekey.toLowerCase() == gamekey.toLowerCase()){
             //
             //         var slide=  document.querySelector('.swiper-container').querySelectorAll('.slide');
             //         var row = slide[num].querySelectorAll('.el-table__row');
             //         var cell= row[0].querySelectorAll('.cell');
             //
             //         if(cell[1].innerHTML!=item.expect){
             //             var html="<tr class=\"el-table__row\">";
             //             html+='<td rowspan="1" colspan="1" class="el-table_1_column_1 is-center table-column"><div class="cell">'+timestampToTime1(item.time)+'</div></td>';
             //             html+='<td rowspan="1" colspan="1" class="el-table_1_column_2 is-center table-column"><div class="cell">'+item.expect+'</div></td>';
             //             var number=item.number.split(',');
             //             html+='<td rowspan="1" colspan="1" class="el-table_1_column_2 is-center table-column"><div class="cell">';
             //             for(var j=0;j<number.length;j++){
             //                 html+="<span class=\""+gametype+"\">"+number[j]+"</span>";
             //             }
             //             html+="</div></td>";
             //             html+='</tr>';
             //
             //             for(var j=0;j<row.length-1;j++){
             //                 html+=row[i].outerHTML;
             //             }
             //             row[0].innerHTML=html;
             //             break;
             //         }
             //
             //     }
             // }
             var iframe= document.querySelector('.iframe');


                     var contentWindow = iframe.contentWindow;
                     contentWindow.lottery_update(data);

         }
         if(document.querySelector('#nav_plan').className.indexOf('active')>-1){

             var iframe= document.querySelector('.contactus').querySelectorAll('.iframe');
             if(iframe.length>0 ) {
                 for (var i = 0; i < iframe.length; i++) {

                     var contentWindow = iframe[i].contentWindow;
                     contentWindow.lottery_update(data);

                 }

             }

         }


     }
     else{
          var url= window.location.href;
          if(url.indexOf('mobile.php')>-1 || url.indexOf('plan')>-1){
              lotteryinfo_update(data);
          }
     }


}

function timestampToTime1(timestamp) {
    var date = new Date(timestamp * 1000);//时间戳为10位需*1000，时间戳为13位的话不需乘1000
    var Y = date.getFullYear() ;
    var M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1);
    var D = date.getDate();
    var h = date.getHours();
    var m = date.getMinutes();
    var s = date.getSeconds();
    if(D<10) D='0'+D;
    if(h<10) h='0'+h;
    if(m<10) m='0'+m;
    if(s<10) s='0'+s;
    return Y+'-'+M+'-'+D+' '+h+':'+m+':'+s;
}