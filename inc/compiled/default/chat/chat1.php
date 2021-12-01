

<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/group.css?v=<?php echo time(); ?>" type="text/css" media="screen" />
<script src="/static/js/group.js?v=<?php echo $cachekey; ?>"></script>


<div class="chat" style="background-color: #FFFFFF">



    <?php if($isgroup==1){?>
    <ul class="menu">
<li class="active"><i class="icon-chat"></i>聊天</li>
        <li onclick="parent.group_note(<?php echo $group['id']; ?>);"><i class="icon-speaker-5"></i>公告</li>
        <?php if($is_owner==1 || $is_manager==1){?>
        <li  onclick="parent.group_detail2(<?php echo $group['id']; ?>);"><i class="icon-cog"></i>设置</li>
        <?php }?>
        <li onclick="parent.group_detail(<?php echo $group['id']; ?>);"><i class="icon-newspaper"></i>群名片</li>

    </ul>
    <?php }?>
    <div class="content">

        <div class="left" <?php if($isgroup==0){?> style='height:560px;'<?php }?>>
            <div class="nodata" style="display: none;margin-top: 40px;">
                <img src="/static/images/loading.gif" style="height: 20px"/>
            </div>
            <div class="message" <?php if($isgroup==0){?> style='height:400px;'<?php }?>>

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

                         <div class="msgline" id="nickname_<?php echo $group['id']; ?>_<?php echo $value['id']; ?>" ></div>
                         <?php if($isgroup==1){?>
                         <div class="nickname" ><span onclick="avatar_menu(<?php echo $value['id']; ?>,<?php echo $value['user']['id']; ?>);"><?php echo $value['user']['nickname']; ?></span></div>
                         <?php }?>

                         <?php if($value['type']=='redpacket'){?>
                         <div class="info redpacket <?php if($value['content']['isopen']==1){?>open<?php }?>" onclick="redpack_open(<?php echo $value['id']; ?>,<?php echo $value['self']; ?>);" >

                             <view class="info11">
                                 <?php if($value['self']==1){?>

                                     <view class="showtext"><?php echo $value['content']['title']; ?></view>
                                     <view class="icon">
                                         <img src="/static/images/redpack<?php if($value['content']['isopen']==1){?>open<?php }?>-icon.png" />
                                     </view>
                                 <?php } else { ?>

                                     <view class="icon">
                                         <img src="/static/images/redpack<?php if($value['content']['isopen']==1){?>open<?php }?>-icon.png" />
                                     </view>
                                     <view class="showtext"><?php echo $value['content']['title']; ?></view>
                                 <?php }?>

                             </view>
                             <view class="title">红包</view>
                         </div>

                         <?php } else { ?>
                         <div class="info" onclick="click_textmsg('<?php echo $value['id']; ?>','<?php echo $value['type']; ?>','<?php  if($value['type']=='text') echo html2text($value['content']); ?>','<?php echo $value['self']; ?>','<?php echo $value['addtime']; ?>');" >

                             <?php echo $value['content']; ?>
                         </div>
                         <?php }?>

                         <div class="info" style="display: none" onclick="click_textmsg('<?php echo $value['id']; ?>','<?php echo $value['type']; ?>','<?php  if($value['type']=='text') echo $value['content']; ?>','<?php echo $value['self']; ?>','<?php echo $value['addtime']; ?>');" ><?php echo $value['content']; ?></div>
                     </div>
                    <div class="loading"><img src="/static/images/loading.gif"/></div>
                </div>
               <?php }?>
                <?php }}?>



            </div>
            <div class="sender">
                <div class="bar">
                    <i class="icon-smile" title="发送表情" style="font-size: 22px" onclick="show_emoji();"></i>
                    <i class="icon-file-image" title="发送图片"  onclick="document.querySelector('#cameraInput').click(); $('.emoji').hide();"></i>
                    <i class="icon-video" title="发送视频"  onclick="document.querySelector('#cameraInput1').click(); $('.emoji').hide();"></i>
                    <i class="icon-file-archive" title="发送文件"  onclick="document.querySelector('#cameraInput2').click(); $('.emoji').hide();"></i>
                   <img src="/static/images/redpacket-icon.png" onclick="sendpacket();" title="发红包" style="height: 16px;width: 14px; vertical-align: middle;cursor: pointer;margin-bottom: 4px;margin-left: 3px" >
                </div>
                <div class="input">

                    <textarea class="textarea" id="input_area" onKeyDown="return enterInput()" onclick=" $('.emoji').hide();"  oninput="listen_input(this)"></textarea>
                    <div id="deny_tips" style="display: none"></div>

                </div>

                <div class="btns">
                    <div class="btn" onclick="parent.close_chatone(<?php echo $group['id']; ?>,isgroup)"><i class="icon-cancel"></i>关闭</div>
                    <div class="btn active" id="send_btn" onclick="submitMsg();"><i class="icon-ok"></i>发送</div>
                </div>
            </div>

          <div class="unread" onclick="scrolltop_unread();" style="display:none;position: absolute;right:5px;bottom: 162px;z-index: 1;height: 25px;line-height: 25px;border-radius: 12px;background-color: #eee;padding: 0px 10px;">
              有<span class="num" style="color:#ff0000;font-weight: 600;">0</span>条未读消息
          </div>

            <div class="emoji">

                <?php if(is_array($emotion)){foreach($emotion AS $index=>$value) { ?>

                <li title="<?php echo $emotion[$index]; ?>">
                    <img src="/static/emoji/<?php echo $index+100;?>.gif" onclick="set_emotion('<?php echo $emotion[$index]; ?>');">
                </li>
                <?php }}?>

            </div>

            <form id="form111" method="post" action=""  enctype="multipart/form-data"  style='display:none;'>

                <input type="file" capture="camera" id="cameraInput" name="cameraInput"  />
            </form>

    <form id="form222" method="post" action=""  enctype="multipart/form-data"  style='display:none;'>

        <input type="file" capture="camera" id="cameraInput1" name="cameraInput"  />
        <input type="file"id="cameraInput2" name="cameraInput2"  />
    </form>
        </div>
        <?php if($isgroup==1){?>
        <div class="right">
            <div class="note"  onclick="parent.group_note(<?php echo $group['id']; ?>);">
                <div style="width: 100%;height: 25px;line-height: 25px;text-align: center;font-size: 14px;">公告</div>
<div class="content"><?php echo $notecontent; ?></div>
            </div>
            <div class="members">
                <div style="width: 100%;height: 30px;line-height: 30px;text-align: center;font-size: 14px;">成员(<span id="people_count"><?php echo $group['people_count']; ?></span>/<?php echo $group['people_max']; ?>)</div>
                <div class="userlist">
             <?php if(is_array($userlist)){foreach($userlist AS $index=>$item) { ?>
              <?php if($index<15){?>
                   <ul id="user_<?php echo $group['id']; ?>_<?php echo $item['id']; ?>"   onclick="show_usermenu(<?php echo $item['id']; ?>,'<?php echo $item['type']; ?>','<?php echo $item['is_deny']; ?>');">

                   <li><img src='<?php echo $item['avatar']; ?>' class='avatar'/>  <?php if($item['is_deny']==1){?><div class='nospeak'></div><?php }?></li>
                    <li><?php echo $item['nickname']; ?></li>
                    <?php if($item['type']=='owner'){?><li><img src='/static/images/group1.png'/> </li>
                    <?php } else if($item['type']=='manager') { ?><li><img src='/static/images/group2.png'/> </li>
                    <?php } else if($item['isvip']==1) { ?><li><img src='/static/images/isvip.png'/> </li>
                    <?php }?>
                 </ul>
               <?php }?>
               <?php }}?>
                </div>

            </div>
        </div>
        <?php }?>

    </div>

