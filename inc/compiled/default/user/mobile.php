

<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/user.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />



<div class="step" style="padding:10px;">
    <?php if($_GET['type']==2){?>
    <ul class="profile" >
        <li>新手机号：</li>
        <li>

            <input type="text" class="input1" id="mobile" value="" placeholder="输入新手机号码">

        </li>

    </ul>


    <?php } else { ?>
    <ul class="profile" >
        <li>手机号：</li>
        <li>
            <?php if($user['mobile']){?>
            <?php echo $mobile; ?>
            <input type="hidden" id="mobile" value="<?php echo $user['mobile']; ?>">
            <?php } else { ?>
            <input type="text" class="input1" id="mobile" value="<?php echo $user['mobile']; ?>" placeholder="请输入您的手机号">
            <?php }?>
        </li>

    </ul>
    <?php }?>

    <ul class="profile" >
        <li>验证码：</li>
        <li><input type="text" class="input1" id="randcode" value="" placeholder="" maxlength="6" style="width:50px;height:30px;line-height: 30px;">
            <input type="button" class="sendbtn" value="获取短信" onclick="sendsms();">


        </li>

    </ul>


    <ul class="login-lines1" >
        <input type="button" value="确认并提交" class="button1" onclick="return reset_pwd();">
    </ul>
</div>



<script>
    var timer=null;
    var getCodeTime=60;
    var type='<?php echo $type; ?>';
    function  sendsms() {
        var mobile=$('#mobile').val();
        var reg =/^0?1[3|4|5|6|7|8|9][0-9]\d{8}$/;
        if(reg.test(mobile)){

            var loading=layer.load(1, {
                shade: [0.1,'#fff']
            });
            $.post("../api/user.php?act=sendCode",{mobile:mobile,type:type}, function(result){
                layer.close(loading);
                //   console.log(result);
                var res=JSON.parse(result);

                if(res.data.method!='error'){
                    clearInterval(timer);
                    timer=setInterval(function () {
                        getCodeTime--;
                        document.querySelector('.sendbtn').disabled=true;
                        $('.sendbtn').val(getCodeTime+'秒再获取');

                        if(getCodeTime<=0){
                            document.querySelector('.sendbtn').disabled=false;
                            $('.sendbtn').val('获取短信');
                            clearInterval(timer);
                        }
                    },1000)


                }else{

                    layer.msg("该手机号已经被其他用户使用",{ type: 1, anim: 2 ,time:1000});
                }

            });

        }else{
            layer.msg("手机号码格式错误",{ type: 1, anim: 2 ,time:2000});
            return false;
        }

    }

    function reset_pwd() {
        var mobile=$('#mobile').val();
        if($('#mobile').val()==''){
            layer.msg("手机号不能为空",{ type: 1, anim: 2 ,time:2000});
            return false;
        }
        var reg =/^0?1[3|4|5|6|7|8|9][0-9]\d{8}$/;
        if(!reg.test(mobile)){
            layer.msg("手机号码格式错误",{ type: 1, anim: 2 ,time:2000});
            return false;
        }
        if($('#randcode').val()==''){
            layer.msg("短信验证码不能为空",{ type: 1, anim: 2 ,time:2000});
            return false;
        }


        if($('#randcode').val()==''){
            layer.msg("短信验证码不能为空",{ type: 1, anim: 2 ,time:2000});
            return false;
        }


        var loading=layer.load(1, {
            shade: [0.1,'#fff']
        });
        $.post("../api/user.php?act=mobile",{id:parent.userid,mobile:$('#mobile').val(),randcode:$('#randcode').val()}, function(result){
            layer.close(loading);
            var res=JSON.parse(result);
            if(res.code=='200'){
                if(type=='change'){


                    location.href='?step=2&type=2';

                }else{
                    layer.msg("手机绑定成功",{ type: 1, anim: 2 ,time:1000});
                    setTimeout(function () {
                        location.href='?step=2';
                    },1000)
                }



            }else{

                layer.msg(res.message,{ type: 1, anim: 2 ,time:1000});
            }

        });

    }


</script>


<?php include_once template("footer");?>