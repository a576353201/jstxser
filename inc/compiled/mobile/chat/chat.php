

<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/group.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />
<script src="/static/js/group_mobile.js?v=<?php echo $cachekey; ?>"></script>
<script src="/static/js/socket.js"></script>
<script src="/static/js/message.js?v=<?php echo $cachekey; ?>"></script>
<div class="chat">
    <div class="header" >
        <span onclick="group_detail(group_id);"><?php echo $group['name']; ?>(<span id="people_count"><?php echo $group['people_count']; ?></span>人)</span>
        <i class="close icon-left-open-2" onclick="window.location='<?php echo $_SERVER['HTTP_REFERER']; ?>';" title="关闭"></i>
        <i class="moreinfo icon-ellipsis" onclick="  group_detail(group_id);" ></i>
    </div>

    <div class="content">

        <div class="left">
            <div class="nodata" style="display: none;margin-top: 40px;">
                <img src="/static/images/loading.gif" style="height: 20px"/>
            </div>

            <div class="message">

                <?php if(is_array($msglist)){foreach($msglist AS $key=>$value) { ?>

                <?php if($value['type']=='tips'){?>
                <div class="tips">
                      <?php echo $value['content']; ?>
                </div>
                <?php } else { ?>

                <div id="msg_<?php echo $value['id']; ?>" class="line <?php if($value['self']==1){?>self<?php }?>">
                    <div id="avatar_<?php echo $value['id']; ?>" class="avatar" onclick="avatar_menu(<?php echo $value['id']; ?>,<?php echo $value['user']['id']; ?>);">
                        <img src="<?php echo $value['user']['avatar']; ?>" onerror="this.src='../uploads/avatar.jpg'"/>
                    </div>
                     <div class="msg">
                         <div class="nickname"  id="nickname_<?php echo $value['id']; ?>"  ><span onclick="avatar_menu(<?php echo $value['id']; ?>,<?php echo $value['user']['id']; ?>);"><?php echo $value['user']['nickname']; ?></span></div>
                         <div class="info <?php echo $value['type']; ?>"> <div class="info"><?php echo $value['content']; ?></div></div>
                     </div>
                    <div class="loading"><img src="/static/images/loading.gif"/></div>
                </div>
               <?php }?>
                <?php }}?>



            </div>
            <div class="sender">


                <div class="input">
                    <i class="icon-smile" title="发送表情" style="font-size: 22px" onclick="show_emoji();"></i>
                    <textarea class="textarea" id="input_area"  oninput="input_value(this.value);" onclick=" $('.emoji').hide();"></textarea>
                    <div id="deny_tips" style="display: none"></div>



                    <i class="icon-file-image" title="发送图片" id="send_image" style="display: none" onclick="document.querySelector('#cameraInput').click(); $('.emoji').hide();"></i>
                    <div class="btn" id="send_btn" onclick="submitMsg();" style="display: none">发送</div>
                </div>

            </div>

            <div class="emoji">

                <?php if(is_array($emotion)){foreach($emotion AS $index=>$value) { ?>

                <li title="<?php echo $emotion[$index]; ?>">
                    <img src="/static/emoji/<?php echo $index+100;?>.gif" onclick="set_emotion('<?php echo $emotion[$index]; ?>');">
                </li>
                <?php }}?>

            </div>

            <form id="form111" method="post" action=""  enctype="multipart/form-data"  style='display:none;'>

                <input type="file"  id="cameraInput" name="cameraInput" accept="image/*" data-role="none" />
            </form>
        </div>
        <div class="right" style="display: none">
            <div class="note"  onclick="parent.group_note(<?php echo $group['id']; ?>);">
                <div style="width: 100%;height: 25px;line-height: 25px;text-align: center;font-size: 14px;">公告</div>
<div class="content"><?php echo $notecontent; ?></div>
            </div>
            <div class="members">
                <div style="width: 100%;height: 30px;line-height: 30px;text-align: center;font-size: 14px;">成员(/<?php echo $group['people_max']; ?>)</div>
                <div class="userlist">

                </div>

            </div>
        </div>

    </div>

</div>
<div id="showimg" style="display: none">
    <img src="" style="height: auto;display: inline-block" />

</div>
<script src="/static/js/sender.js"></script>
<audio src="/static/voice/chat.mp3" id="voice_chat" preload="preload" style="display: none"></audio>
<audio src="/static/voice/friend.mp3" id="voice_msg" preload="preload" style="display: none"></audio>

