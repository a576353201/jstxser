<table>
    <thead>
    <tr>
        <td  style="width: 40px;">期号</td>

        <td >
            <div class="kjh-title">
                <span class="td-1">冠</span>
                <span class="td-2">亚</span>
                <span class="td-3">三</span>
                <span class="td-4">四</span>
                <span class="td-5">五</span>
                <span class="td-6">六</span>
                <span class="td-7">七</span>
                <span class="td-8">八</span>
                <span class="td-9">九</span>
                <span class="td-10">十</span>


            </div>

        </td>
        <td style="width:<?php if($gameinfo['showkey']=='F1'){?>90<?php } else { ?>50<?php }?>px;">

            <?php if($gameinfo['showkey']=='F1'){?>

            <span id="time_bj" onclick="change_time('oz');" style="cursor: pointer" title="当前为北京时间，点击切换到欧洲时间">北京时间</span>
            <span id="time_oz" onclick="change_time('bj');" style="cursor: pointer;display: none;" title="当前为欧洲时间，点击切换到北京时间">欧洲时间</span>
            <?php } else { ?>
            时间
            <?php }?></td>
    </tr>

    </thead>
    <tbody>
    <?php if(is_array($number_list)){foreach($number_list AS $key=>$value) { ?>
    <tr>
        <td>
      <?php echo substr($value['period'],strlen($value['period'])-3,3); ?>

        </td>

        <td>

            <div class="pk10-opennuma show-pk10-tab-span kjh-num">
        <?php if(is_array($value['number_arr'])){foreach($value['number_arr'] AS $key1=>$value1) { ?>
        <p><span class="num-<?php echo $value1; ?> k"><?php echo $value1; ?></span></p>
        <?php }}?>

    </div>
        <div class="kjh-num-zh" style="display: none;">
            <?php if(is_array($value['number_arr'])){foreach($value['number_arr'] AS $key1=>$value1) { ?>
            <p>
                <span class="num-<?php echo $value1; ?> k"><?php echo $value1; ?></span>
                <?php if($value1>5){?><span style="color:#fd0000">大</span><?php } else { ?><span style="color:#0867d1">小</span><?php }?>
                <?php if($value1%2==1){?><span style="color:#fd0000">单</span><?php } else { ?><span style="color:#0867d1">双</span><?php }?>


            </p>
            <?php }}?>

        </div>
        </td>
        <td>
            <?php if($gameinfo['showkey']=='F1'){?>

            <span class="time_bj"><?php echo date('m-d H:i',$value['lottime']); ?></span>
            <span class="time_oz" style="display: none"><?php echo date('m-d H:i',$value['lottime']-7*3600); ?></span>
            <?php } else { ?>
            <span><?php echo date('H:i',$value['lottime']); ?></span>
            <?php }?>
        </td>


    </tr>

    <?php }}?>


    </tbody>
</table>

<script>
    function  change_time(type) {
        var time_bj=document.querySelectorAll('.time_bj');
        var time_oz=document.querySelectorAll('.time_oz');
        if(type=='bj'){
            document.getElementById('time_bj').style.display='';
            document.getElementById('time_oz').style.display='none';
            document.getElementById('time1_bj').style.display='';
            document.getElementById('time1_oz').style.display='none';
        }else{

            document.getElementById('time_bj').style.display='none';
            document.getElementById('time_oz').style.display='';
            document.getElementById('time1_bj').style.display='none';
            document.getElementById('time1_oz').style.display='';
        }

        for(var i=0;i<time_bj.length;i++){
            if(type=='bj'){
                time_bj[i].style.display='';
                time_oz[i].style.display='none';
            }else{

                time_bj[i].style.display='none';
                time_oz[i].style.display='';
            }


        }



    }
</script>