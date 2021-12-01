

<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/user.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />
<?php if($user['isdaili']==1 && $user['vip']<=1){?>

<ul class="nav1">
    <li class="active" onclick="change_tab(0);" style="width:50%; "><?php if($user['vip']>0){?>续费<?php } else { ?>个人<?php }?>VIP</li>
    <li class="" onclick="change_tab(1);"><?php if($user['vip']>0){?>升级为团队<?php } else { ?>团队<?php }?>VIP</li>
</ul>
<?php } else { ?>
<ul class="layer_nav" >
    <li class="active" ><?php if($user['vip']>0){?>续费<?php } else { ?>加入<?php }?>VIP</li>

</ul>
<?php }?>


<?php if($user['vip']>0){?>
<ul class="profile"  >
    <li>当前VIP：</li>

    <li>
        <span style="color:#666"><?php echo date('Y-m-d',$user['vip_time']); ?></span>  到期

    </li>
</ul>
<ul class="profile"  >
    <li>VIP类型：</li>

    <li>
        <?php if($user['vip']==1){?>个人VIP<?php } else { ?>团队VIP<?php }?>

    </li>
</ul>
<?php }?>

<ul class="profile" >
    <li>购买时长：</li>

    <li id="buytime">
        <span class="money" onclick="set_time(1);">一月</span>
        <span class="money active" onclick="set_time(12);">一年</span>
    </li>
</ul>
<ul class="profile" >
    <li>需要支付：</li>

    <li>
        <view style="color: #FF2600;font-size: 16px;font-weight: 600;">
         <span id="money"><?php echo $system['vip_year']; ?></span>
            元
        </view>

    </li>
</ul>


    <ul class="login-lines1" >
        <input type="button" value="确认支付" class="button1" onclick="return click_pay();">
    </ul>




<script type="text/javascript">
var buytime=12;
var money='<?php echo $system['vip_year']; ?>';

var type=<?php echo $type; ?>;
var vip=<?php echo $user['vip']; ?>;
var lasttime=parseInt(<?php echo $lasttime; ?>);
var lastmoney=0;
var index = parent.layer.getFrameIndex(window.name);
parent.layer.iframeAuto(index);
function change_tab(num) {

    var li=document.querySelector('.nav1').querySelectorAll('li');
    for(var i=0;i<li.length;i++){
        if(i==num) li[i].className='active';
        else li[i].className='';
    }
    type=num;
    set_time(buytime);
}
function set_time(num) {
    buytime=num;
 var tt= document.querySelector('#buytime').querySelectorAll('.money');


    if(buytime==1)
    {
        money=<?php echo $system['vip_month']; ?>;
        tt[0].className='money active';
        tt[1].className='money';
    }else{
        money=<?php echo $system['vip_year']; ?>;
        tt[1].className='money active';
        tt[0].className='money';
    }
    if(vip==0){
        if(type==0){
            if(buytime==1)
            {
                money=<?php echo $system['vip_month']; ?>;
            }else{
                money=<?php echo $system['vip_year']; ?>;
            }
        }else{
            if(buytime==1)
            {
                money=<?php echo $system['vip1_month']; ?>;
            }else{
                money=<?php echo $system['vip1_year']; ?>;
            }
        }

    }
    else if(vip==1){
        if(type==0){
            if(buytime==1)
            {
                money=<?php echo $system['vip_month']; ?>;
            }else{
                money=<?php echo $system['vip_year']; ?>;
            }
        }else{
            if(lasttime>30){
                 lastmoney=parseInt(lasttime*<?php echo $system['vip_year']; ?>/365);
            }
            else {
                lastmoney=parseInt(lasttime*<?php echo $system['vip_month']; ?>/30);
            }


            if(lastmoney><?php echo $system['vip1_month']; ?> && buytime==1){
                buytime=12;
                set_time(12);
            }
            if(buytime==1)
            {
                money=parseInt(<?php echo $system['vip1_month']; ?>-lastmoney);
            }else{
                money=parseInt(<?php echo $system['vip1_year']; ?>-lastmoney);
            }
        }
    }
    else{
        if(buytime==1)
        {
            money=<?php echo $system['vip1_month']; ?>;
        }else{
            money=<?php echo $system['vip1_year']; ?>;
        }
    }



    $('#money').html(money);

}
if(type==1 && vip<3) change_tab(1);
set_time(12);
function click_pay() {

    if(money><?php echo $user['money1']; ?>){
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

    var index= parent.layer.open({
        type: 2,
        title: false,
        shadeClose: true,
        shade: 0.6,
        area: ['300px','250px'],
        content: '/user/pay.php?from=layer&viptype='+type+'&type=vip&id=0&money='+money+"&buytime="+buytime //iframe的url
    });
    var index = parent.layer.getFrameIndex(window.name);
    parent.layer.close(index);
}
</script>

<style>
    .money{
        display: inline-block;
        height: 30px;
        line-height: 30px;
        margin-right: 10px;
        text-align: center;
        border: 1px #ccc solid;
        border-radius: 5px;
        color: #666;
        font-size: 14px;
        width: 70px;
        cursor: pointer;
    }
    .money.active{
        background-color: #2319DC;
        color: #FFFFFF;
        border: 1px #2319DC solid;
        font-weight: 600;
    }
</style>
<?php include_once template("footer");?>