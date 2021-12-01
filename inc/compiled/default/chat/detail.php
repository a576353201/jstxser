

<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/group.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />
<script src="/static/js/group.js?v=<?php echo $cachekey; ?>"></script>





<div class="detail">

<div>
    <div class="info">
        <img src="<?php echo $group['avatar']; ?>" class="avatar" id="group_avatar" <?php if($is_owner==1){?>onclick="document.querySelector('#cameraInput').click();"<?php }?>/>
        <?php if($is_owner==1 || $is_manager==1){?> <div class="number" style="cursor: pointer" onclick="document.querySelector('#cameraInput').click();">[更换头像]</div><?php }?>
        <div class="title" id="group_title"><?php echo $group['name']; ?></div>
        <div class="number"><?php echo $group['id']; ?></div>


        <?php if($is_owner==1 || $is_manager==1){?>
        <form id="form111" method="post" action=""  enctype="multipart/form-data"  style='display:none;'>

            <input type="file" capture="camera" id="cameraInput" name="cameraInput" accept="image/*"   />
        </form>
        <?php }?>
    </div>
<i class="qrcode icon-qrcode" onclick="qrcode();"></i>
    <?php if($isin==1){?>
<div class="chatbtn" onclick="go_chat();"><i class="icon-chat"></i>发消息</div>
    <?php } else { ?>
    <div class="chatbtn" onclick="apply_group(<?php echo $group['no_invite']; ?>);"><i class="icon-plus-circle"></i>申请入群</div>
    <?php }?>
</div>
<div>
<div class="menu">
    <li class="active" onclick="change_tab(0);">首页</li>
    <li onclick="change_tab(1);">成员</li>
    <?php if($isin==1){?>
    <?php if($is_owner==1 || $is_manager==1){?>
    <li onclick="change_tab(2);">设置</li>
    <li onclick="change_tab(3);">其他</li>
    <?php } else { ?>
    <li onclick="change_tab(2);">其他</li>
    <?php }?>


    <span style="float: right;margin-top: 8px;margin-right: 10px;cursor: pointer;" title="邀请好友"  onclick="user_invite('<?php echo $group['id']; ?>')">
       <i class="icon-user-add" style="font-size: 16px;color: #2319DC"></i>

    </span>
    <?php }?>
</div>

<div class="info step" >
    <?php include_once template("chat/detail_info");?>
</div>

    <div  class="info step" style="display: none;position: relative;">
        <?php include_once template("chat/detail_user");?>
    </div>
    <?php if($isin==1){?>
    <?php if($is_owner==1 || $is_manager==1){?>
    <div class="info step" style="display: none">
        <?php include_once template("chat/detail_setting");?>
    </div>
    <div class="info step" style="display: none">
        <?php include_once template("chat/detail_other");?>
    </div>
    <?php } else { ?>
    <div class="info step" style="display: none">
        <?php include_once template("chat/detail_other");?>
    </div>
    <?php }?>
    <?php }?>

</div>
</div>


<script>
   var userid=parseInt('<?php echo $_SESSION['userid']; ?>');
   var is_owner=parseInt('<?php echo $is_owner; ?>');
   var issetname=parseInt('<?php echo $user['issetname']; ?>');

   function qrcode() {
     parent.layer.open({
           type: 2,
           title: false,
           shadeClose: false,
           shade: 0.6,
           area: ['320px','330px'],
           content: '/chat/qrcode.php?from=layer&id=<?php echo $group['id']; ?>' //iframe的url
       });
   }

    function go_chat() {
        parent.open_chatarea(<?php echo $group['id']; ?>,'<?php echo $group['name']; ?>','<?php echo $group['avatar']; ?>',1);
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.close(index);
    }
