<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/user.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />
<ul class="nav1">
    <li class="active" onclick="change_tab(0);">我的银行卡</li>
    <li class="" onclick="change_tab(1);">新增银行卡</li>


</ul>


<div class="step">
    <ul class="cardManage clearFix" id="_bankList" style="clear: both">


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

    <div class="nodata" style="color: #666;clear: both;">

        最多可以绑定<span style="color: #ff0000"><?php echo $system['bank_num']; ?></span>张银行卡

    </div>

</div>

<div class="step" style="display: none">
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
        var li=document.querySelector('.nav1').querySelectorAll('li');
        for(var i=0;i<li.length;i++){
            if(i==num) {
                li[i].className='active';
                step[i].style.display='';
            }
            else {
                li[i].className='';
                step[i].style.display='none';
            }
        }

        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.iframeAuto(index);
    }
    change_tab(<?php echo $step; ?>);
    window.onload = function() {
        loadCityData();
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.iframeAuto(index);
    }
</script>
<?php include_once template("footer");?>

