

<?php include_once template("header");?>
<?php include_once template("game/header");?>
<style>
    .iframe-div {padding:20px 0;background-color: #ffffff;}
    .iframe {width:100%;height:650px;background-color: #ffffff;}

</style>
<div class="container cst-mainbody" style="background-color: #ffffff;">
    <div class="location-box"  style="width: 1170px;background-color: #e9e9e9;margin:0 0 10px -15px;">
        <ul>
            <li></li>
            <li>
                <span>当前位置:</span>
                <a href="<?php echo $HttpPath; ?>"><?php echo $system['web_title']; ?></a> > <a href="home_<?php echo $gameinfo['showkey']; ?>.html"><?php echo $gameinfo['title']; ?></a> > <a href="#">开奖直播</a>
            </li>
        </ul>
    </div>
    <div class="iframe-div">
        <?php if($live_url){?>
        <iframe class="iframe" frameborder="no" border="0" marginwidth="0" marginheight="0" scrolling="no" allowtransparency="yes" src="<?php echo $live_url; ?>" ></iframe>
        <?php } else { ?>

        暂无开奖直播
        <?php }?>
    </div>
</div>
<script>
    function setIframeHeight(iframe) {
        if (iframe) {
            var iframeWin = iframe.contentWindow || iframe.contentDocument.parentWindow;
            if (iframeWin.document.body) {
                iframe.height = iframeWin.document.documentElement.scrollHeight || iframeWin.document.body.scrollHeight;
            }
        }
    };



</script>
<?php include_once template("footer");?>

</body>
</html>