function apply_group(no_invite) {
    if(parent.check_userlock()==false) return false;
    if(issetname!=1){
        var index=  layer.confirm('未设置昵称，不能申请加入群组', {
            title:'提示',
            time: 20000, //20s后自动关闭
            btn: ['去设置', '取消']
        },function () {

            layer.close(index);
            parent.user_edit();
            setTimeout(function () {
                var index = parent.layer.getFrameIndex(window.name);
                parent.layer.close(index);
            },1000)
        },function () {

        });

        return false;
    }

    if(userid>0){
        //不需要审核，直接进进群
        if(no_invite==0){
            var data={type:'Join_Group',userid:userid,group_id:'<?php echo $group['id']; ?>'};
            parent.send_data(JSON.stringify(data));
            parent.layer_loading=layer.load(1, {
                shade: [0.1,'#fff']
            });
            parent.layer_name= parent.layer.getFrameIndex(window.name);;
        }else{


            parent.chat_apply(<?php echo $group['id']; ?>);
        }
    }else{
        parent.layerlogin();
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.close(index);

    }
}

   function change_tab(num) {
       var step=document.querySelectorAll('.step');
       var li=document.querySelector('.menu').querySelectorAll('li');
       for(var i=0;i<li.length;i++){
           if(i==num) {
               li[i].className='active';
               step[i].style.display='';
           }
           else {
               li[i].className='';
               step[i].style.display='none';
           }
       }

//       var index = parent.layer.getFrameIndex(window.name);
//       parent.layer.iframeAuto(index);
   }
   change_tab(<?php echo $step; ?>);

   <?php if($isin==1 ){?>
   function group_quit() {
       if(is_owner==1) var tips='确认要解散该群吗？';
       else var tips='确认要退出该群吗？';

       var index=  layer.confirm(tips, {
           time: 20000, //20s后自动关闭
           btn: ['确定', '取消']
       },function () {
           var data={type:'deleteGroup',userid:userid,group_id:<?php echo $group['id']; ?>,fromid:userid};
           parent.send_data(JSON.stringify(data));
           layer.close(index);
           parent.layer.msg("操作成功",{ type: 1, anim: 2 ,time:1000});
           location.reload();
       },function () {

       });
   }

   <?php }?>
   <?php if($is_owner==1 || $is_manager==1){?>
   var filechooser = document.getElementById("cameraInput");
   var canvas = document.createElement("canvas");
   var tCanvas = document.createElement("canvas");
   var maxsize =10*1024 * 1024;
   filechooser.onchange = function () {

       if (!this.files.length) return;

       var files = Array.prototype.slice.call(this.files);
       files.forEach(function (file, i) {
           if (!/\/(?:jpeg|png|gif)/i.test(file.type)) {   layer.msg("您选择的图片格式不正确",{ type: 1, anim: 2 ,time:1000});;return;}
           var reader = new FileReader();

//          获取图片大小
           var size = file.size/1024 > 1024 ? (~~(10*file.size/1024/1024))/10 + "MB" :  ~~(file.size/1024) + "KB";
           reader.onload = function () {

               var result = this.result;

               if (result.length <= maxsize) {

                   var img = new Image();
                   document.querySelector('#group_avatar').src=result;
                   $('.avatar').show();
                   if(result.length>2*1024*1024 ){
                       if(img.complete){

                           result= compress(img);
                           upload(result, file.type, $(li));

                           return ;
                       }

                       else{
                           img.onload = function(){
                               result= compress(img);
                               upload(result, file.type);
                               return ;
                           }
                       }
                   }
                   else{
                       upload(result, file.type);
                       return;
                   }
               }
               else{
                   layer.msg("图片最大上传10MB！",{ type: 1, anim: 2 ,time:1000});
                   return false;
               }


           };
           reader.readAsDataURL(file);
       })
   };

   //    使用canvas对大图片进行压缩
   function compress(img) {
       var initSize = img.src.length;
       var width = img.width;
       var height = img.height;
       //如果图片大于四百万像素，计算压缩比并将大小压至400万以下
       var canvas = document.createElement("canvas");

       canvas.width = width;
       canvas.height = height;
       var drawer = canvas.getContext("2d");
       drawer.drawImage(img, 0, 0,width, height);
       var ndata  = canvas.toDataURL("image/jpeg", 0.6);

       tCanvas.width = tCanvas.height = canvas.width = canvas.height = 0;
       return ndata;
   }
   //    图片上传，将base64的图片转成二进制对象，塞进formdata上传
   function upload(basestr, type) {
       var loading=layer.load(1, {
           shade: [0.1,'#fff']
       });
       var base64Data = basestr.substr(22);
       //在前端截取22位之后的字符串作为图像数据
       //开始异步上
       //   console.log(base64Data);

       $.post("../api/index.php?act=uploadImage&type=group&dir=avatar", { group_id:<?php echo $group['id']; ?>,"imgData": base64Data }, function (data, status) {
           layer.close(loading);
           is_loading=0;
           if(data.code==200){

               layer.msg("头像更换成功",{ type: 1, anim: 2 ,time:1000});

           }
           else{
               // location.reload();
               layer.msg("上传超时",{ type: 1, anim: 2 ,time:1000});
           }


       }, "json");


   }


    <?php }?>
</script>


<?php include_once template("footer");?>