

<?php include_once template("header");?>
<?php include_once template("game/header");?>


<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>51cp/static/web/css/jsk3/basicTrend.css?v=c167ceaa2357dd0f98caf9a7514f1ea5" type="text/css"/>

    <div class="container cst-mainbody" style="padding:0;">
        <div class="location-box">
            <ul>
                <li></li>
                <li>
                    <span>当前位置:</span>
                    <a href="<?php echo $HttpPath; ?>"><?php echo $system['web_title']; ?></a> > <a href="home_<?php echo $gameinfo['showkey']; ?>.html"><?php echo $gameinfo['title']; ?></a> > <a href="#">走势图</a>
                </li>
            </ul>
        </div>
        <?php include_once template("$tpl_name");?>
  </div>




<?php include_once template("footer");?>

</body>
</html>
