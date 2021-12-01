

<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/user.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />

<ul class="nav1">
    <li class="active" onclick="change_tab(0);">个人中心</li>
    <li class="" onclick="change_tab(1);">资料设置</li>
    <li class="" onclick="change_tab(2);">手机绑定</li>

</ul>

<div class="step">

    <?php include_once template("user/userindex");?>
</div>


<div class="step" style="padding:10px;">

    <?php include_once template("user/profile");?>
</div>

<div class="step" style="padding:10px;">

    <?php include_once template("user/mobile");?>
</div>



<script>
    var method='login';
    function change_tab(num) {
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
</script>


<?php include_once template("footer");?>