</div>
<div id="showimg" style="display: none">
    <img src="" style="height: auto;display: inline-block" />

</div>
<script src="/static/js/sender.js?v=<?php echo $cachekey; ?>"></script>

<script>
    var ismobile=0;
    var msgtype='text';
    var group_id=<?php echo $group['id']; ?>;
    var userid='<?php echo $user['id']; ?>';
    var avatar='<?php echo $user['avatar']; ?>';
    var nickname='<?php echo $user['nickname']; ?>';
    var is_owner=<?php echo $is_owner; ?>;
    var is_manager=<?php echo $is_manager; ?>;
    var is_deny=<?php echo $is_deny; ?>;
    var isgroup=<?php echo $isgroup; ?>;
    var userlist=[];
    var isatuser=false;
    var atuser='';

    var user_status=parseInt('<?php echo $user['status']; ?>');


function  enterInput(){

    if(event.keyCode == 13 && event.ctrlKey){

        document.querySelector('#input_area').value += "\n"; //换行
    }else if(event.keyCode == 13){

       submitMsg(); //提交的执行函数
        event.preventDefault();//禁止回车的默认换行

    }
}

function click_atuser(id) {

     for(var i=0;i<userlist.length;i++){
         if(userlist[i].id==id){
            document.querySelector('#input_area').value+="@"+userlist[i].nickname;
            isatuser=true;
            atuser={id:id,nickname:userlist[i].nickname}
         }
     }
    layer.close(layer_tips);
}