<script>
    var websocketUrl='<?php echo $websocket; ?>';
    ws_join();

    var ismobile=1;
    var msgtype='text';
    var group_id=<?php echo $group['id']; ?>;
    var userid='<?php echo $user['id']; ?>';
    var avatar='<?php echo $user['avatar']; ?>';
    var nickname='<?php echo $user['nickname']; ?>';
    var is_owner=<?php echo $is_owner; ?>;
    var is_manager=<?php echo $is_manager; ?>;
    var is_deny=<?php echo $is_deny; ?>;
    var userlist=[];
    var menuid=5;
    var user_status=parseInt('<?php echo $user['status']; ?>');
    reading_id=group_id;
    function input_value(value) {

        if(value==''){
            $('#send_image').show();
            $('#send_btn').hide();
            $('#input_area').removeClass('sending');
            $('#input_area').removeClass('lines');

        }else{
            $('#send_image').hide();
            $('#send_btn').show();
            $('#input_area').addClass('sending');
        }
      var hh=document.querySelector('#input_area').scrollHeight;
        if(hh>30){
            $('#input_area').addClass('lines');
        }
        else{
            $('#input_area').removeClass('lines');
        }

    }

function  enterInput(){

    if(event.keyCode == 13 && event.ctrlKey){

        document.querySelector('#input_area').value += "\n"; //换行
    }else if(event.keyCode == 13){

       submitMsg(); //提交的执行函数
        event.preventDefault();//禁止回车的默认换行

    }
}

function  toHtml(str) {
str=str.replace(/ /g,"&nbsp;");
str=str.replace(/\n/g,"<br>");
return str;
}

function submitMsg() {

    var mid='m' + Math.random().toString(36).substring(2);
    var input_area= document.querySelector('#input_area').value;
    if(input_area!=''){

      input_area=toHtml(input_area);

         if(msgtype=='emotion'){
             var content={type:msgtype,content:input_area};
         }
         else var content=input_area;

        var data={type:'group',userid:userid,group_id:group_id,content:content,msgtype:msgtype,mid:mid};
          send_data(JSON.stringify(data));
        document.querySelector('#input_area').value='';
        document.querySelector('#input_area').focus();
        var tempdata={sender_id:userid,msg_id:mid,_mid:mid,isloading:1,message:{type:msgtype,content:content},sender:{id:userid,avatar:avatar,nickname:nickname}};
        addone(tempdata);
        msgtype='text';
        document.querySelector('.emoji').style.display='none';
        input_value('');
    }

}

function  set_deny() {
    if(user_status==0 && (is_deny==0 || is_owner==1 || is_manager==1)){
      document.querySelector('#input_area').style.display='inline-block';
      document.querySelector('#deny_tips').style.display='none';
      document.querySelector('#send_image').style.display='inline-block';
       $('.icon-smile').show();
      // document.querySelector('#input_area').focus();
   }else{
       document.querySelector('#input_area').style.display='none';
       document.querySelector('#deny_tips').style.display='inline-block';
       if(is_deny==1) {
           document.querySelector('#deny_tips').innerHTML='您已被禁言';
       }
       else if(is_deny==2) {
           document.querySelector('#deny_tips').innerHTML='全体禁言,限群主和管理员可发布消息';
       }
       else   if(is_deny==3) {
           document.querySelector('#deny_tips').innerHTML='游客禁止禁止发言';
       }
       else if (user_status>0){
           document.querySelector('#deny_tips').innerHTML='您的账号已被冻结'
       }
       $('.icon-smile').hide();
       document.querySelector('#send_image').style.display='none';
   }

    
}

