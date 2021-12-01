

<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/user.css" type="text/css" media="screen" />

<ul class="nav1" >

</ul>
<div class="header">
    <span class="back" onclick="history.back();"><i class="icon-left-open-3"></i></span>
    <div class="nav" style="left: 25%;width: 50%;">
        <li class="item active" onclick="change_tab(0);">修改<?php echo $pwdname; ?>密码</li>
        <li class="item" onclick="change_tab(1);">忘记<?php echo $pwdname; ?>密码</li>
    </div>

</div>



<div class="step" style="padding:10px;margin-top: 10px;">
    <?php if($isfrist==0){?>
    <div class="login-lines1">
        <div class="line">
            <i class="icon icon-lock"></i>
            <input type="password" id="oldpwd" value="" class="input1" placeholder="请输入原始<?php echo $pwdname; ?>密码" onblur="check_other(this.value,'oldpwd');">
        </div>
        <i id="oldpwd_tips" class="tips"></i>
    </div>
    <?php }?>

    <div class="login-lines1">
        <div class="line">
            <i class="icon icon-lock"></i>
            <input type="password" id="password" value="" class="input1" placeholder="请输入新<?php echo $pwdname; ?>密码" oninput="checkpwd(this.value);" onblur="check_other(this.value,'password');check_other($('#password2').val(),'password1');">
        </div>
        <i id="password_tips" class="tips"></i>
    </div>
    <div class="passwordtips" style=" width:calc(100% - 150px); padding-left: 150px;">
        密码强度：<span class="color0">弱</span>
    </div>
    <div class="login-lines1">
        <div class="line">
            <i class="icon icon-lock"></i>
            <input type="password" id="password2" value="" class="input1" placeholder="再次输入新<?php echo $pwdname; ?>密码" onblur="check_other(this.value,'password1');">
        </div>
        <i id="password1_tips" class="tips"></i>
    </div>

    <ul class="login-lines1" >
        <input type="button" value="确认修改" class="button1" onclick="return change_pwd();">
    </ul>
</div>

<div class="step" style="padding:10px;">
    <ul class="profile" >
        <li>手机号：</li>
        <li>
            <?php echo $mobile; ?>
            <input type="hidden" id="mobile" value="<?php echo $user['mobile']; ?>">

        </li>

    </ul>
    <ul class="profile" >
        <li>验证码：</li>
        <li><input type="text" class="input1" id="randcode" value="" placeholder="" maxlength="6" style="width:50px;height:30px;line-height: 30px;">
            <span class="sendbtn" onclick="sendsms();" style="display: inline-block">发送短信</span>


        </li>

    </ul>
    <ul class="profile" >
        <li><?php echo $pwdname; ?>密码：</li>
        <li><input type="password" class="input1" id="pwd" value="" placeholder="输入新的<?php echo $pwdname; ?>密码"  onblur="check_other(this.value,'pwd');">


            <i id="pwd_tips" class="tips"></i>
        </li>

    </ul>

    <ul class="login-lines1" >
        <input type="button" value="确认并提交" class="button1" onclick="return reset_pwd();">
    </ul>
</div>