function listen_input(div) {
    var value=div.value;
    if(isgroup==1){
        var last=value.substr(value.length-1,1);
        if(atuser!=''){
            if(value.indexOf('@'+atuser.nickname)<=-1){
                atuser='';
                isatuser=false;
            }
        }

//       if(last=='@' || (isatuser==true && last!='@')){
//         //  isatuser=true;
//
//       }else{
//         isatuser=false;
//         atuser='';
//       }
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

        if(isgroup==1){

            if( msgtype=='text' && atuser!='' && isatuser==true && content.indexOf('@'+atuser.nickname)>-1 ){
                var content=input_area.replace('@'+atuser.nickname,'@{'+atuser.id+'}');
                var content={
                    type:'remind',
                    remind:atuser,
                    content:content
                }
            }

            var data={type:'group',userid:userid,group_id:group_id,content:content,msgtype:msgtype,mid:mid};

        }
      else   var data={type:'chat',userid:userid,friend_uid:group_id,content:content,msgtype:msgtype,mid:mid};


        parent.send_data(JSON.stringify(data));
        document.querySelector('#input_area').value='';
        document.querySelector('#input_area').focus();
        var tempdata={sender_id:userid,msg_id:mid,_mid:mid,isloading:1,message:{type:msgtype,content:content},sender:{id:userid,avatar:avatar,nickname:nickname}};
        addone(tempdata);

        msgtype='text';
        document.querySelector('.emoji').style.display='none';
    }

}
function redpack_open(id,self) {

    var banknum='<?php echo $user['banknum']; ?>';
        if(parseInt(banknum)<1){
            parent.layer.msg("绑定银行卡后才可以拆红包",{ type: 1, anim: 2 ,time:1000});
            return false;
        }

        if(isgroup==0 && self!=1){
            parent.layer.open({
                type: 2,
                title:false,
                closeBtn:true,
                shadeClose: false,shade: 0.6,
                area: ['260px','350px'],
                content: '/chat/redpacket_detail.php?from=layer&id='+id//iframe的url
            });
        }else{
            parent.layer.open({
                type: 2,
                title:false,
                closeBtn:true,
                shadeClose: false,shade: 0.6,
                area: ['260px','350px'],
                content: '/chat/redpacket_open.php?from=layer&id='+id//iframe的url
            });
        }

}
function sendpacket() {

    var banknum='<?php echo $user['banknum']; ?>';
    if(parseInt(banknum)<1){
        parent.layer.msg("绑定银行卡后才可以发送红包",{ type: 1, anim: 2 ,time:1000});
        return false;
    }
    parent.layer.open({
        type: 2,
        title:false,
        closeBtn:true,
        shadeClose: false,shade: 0.6,
        area: ['320px','430px'],
        content: '/chat/redpacket_send.php?from=layer&id='+group_id+"&isgroup="+isgroup//iframe的url
    });
}
function  set_deny() {
     if(user_status==0 && (is_deny==0 || is_owner==1 || is_manager==1)){
      document.querySelector('#input_area').style.display='inline-block';
      document.querySelector('#deny_tips').style.display='none';
      document.querySelector('#send_btn').style.display='inline-block';
       document.querySelector('#input_area').focus();
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

       document.querySelector('#send_btn').style.display='none';
   }

    
}
function chat_back(id) {

    $('#msg_'+id).remove();
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
            try{
                var content=data.message.content.content;
            }catch (e){
                var content=data.message.content;
            }

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
        else if(data.message.type=='vedio'){
            if(data.isloading==0) data.message.content="/"+data.message.content;
            var content="<video src='"+data.message.content+"'onclick='showimg(this.src);'  controls=\"\" style=\"width: 100%;max-width: 253px\"/>";
        }

        else if(data.message.content.type=='remind'){
            if(data.message.content.remind.id==userid){
                var content=data.message.content.content.replace('@{'+data.message.content.remind.id+'}','有人@我')
            }
            else{
                var content=data.message.content.content.replace('@{'+data.message.content.remind.id+'}','@'+data.message.content.remind.nickname)
            }

        }

else
        var content=data.message.content;


        var avatar=data.sender.avatar;
        var nickname=data.sender.nickname;
        if(avatar.indexOf('http')<=-1) avatar="/"+avatar;
        if(data.isloading==1) var loadshow="style='display:inline-block';";else var loadshow='';
        var showhtml='<div class="avatar" id="avatar_'+data['msg_id']+'"  onclick="avatar_menu(\''+data.msg_id+'\','+data.sender.id+');"><img src="'+avatar+'" onerror="this.src=\'../uploads/avatar.jpg\'"/></div>\n' +
            '<div class="msg"><div class="msgline"  id="nickname_'+group_id+'_'+data.msg_id+'"></div>';
  if(isgroup)
        showhtml+=' <div class="nickname"  ><span onclick="avatar_menu(\''+data.msg_id+'\','+data.sender.id+');">'+nickname+'</span></div>';
       if(data.message.type=='redpacket'){
           if(self=='self') var isself=1;else var isself=0;
        showhtml+=' <div class="info redpacket" onclick="redpack_open('+data.msg_id+','+isself+');" >  <view class="info11">' ;
        if(self=='self'){
            showhtml+=' <view class="showtext">'+content.title+'</view> <view class="icon"><img src="/static/images/redpack-icon.png" /></view>';

        }else{
            showhtml+=' <view class="icon"><img src="/static/images/redpack-icon.png" /></view><view class="showtext">'+content.title+'</view> ';
        }

            showhtml+='</view><view class="title">彩匠红包</view></div>';

       }
       else
        showhtml+='<div class="info" onclick="click_textmsg(\''+data.msg_id+'\',\''+data.message.type+'\',\''+data.message.content+'\',\''+data.self+'\',\''+data.timestamp+'\')">'+content+'</div> </div> \n' +
            '<div class="loading" '+loadshow+'><img src="/static/images/loading.gif"/></div>';
        if(data.sender_id==userid  && data.isloading==0){
            try{
                var div=document.querySelector('#msg_'+data._mid);

                if(div!=undefined && div.innerHTML.indexOf('loading')>-1) {
                  //  div.querySelector('.loading').style.display="none";
                    $('#msg_'+data._mid).remove();
                }

                    var html = '<div id="msg_' + data['msg_id'] + '" class="line ' + self + '" onclick="">' + showhtml + '</div>';
                    $('.message').append(html);

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

    if(self=='self' || isbottom==true)
    scrolltobottom();
    else{
       if(unreadid==0) unreadid=data.msg_id;
       unreadnum++;
       if(unreadnum>0) {
           $('.unread').show();
           $('.unread .num').html(unreadnum);
       }
    }

}
var unreadnum=0;
var unreadid=0;
function  scrolltobottom() {
    document.querySelector('.message').scrollTo(0,document.querySelector('.message').scrollHeight);
    isbottom=true;
    unreadid=0;
    unreadnum=0;
    $('.unread').hide();
}

function  scrolltop_unread() {
    $(".message").animate({ scrollTop: $("#msg_"+unreadid).offset().top }, {duration: 500,easing: "swing"});
    unreadid=0;
    unreadnum=0;
    $('.unread').hide();
}
function message_add(data) {
     addone(data);

}

var layer_tips=null;
function show_usermenu(id,type,is_deny) {
    var html="<div class='usermenu'>"

    html+="<div onclick='parent.user_detail("+id+","+group_id+")'>查看资料</div>";
    if(isgroup==1){
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

        }

    }
    else{

        return parent.user_detail(id,group_id);
    }

    html+="<div onclick='click_atuser("+id+")'>@TA</div>";
    html+="</div>";
      layer_tips= layer.tips(html, '#user_'+group_id+'_'+id, {
    });
}


function click_textmsg(id,type,content,self,adddtime) {
    console.log(id,type,content,self,adddtime);
    var html="<div class='usermenu'>"

    html+="<div onclick='msg_delete("+id+")'>删除</div>";
    if(type=='text')  html+="<div onclick='msg_copy(\""+content+"\")'>复制</div>";
  if((isgroup==1  && (is_manager || is_owner)) || (self==1 && parseInt((new Date()).getTime() / 1000)-adddtime<=120))  html+="<div onclick='msg_back("+id+")'>测回</div>";
    html+="</div>";
    console.log( '#user_'+group_id+'_'+id)
    layer_tips= layer.tips(html, '#nickname_'+group_id+'_'+id, {
    });
}

function msg_back(id){
if(isgroup==1) var storeKey='G'+group_id;
else var storeKey='U'+group_id;
    var  data = {
        userid:parseInt(userid),
        msg_id: id,
        type:'chat_back',
        store:storeKey
    }
    parent.send_data(JSON.stringify(data));
    layer.close(layer_tips);
}

function msg_copy(content){
    copy(content);
    layer.close(layer_tips);
}

function  msg_delete(id) {
    $("#msg_"+id).remove();

    var postdata = {
        id: id,
        userid: userid
    };
    $.post("../api/group.php?act=clearchatlist",postdata, function(result){


    });
    parent.lastchat();
//
//    if (isgroup) {
//        var groupid =id;
//
//        var touid = 0;
//
//    } else {
//        var touid =id;
//        var groupid = 0;
//
//    }
//    console.log({groupid: groupid, userid: userid, touid: touid, isgroup:isgroup})
//    $.post("../api/group.php?act=delete_msglist",{groupid: groupid, userid: userid, touid: touid, isgroup:isgroup}, function(result){
//
//
//    });

    layer.close(layer_tips);

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

       if(isgroup==1){

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


           }
        //   html+="<div onclick='click_atuser("+id+")'>@TA</div>";
           html += "<div onclick='click_atuser(" + uid + ")'>@TA</div>";
           html += "</div>";
           layer_tips = layer.tips(html, '#nickname_'+group_id+'_'+ id, {tips:[3,'rgba(0,0,0,0.6)']});
       }
      else {
           return parent.user_detail(uid,group_id);
       }

   }else{
       return parent.user_detail(uid,group_id);
   }

}

