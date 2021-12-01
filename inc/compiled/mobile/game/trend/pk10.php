<script type="text/javascript" src="<?php echo $HttpPath; ?>static/web/js/pk10/trend-public.js?v=c167ceaa2357dd0f98caf9a7514f1ea5"></script>
<script type="text/javascript" src="<?php echo $HttpPath; ?>static/web/js/pk10/pk10-trend-open.js?v=c167ceaa2357dd0f98caf9a7514f1ea5"></script>
    <div style="background-color: #ffffff;">
        <div class="trend-panel-box1">
            <ul class="fh">

                <li class="fh-f9 <?php if($pos_type==1){?>n-active<?php }?>" onclick="location.href='?pos_type=1&pos_num=1';">位置</li>
                <li class="fh-f9 <?php if($pos_type==2){?>n-active<?php }?>" onclick="location.href='?pos_type=2&pos_num=1';">车号</li>
                <li class="fh-f9 <?php if($pos_type==3){?>n-active<?php }?>" onclick="location.href='?pos_type=3&pos_num=1';">和值</li>
                <li class="fh-f9 <?php if($pos_type==4){?>n-active<?php }?>" onclick="location.href='?pos_type=4&pos_num=1';">龙虎</li>
                <li class="fh-f9 <?php if($pos_type==5){?>n-active<?php }?>" onclick="location.href='?pos_type=5&pos_num=1';">组合</li>
            </ul>
            <ul class="fh">

                <?php if($pos_type==1 ||  $pos_type==5){?>
                <?php if(is_array($pos_arr)){foreach($pos_arr AS $key2=>$value2) { ?>


                <li <?php if($pos_num==$key2){?>class="active" <?php }?> onclick="location.href='?pos_type=<?php echo $pos_type; ?>&pos_num=<?php echo $key2; ?>'"><?php echo $value2; ?></li>


                <?php }}?>

                <?php } else if($pos_type==2) { ?>
                <?php if(is_array($pos_arr)){foreach($pos_arr AS $key2=>$value2) { ?>

                <li <?php if($pos_num==$key2){?>class="active" <?php }?> onclick="location.href='?pos_type=<?php echo $pos_type; ?>&pos_num=<?php echo $key2; ?>'"><?php echo $key2; ?>号</li>
                <?php }}?>
                <?php } else if($pos_type==3) { ?>
                <li class="active" onclick="location.href='?pos_type=<?php echo $pos_type; ?>&pos_num=1'">冠亚和</li>

                <?php } else if($pos_type==4) { ?>
                <?php if(is_array($pos_arr)){foreach($pos_arr AS $key=>$value) { ?>
                <?php if($key<5) { ?>
                <li <?php if($pos_num==$key2){?>class="active" <?php }?> onclick="location.href='?pos_type=<?php echo $pos_type; ?>&pos_num=<?php echo $key; ?>'"><?php echo $value; ?>龙虎</li>

                <?php } ?>

                <?php }}?>


                <?php }?>

            </ul>
        </div>

        <div class="trend-panel-box3">
            <ul class="fh">
                <li class="fh-f1"><?php echo $gameinfo['title']; ?><?php if($pos_type==1){?><?php echo $pos_arr[$pos_num]; ?><?php }?><?php if($pos_type==2){?><?php echo $pos_num; ?>号<?php }?><?php if($pos_type==3){?>冠亚和<?php }?><?php if($pos_type==4){?><?php echo $pos_arr[$pos_num]; ?>龙虎<?php }?><?php if($pos_type==5){?>组合<?php echo $pos_arr[$pos_num]; ?><?php }?>走势图</li>
                <li id="seting_btn"><i class="iconfont icon-shaixuan"></i>设置</li>
            </ul>
        </div>






        <?php include_once template("$tpl_name1");?>


    </div>