function  addone(data) {

    if(data.message.type=='tips'){
        var html='<div id="msg_'+data['msg_id']+'" class="tips ">'+data.message.content.text+'</div>';
        $('.message').append(html);
        get_userlist();
    }
    else{

        if(data.sender_id==userid) var self='self';else var self='';
        if(data.message.type=='emotion'){
            var content=data.message.content.content;
            var emotion=['微笑','撇嘴', '色', '发呆', '得意', '流泪', '害羞', '闭嘴', '睡', '大哭', '尴尬', '发怒', '调皮', '呲牙', '惊讶', '难过', '酷', '冷汗', '抓狂', '吐', '偷笑', '可爱', '白眼', '傲慢', '饥饿', '困', '惊恐', '流汗', '憨笑', '大兵', '奋斗', '咒骂', '疑问', '嘘', '晕', '折磨', '衰', '骷髅', '敲打', '再见', '擦汗', '抠鼻', '鼓掌', '糗大了', '坏笑', '左哼哼', '右哼哼', '哈欠', '鄙视', '委屈', '快哭了', '阴险', '亲亲', '吓', '可怜', '菜刀', '西瓜', '啤酒', '篮球', '乒乓', '咖啡', '饭', '猪头', '玫瑰', '凋谢', '示爱', '爱心', '心碎', '蛋糕', '闪电', '炸弹', '刀', '足球', '瓢虫', '便便', '月亮', '太阳', '礼物', '拥抱', '强', '弱', '握手', '胜利', '抱拳', '勾引', '拳头', '差劲', '爱你', 'NO', 'OK', '爱情', '飞吻', '跳跳', '发抖', '怄火', '转圈', '磕头', '回头', '跳绳', '挥手', '激动',
                '闭嘴', '笑哭', '吐舌','耶', '跳舞','恐惧','失望','脸红','无语','奸笑','嘿哈','鬼混','福','合十','强壮','红包','发财','庆祝','礼物','机制'];
             for(var i=0;i<emotion.length;i++){
                   var num=i+100;
                   for(var j=0;j<100;j++){

                       if(content.indexOf("["+emotion[i]+"]")>-1){

                           //    var reg = new RegExp("["+emotion[i]+"]", "g");
                           content= content.replace("["+emotion[i]+"]","<img src='/static/emoji/"+num+".gif' class='face' />");
                       }else{
                           break;
                       }
                   }
             }
        }
        else if(data.message.type=='image'){
            if(data.isloading==0) data.message.content="/"+data.message.content;
            var content="<img src='"+data.message.content+"' class='chatimg' onclick='showimg(this.src);' />";
        }
else
        var content=data.message.content;


        var avatar=data.sender.avatar;
        var nickname=data.sender.nickname;
        if(avatar.indexOf('http')<=-1) avatar="/"+avatar;
        if(data.isloading==1) var loadshow="style='display:inline-block';";else var loadshow='';
        var showhtml='<div class="avatar" id="avatar_'+data['msg_id']+'"  onclick="avatar_menu(\''+data.msg_id+'\','+data.sender.id+');"><img src="'+avatar+'" onerror="this.src=\'../uploads/avatar.jpg\'"/></div>\n' +
            '  <div class="msg"><div class="nickname"  ><span id="nickname_'+data['msg_id']+'" onclick="avatar_menu(\''+data.msg_id+'\','+data.sender.id+');">'+nickname+'</span></div><div class="info '+data.message.type+'">'+content+'</div> </div> \n' +
            '<div class="loading" '+loadshow+'><img src="/static/images/loading.gif"/></div>';
        if(data.sender_id==userid  && data.isloading==0){
            try{
                var div=document.querySelector('#msg_'+data._mid);

                if(div!=undefined && div.innerHTML.indexOf('loading')>-1) {
                    div.querySelector('.loading').style.display="none";
                }
                else {
                    var html='<div id="msg_'+data['msg_id']+'" class="line '+self+'">'+showhtml+'</div>';
                    $('.message').append(html);
                }
            }catch (e){
                var html='<div id="msg_'+data['msg_id']+'" class="line '+self+'">'+showhtml+'</div>';
                $('.message').append(html);
            }
        }
        else{
            var html='<div id="msg_'+data['msg_id']+'" class="line '+self+'">'+showhtml+'</div>';
            $('.message').append(html);
        }

    }


    scrolltobottom();

}

function  scrolltobottom() {
    document.querySelector('.message').scrollTo(0,9999);
}
function message_add(data) {
     addone(data);
    console.log(data);
}
var layer_tips=null;
function show_usermenu(id,type,is_deny) {
    var html="<div class='usermenu'>"

    html+="<div onclick='parent.user_detail("+id+","+group_id+")'>查看资料</div>";
    if((is_owner==1 || is_manager==1) && type!='owner'){
        if(is_owner==1){
            if(type=='manager'){
                html+="<div onclick='set_manager("+id+",0)'>取消管理</div>";
            }
            if(type=='user'){
                html+="<div onclick='set_manager("+id+",1)'>设为管理</div>";
            }
        }

        if(type=='user'){
            if(is_deny==1)
            html+="<div onclick='set_userdeny("+id+",0)'>解除禁言</div>";

            if(is_deny==0)
                html+="<div onclick='set_userdeny("+id+",1)'>禁言</div>";
        }

        if(is_owner==1 && type!='owner'){
            html+="<div onclick='set_userount("+id+")'>踢人</div>";
        }
        if(is_manager==1 && type=='user'){
            html+="<div onclick='set_userount("+id+")'>踢人</div>";
        }

    }else{

        return user_detail(id,group_id);
    }


    html+="</div>";
      layer_tips= layer.tips(html, '#user_'+id, {
    });
}

