

<?php include_once template("header");?>
<?php include_once template("game/header");?>
<style>
    .iframe-div {padding:10px 10px;background-color: #ffffff;line-height: 25px;}
    .iframe {width:100%;height:600px;background-color: #ffffff;}

</style>
<div class="container cst-mainbody" style="background-color: #ffffff;">
    <div class="location-box"  style="width: 1170px;background-color: #e9e9e9;margin:0 0 10px -15px;">
        <ul>
            <li></li>
            <li>
                <span>当前位置:</span>
                <a href="<?php echo $HttpPath; ?>"><?php echo $system['web_title']; ?></a> > <a href="home_<?php echo $gameinfo['showkey']; ?>.html"><?php echo $gameinfo['title']; ?></a> > <a href="#">玩法规则</a>
            </li>
        </ul>
    </div>
    <div class="iframe-div">
    <?php echo $rule; ?>
    </div>
</div>

<?php include_once template("footer");?>

</body>
</html>


