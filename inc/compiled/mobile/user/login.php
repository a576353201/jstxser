

<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/user.css?v=<?php echo time(); ?>" type="text/css" media="screen" />

<div style="height: 890px;
    background: url(/assets/img/api_bg.e30f5b1e.png) 50% no-repeat;
    background-size: 100% 100%;
    padding-top: 100px;
    position: relative;">
    <ul class="nav" style="margin-top: 30px;">
        <li class="active" onclick="change_tab(0);">登录</li>
        <li onclick="change_tab(1);">注册</li>
    </ul>


<div style="width: 610px;margin: 0 auto;position: relative;display: block;overflow-x: hidden;height: auto;height: 500px">

    <div class="bigbox" style="width:610px">

        <div class="loginbox">

            <ul class="login-lines" >
                <li>账号：</li>
                <li><input type="text" id="login_name" value="" class="input" placeholder="ID\用户名\手机号"></li>
            </ul>

            <ul class="login-lines">
                <li>密码：</li>
                <li><input type="password" id="login_password" value="" class="input" placeholder="请输入密码"></li>
            </ul>

            <ul class="login-lines">
                <li></li>
                <li><input type="button" name="username" value="确认登录" class="button" onclick="return click_login();">

                <a href="" style="margin-left:50px;">忘记密码</a>
                </li>
            </ul>


        </div>
        <div class="loginbox" >

            <ul class="login-lines">
                <li>用户名：</li>
                <li><input type="text" id="username" value="" class="input" placeholder="请输入手机号"></li>
            </ul>

            <ul class="login-lines">
                <li>密码：</li>
                <li><input type="password" id="password" value="" class="input" placeholder="请输入密码"></li>
            </ul>
            <ul class="login-lines">
                <li>确认密码：</li>
                <li><input type="password" id="password2" value="" class="input" placeholder="再次输入密码"></li>
            </ul>
            <ul class="login-lines">
                <li>验证码：</li>
                <li><input type="text" id="randcode" value="" class="input" maxlength="4">
                    <img src='../inc/checkcode.inc.php' height='48px'  id='img_code'  onclick='change_code();' title="看不清？换一个"/>

                </li>
            </ul>
            <ul class="login-lines">
                <li></li>
                <li><input type="button" value="立即注册" class="button" onclick="return click_reg();"></li>
            </ul>


        </div>

    </div>

</div>
</div>


<script>
    var method='login';
    function change_tab(num) {
        var w=num*620;
        document.querySelector('.bigbox').style="transform: translateX(-"+w+"px);"
        var li=document.querySelector('.nav').querySelectorAll('li');
        for(var i=0;i<li.length;i++){
            if(i==num) li[i].className='active';
            else li[i].className='';
        }

        if(i==1) method='reg';
        else method='login';
    }
    function change_code(){
        document.getElementById('img_code').src='../inc/checkcode.inc.php?rand='+Math.random();

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
        $.post("../api/user.php?act=userlogin",{username:$('#login_name').val(),password:$('#login_password').val()}, function(result){
            layer.close(loading);
            console.log(result);
            var res=JSON.parse(result);
            if(res.code=='200'){
                userurl='user/index.php';
                layer.msg("登录成功",{ type: 1, anim: 2 ,time:1000});
                location.href='index.php';
            }else{
                layer.msg(res.message,{ type: 1, anim: 2 ,time:1000});
            }

        });

    }


    function click_reg() {

        if($('#username').val()==''){
            layer.msg("请输入手机号",{ type: 1, anim: 2 ,time:1000});
            return false;
        }

        if($('#username').val().length<6){
            layer.msg("用户长度不能小于6位",{ type: 1, anim: 2 ,time:1000});
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
        var loading=layer.load(1, {
            shade: [0.1,'#fff']
        });
        $.post("../api/user.php?act=reg",{username:$('#username').val(),password:$('#password').val(),randcode:$('#randcode').val()}, function(result){
            layer.close(loading);
            var res=JSON.parse(result);
            if(res.code=='200'){
                userurl='user/index.php';
                layer.msg("注册成功",{ type: 1, anim: 2 ,time:1000});
                location.href='index.php';
            }else{
                change_code();
                layer.msg(res.message,{ type: 1, anim: 2 ,time:1000});
            }

        });


    }

</script>


<?php include_once template("footer");?>