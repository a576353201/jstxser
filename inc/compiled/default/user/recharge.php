<?php include_once template("header");?>

<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/user.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />

<style>
    .profile .money{
        height: 25px;
        line-height: 25px;
        margin: 5px 3px;
        text-align: center;
        border-radius: 5px;
        background-color: #fff;
        border:1px solid #666;
        color: #555;
        width: 60px;
        display: inline-block;
        cursor: pointer;
    }
    .profile .money.active{
        background-color: #2319dc;
        border-color: #2319dc;
        color: #fff;
    }

    .blur{
        color: #2319DC;

    }
    .btn1{
        height:25px;
        line-height: 25px;
        margin-left: 10px;
        padding: 0px 8px;
        border-radius: 5px;
        border: 1px #666 solid;
        background-color: #fff;
        color: #666;
        cursor: pointer;
    }
    .money11{
        height:50px;
        line-height: 50px;
        font-size: 40px;
        font-weight: 600;
        text-align: center;
    }
    .money11 .rmb{
        font-size: 16px
    }
    .qrcode{
        text-align: center;
        width: 100%;
    }
    .qrcode img{
        width: 250px;
    }
    .tips{
        height: 40px;
        line-height: 40px;
        text-align: center;
        font-size: 14px;
        color: #666;
    }
</style>


<ul class="nav1">
    <li class="active" >充值</li>
    <li class="" onclick="location.href='plat.php';">提现</li>
    <li class="" onclick="location.href='money.php';">帐单</li>

</ul>
<div class="step"  style="margin: 20px auto;">
    <div id="step0" >
        <ul class="profile" >
            <li>支付方式：</li>
            <li>

                <select id="recharge_type" onchange="change_method( value);">
                    <?php if(is_array($method)){foreach($method AS $index=>$value) { ?>

                    <option value="<?php echo $value; ?>"><?php echo $recharge_arr[$value]; ?></option>

                    <?php }}?>

                </select>

            </li>

        </ul>

        <ul class="profile" >
            <li>渠道：</li>
            <li>
                <select id="bankselected" onchange="change_bank( value);">
                </select>

            </li>

        </ul>
        <ul class="profile" >
            <li>充值金额：</li>
            <li>

                <input type="text" class="input1" id="money" value="<?php if(isset($_GET['money']) && $_GET['money']!=undefined){?><?php echo $_GET['money']; ?><?php } else { ?>100<?php }?>"  placeholder="" style="width: 100px;" >元

                <span id="tips" style="font-size: 12px;color: #ff0000;"></span>

            </li>

        </ul>
        <ul class="profile" id="money_list" style="line-height: 50px;height: 50px;text-align: center;" >

        <span class="money" onclick="set_money(50,0);" >
          50元
        </span>
            <span class="money active"  onclick="set_money(100,1);" >
          100元
        </span>
            <span class="money"  onclick="set_money(200,2);" >
          200元
        </span>
            <span class="money"  onclick="set_money(500,3);" >
          500元
        </span>
        </ul>
        <ul class="profile" >

            <input type="button" value="下一步" class="button1" onclick="return order_sub();">


        </ul>


    </div>



    <div id="step1" style="display: none">



    </div>

</div>


         <script>
   var setting=JSON.parse('<?php echo json_encode($rechargeset); ?>');
var online=setting.online;

   var set={};
   var paytype=[];
   function setmethod(){
       try{
           if(online==true){

               for(var ii in setting.way){
                   for(var jj in setting.method){
                       if( setting.method[jj]==ii){
                           paytype.push({id:ii,name:setting.way[ii]}) ;
                           break;
                       }
                   }
               }

           }else{
               for(var ii in setting.way){
                   for(var jj in setting.method){
                       if( setting.method[jj]==ii){
                           var bank= setting.bank[ii];
                           var name={min:bank[0]['min'],max:bank[0]['max'],fee:bank[0]['fee']};

                           paytype.push({id:ii,name: setting.way[ii],bank:bank}) ;
                           break;
                       }
                   }
               }
           }


           //clicktype( selected)
       }catch(e){
           //TODO handle the exception
       }


   }
   function set_money(money,num) {
       var span=document.querySelector('#money_list').querySelectorAll('span');
       for(var i=0;i<span.length;i++){
           if(i==num) span[i].className='money active';
           else span[i].className='money';
       }
       document.getElementById('money').value=money;
   }
   var bank=[];
   var bankid=0;
   function change_method(value) {

       for(var i=0;i<paytype.length;i++){

           if(paytype[i].id==value){
               bank=paytype[i].bank;
           }

       }
        bankid=0;
       $('#money').attr('placeholder',"最低"+bank[0]['min']+'元');

       if(bank[0]['fee']>0){
           $('#tips').html('手续费'+bank[0]['fee']+'%')
           $("#tips").show();
       }else {
           $('#tips').hide();
       }
        var html="";
       for(var i=0;i<bank.length;i++){
           html+="<option value='"+i+"'>"+bank[i].title+"</option>";
       }
       $('#bankselected').html(html);

   }
      function    change_bank(index) {
             bankid=index;
          $('#money').attr('placeholder',"最低"+bank[bankid]['min']+'元');

          if(bank[bankid]['fee']>0){
              $('#tips').html('手续费'+bank[bankid]['fee']+'%')
              $("#tips").show();
          }else {
              $('#tips').hide();
          }
      }
