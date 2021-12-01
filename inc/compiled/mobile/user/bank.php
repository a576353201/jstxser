<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/user.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />
<style>
    select{
        background-color: #fff;
        border: 1px #ddd solid;
        border-radius: 5px;
    }

</style>
<div class="header" style="padding: 5px 0px;">
    <span class="back" onclick="history.back();" style="top:5px;"><i class="icon-left-open-3"></i></span>
    <div id="head_nav" class="nav" style="width: 60%;left: 20%;top:5px;">
        <div class="item active"  onclick="change_tab(0);" onclick="location.href='recharge.php';">我的银行卡</div>

        <div class="item "  onclick="change_tab(1);">新增银行卡</div>
    </div>

</div>

<div class="step">
    <ul class="cardManage clearFix" id="_bankList" style="clear: both;margin-top: 50px;">


        <?php if(is_array($bank)){foreach($bank AS $index=>$value) { ?>
        <li class="bank_item">
            <dl>
                <dd><span> <?php echo $value['bankname']; ?></span><span>持卡人：<?php echo $value['realname']; ?></span></dd>
                <dd><span>卡号：<?php echo $value['number']; ?></span></dd></dl>
            <p class="bank_bottom">绑定时间：<?php echo date('Y-m-d H:i:s',$value['time']); ?><span></span></p>

            <span class="bank_default"><img src="/static/images/bank_img.png"></span>

        </li>

        <?php }}?>

    </ul>

    <div class="nodata" style="color: #666;clear: both;margin-top: 10px;text-align: center">

        最多可以绑定<span style="color: #ff0000"><?php echo $system['bank_num']; ?></span>张银行卡

    </div>

</div>

<div class="step" style="display: none;margin-top: 50px;">
    <?php include_once template("user/bank_add");?>

</div>

<script>
    var realname='<?php echo $realname; ?>';
    function change_tab(num) {
        if(num==0 && realname==''){
            layer.msg("您还没有绑定任何银行卡",{ type: 1, anim: 2 ,time:1000});
            return false;
        }

        var step=document.querySelectorAll('.step');
        var li=document.querySelector('.nav').querySelectorAll('.item');
        for(var i=0;i<step.length;i++){
            if(i==num) {
                li[i].className='item active';
                step[i].style.display='';
            }
            else {
                li[i].className='item';
                step[i].style.display='none';
            }
        }
    }
    loadCityData();
    change_tab(<?php echo $step; ?>);

</script>
<?php include_once template("footer");?>

