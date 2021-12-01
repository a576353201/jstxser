<script type="text/javascript" src="<?php echo $HttpPath; ?>static/web/js/jsk3/jsk3-trend-open.js?v=c167ceaa2357dd0f98caf9a7514f1ea5"></script>
<script type="text/javascript" src="<?php echo $HttpPath; ?>static/web/js/jsk3/trend-public.js?v=c167ceaa2357dd0f98caf9a7514f1ea5"></script>


<div style="background-color: #ffffff;">

    <div class="common-zs-tab common-zs-tab-div">




            <?php if(is_array($pos_arr)){foreach($pos_arr AS $key2=>$value2) { ?>
            <a href="?pos_type=<?php echo $key2; ?>" <?php if($pos_type==$key2){?>class="active" <?php }?>><?php echo $value2; ?></a>

            <?php }}?>
        </div>


    </div>

<div class="trend-panel-box3">
    <ul class="fh">
        <li class="fh-f1"><?php echo $gameinfo['title']; ?><?php echo $pos_arr[$pos_type]; ?>走势图</li>
        <li id="seting_btn"><i class="iconfont icon-shaixuan"></i>设置</li>
    </ul>
</div>
   

    <script>

        var openInfo=myinfoData;

        var list='<?php echo $list; ?>';


        list = JSON.parse(list);
        for(var ii in list[1]){
            console.log(ii,list[0][ii]);
        }

    </script>
    <?php include_once template("$tpl_name1");?>








