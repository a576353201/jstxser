

<?php include_once template("header");?>
<?php include_once template("game/header");?>
<style>
    .iframe-div {padding:20px 0;background-color: #ffffff;}
    .iframe {width:100%;height:600px;background-color: #ffffff;}

</style>
<div class="container cst-mainbody" style="background-color: #ffffff;">

    <div class="iframe-div">
        <?php if($live_url){?>
        <iframe class="iframe" frameborder="no" border="0" marginwidth="0" marginheight="0" scrolling="no" allowtransparency="yes" src="<?php echo $live_url; ?>"></iframe>
        <?php } else { ?>

        暂无开奖直播
        <?php }?>
    </div>
</div>

<?php include_once template("footer");?>

</body>
</html>


