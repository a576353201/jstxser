<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/user.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />



<script src="/static/js/script_area.js"></script>

<form action="" method="post" name="form1" id="form1">
    <input type='hidden' name='info' id='info' value='<!--<?php echo $u_bank.mark; ?>-->'>
    <ul class="profile" >
        <li>姓　　名：</li>
        <li>
            <?php if($realname){?>
           <?php echo $realname; ?>
            <input name="realname" id="realname" type="hidden" class="input1" size=30 value="<?php echo $realname; ?>" maxlength="4">
            <?php } else { ?>
            <input name="realname" id="realname" type="text" size=30 value="" class="input1" maxlength="4">
            <?php }?>

        </li>
    </ul>
    <ul class="profile" >
        <li>卡　　号：</li>
        <li><input name="banknum" id="banknum" type="text" size=30 value="" class="input1">
        </li>
    </ul>

    <ul class="profile" >
        <li>选择银行：</li>
        <li>
            <select id="bankname" name='bankname'>
                <?php if(is_array($bank_arr)){foreach($bank_arr AS $key=>$item) { ?>
                <option value="<?php echo $item; ?>" ><?php echo $item; ?></option>
                <?php }}?>
            </select>


        </li>
    </ul>

    <ul class="profile" >
        <li>所在地区：</li>
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
        <li>支行名称：</li>
        <li>
            <input type="text" name="mark" value="" class="input1" id="mark">
        </li>
    </ul>

    <ul class="profile" >
        <li>首 选 卡：</li>
        <li>
            <select name="default" id="default">
                <option value='0'>否</option>
                <option value='1'  <?php if(!$realname ){?>selected<?php }?> >是</option>
            </select>

        </li>
    </ul>
    <ul class="profile" >
        <li>资金密码：</li>
        <li>
            <input type="password" name='pwd' id='pwd' value='' class="input1" maxlength="6">
        </li>

    </ul>
</form>

<ul class="profile" style="margin-top: 8px;">
    <input type="button" value="确认绑定" class="button1" onclick="return click_bind();">
</ul>

<script>

    function click_bind() {
        if ($('#realname').val() == "") {
            parent.layer.msg("请输入开户姓名",{ type: 1, anim: 2 ,time:1000});
            document.getElementById('realname').focus();
            return false;
        }

        if ($('#realname').val().length<2 || $('#realname').val().length>4 ) {
            parent.layer.msg("开户姓名最多四个字",{ type: 1, anim: 2 ,time:1000});
            document.getElementById('realname').focus();
            return false;
        }

        var reglx = /^[\u0391-\uFFE5]+$/;
        if(!reglx.test($('#realname').val())){
            layer.msg("开户姓名只能包含中文",{ type: 1, anim: 2 ,time:1000});
            document.getElementById('realname').focus();
            return false;
        }


        if ($('#banknum').val() == "") {
            parent.layer.msg("请输入银行卡号",{ type: 1, anim: 2 ,time:1000});
            document.getElementById('banknum').focus();
            return false;
        }
        if($("#banknum").val().length < 15 || $("#banknum").val().length > 19) {
            parent.layer.msg("银行卡号长度必须在15到19之间",{ type: 1, anim: 2 ,time:1000});
            //$("#banknoInfo").html("银行卡号长度必须在16到19之间");
            return false;
        }
        var num = /^\d*$/;
        //全数字
     if(!num.exec($("#banknum").val())) {
         parent.layer.msg("银行卡号必须全为数字",{ type: 1, anim: 2 ,time:1000});
     //  $("#banknoInfo").html("银行卡号必须全为数字");
           return false;
     }


//        var regExp = /^([1-9]{1})(\d{14}|\d{15}|\d{16}|\d{17}|\d{18}|\d{19})$/;
//        if(regExp.test($("#banknum").val())){
//            parent.layer.msg("银行卡号格式不正确",{ type: 1, anim: 2 ,time:1000});
//            document.getElementById('banknum').focus();
//            return false;
//        }
        if(document.querySelector('#city').value=='城市'){
            parent.layer.msg("请输选择开户行所在地区",{ type: 1, anim: 2 ,time:1000});

            return false;

        }
        if ($('#mark').val() == "") {
            parent.layer.msg("请输入支行名称",{ type: 1, anim: 2 ,time:1000});
            document.getElementById('mark').focus();
            return false;
        }
        if ($('#pwd').val() == "") {
            parent.layer.msg("请输入资金密码",{ type: 1, anim: 2 ,time:1000});
            document.getElementById('pwd').focus();
            return false;
        }
        if(parseInt($('#pwd').val())>0 && parseInt($('#pwd').val())<1000000 && $('#pwd').val().length==6){

        }else{
            layer.msg("资金密码必须为6位数字",{ type: 1, anim: 2 ,time:1000});
            return false;
        }
        if(parent.check_userlock()==false) return false;
        var loading=layer.load(1, {
            shade: [0.1,'#fff']
        });
        $.post("../api/user.php?act=bank_add",{bankname:document.querySelector('#bankname').value,realname:$('#realname').val() ,banknum:$('#banknum').val(),province:document.querySelector('#province').value,city:document.querySelector('#city').value,mark:$('#mark').val(),default:document.querySelector('#default').value,pwd:$('#pwd').val()}, function(result){
            layer.close(loading);
            result=JSON.parse(result);

            if(result.code==200){
                var data=result.data;
                realname=$('#realname').val();
                location.href='bank.php';
                parent.layer.msg("绑定成功",{ type: 1, anim: 2 ,time:1000});
            }
            else{
                parent.layer.msg(result.message,{ type: 1, anim: 2 ,time:1000});
            }



        });

    }

</script>
<?php include_once template("footer");?>

