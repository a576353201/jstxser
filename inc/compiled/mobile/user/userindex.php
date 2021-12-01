

<style>
    .fresh{
        transform: rotate(0deg);
        -webkit-transform: rotate(0deg);
        -moz-transform: rotate(0deg);
        -o-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
    }
  .fresh.active{
        transform: rotate(360deg);
        -webkit-transform: rotate(360deg);
        -moz-transform: rotate(360deg);
        -o-transform: rotate(360deg);
        -ms-transform: rotate(360deg);
        transition: all 0.5s ease-in-out;
        -webkit-transition: all 0.5s ease-in-out;
        -moz-transition: all 0.5s ease-in-out;
        -o-transition: all 0.5s ease-in-out;
    }
</style>

<div  class="usercenter">

    <ul>
        <li>
            <img src="<?php echo $user['avatar']; ?>" class="avatar"><br>
            <span style="color: #fff;cursor: pointer" onclick="document.querySelector('#cameraInput').click();">更换头像</span>
            <form id="form111" method="post" action=""  enctype="multipart/form-data"  style='display:none;'>

                <input type="file"  id="cameraInput" name="cameraInput" accept="image/*" data-role="none" />


            </form>
        </li>
        <li>
            <div ><span style="font-size: 16px;font-weight: 600;"><?php echo $user['nickname']; ?></span>
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
            <div>ID:<?php echo $user['number']; ?></div>

            <div id="money">余额：￥<span id="showmoney" style="color: #ff0000;padding:0px 2px;"><?php echo $user['money']; ?></span>
                <img onclick="fresh_money();" src="/static/images/mobile/fresh.png"  class="fresh" style="height: 15px;vertical-align: middle;margin-left: 1px;"/></div>

        </li>

    </ul>
    <div class="other" style="top:42px;">
        <div class="row">
            <div  style="font-size: 12px;">今日打赏</div>
            <div  style="color: #ff0000;">￥<?php echo $dashang; ?></div>
        </div>
        <div class="row">
            <div  style="font-size: 12px;">今日佣金</div>
            <div  style="color: #ff0000;">￥<?php echo $yongjin; ?></div>
        </div>

    </div>

    <div class="menu">

        <div class="row" onclick="location.href='recharge.php';">
            <i class="icon-coins-money-stack"></i>充值

        </div>
        <div class="row" onclick="location.href='plat.php';">
            <i class="icon-cash"></i>提现

        </div>
        <div class="row" onclick="location.href='money.php';">
            <i class="icon-chart"></i>账单

        </div>


    </div>

</div>

<div class="usermenu1" style="margin-top: 10px;" >
    <div class="title"><i class="icon-cog"></i>账户设置</div>
    <ul class="info">
       <li style="line-height: 23px;" onclick="location.href='profile.php';"><i class="icon-edit" style="color: #0aad6c;font-size: 28px;"></i><br>修改资料</li>
        <li onclick="location.href='mobile.php';"><i class="icon-mobile-1" style="color: #2319dc"></i><br>绑定手机</li>
        <li onclick="location.href='bank.php';"><i class="icon-credit-card" style="color: #be28bd;"></i><br>提现账户</li>
        <li onclick="location.href='pwd.php?step=0&method=login';"><i class="icon-lock-2" style="color: #be2827"></i><br>登录密码</li>
        <li onclick="forgetpwd('safe');"><i class="icon-shield" style="color: #ff2929;"></i><br>资金密码</li>

    </ul>
</div>

<div class="usermenu1" >
    <div class="title"><i class="icon-chat"></i>我的群组</div>
    <ul class="info">
        <li onclick="location.href='/chat/mygroup.php?type=0';"><i class="icon-user-add" style="color: #4c9bf6;"></i><br>我创建的</li>
        <li onclick="location.href='/chat/mygroup.php?type=1';"><i class="icon-users"  style="color: #b43ae0;"></i><br>我加入的</li>
    </ul>
</div>

<div class="usermenu1" >
    <div class="title"><i class="icon-chart-line-1"></i>我的计划</div>
    <ul class="info">
        <?php if($user['isvip']==1){?>

        <li onclick="location.href='/plan/my_add.php';"  ><i class="icon-chart" style="color: #2319dc;"></i><br>我的发布</li>
        <?php } else { ?>
        <li  onclick="plan_apply();" >  <i class="icon-chart"  style="color: #2319dc;"></i> <br>申请计划员</li>

        <?php }?>

        <li onclick="my_plan_reward(0);"><i class="icon-money"  style="color:#ff4d51"></i><br>打赏记录</li>
        <li onclick="my_plan_action(0);" ><i class="icon-star" style="color: #9b1f1f"></i><br>我的关注</li>

    </ul>
</div>



<div style="width: 80%;margin: 20px auto;">
    <div class="button1" style="text-align: center" onclick="quit_login();">
        <i class="icon-logout"></i>
        退出登录
    </div>

</div>
<div style="height: 50px;width: 100%"></div>
<script>
    function click_sign() {
        if(check_userlock()==false) return false;
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
  function fresh_money() {
      $('.fresh').addClass('active');
      setTimeout(function () {
          $('.fresh').removeClass('active');
      },800)
      $.post("/api/user.php?act=usermoney",{}, function(result){
          var res=JSON.parse(result);
          $('#showmoney').html(res.data);
      });
  }
    function quit_login() {

        var index=  layer.confirm('确认要退出登录么？', {
            title:'提示',
            time: 10000, //20s后自动关闭
            btn: ['确定', '取消']
        },function () {
            layer.close(index);
            $.get("/user/quit.php",{}, function(result){

                layer.msg("退出成功",{ type: 1, anim: 2 ,time:2000});
                setTimeout(function () {
                    location.href="/mobile.php";
                },1500)

            });
        },function () {

        });


    }

    function forgetpwd(method) {
        if(ismobile==1){

            location.href='pwd.php?step=0&method='+method
        }else{
           var con= layer.confirm('绑定手机号,才可以设置支付密码', {
                btn: ['绑定手机', '关闭'],title:'提示'
            },function(){
               layer.close(con);
               location.href='mobile.php'

            });
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