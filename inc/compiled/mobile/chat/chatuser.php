

<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/group.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />
<script src="/static/js/group_mobile.js?v=<?php echo $cachekey; ?>"></script>
<script src="/static/js/socket.js"></script>
<script src="/static/js/message.js?v=<?php echo $cachekey; ?>"></script>

<div class="chat">
    <div class="header" >
        <span ><?php echo $group['name']; ?></span>
        <i class="close icon-left-open-2"  onclick="window.location='<?php echo $_SERVER['HTTP_REFERER']; ?>';" title="关闭"></i>

    </div>
    <div class="content" >

        <div class="left">
            <div class="message">

                <?php if(is_array($msglist)){foreach($msglist AS $key=>$value) { ?>

                <?php if($value['type']=='tips'){?>

                <?php } else { ?>

                <div id="msg_<?php echo $value['id']; ?>" class="line <?php if($value['self']==1){?>self<?php }?>">

                    <?php if($value['type']=='apply'){?>

                    <div class="avatar" onclick="user_detail(<?php echo $value['user']['id']; ?>)">
                        <img src="<?php echo $value['user']['avatar']; ?>" onerror="this.src='../uploads/avatar.jpg'"/>

                    </div>

                    <div class="msg">
                        <div class="nickname"><?php echo timestamp($value['addtime']); ?>

                        </div>
                        <div class="info">

                            <?php echo $value['content']; ?>
                        </div>
                    </div>

                    <?php } else { ?>
                    <div class="avatar">
                        <img src="<?php echo $value['user']['avatar']; ?>" onerror="this.src='../uploads/avatar.jpg'"/>

                    </div>

                    <div class="msg">
                        <div class="nickname"><?php echo timestamp($value['addtime']); ?></div>
                        <div class="info" >

                            <?php echo $value['content']; ?>
                        </div>
                    </div>
                    <?php }?>
                    <div class="loading"><img src="/static/images/loading.gif"/></div>
                </div>
                <?php }?>
                <?php }}?>



            </div>


            <div class="sender">


                <div class="input">

                    <textarea style=" width: calc(100% - 80px);" class="textarea" id="input_area"   onclick=" $('.emoji').hide();"></textarea>





                    <div class="btn" id="send_btn" onclick="submitMsg();">发送</div>
                </div>

            </div>

        </div>


    </div>

</div>

<audio src="/static/voice/chat.mp3" id="voice_chat" preload="preload" style="display: none"></audio>
<audio src="/static/voice/friend.mp3" id="voice_msg" preload="preload" style="display: none"></audio>

<script>
    var websocketUrl='<?php echo $websocket; ?>';
    ws_join();
    var msgtype='text';
    var group_id=<?php echo $group['id']; ?>;
    var userid=parseInt('<?php echo $user['id']; ?>');
    var avatar='<?php echo $user['avatar']; ?>';
    var nickname='<?php echo $user['nickname']; ?>';
    var menuid=5;
    reading_id=group_id;
    function  enterInput(){
        if(event.keyCode == 13 && event.ctrlKey){

            document.querySelector('#input_area').value += "\n"; //换行
        }else if(event.keyCode == 13){

            submitMsg(); //提交的执行函数
            event.preventDefault();//禁止回车的默认换行

        }
    }
    function submitMsg() {

        var mid='m' + Math.random().toString(36).substring(2);
        var input_area= document.querySelector('#input_area').value;
        if(input_area!=''){
            var data={type:'chat',userid:userid,friend_uid:0,content:input_area,msgtype:msgtype,mid:mid};
            parent.send_data(JSON.stringify(data));
            document.querySelector('#input_area').value='';
            document.querySelector('#input_area').focus();
            var tempdata={sender_id:userid,seif:1,msg_id:mid,_mid:mid,isloading:1,message:{type:msgtype,content:input_area},sender:{avatar:avatar,nickname:nickname}};
            addone(tempdata)
        }


    }


    function  addone(data) {
        if(data.sender_id==parent.userid) var self='self';else var self='';

        var content=data.message.content;
        var avatar=data.sender.avatar;
        var nickname=data.sender.nickname;
        if(avatar.indexOf('http')<=-1) avatar="/"+avatar;
        if(data.isloading==1) var loadshow="style='display:inline-block';";else var loadshow='';

        if(data.message.type=='apply'){
           var content=data.message.content;
              avatar=content.other.avatar;
              nickname=content.other.nickname;
              var uid=content.other.userid;
              var content1="<span class=\"groupname\" onclick=\"user_detail("+uid+");\">"+nickname+"</span> 申请加入群：<span class=\"groupname\" onclick=\"group_detail("+content.other.groupid+");\">"+content.other.groupname+"</span>";
             content1+="<div><span style=\"color: #666\">附言：</span>"+content.other.content+"</div>";
              content1+="<div class=\"apply \"  name='apply_"+content.other.applyid+"'><div class=\"btns cancel\" onclick=\"deal_apply("+content.other.applyid+",2)\">拒绝</div><div class=\"btns ok\" onclick=\"deal_apply("+content.other.applyid+",1)\">同意</div></div>    "

            var showhtml='<div class="avatar" onclick="user_detail('+uid+')"><img src="/'+avatar+'" onerror="this.src=\'../uploads/avatar.jpg\'"/></div>\n' +
                '  <div class="msg"><div class="nickname">'+timestampFormat(data.timestamp)+'</div><div class="info">'+content1+'</div> </div> \n' +
                '<div class="loading" '+loadshow+'><img src="/static/images/loading.gif"/></div>';

        }else{
            var showhtml='<div class="avatar"><img src="'+avatar+'" onerror="this.src=\'../uploads/avatar.jpg\'"/></div>\n' +
                '  <div class="msg"><div class="nickname">'+nickname+'</div><div class="info">'+content+'</div> </div> \n' +
                '<div class="loading" '+loadshow+'><img src="/static/images/loading.gif"/></div>';


        }


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
        scrolltobottom();

    }


    function message_add(data) {
        addone(data);
        console.log(data);
    }
    function  scrolltobottom() {
        document.querySelector('.message').scrollTo(0,document.querySelector('.message').scrollHeight);
    }
    function deal_apply(applyid,status) {

        var data={type:'deal_group_apply',userid:userid,applyid:applyid,status:status};
        send_data(JSON.stringify(data));

    }

    function update_apply(apply) {


       var mark="";
       if(userid!=apply.apply_uid) mark+="其他管理员";
       if(apply.status==1) mark+='已同意';else  mark+="已拒绝";
       var  html="<div class='applymsg'>"+mark+"</div>";

        var id=apply.id;
        var list= document.getElementsByName('apply_'+id);
        console.log(list.length);
       for(var i=0;i<list.length;i++){

           list[i].outerHTML=html;
       }

    }
    function click_plan_title(id) {
        location.href="plan/detail.php?id="+id;

    }
    function click_plan_update(id) {

       location.href='/plan/edit.php?from=layer&id='+id //iframe的url


    }
    window.onload=function () {
        //document.querySelector('#input_area').focus();
        scrolltobottom();
    }
</script>