function avatar_menu(id ,uid) {
   var isin=0;
   var user={};

//   if(uid==userid){
//
//       return parent.user_edit();
//   }

    for(var i=0;i<userlist.length;i++){

        if(userlist[i].id==uid){
           isin=1;
           user=userlist[i];

           break;
        }

    }

   if(isin==1) {
     var type=user.type;
     var is_deny=user.is_deny;
       var html = "<div class='usermenu'>";
       html += "<div onclick='parent.user_detail(" + uid + ","+group_id+")'>查看资料</div>";
       if ((is_owner == 1 || is_manager == 1) && type != 'owner') {
           if (is_owner == 1) {
               if (type == 'manager') {
                   html += "<div onclick='set_manager(" + uid + ",0)'>取消管理</div>";
               }
               if (type == 'user') {
                   html += "<div onclick='set_manager(" + uid + ",1)'>设为管理</div>";
               }
           }

           if (type == 'user') {
               if (is_deny == 1)
                   html += "<div onclick='set_userdeny(" + uid + ",0)'>解除禁言</div>";

               if (is_deny == 0)
                   html += "<div onclick='set_userdeny(" + uid + ",1)'>禁言</div>";
           }

           if (is_owner == 1 && type != 'owner') {
               html += "<div onclick='set_userount(" + uid + ")'>踢人</div>";
           }
           if (is_manager == 1 && type == 'user') {
               html += "<div onclick='set_userount(" + uid + ")'>踢人</div>";
           }
           html += "</div>";
           layer_tips = layer.tips(html, '#nickname_' + id, {tips:[3,'rgba(0,0,0,0.6)']});
       } else {
           return user_detail(uid,group_id);
       }

   }else{
       return user_detail(uid,group_id);
   }

}

function set_manager(id,type) {
    if(check_userlock()==false) return false;
    var data={type:'groupset1',mode:'manage',settype:type,group_id:group_id,userid:id,from_uid:userid};
    send_data(JSON.stringify(data));
    layer.close(layer_tips);
}

function  set_userdeny(id,type) {
    if(check_userlock()==false) return false;
    var data={type:'groupset1',mode:'deny',settype:type,group_id:group_id,userid:id,from_uid:userid};
    send_data(JSON.stringify(data));
    layer.close(layer_tips);
}

function set_userount(id) {
    if(check_userlock()==false) return false;
    layer.close(layer_tips);
    var index=  layer.confirm('确定要踢出?', {
        time: 20000, //20s后自动关闭
        btn: ['确定', '取消']
    },function () {
        var data={type:'deleteGroup',userid:id,group_id:group_id,fromid:userid};
       send_data(JSON.stringify(data));
        layer.close(index);

    },function () {

    });


}

function group_update() {
    get_userlist();

}

function get_userlist() {
    var loading=layer.load(1, {
        shade: [0.1,'#fff']
    });
    $.post("../api/group.php?act=userlist",{group_id:group_id}, function(result){
        layer.close(loading);
        var res=JSON.parse(result);

        if(res.code=='200'){
            var html="";
            userlist=[];
            for(var i=0;i<res.userlist.length;i++){
                var item=res.userlist[i];
                html+="<ul id=\"user_"+item.id+"\" onclick=\"show_usermenu("+item.id+",'"+item.type+"','"+item.is_deny+"');\">";
                if(item.is_deny==1) var nospeak="<div class='nospeak'></div>";else var nospeak="";
                html+=" <li><img src='"+item.avatar+"' class='avatar'/> "+nospeak+"</li>";
                html+=" <li>"+item.nickname+" </li>"
                if(item.type=='owner') html+=" <li><img src='/static/images/group1.png'/> </li>";
                else if(item.type=='manager') html+=" <li><img src='/static/images/group2.png'/> </li>";
                else if(item.isvip==1) html+=" <li><img src='/static/images/isvip.png'/> </li>";
                html+="</ul>";
                userlist.push(item);
            }
            $('.userlist').html(html);
            $('#people_count').html(res.userlist.length);
           var group=res.group;
            is_owner=group.is_owner;
            is_manager=group.is_manager;
            is_deny=group.is_deny;



            set_deny();
        }else{
            layer.msg("网络连接超时",{ type: 1, anim: 2 ,time:1000});
        }

    });
}



    get_userlist();

window.onload=function () {
 // document.querySelector('#input_area').focus();

    scrolltobottom();
}
    function  getchatlsit() {
        if(nodata==0) $('.nodata').show();
        page++;
        $.post("../api/group.php?act=msglist",{group_id:group_id,page:page}, function(result){

            var res=JSON.parse(result);

            if(res.code=='200'){
                $('.nodata').hide();

                $('.message').prepend(res.data);
            }
            else{
                if(nodata==0){
                    nodata=1;
                    $('.message').prepend("<div class=\"tips\">仅能查看最近7日的聊天记录</div>");
                    $('.nodata').hide();
                }

            }

        });
    }
var page=1;
var nodata=0;
    document.querySelector('.message').addEventListener('scroll',function (e) {

            if(document.querySelector('.message').scrollTop<=50){

                getchatlsit();

            }

    })

</script>
