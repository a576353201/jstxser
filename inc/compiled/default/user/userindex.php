<ul class="usercenter">
<li>
    <img src="<?php echo $user['avatar']; ?>" class="avatar"><br>
    <span style="color: #2319dc;cursor: pointer" onclick="document.querySelector('#cameraInput').click();">更换头像</span>
    <form id="form111" method="post" action=""  enctype="multipart/form-data"  style='display:none;'>

        <input type="file" capture="camera" id="cameraInput" name="cameraInput"   />


    </form>
</li>
<li style="width: 230px;">
    <div style="position: relative" ><span style="font-size: 16px;font-weight: 600;"><?php echo $user['nickname']; ?></span>
    <?php if($user['sex']>0){?>
        <img src="/static/images/gender<?php echo $user['sex']; ?>.png" style="height: 16px;vertical-align: middle;border-radius: 5px;margin-left: 5px;margin-bottom: 5px"/>
        <?php }?>
        <?php if($system['signopen']==1){?>
        <?php if($is_signed==1){?>
        <span class="sign_btn ok"><i class="icon-ok"></i>已签</span>
        <?php } else { ?>
        <span class="sign_btn click" onclick="click_sign();"><i class="icon-plus-circle"></i>签到</span>
        <?php }?>
        <?php }?>
    </div>
    <div>ID:<?php echo $user['number']; ?>

        <img src="/static/images/vip<?php if($user['vip']>0){?>1<?php } else { ?>0<?php }?>.png" style="height: 20px;vertical-align: middle;cursor: pointer" title="加入VIP" <?php if($user['vip']!=2){?> onclick="joinvip();" <?php }?>>

    </div>

    <div style="color: #666;font-size: 12px;">最近登录时间:<?php echo date('Y-m-d H:i',$user['logintime']); ?></div>

</li>



</ul>

<div class="security-center">
    <ul class="security-settings">

        <li class="bind-cpwd">
            <i class="icon icon-sec icon-money-1"></i>
            <h4>我的钱包</h4>
            <p style="line-height: 30px">
       账户余额：<?php echo $user['money']; ?>

            </p>
<div class="btnline">
    <div class="btn" onclick="location.href='recharge.php';">充值</div>
<div class="btn"  onclick="location.href='plat.php';">提现</div>
    <div class="btn"  onclick="location.href='money.php';">账单</div>
</div>

        </li>
        <li class="bind-question">
            <i class="icon icon-sec icon-credit-card"></i>
            <h4>提现账户</h4>
            <p>为了方便您申请提现，建议及时绑定提现账户</p>
            <a onclick="add_bank();" class="btn11 btn-SecurityQuestion">设置</a>
        </li>

        <li class="bind-name">
            <i class="icon icon-sec icon-lock"></i>
            <h4>密码修改</h4>
            <p>不定时修改，可以提高账户的安全性</p>
            <div class="btnline">
                <div class="btn" onclick="location.href='pwd.php?step=0&method=login'">登录密码</div>
                <div class="btn" onclick="location.href='pwd.php?step=0&method=safe'">资金密码</div>

            </div>

        </li>
        <li class="bind-pwd">
            <i class="icon icon-sec icon-shield"></i>
            <h4>我是代理</h4>
            <p>邀请好友注册,可赚取佣金</p>
            <div class="btnline">
                <div class="btn" onclick="invite(1)">邀请好友</div>
                <div class="btn" onclick="invite(0)">我的下级</div>
            </div>
        </li>


    </ul>
</div>
<script>
var ismobile=<?php echo $ismobile; ?>;
    function joinvip() {
        var index= parent.layer.open({
            type: 2,
            title: false,
            shadeClose: true,
            shade: 0.6,
            area: ['350px','260px'],
            content: "/user/joinvip.php"//iframe的url
        });
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.close(index);
    }

    function invite(method) {
        var index= parent.layer.open({
            type: 2,
            title: false,
            shadeClose: true,
            shade: 0.6,
            area: ['450px','400px'],
            content: "/user/invite.php?method="+method//iframe的url
        });
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.close(index);
    }
    function click_sign() {
        if(parent.check_userlock()==false) return false;
        var loading=layer.load(1, {
            shade: [0.1,'#fff']
        });
        $.post("../api/user.php?act=sign", {}, function (res) {
            layer.close(loading);
            var data=JSON.parse(res);
            if (data.code == 200) {

                var str="<div style='text-align: center;line-height: 60px;line-height: 60px;'><i style='color:#2319dc;font-size:26px; ' class='icon-ok'></i>"+data.message+"</div>";
                layer.open({
                    type: 1,
                    title: false,
                    area: ['250px', '70px'],
                    shade: 0.8,
                    closeBtn: 0,
                    time:2000,
                    shadeClose: true,
                    content: str
                });
                $('.sign_btn').removeClass('click');
                $('.sign_btn').addClass('ok');
                $('.sign_btn').html("<i class=\"icon-ok\"></i>已签");

            }
            else {
                // location.reload();
                layer.msg(data.message, {type: 1, anim: 2, time: 1000});
            }


        });

    }
    
    function forgetpwd(method) {
        if(ismobile==1){

            location.href='pwd.php?step=1&method='+method
        }else{
           var con= layer.confirm('绑定手机号,才可以重置密码', {
                btn: ['绑定手机', '关闭'],title:'提示'
            },function(){
               layer.close(con);
                change_tab(2);
            });
        }

    }
    var issetpwd='<?php echo $issetpwd; ?>';
   function add_bank() {
       if(ismobile==1 && issetpwd==1){

           location.href='bank.php'
       }else{
           if(ismobile==0){
               var con= layer.confirm('绑定手机号,才可设置银行卡', {
                   btn: ['绑定手机', '关闭'],title:'提示'
               },function(){
                   layer.close(con);
                   change_tab(2);
               });
           }
           else {
               var con= layer.confirm('请先设置资金密码', {
                   btn: ['去设置', '关闭'],title:'提示'
               },function(){
                   layer.close(con);
                   location.href='pwd.php?step=0&method=safe'
               });
           }

       }
   }
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
                 document.querySelector('.avatar').src=result;

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
        $.post("../api/index.php?act=uploadImage&type=avatar&dir=avatar", { id:parent.userid,"imgData": base64Data }, function (data, status) {
            layer.close(loading);
            if(data.code==200){
                layer.msg("头像上传成功",{ type: 1, anim: 2 ,time:1000});
            }
            else{
               // location.reload();
               layer.msg("上传超时",{ type: 1, anim: 2 ,time:1000});
            }


        }, "json");


    }
</script>