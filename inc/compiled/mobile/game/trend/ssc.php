
<script type="text/javascript" src="<?php echo $HttpPath; ?>static/web/js/cqssc/cqssc-trend-open.js?v=c167ceaa2357dd0f98caf9a7514f1ea5"></script>
<script type="text/javascript" src="<?php echo $HttpPath; ?>static/web/js/jsk3/trend-public.js?v=c167ceaa2357dd0f98caf9a7514f1ea5"></script>
<div style="background-color: #ffffff;">
    <div class="common-zs-title" style="display: none;">
        <span><?php echo $gameinfo['title']; ?>走势图</span>
        <span class="lg-tab-span">收起全部项目</span>
    </div>
    <div class="trend-panel-box1">
        <ul class="fh">
            <?php if(is_array($pos_wei)){foreach($pos_wei AS $key1=>$value1) { ?>

            <li class="fh-f1 <?php if($pos_type==$key1){?>n-active<?php }?>" onclick="location.href='trend_<?php echo $gameinfo['showkey']; ?>.html?pos_type=<?php echo $key1; ?>&pos_num=1';"><?php echo $value1; ?></li>

            <?php }}?>

        </ul>
        <ul class="fh">
            <?php if(is_array($pos_arr[$pos_type])){foreach($pos_arr[$pos_type] AS $key2=>$value2) { ?>


            <li <?php if($pos_num==$key2){?>class="active" <?php }?> onclick="location.href='?pos_type=<?php echo $pos_type; ?>&pos_num=<?php echo $key2; ?>';"><?php echo $value2; ?></li>
            <?php }}?>

        </ul>
    </div>
    <div class="trend-panel-box3">
        <ul class="fh">
            <li class="fh-f1"><?php echo $gameinfo['title']; ?><?php echo $pos_wei[$pos_type]; ?><?php echo $pos_arr[$pos_type][$pos_num]; ?>走势图</li>
            <li id="seting_btn"><i class="iconfont icon-shaixuan"></i>设置</li>
        </ul>
    </div>


<script>

    var openInfo=myinfoData;

    var list='<?php echo $list; ?>';

    list = JSON.parse(list);

</script>
    <?php include_once template("$tpl_name1");?>




