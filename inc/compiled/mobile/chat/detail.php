

<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/group.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />
<script src="/static/js/group_mobile.js?v=<?php echo $cachekey; ?>"></script>
<script src="/static/js/socket.js"></script>
<script src="/static/js/message.js?v=<?php echo $cachekey; ?>"></script>
<style>

    body{
        background-color: #Fafafa;
    }

    .btn2{
        height: 25px;
        line-height: 25px;
        vertical-align: middle;
        border-radius: 5px;
        text-align: center;
        border: 0px;
        background-color: #ddd;
        color: #666;
        padding: 0px 10px;
    }

    .step{
        padding-top: 40px;
        position: relative;
    }

</style>


<div class="header " style="padding: 5px 0px;">
    <span class="back" style="top:5px;" onclick="close_layer();"><i class="icon-left-open-3"></i></span>
    <div class="menu3" >
        <li class="item active" onclick="change_tab(0);">首页</li>
        <li class="item" onclick="change_tab(1);">成员</li>
        <li class="item" onclick="change_tab(2);">公告</li>
        <?php if($is_owner==1 || $is_manager==1){?>
        <li class="item" onclick="change_tab(3);">设置</li>
        <?php }?>

    </div>

</div>
<div class="step">
    <?php include_once template("chat/detail_info");?>

</div>

<div class="step" style="display: none">

    <?php include_once template("chat/detail_user");?>
</div>

<div class="step" style="display: none">

    <?php include_once template("chat/note");?>

</div>
<div class="step" style="display: none">

    <?php include_once template("chat/detail_setting");?>
</div>




<script>
    var userid=parseInt('<?php echo $_SESSION['userid']; ?>');
    var is_owner=parseInt('<?php echo $is_owner; ?>');
    var is_manager=parseInt('<?php echo $is_manager; ?>');
    var issetname=parseInt('<?php echo $user['issetname']; ?>');
    var group_id='<?php echo $group['id']; ?>';
    var from='<?php echo $_GET['from']; ?>';

    if(from=='qrcode'){
        var websocketUrl='<?php echo $websocket; ?>';
        ws_join();
    }

    function close_layer() {
        if(from=='qrcode'){
           location.href='/mobile.php';
        }else{
            var index = parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);
        }

    }

    function login_btn() {
        if(from=='qrcode'){
            showlogin();
        }else{
            parent.showlogin();
        }
    }
    function qrcode() {

        if(from=='qrcode'){
            layer.open({
                type: 2,
                title: false,
                shadeClose: false,
                shade: 0.6,
                area: ['300px','320px'],
                content: '/chat/qrcode.php?from=layer&id=<?php echo $group['id']; ?>' //iframe的url
            });
        }else{
            parent.layer.open({
                type: 2,
                title: false,
                shadeClose: false,
                shade: 0.6,
                area: ['300px','320px'],
                content: '/chat/qrcode.php?from=layer&id=<?php echo $group['id']; ?>' //iframe的url
            });
        }

    }

    function go_chat() {
        if(from=='qrcode'){
            open_chatarea(<?php echo $group['id']; ?>,'<?php echo $group['name']; ?>','<?php echo $group['avatar']; ?>');
        }else{
            parent.open_chatarea(<?php echo $group['id']; ?>,'<?php echo $group['name']; ?>','<?php echo $group['avatar']; ?>');
            var index = parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);
        }

    }
    function apply_group(no_invite) {

        if(userid>1){

        }else{
            if(from=='qrcode' ){
                layerlogin();
            }else{
                parent.layerlogin();
                var index = parent.layer.getFrameIndex(window.name);
                parent.layer.close(index);
            }
            return false;
        }

        if(issetname!=1){
            var index=  layer.confirm('未设置昵称，不能申请加入群组', {
                title:'提示',
                time: 20000, //20s后自动关闭
                btn: ['去设置', '取消']
            },function () {

                if(from=='qrcode'){
                    location.href='/user/profile.php';
                }else{
                    layer.close(index);

                    parent.location.href='/user/profile.php';
                    setTimeout(function () {
                        var index = parent.layer.getFrameIndex(window.name);
                        parent.layer.close(index);
                    },1000)
                }


            },function () {

            });

            return false;
        }

        if(userid>0){
            //不需要审核，直接进进群

            if(from=='qrcode'){
                if(no_invite==0){
                    var data={type:'Join_Group',userid:userid,group_id:'<?php echo $group['id']; ?>'};
                       send_data(JSON.stringify(data));

                }else{


                  chat_apply(<?php echo $group['id']; ?>);
                }
            }else{
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
            }


        }else{

            if(from=='qrcode'){
                showlogin();
            }else{
                parent.showlogin();
                var index = parent.layer.getFrameIndex(window.name);
                parent.layer.close(index);
            }



        }
    }

    function change_tab(num) {
        var step=document.querySelectorAll('.step');
        var li=document.querySelector('.menu3').querySelectorAll('li');
        for(var i=0;i<li.length;i++){
            if(i==num) {
                li[i].className='item active';
                step[i].style.display='';
            }
            else {
                li[i].className='item';
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
           parent.history.back();
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
