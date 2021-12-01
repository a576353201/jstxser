<table>
    <thead>
    <tr>
        <td rowspan="2" style="width:100px">期号</td>
        <td rowspan="2" style="width:220px;">
            <?php if($gameinfo['showkey']=='F1'){?>

            <span id="time_bj" onclick="change_time('oz');" style="cursor: pointer" title="当前为北京时间，点击切换到欧洲时间">北京时间<br><span style="font-size: 12px;color: #999;">切换到欧洲时间</span></span>
            <span id="time_oz" onclick="change_time('bj');" style="cursor: pointer;display: none;" title="当前为欧洲时间，点击切换到北京时间">欧洲时间<br><span style="font-size: 12px;color: #999;">切换到北京时间</span></span>
            <?php } else { ?>
            时间
            <?php }?></td>
        <td style="width:450px;">
            <div class="lg-history-tab show-pk10">
                <span data-val="1" class="active">号码</span>
                <span data-val="2">大小</span>
                <span data-val="3">单双</span>
                <span data-val="4">对子</span>
                <span data-val="5">综合</span>
            </div>
        </td>
        <td colspan="3">冠亚和</td>
        <td colspan="5">1~5龙虎</td>
    </tr>
    <tr>
        <td>
            <div class="show-pk10-tab" >
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
        <td style="width:60px" data-val="1">和</td>
        <td style="width:60px" data-val="2">大小</td>
        <td style="width:60px" data-val="3">单双</td>
        <td data-val="4">1</td>
        <td data-val="5">2</td>
        <td data-val="6">3</td>
        <td data-val="7">4</td>
        <td data-val="8">5</td>
    </tr>
    </thead>
    <tbody>
    <?php if(is_array($number_list)){foreach($number_list AS $key=>$value) { ?>
    <tr>
        <td>
            <?php echo substr($value['period'],0,strlen($value['period'])-3); ?><span style="color:red;"><?php echo substr($value['period'],strlen($value['period'])-3,3); ?></span>

        </td>
        <td>
            <?php if($gameinfo['showkey']=='F1'){?>

            <span class="time_bj"><?php echo date('Y-m-d H:i:s',$value['lottime']); ?></span>
            <span class="time_oz" style="display: none"><?php echo date('Y-m-d H:i:s',$value['lottime']-7*3600); ?></span>
            <?php } else { ?>
            <span><?php echo date('Y-m-d H:i:s',$value['lottime']); ?></span>
            <?php }?>

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
        <td data-val="1" style="font-size:25px;"><?php echo $value['number_arr'][0]+$value['number_arr'][1];?></td>
        <?php if(($value['number_arr'][0]+$value['number_arr'][1])>=12){ ?>
        <td data-val="2" style="color:#fd0000;">大</td>
        <?php }else{ ?>
        <td data-val="2" style="color:#0867d1;">小</td>
        <?php } ?>
        <?php if(($value['number_arr'][0]+$value['number_arr'][1])%2==1){ ?>
        <td data-val="3" style="color:#fd0000;">单</td>
        <?php }else{ ?>
        <td data-val="3" style="color:#0867d1;">双</td>
        <?php } ?>
        <?php for($i=0;$i<5;$i++){ ?>
        <?php if($value['number_arr'][$i]>$value['number_arr'][9-$i]){ ?>
        <td data-val="<?php echo $i+4;?>" style="color:#fd0000;">龙</td>
        <?php }else{ ?>
        <td data-val="<?php echo $i+4;?>" style="color:#0867d1;">虎</td>

        <?php } ?>

        <?php } ?>

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
        }else{

            document.getElementById('time_bj').style.display='none';
            document.getElementById('time_oz').style.display='';
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