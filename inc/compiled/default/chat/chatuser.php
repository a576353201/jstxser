

<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/group.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />
<script src="/static/js/group.js?v=<?php echo $cachekey; ?>"></script>


<div class="chat">

    <div class="content" style="height:460px;">

        <div class="left" style="height:460px;border: 0px;">
            <div class="message" style="height: 325px;bottom: 130px;">

                <?php if(is_array($msglist)){foreach($msglist AS $key=>$value) { ?>

                <?php if($value['type']=='tips'){?>

                <?php } else { ?>

                <div id="msg_<?php echo $value['id']; ?>" class="line <?php if($value['self']==1){?>self<?php }?>">

                    <?php if($value['type']=='apply'){?>

                    <div class="avatar" onclick="parent.user_detail(<?php echo $value['user']['id']; ?>)">
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
            <div class="sender" style="height:130px;">

                <div class="input">

                    <textarea class="textarea" id="input_area"  onKeyDown="return enterInput()"></textarea>

                </div>

                <div class="btns">
                    <div class="btn" onclick="parent.close_chatone(<?php echo $group['id']; ?>)"><i class="icon-cancel"></i>??????</div>
                    <div class="btn active" onclick="submitMsg();"><i class="icon-ok"></i>??????</div>
                </div>
            </div>
        </div>


    </div>

</div>


<script>
    var msgtype='text';
    var group_id=<?php echo $group['id']; ?>;
    var userid=parseInt('<?php echo $user['id']; ?>');
    var avatar='<?php echo $user['avatar']; ?>';
    var nickname='<?php echo $user['nickname']; ?>';
    function  enterInput(){
        if(event.keyCode == 13 && event.ctrlKey){

            document.querySelector('#input_area').value += "\n"; //??????
        }else if(event.keyCode == 13){

            submitMsg(); //?????????????????????
            event.preventDefault();//???????????????????????????

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
              var content1="<span class=\"groupname\" onclick=\"parent.user_detail("+uid+");\">"+nickname+"</span> ??????????????????<span class=\"groupname\" onclick=\"parent.group_detail("+content.other.groupid+");\">"+content.other.groupname+"</span>";
             content1+="<div><span style=\"color: #666\">?????????</span>"+content.other.content+"</div>";
              content1+="<div class=\"apply \"  name='apply_"+content.other.applyid+"'><div class=\"btns cancel\" onclick=\"deal_apply("+content.other.applyid+",2)\">??????</div><div class=\"btns ok\" onclick=\"deal_apply("+content.other.applyid+",1)\">??????</div></div>    "

            var showhtml='<div class="avatar" onclick="parent.user_detail('+uid+')"><img src="/'+avatar+'" onerror="this.src=\'../uploads/avatar.jpg\'"/></div>\n' +
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
        parent.send_data(JSON.stringify(data));

    }

    function update_apply(apply) {


       var mark="";
       if(userid!=apply.apply_uid) mark+="???????????????";
       if(apply.status==1) mark+='?????????';else  mark+="?????????";
       var  html="<div class='applymsg'>"+mark+"</div>";

        var id=apply.id;
        var list= document.getElementsByName('apply_'+id);
        console.log(list.length);
       for(var i=0;i<list.length;i++){

           list[i].outerHTML=html;
       }

    }
    function click_plan_title(id) {
        if( parent.document.querySelector("#nav_plan").className.indexOf('active')>-1){
            parent.document.querySelector('.iframe').src="plan/detail.php?id="+id;
        }else{
            parent.document.querySelector('#nav_plan').click();
            setTimeout(function () {
                parent.document.querySelector('.iframe').src="plan/detail.php?id="+id;
            },1000)
        }

    }
    function click_plan_update(id) {

        parent.layer.open({
            type: 2,
            title: false,
            shadeClose: false,shade: 0.6,
            area: ['600px','600px'],
            content: '/plan/edit.php?from=layer&id='+id //iframe???url
        });
        if( parent.document.querySelector("#nav_plan").className.indexOf('active')>-1){
            setTimeout(function () {
                parent.document.querySelector('#nav_plan').click();
            },1000)
        }

    }
    window.onload=function () {
        document.querySelector('#input_area').focus();
        scrolltobottom();
    }
</script>



<?php include_once template("footer");?>