function set_manager(id,type) {
    if(parent.check_userlock()==false) return false;
    var data={type:'groupset1',mode:'manage',settype:type,group_id:group_id,userid:id,from_uid:userid};
    parent.send_data(JSON.stringify(data));
    layer.close(layer_tips);
}

function  set_userdeny(id,type) {
    if(parent.check_userlock()==false) return false;
    var data={type:'groupset1',mode:'deny',settype:type,group_id:group_id,userid:id,from_uid:userid};
    parent.send_data(JSON.stringify(data));
    layer.close(layer_tips);
}

function set_userount(id) {
    if(parent.check_userlock()==false) return false;
    layer.close(layer_tips);
//    var index=  layer.confirm('确定要踢出?', {
//        time: 20000, //20s后自动关闭
//        btn: ['确定', '取消']
//    },function () {
//        var data={type:'deleteGroup',userid:id,group_id:group_id,fromid:userid};
//        parent.send_data(JSON.stringify(data));
//        layer.close(index);
//
//    },function () {
//
//    });
    parent.layer.open({
        type: 2,
        title: "选择踢出用户理由",
        shadeClose: false,shade: 0.6,
        area: ['300px','250px'],
        content: '/chat/logout.php?from=layer&userid='+id+"&group_id="+group_id //iframe的url
    });

}

