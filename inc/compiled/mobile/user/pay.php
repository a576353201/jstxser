<?php include_once template("header");?>

<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/user.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />

<div class="dialog-title"><?php echo $web_title; ?></div>

<style>

    .profile li:first-child{
        width: 120px;
    }
    .profile li:last-child {
        width: calc(100% - 130px);
    }
    .profile .money{
        height: 20px;
        line-height: 20px;
        margin: 5px 3px;
        text-align: center;
        border-radius: 5px;
        background-color: #fff;
        border:1px solid #666;
        color: #555;
        width: 50px;
        display: inline-block;
        cursor: pointer;
    }
    .profile .money.active{
        background-color: #2319dc;
        border-color: #2319dc;
        color: #fff;
    }
</style>

<div class="step" style="margin: 10px auto;" id="step_0">

    <ul class="profile" style="text-align:center">


            ￥<input type="text" class="input1" onKeyDown="return enterInput()" autocomplete="off" id="money" value="<?php if($money>0){?><?php echo $money; ?><?php } else { ?>10<?php }?>" style="height:40px;line-height:40px;width: 100px;"  placeholder="输入<?php echo $money_title; ?>">

            <span id="tips" style="font-size: 12px;color: #666;"></span>

    </ul>
    <ul class="profile" id="money_list" style="line-height: 30px;height: 30px;text-align: center;padding-top: 5px;" >

        <span class="money" onclick="set_money(5,0);" >
          5元
        </span>
        <span class="money active"  onclick="set_money(10,1);" >
          10元
        </span>
        <span class="money"  onclick="set_money(50,2);" >
          50元
        </span>
        <span class="money"  onclick="set_money(100,3);" >
          100元
        </span>
    </ul>
    <ul class="profile" style="width:90%;margin: 0px auto;margin-top: 10px;text-align: center">
        <button class="cancel-btn" onclick="close_this();">取消</button>
        <button class="confirm-btn" onclick="order_sub();">下一步</button>



    </ul>

</div>


<div class="step" style="margin: 10px auto;display: none;margin-bottom:20px;" id="step_1">
<div style="height: 45px;line-height: 45px;font-size: 18px;font-weight: 600;text-align: center">

    <span>￥</span><span id="pay_money" style="font-size: 32px;"></span>
</div>
    <div class="pay-password" style="margin-top: 10px;">
        <input type="tel" maxlength="6" class="real-ipt">
        <div class="surface-ipts">
            <div class="surface-ipt">
                <input type="password" >
                <input type="password" >
                <input type="password" >
                <input type="password" >
                <input type="password" >
                <input type="password" >
            </div>
        </div>
    </div>

    <ul class="profile" style="width:90%;margin: 0px auto;margin-top: 10px;text-align: center;display: none;">
        <button class="cancel-btn" onclick="close_this();">取消</button>
        <button class="confirm-btn">付款</button>



    </ul>

</div>


<script>
    function close_this() {
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.close(index);
    }
    function  enterInput(){

        if(event.keyCode == 13){

            order_sub(); //提交的执行函数
            event.preventDefault();//禁止回车的默认换行

        }
    }
   var  max=parseFloat(<?php echo $user['money']; ?>);
   var min=1;
    function order_sub(){

        var money =document.getElementById('money').value; //用户充值金额


        if (money == "") {
            parent.layer.msg("请输入<?php echo $money_title; ?>",{ type: 1, anim: 2 ,time:1000});
            document.getElementById('money').focus();
            return false;
        }


        if (isNaN(money)) {
            parent.layer.msg('<?php echo $money_title; ?>必须为数字！',{ type: 1, anim: 2 ,time:1000});

            document.getElementById('money').focus();
            return false;
        }
        if (parseFloat(money) - parseFloat(min) < 0) {
            parent.layer.msg('最低打赏'+ min + '元！',{ type: 1, anim: 2 ,time:1000});
            document.getElementById('money').focus();
            return false;
        }

        if (parseFloat(money) - parseFloat(max) >0) {
            var index=  layer.confirm('您的账户余额不足', {
                title:'提示',
                btn: ['去充值','取消'] //按钮
            }, function(){
                parent.click_recharge(money);
                var index = parent.layer.getFrameIndex(window.name);
                parent.layer.close(index);
            }, function(){

            });
            return false;
        }


        click_next();

        //      show_bg('block','请在新打开的页面完成充值');


    }

    function click_next() {
        var money =document.getElementById('money').value;
        $('#step_0').hide();
        $('#step_1').show();
        $("#pay_money").html(money);

        document.querySelector('.real-ipt').focus();
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.iframeAuto(index);
    }
    var $inputs = $(".surface-ipt input");
    $(".real-ipt").on("input", function () {
        if (!$(this).val()) {   //无值
        }
        if (/^[0-9]*$/g.test($(this).val())) {  //有值且只能是数字（正则）
            pwd = $(this).val().trim();
            len = pwd.length;
            for (var i in pwd) {
                $inputs.eq(i).val(pwd[i]);
            }
            $inputs.each(function () {  //将有值的当前input 后面的所有input清空
                var index = $(this).index();
                if (index >= len) {
                    $(this).val("");
                }
            })
            if (len === 6) {
                //执行付款操作

                var loading=layer.load(1, {
                    shade: [0.1,'#fff']
                });
                $.post("../api/pay.php?act=paymoney",{type:'<?php echo $_GET['type']; ?>',money:document.getElementById('money').value,pwd:pwd,id:<?php echo $_GET['id']; ?>}, function(result){
                    layer.close(loading);
                    result=JSON.parse(result);

                    if(result.code==200){
                        var data=result.data;

                        parent.layer.msg(result.message,{ type: 1, anim: 2 ,time:1000});

                       setTimeout(function () {
                            parent.location.reload();
                            var index = parent.layer.getFrameIndex(window.name);
                            parent.layer.close(index);
                        },800)

                    }
                    else if(result.code==1){
                        var index=  layer.confirm('您的账户余额不足', {
                            title:'提示',
                            btn: ['去充值','取消'] //按钮
                        }, function(){
                            parent.click_recharge(money);
                            var index = parent.layer.getFrameIndex(window.name);
                            parent.layer.close(index);
                        }, function(){

                        });
                    }
                        else
                        {
                       layer.msg(result.message,{ type: 1, anim: 2 ,time:1000});
                    }



                });
            }

        } else {    //清除val中的非数字，返回纯number的value
            var arr = $(this).val().match(/\d/g);
            try {
                $(this).val($(this).val().slice(0,$(this).val().lastIndexOf(arr[arr.length-1])+1));
            } catch(e) {
                // console.log(e.message)
                //清空
                $(this).val("");
            }
        }
      //  console.log("password:" + pwd);
    })
    //  获取焦点事件避免输入键盘挡住对话框
    $('.real-ipt').on('focus', function () {
        $('.pay-dialog').css('top','1rem')
    })
    $('.real-ipt').on('blur', function () {
        $('.pay-dialog').css('top','3rem')
    })


    function set_money(money,num) {
        var span=document.querySelector('#money_list').querySelectorAll('span');
        for(var i=0;i<span.length;i++){
            if(i==num) span[i].className='money active';
            else span[i].className='money';
        }
        document.getElementById('money').value=money;
    }
    window.onload=function () {
          <?php if($money>0){?>
        click_next();
        <?php }?>
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.iframeAuto(index);
    }
</script>
