

<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>static/css/user.css?v=<?php echo $cachekey; ?>" type="text/css" media="screen" />

<ul class="nav1">
    <li class="active" onclick="change_tab(0);">我的下级</li>
    <li class="" onclick="change_tab(1);">推广链接</li>
    <li class="" onclick="change_tab(2);">新增推广</li>
    <li class="" onclick="change_tab(3);">手动开户</li>
</ul>

<div class="step">

    <?php include_once template("user/invite_user");?>
</div>


<div class="step" style="display: none">

    <?php include_once template("user/invite_url");?>
</div>

<div class="step" style="display: none" >

    <?php include_once template("user/invite_add");?>
</div>


<div class="step" style="display: none" >

    <?php include_once template("user/invite_add1");?>
</div>



<script>
    var method=<?php echo $method; ?>;
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
    change_tab(method);
</script>


<?php include_once template("footer");?>