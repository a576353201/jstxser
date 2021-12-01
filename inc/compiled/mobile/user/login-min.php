

<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/user.css" type="text/css" media="screen" />

<ul class="nav1">
    <li class="active" onclick="change_tab(0);">登录</li>
    <li class="" onclick="change_tab(1);">注册</li>
</ul>

<div id="login">
    <div class="login-lines1" style="margin-top: 20px;">

        <div class="line">
            <i class="icon icon-user"></i>
            <input type="text" id="login_name" value="" class="input1" placeholder="ID\用户名\手机号" >
        </div>
    </div>

    <div class="login-lines1">

        <div class="line">
            <i class="icon icon-lock"></i>
            <input type="password" id="login_password" value="" class="input1" placeholder="请输入密码" >
        </div>
    </div>
    <div class="login-lines1" style="height: 30px;line-height: 30px;margin-top: -10px;">

        <input type="checkbox" value="1" id="save" checked> 记住登录状态

        <a href="pwd1.php" style="margin-left:45px;color: #666">忘记密码</a>

    </div>

    <div class="login-lines1" style="margin-top: 10px">
        <input type="button" name="username" value="确认登录" class="button1" onclick="return click_login();">

    </div>


</div>



<div id="reg" style="display: none">
    <div class="login-lines1"  style="margin-top: 20px;">
        <div class="line">
            <i class="icon icon-user"></i>
      <input type="text" id="username" value="" class="input1" placeholder="请输入手机号" onblur="check_name(this.value);" >


        </div>
        <i id="name_tips" class="tips"></i>
    </div>

    <div class="login-lines1">
        <div class="line">
            <i class="icon icon-lock"></i>
            <input type="password" id="password" value="" class="input1" placeholder="请输入密码"  oninput="checkpwd(this.value);" onblur="check_other(this.value,'password');check_other($('#password2').val(),'password1');">
        </div>
        <i id="password_tips" class="tips"></i>
    </div>
<div class="passwordtips">
    密码强度：<span class="color0">弱</span>
</div>
    <div class="login-lines1">
        <div class="line">
            <i class="icon icon-lock"></i>
            <input type="password" id="password2" value="" class="input1" placeholder="再次输入密码" onblur="check_other(this.value,'password1');" >
        </div>
        <i id="password1_tips" class="tips"></i>
    </div>
    <div class="login-lines1">
        <div class="line">
            <i class="icon icon-shield"></i>
       <input type="text" id="randcode" value="" class="input1" maxlength="4" placeholder="验证码" onblur="check_other(this.value,'randcode');" >
            <img src='../inc/checkcode.inc.php' height='48px'  id='img_code'  onclick='change_code();' title="看不清？换一个"/>

        </div>
        <i id="randcode_tips" class="tips"></i>
    </div>
    <div class="login-lines1">

      <input type="button" value="立即注册" class="button1" onclick="return click_reg();">
    </div>


</div>


<script>
    var method='login';
    function change_tab(num) {

        var li=document.querySelector('.nav1').querySelectorAll('li');
        for(var i=0;i<li.length;i++){
            if(i==num) li[i].className='active';
            else li[i].className='';
        }

        if(num==1) {
            method='reg';
            $('#login').hide();
            $('#reg').show();

        }
        else{
            method='login';
            $('#login').show();
            $('#reg').hide();
        }

            var index = parent.layer.getFrameIndex(window.name);
        console.log(index);
            parent.layer.iframeAuto(index);


    }
    function  enterInput(){

        if(event.keyCode == 13){
          if(method=='login'){
              click_login();
          }
          else {
              click_reg();
          }
            event.preventDefault();//禁止回车的默认换行

        }
    }
    function change_code(){
        document.getElementById('img_code').src='../inc/checkcode.inc.php?rand='+Math.random();

    }
    var name_status=false;
    var code_status=false;
    function check_name(value) {
        var reg=/^[\d\w]+$/;
        if(reg.test(value)){
            if(value.length>5){
                $.post("../api/user.php?act=checkname",{username:value}, function(result){
                    var res=JSON.parse(result);
                    console.log(res);
                    if(res.code==200){
                        document.querySelector('#name_tips').className='tips icon-ok-circle';
                        name_status=true;
                    }else{
                        document.querySelector('#name_tips').className='tips icon-cancel-circle';
                        name_status=false;
                        layer.msg("该账号已经被注册",{ type: 1, anim: 2 ,time:1000});
                    }

                });

            }else{
                document.querySelector('#name_tips').className='tips icon-cancel-circle';
                name_status=false;

            }


        }else{
            document.querySelector('#name_tips').className='tips icon-cancel-circle';
            name_status=false;

        }



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
                if(name=='password'){
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

    function click_login() {

        if($('#login_name').val()==''){
            layer.msg("请输入登录账号",{ type: 1, anim: 2 ,time:1000});
            return false;
        }

        if($('#login_password').val()==''){
            layer.msg("请输入登录密码",{ type: 1, anim: 2 ,time:1000});
            return false;
        }
        var loading=layer.load(1, {
            shade: [0.1,'#fff']
        });
        if(document.querySelector('#save').checked==true)
            var save=1;
        else var save=0;
        $.post("../api/user.php?act=userlogin",{username:$('#login_name').val(),password:$('#login_password').val(),save:save}, function(result){
            layer.close(loading);
            console.log(result);
            var res=JSON.parse(result);
            if(res.code=='200'){
                userurl='user/index.php';
                parent.layer.msg("登录成功",{ type: 1, anim: 2 ,time:1000});
                setTimeout(function () {
                    parent.location.reload();
                },500)

            }else{
                layer.msg(res.message,{ type: 1, anim: 2 ,time:1000});
            }

        });

    }


    function click_reg() {

        if($('#username').val()==''){
            layer.msg("请输入手机号",{ type: 1, anim: 2 ,time:2000});
            return false;
        }

        if($('#username').val().length<6){
            layer.msg("用户长度不能小于6位",{ type: 1, anim: 2 ,time:1000});
            return false;
        }
        var reg=/^[\d\w]+$/;
        if(!reg.test($('#username').val())){
            layer.msg("用户名只能包含字母或数字",{ type: 1, anim: 2 ,time:1000});
            return false;
        }
        if($('#password').val()==''){
            layer.msg("请输入密码",{ type: 1, anim: 2 ,time:1000});
            return false;
        }

        if($('#password').val().length<6){
            layer.msg("密码长度不能小于6位",{ type: 1, anim: 2 ,time:1000});
            return false;
        }
        if($('#password').val()!=$('#password2').val()){
            layer.msg("两次密码输入不一致",{ type: 1, anim: 2 ,time:1000});
            return false;
        }
        if($('#randcode').val()==''){
            layer.msg("请输入验证码",{ type: 1, anim: 2 ,time:1000});
            return false;
        }
        if(name_status==false){
            layer.msg("该账号已经被注册",{ type: 1, anim: 2 ,time:1000});
            return false;
        }
        if(code_status==false){
            layer.msg("验证码不正确",{ type: 1, anim: 2 ,time:1000});
            return false;
        }
        var loading=layer.load(1, {
            shade: [0.1,'#fff']
        });
        $.post("../api/user.php?act=reg",{username:$('#username').val(),password:$('#password').val(),randcode:$('#randcode').val()}, function(result){
            layer.close(loading);
            var res=JSON.parse(result);
            if(res.code=='200'){
                parent.location.reload();
                layer.msg("注册成功",{ type: 1, anim: 2 ,time:1000});

            }else{
                change_code();
                layer.msg(res.message,{ type: 1, anim: 2 ,time:1000});
            }

        });


    }

</script>
