

<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/user.css" type="text/css" media="screen" />
<style>


    .profile li:first-child{
        text-align: right;
        padding-right: 5px;
        width:90px; ;
    }
    .profile li:last-child{
        width:calc(100% - 100px);
    }
</style>
<ul class="nav1" >
    <li class="active">忘记登录密码</li>
    <li class="" ></li>
</ul>

<div class="step" style="padding:10px;" id="step0">

    <ul class="profile" >
        <li>用户名：</li>
        <li>

            <input type="text" class="input1" id="name" value="" placeholder="输入用户名或者ID">

        </li>

    </ul>


    <ul class="login-lines1" >
        <input type="button" value="下一步" class="button1" onclick="return click_next(0);">
    </ul>
</div>


<div class="step" style="padding:10px;display: none" id="step1">

    <ul class="profile" >
        <li>绑定手机号：</li>
        <li id="mobile">

        </li>

    </ul>
    <ul class="profile" >
        <li>验证码：</li>
        <li><input type="text" class="input1" id="randcode" value="" placeholder="" maxlength="6" style="width:50px;height:30px;line-height: 30px;">
            <input type="button" class="sendbtn" value="获取短信" onclick="sendsms();">


        </li>

    </ul>


    <ul class="login-lines1" >
        <input type="button" value="下一步" class="button1" onclick="return click_next(1);">
    </ul>
</div>

<div class="step" style="padding:10px;display: none" id="step2">


    <ul class="profile" >
        <li>新登录密码</li>
        <li><input type="password" class="input1" id="pwd" value="" placeholder="输入新的登录密码" >

        </li>

    </ul>

    <ul class="profile" >
        <li>确认登录密码</li>
        <li><input type="password" class="input1" id="pwd2" value="" placeholder="再次新的登录密码" >


        </li>

    </ul>

    <ul class="login-lines1" >
        <input type="button" value="下一步" class="button1" onclick="return reset_pwd();">
    </ul>
</div>



<script>

    var mobile="";
    var userid=0;
    function  click_next(step) {

          if(step==0){
              var loading=layer.load(1, {
                  shade: [0.1,'#fff']
              });
              $.post("../api/user.php?act=findpwd0",{username:$('#name').val()}, function(result){
                  layer.close(loading);
                  var res=JSON.parse(result);

                  if(res.code==200){
                      mobile=res.data.mobile;
                      userid=res.data.id;
                      $('#mobile').html(mobile.substr(0,3)+'****'+mobile.substr(mobile.length-3,3));
                      $('#step0').hide();
                      $('#step1').show();
                      var index = parent.layer.getFrameIndex(window.name);
                      parent.layer.iframeAuto(index);
                  }else{

                      layer.msg(res.message,{ type: 1, anim: 2 ,time:1000});
                  }

              });
          }

          else if(step==1){

              $.post("../api/user.php?act=findpwd1",{mobile:mobile,randcode:$('#randcode').val()}, function(result){
                  layer.close(loading);
                  var res=JSON.parse(result);

                  if(res.code==200){

                      $('#step1').hide();
                      $('#step2').show();
                      var index = parent.layer.getFrameIndex(window.name);
                      parent.layer.iframeAuto(index);
                  }else{

                      layer.msg(res.message,{ type: 1, anim: 2 ,time:1000});
                  }

              });

          }
    }

    var timer=null;
    var getCodeTime=60;
    function  sendsms() {

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
                        $('.sendbtn').val(getCodeTime+'秒再获取');

                        if(getCodeTime<=0){
                            document.querySelector('.sendbtn').disabled=false;
                            $('.sendbtn').val('获取短信');
                            clearInterval(timer);
                        }
                    },1000)


                }else{

                    layer.msg("该手机号尚未注册",{ type: 1, anim: 2 ,time:1000});
                }

            });

        }else{
            layer.msg("手机号码格式错误",{ type: 1, anim: 2 ,time:2000});
            return false;
        }

    }

    function reset_pwd() {

        if(mobile==''){
            layer.msg("手机号不能为空",{ type: 1, anim: 2 ,time:2000});
            return false;
        }
        var reg =/^0?1[3|4|5|6|7|8|9][0-9]\d{8}$/;
        if(!reg.test(mobile)){
            layer.msg("手机号码格式错误",{ type: 1, anim: 2 ,time:2000});
            return false;
        }

        if($('#pwd').val()==''){
            layer.msg("请输入登录密码",{ type: 1, anim: 2 ,time:1000});
            return false;
        }

        if($('#pwd').val().length<6){
            layer.msg("登录密码长度不能小于6位",{ type: 1, anim: 2 ,time:1000});
            return false;
        }

        if($('#pwd').val() != $('#pwd2').val()){

            layer.msg("两次密码输入不一致",{ type: 1, anim: 2 ,time:1000});
            return false;
        }

        var loading=layer.load(1, {
            shade: [0.1,'#fff']
        });
        $.post("../api/user.php?act=findpwd2",{id:userid,pwd:$('#pwd').val()}, function(result){
            layer.close(loading);
            var res=JSON.parse(result);
            if(res.code=='200'){
                parent.layer.msg("登录密码已重置,请牢记",{ type: 1, anim: 2 ,time:2000});

                setTimeout(function () {
                    parent.showlogin();
                    var index = parent.layer.getFrameIndex(window.name);
                    parent.layer.close(index);

                },1000)
            }else{

                layer.msg(res.message,{ type: 1, anim: 2 ,time:1000});
            }

        });


    }

    window.onload=function () {
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.iframeAuto(index);
    }


</script>


<?php include_once template("footer");?>