var postdata=[];
         function order_sub(){


             var rechargeMin =bank[bankid]['min'] //最小充值金额
             var rechargeMax =bank[bankid]['max'];
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
             if(parent.check_userlock()==false) return false;
             if(online==false){
                    console.log(bank[bankid])
              if(bank[bankid].method=='alipay' || bank[bankid].method=='weixin' ) var type=bank[bankid].method;
                    else var type=bank[bankid].method;
              postdata={money:rechargeMoney,type:type,userid:<?php echo $_SESSION['userid']; ?>,bank:bank[bankid],online:online};
                 showbankinfo();
             }
             else{
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

             }



       //      show_bg('block','请在新打开的页面完成充值');


         }
         
         function showbankinfo() {

             var bankinfo=bank[bankid];
             var html='';
             if(postdata.type=='bank'){

                 html+="<ul class='profile'><li>汇款银行：</li><li><span class='blur'>"+bankinfo.title+"</span><input type='button' onclick='copy(\""+bankinfo.title+"\")' value='复制' class='btn1' ></li></ul>";
                 html+="<ul class='profile'><li>开户姓名：</li><li><span class='blur'>"+bankinfo.realname+"</span><input type='button' onclick='copy(\""+bankinfo.realname+"\")' value='复制' class='btn1' ></li></ul>";
                 html+="<ul class='profile'><li>汇款账户：</li><li><span class='blur'>"+bankinfo.number+"</span><input type='button' onclick='copy(\""+bankinfo.number+"\")' value='复制' class='btn1' ></li></ul>";
                 html+="<ul class='profile'><li>转账金额：</li><li><span style='color：#ff0000'>"+bankinfo.money+"</span>元<input type='button' onclick='copy(\""+bankinfo.money+"\")' value='复制' class='btn1' ></li></ul>";


             }
             else{
                 html+="<div class='money11'><span class='rmb'>￥</span>"+postdata.money+"</div>";
                 html+="<div class='qrcode'><img src='/"+bankinfo.qrcode+"'></div>";
                 html+="<div class='tips'>请扫描上方的二维码完成付款</div>";
             }
html+='   <ul class="profile" ><input type="button" value="我已完成汇款" class="button1" onclick="return sub_ok();"></ul>';


             $('#step1').html(html);
             $('#step0').hide();
             $('#step1').show();

             setTimeout(function () {
                 var index = parent.layer.getFrameIndex(window.name);
                 parent.layer.iframeAuto(index);
             },500)
         }
    function sub_ok() {
        postdata.bank=JSON.stringify(postdata.bank);

        $.post("../api/pay.php?act=recharge1",postdata, function(result){

            result=JSON.parse(result);

            if(result.code==200){
                var index=  layer.confirm('充值已提交，大概1-5分钟内到账', {
                    title:'提示',
                    btn: ['查看账单','未到账'] //按钮
                }, function(){
                    location.href='money.php';
                }, function(){
                    layer.close(index);
                });
            }
            else{
                parent.layer.msg(result.message,{ type: 1, anim: 2 ,time:1000});
            }



        });


    }
   function copy(text) {
       console.log(text);
       Clipboard.copy(text);
   }
   window.Clipboard = (function(window, document, navigator) {
       var textArea,
           copy;

       // 判断是不是ios端
       function isOS() {
           return navigator.userAgent.match(/ipad|iphone/i);
       }
       //创建文本元素
       function createTextArea(text) {
           textArea = document.createElement('textArea');
           textArea.innerHTML = text;
           textArea.value = text;
           document.body.appendChild(textArea);
       }
       //选择内容
       function selectText() {
           var range,
               selection;

           if (isOS()) {
               range = document.createRange();
               range.selectNodeContents(textArea);
               selection = window.getSelection();
               selection.removeAllRanges();
               selection.addRange(range);
               textArea.setSelectionRange(0, 999999);
           } else {
               textArea.select();
           }
       }

       //复制到剪贴板
       function copyToClipboard() {
           try{
               if(document.execCommand("Copy")){

                   layer.msg('复制成功',{ type: 1, anim: 2 ,time:1000});
               }else{

                   layer.msg('复制失败！请手动复制！',{ type: 1, anim: 2 ,time:1000});
               }
           }catch(err){

               layer.msg('复制错误！请手动复制！',{ type: 1, anim: 2 ,time:1000});

           }
           document.body.removeChild(textArea);
       }

       copy = function(text) {
           createTextArea(text);
           selectText();
           copyToClipboard();
       };

       return {
           copy: copy
       };
   })(window, document, navigator);

   window.onload=function () {
             setmethod();

             change_method(document.querySelector('#recharge_type').value);

             var index = parent.layer.getFrameIndex(window.name);
             parent.layer.iframeAuto(index);
         }
         </script>


<?php include_once template("footer");?>