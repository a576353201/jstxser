<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/user.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />
<div class="header" style="padding: 5px 0px;">
    <span class="back" onclick="history.back();" style="top:5px;"><i class="icon-left-open-3"></i></span>
    <div id="head_nav" class="nav" style="width: 60%;left: 20%;top:5px;">
        <div class="item "  onclick="location.href='recharge.php';">充值</div>
        <div class="item active" style="border-left: 1px solid #2319dc;width: 33%"   >提现</div>
        <div class="item " style="border-left: 1px solid #2319dc;" onclick="location.href='money.php';" >账单</div>
    </div>

</div>

<ul class="profile" >
    <li>账户余额：</li>
    <li>
        <?php echo $user['money']; ?>元
    </li>
</ul>
<ul class="profile" >
    <li>选择银行：</li>
    <li>
        <select id="bankid" name='bankid' style="width: 200px;">
            <?php if(is_array($bank)){foreach($bank AS $key=>$item) { ?>
            <option value="<?php echo $item['id']; ?>" ><?php echo $item['number']; ?></option>
            <?php }}?>
        </select>


    </li>
</ul>
<ul class="profile" >
    <li>提现金额：</li>
    <li><input name="money" id="money" type="text" size=30 value="" class="input1" style="width: 120px;"  placeholder="最低<?php echo $system['plat_min']; ?>元">元
    </li>
</ul>

<ul class="profile" >
    <li>资金密码：</li>
    <li>
        <input type="password" name='pwd' id='pwd' value='' class="input1" style="width: 120px;" maxlength="6">
    </li>

</ul>

<ul class="profile" style="margin-top: 8px;">
    <input type="button" value="确认提现" class="button1" onclick="return click_bind();">
</ul>
    
         <script>
             var plat_min=parseInt(<?php echo $plat['plat_min']; ?>);
             var plat_max=parseInt(<?php echo $plat['plat_max']; ?>);
             var user_money=parseFloat(<?php echo $user['money']; ?>);
             function click_bind() {

                 var money =document.getElementById('money').value; //用户充值金额

                 // var rechargeRand = 4485;
                 var urlflag;


                 if (money == "") {
                     parent.layer.msg("请填写提现金额",{ type: 1, anim: 2 ,time:1000});
                     document.getElementById('money').focus();
                     return false;
                 }

                 if (isNaN(money)) {
                     parent.layer.msg('提现金额必须为数字！',{ type: 1, anim: 2 ,time:1000});

                     document.getElementById('money').focus();
                     return false;
                 }
                 if (parseFloat(money) - parseFloat(plat_min) < 0) {
                     parent.layer.msg('每次最少提现'+ user_money + '元！',{ type: 1, anim: 2 ,time:1000});
                     document.getElementById('money').focus();
                     return false;
                 }
                 if (parseFloat(money) - parseFloat(user_money) >0) {
                     parent.layer.msg('您的提现金额不能大于'+ plat_max+ '元！',{ type: 1, anim: 2 ,time:1000});
                     document.getElementById('money').focus();
                     return false;
                 }
                 if (parseFloat(money) - parseFloat(plat_max) >0) {
                     parent.layer.msg('每次最多提现'+ plat_max+ '元！',{ type: 1, anim: 2 ,time:1000});
                     document.getElementById('money').focus();
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
                 var loading=layer.load(1, {
                     shade: [0.1,'#fff']
                 });
                 $.post("../api/pay.php?act=plat",{money:money,bankid:document.querySelector('#bankid').value,pwd:$('#pwd').val()}, function(result){
                     layer.close(loading);
                     result=JSON.parse(result);

                     if(result.code==200){
                         var data=result.data;

                        // parent.layer.msg('提现已提交，请等待管理审核',{ type: 1, anim: 2 ,time:1000});

                         var index=  layer.confirm('提现已提交，请耐心等待', {
                             title:'提示',
                             btn: ['查看账单','关闭'] //按钮
                         }, function(){
                             location.href='money.php';

                         }, function(){
                             var index = parent.layer.getFrameIndex(window.name);
                             parent.layer.close(index);
                         });
                     }
                     else{
                         parent.layer.msg(result.message,{ type: 1, anim: 2 ,time:1000});
                     }



                 });
             }
             
             window.onload = function() {
               
                 var index = parent.layer.getFrameIndex(window.name);
                 parent.layer.iframeAuto(index);
             }

         </script>
<?php include_once template("footer");?>