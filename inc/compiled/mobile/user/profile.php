
<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/user.css" type="text/css" media="screen" />

<div class="header">
<span class="back" onclick="history.back();"><i class="icon-left-open-3"></i></span>
<span class="title">修改资料</span>

</div>
<div class="step" style="margin-top: 60px;">


<ul class="profile"  style="height: 40px;line-height: 40px;">
    <li>ID：</li>
    <li><?php echo $user['number']; ?>

    </li>

</ul>
<ul class="profile" style="height: 40px;line-height: 40px;">
    <li>用户名：</li>
    <li><?php echo $user['name']; ?>

    </li>

</ul>
<ul class="profile" >
    <li>昵称：</li>
    <li><input type="text" class="input1" id="nickname" value="<?php if($user['issetname']==1){?><?php echo $user['nickname']; ?><?php }?>" maxlength="7">

    </li>

</ul>

<ul class="profile" >
    <li>所在地：</li>
    <li>
        <select class="provinceTarget inputEle selectTag" id="province" onchange="privicechange();">
            <option data-index="-1" value="省份">省份</option>
        </select>

        <!--城市选项列表-->
        <select class="cityTarget inputEle selectTag" id="city">
            <option data-index="-1" value="城市">城市</option>
        </select>
    </li>

</ul>
<ul class="profile" >
    <li>性别：</li>
    <li>
        <select id="sex" >
            <option value="0">保密</option>
            <option value="1" <?php if($user['sex']==1){?>selected<?php }?>>男</option>
            <option value="2" <?php if($user['sex']==2){?>selected<?php }?>>女</option>
        </select>

    </li>

</ul>

<ul class="profile" style="margin-top: 10px;" >
    <li>个性签名：</li>
    <li>
       <textarea id="sign" placeholder="请填写您的个性签名"><?php echo $user['sign']; ?></textarea>

    </li>

</ul>
<ul class="profile" style="margin-top:15px;">
<input type="button" value="确认修改" class="button1" onclick="return click_reg();">
</ul>

</div>
<script src="/static/js/script_area.js"></script>
<script>
    var menuid=4;

        loadCityData();
        <?php if($user['city'] && $user['city']!=null){?>
        updateLocationInfo('<?php echo $user['province']; ?>','<?php echo $user['city']; ?>');
        <?php }?>

    function click_reg() {
          if($('#nickname').val()==''){

              layer.msg("昵称不能为空",{ type: 1, anim: 2 ,time:1000});
              return false;
          }
        if($('#nickname').val().length>7){

            layer.msg("昵称最多7个字符",{ type: 1, anim: 2 ,time:1000});
            return false;
        }
        var reglx = /^[\u0391-\uFFE5A-Za-z]+$/;
        if(!reglx.test($('#nickname').val())){
            layer.msg("昵称只能包含中文或者英文",{ type: 1, anim: 2 ,time:1000});
            return false;
        }


        var loading=layer.load(1, {
            shade: [0.1,'#fff']
        });
        $.post("../api/user.php?act=profile",{id:parent.userid,nickname:$('#nickname').val(),sex:$('#sex').val(),sign:$('#sign').val(),province:$('#province').val(),city:$('#city').val()}, function(result){
            layer.close(loading);
            var res=JSON.parse(result);
            if(res.code=='200'){
                parent.issetname=1;
                layer.msg("修改成功",{ type: 1, anim: 2 ,time:1000});


                setTimeout(function () {
                    window.location='index.php';
                },1000)

            }else{
                change_code();
                layer.msg(res.message,{ type: 1, anim: 2 ,time:1000});
            }

        });


    }

</script>
<?php include_once template("footer");?>