<script>
    var timer=null;
    var getCodeTime=60;
    var menuid=4;
    function  sendsms() {
        var mobile=$('#mobile').val();
        var reg =/^0?1[3|4|5|6|7|8|9][0-9]\d{8}$/;
        if(reg.test(mobile)){

            var loading=layer.load(1, {
                shade: [0.1,'#fff']
            });
            $.post("../api/user.php?act=sendCode",{mobile:mobile,type:'pwd'}, function(result){
                layer.close(loading);
             //   console.log(result);
                var res=JSON.parse(result);

                if(res.data.method!='error'){
                    clearInterval(timer);
                    timer=setInterval(function () {
                        getCodeTime--;
                        document.querySelector('.sendbtn').disabled=true;
                        $('.sendbtn').html(getCodeTime+'秒再获取');

                        if(getCodeTime<=0){
                            document.querySelector('.sendbtn').disabled=false;
                            $('.sendbtn').html('获取短信');
                            clearInterval(timer);
                        }
                    },1000)


                }else{

                    layer.msg("短信发送失败",{ type: 1, anim: 2 ,time:1000});
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
        if($('#pwd').val()==''){
            layer.msg("请输入<?php echo $pwdname; ?>密码",{ type: 1, anim: 2 ,time:1000});
            return false;
        }

        if($('#pwd').val().length<6){
            layer.msg("<?php echo $pwdname; ?>密码长度不能小于6位",{ type: 1, anim: 2 ,time:1000});
            return false;
        }

        var loading=layer.load(1, {
            shade: [0.1,'#fff']
        });
        $.post("../api/user.php?act=reset_pwd",{id:parent.userid,mobile:$('#mobile').val(),randcode:$('#randcode').val(),pwd:$('#pwd').val(),method:method}, function(result){
            layer.close(loading);
            var res=JSON.parse(result);
            if(res.code=='200'){
                    layer.msg("<?php echo $pwdname; ?>密码已重置",{ type: 1, anim: 2 ,time:1000});
                    setTimeout(function () {
                        location.href='index.php';
                    },1000)
            }else{

                layer.msg(res.message,{ type: 1, anim: 2 ,time:1000});
            }

        });


    }

    var method='<?php echo $_GET['method']; ?>';
    var isfrist=0;
    if(method=='safe') isfrist='<?php echo $isfrist; ?>';
    function change_pwd() {

        if(isfrist==0 && $('#oldpwd').val()==''){
            layer.msg("请输入原始<?php echo $pwdname; ?>密码",{ type: 1, anim: 2 ,time:2000});
            return false;
        }


        if($('#password').val()==''){
            layer.msg("请输入新<?php echo $pwdname; ?>密码",{ type: 1, anim: 2 ,time:1000});
            return false;
        }

        if($('#password').val().length<6){
            layer.msg("新密码长度不能小于6位",{ type: 1, anim: 2 ,time:1000});
            return false;
        }
        if($('#password').val()!=$('#password2').val()){
            layer.msg("两次密码输入不一致",{ type: 1, anim: 2 ,time:1000});
            return false;
        }

        var loading=layer.load(1, {
            shade: [0.1,'#fff']
        });
        $.post("../api/user.php?act=change_pwd",{method:method,id:parent.userid,password:$('#password').val(),oldpwd:$('#oldpwd').val(),isfrist:isfrist}, function(result){
            layer.close(loading);
            var res=JSON.parse(result);
            if(res.code=='200'){
                layer.msg("<?php echo $pwdname; ?>密码已修改成功",{ type: 1, anim: 2 ,time:1000});
                setTimeout(function () {
                    location.href='index.php';
                },1000)
              //  parent.location.reload();


            }else{

                layer.msg(res.message,{ type: 1, anim: 2 ,time:1000});
            }

        });


    }
    function checkpwd(pwd) {
        var p1 = (pwd.search(/[a-zA-Z]/) != -1) ? 1 : 0;
        var p2 = (pwd.search(/[0-9]/) != -1) ? 1 : 0;
        var p3 = (pwd.search(/[A-Z]/) != -1) ? 1 : 0;
        var pa = p1 + p2 + p3;

        if(pa>0){

            var num=pa-1;
            var color=document.querySelector('.passwordtips').querySelector('span');
            var arr=['弱','中','强'];
            color.innerHTML=arr[num];
            color.className='color'+num;
            $('.passwordtips').show();

        }else{
            $('.passwordtips').hide();
        }

    }
    function check_other(value,name) {




        if(value.length>0){
            if(name=='password' || name=='oldpwd'){
                if(value.length>5){
                    document.querySelector('#'+name+'_tips').className='tips icon-ok-circle';
                }   else{
                    document.querySelector('#'+name+'_tips').className='tips icon-cancel-circle';
                }
            }
            if(name=='password1'){
                if(value==$('#password').val()){
                    document.querySelector('#'+name+'_tips').className='tips icon-ok-circle';
                }   else{
                    document.querySelector('#'+name+'_tips').className='tips icon-cancel-circle';
                }
            }
            if(name=='randcode'){
                if(value.length==4){
                    $.post("../api/user.php?act=checkcode",{randcode:value}, function(result){

                        var res=JSON.parse(result);
                        if(res.code=='200'){
                            document.querySelector('#'+name+'_tips').className='tips icon-ok-circle';
                            code_status=true;
                        }else{
                            document.querySelector('#'+name+'_tips').className='tips icon-cancel-circle';
                            code_status=false;
                            layer.msg("验证码错误",{ type: 1, anim: 2 ,time:1000});
                            change_code();
                        }

                    });
                }else{
                    code_status=false;
                    document.querySelector('#'+name+'_tips').className='tips icon-cancel-circle';
                }

            }

        }else{
            document.querySelector('#'+name+'_tips').className='tips';
        }

    }

    var ismobile=<?php echo $ismobile; ?>;
    function change_tab(num) {

        if(num==1){

                if(ismobile==1){


                }else{
                    var con= layer.confirm('绑定手机号,才可以重置密码', {
                        btn: ['绑定手机', '关闭'],title:'提示'
                    },function(){
                        location.href='mobile.php?step=2'

                    });
                    return false;
                }

        }

        var step=document.querySelectorAll('.step');
        var li=document.querySelector('.nav').querySelectorAll('li');
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

        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.iframeAuto(index);
    }
    change_tab(<?php echo $step; ?>);
</script>


<?php include_once template("footer");?>