function group_update() {
   if(isgroup==1)  get_userlist();

}

if(isgroup==1){
    setTimeout(function () {
     get_userlist();
    },500)
}

function get_userlist() {

    $.post("../api/group.php?act=userlist",{group_id:group_id}, function(result){

        var res=JSON.parse(result);

        if(res.code=='200'){
            var html="";
            userlist=[];
            for(var i=0;i<res.userlist.length;i++){
                var item=res.userlist[i];
                html+="<ul id=\"user_"+group_id+"_"+item.id+"\" onclick=\"show_usermenu("+item.id+",'"+item.type+"','"+item.is_deny+"');\">";
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


window.onload=function () {
  document.querySelector('#input_area').focus();

    scrolltobottom();
}

    function  getchatlsit() {
        if(nodata==0) $('.nodata').show();
        page++;
        $.post("../api/group.php?act=msglist",{group_id:group_id,page:page,isgroup:isgroup}, function(result){

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
    var isbottom=false;
    document.querySelector('.message').addEventListener('scroll',function (e) {


        if(document.querySelector('.message').scrollHeight-document.querySelector('.message').scrollTop<=document.querySelector('.message').clientHeight+50){
            isbottom=true;
            unreadid=0;
            unreadnum=0;
            $('.unread').hide();
        }
        else isbottom=false;

        if(document.querySelector('.message').scrollTop<=50){

            getchatlsit();

        }

    })
</script>



<?php include_once template("footer");?>