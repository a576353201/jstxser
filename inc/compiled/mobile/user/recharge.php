<?php include_once template("header");?>

<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/user.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />


<div class="header" style="padding: 5px 0px;">
    <span class="back" onclick="history.back();" style="top:5px;"><i class="icon-left-open-3"></i></span>
    <div id="head_nav" class="nav" style="width: 60%;left: 20%;top:5px;">
        <div class="item active" >充值</div>
        <div class="item" style="border-left: 1px solid #2319dc;width: 33%"  onclick="location.href='plat.php';" >提现</div>
        <div class="item" style="border-left: 1px solid #2319dc;"  onclick="location.href='money.php';">账单</div>
    </div>

</div>
<div class="step" style="margin-top: 50px;">
    <ul class="profile" >
        <li>支付方式：</li>
        <li>

   <select id="recharge_type" onchange="change_method(this.value);">
       <?php if(is_array($method)){foreach($method AS $index=>$value) { ?>

       <option value="<?php echo $value; ?>"><?php echo $recharge_arr[$value]; ?></option>

       <?php }}?>

   </select>

        </li>

    </ul>
<ul class="profile" >
    <li>充值金额：</li>
    <li>

        <input type="text" class="input1" id="money" autocomplete="off" value="<?php if(isset($_GET['money']) && $_GET['money']!=undefined){?><?php echo $_GET['money']; ?><?php }?>"  placeholder="" style="width: 100px;" >元

        <span id="tips" style="font-size: 12px;color: #666;"></span>

    </li>

</ul>
<ul class="profile" >

    <input type="button" value="下一步" class="button1" onclick="return order_sub();">


</ul>

</div>


         <script>
   var setting=<?php echo $setting; ?>;
   var set={};

   function change_method(value) {
       set=setting[value];
       $('#money').attr('placeholder',"最低"+set['min']+'元');

       if(set['fee']>0){
           $('#tips').html('手续费'+set['fee']+'%')
       }
       else $('#tips').html('');

   }
         function order_sub(){


             var rechargeMin =set['min'] //最小充值金额
             var rechargeMax =set['max'];
             var rechargeMoney =document.getElementById('money').value; //用户充值金额

            // var rechargeRand = 4485;
             var urlflag;


             if (rechargeMoney == "") {
                 parent.layer.msg("请填写充值金额",{ type: 1, anim: 2 ,time:1000});
                 document.getElementById('money').focus();
                 return false;
             }

             if (rechargeMoney == 0) {
                 parent.layer.msg('充值金额不能为0！',{ type: 1, anim: 2 ,time:1000});

                 document.getElementById('money').focus();
                 return false;
             }

             if (isNaN(rechargeMoney)) {
                 parent.layer.msg('充值金额必须为数字！',{ type: 1, anim: 2 ,time:1000});

                 document.getElementById('money').focus();
                 return false;
             }
             if (parseFloat(rechargeMoney) - parseFloat(rechargeMin) < 0) {
                 parent.layer.msg('每次最少充值'+ rechargeMin + '元！',{ type: 1, anim: 2 ,time:1000});
                 document.getElementById('money').focus();
                 return false;
             }

             if (parseFloat(rechargeMoney) - parseFloat(rechargeMax) >0) {
                 parent.layer.msg('每次最多充值'+ rechargeMax+ '元！',{ type: 1, anim: 2 ,time:1000});
                 document.getElementById('money').focus();
                 return false;
             }

             var loading=layer.load(1, {
                 shade: [0.1,'#fff']
             });
             $.post("../api/pay.php?act=recharge",{money:rechargeMoney,type:document.querySelector('#recharge_type').value}, function(result){
                 layer.close(loading);
                 result=JSON.parse(result);

                 if(result.code==200){
                     var data=result.data;

                   //  parent.layer.msg(data,{ type: 1, anim: 2 ,time:1000});
                     parent.window.open(data);
                   var index=  layer.confirm('充值是否到账？', {
                         title:'提示',
                         btn: ['已到账','未到账'] //按钮
                     }, function(){

                     }, function(){
                       layer.close(index);
                     });
                 }
                 else{
                     parent.layer.msg(result.message,{ type: 1, anim: 2 ,time:1000});
                 }



             });


       //      show_bg('block','请在新打开的页面完成充值');


         }
         window.onload=function () {

             change_method(document.querySelector('#recharge_type').value);
             var index = parent.layer.getFrameIndex(window.name);
             parent.layer.iframeAuto(index);
         }
         </script>
<?php include_once template("footer");?>