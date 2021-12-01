

<table class="history_ssc">
    <thead>
    <tr>
        <td rowspan="2" style="width:150px">期号</td>
        <td rowspan="2" style="width:200px;">时间</td>
        <td style="width:400px;">
            <div class="lg-history-tab show-pk10">
                <span data-val="1" class="active">号码</span>
                <span data-val="2">大小</span>
                <span data-val="3">单双</span>
                <span data-val="4">对子</span>
                <span data-val="5">综合</span>
            </div>
        </td>
        <td colspan="3">总和</td>
        <td>龙虎</td>
        <td colspan="3">形态</td>
    </tr>
    <tr>
        <td>
            <div class="show-pk10-tab">
                <span class="td-1">万</span>
                <span class="td-2">千</span>
                <span class="td-3">百</span>
                <span class="td-4">十</span>
                <span class="td-5">个</span>
            </div>
        </td>
        <td data-val="1" style="width:60px">和</td>
        <td data-val="2" style="width:60px">大小</td>
        <td data-val="3" style="width:60px">单双</td>
        <td data-val="4">龙虎</td>
        <td data-val="5">前三</td>
        <td data-val="6">中三</td>
        <td data-val="7">后三</td>
    </tr>
    </thead>
    <tbody>

    <?php if(is_array($number_list)){foreach($number_list AS $key=>$value) { ?>
    <tr>
        <td>
            <?php echo substr($value['period'],0,strlen($value['period'])-3); ?><span style="color:red;"><?php echo substr($value['period'],strlen($value['period'])-3,3); ?></span>

        </td>
        <td>
            <span><?php echo date('Y-m-d H:i:s',$value['lottime']); ?></span>
        </td>
        <td>

            <div class="ssc-opennuma pk10-opennuma show-pk10-tab-span kjh-num">
                <?php if(is_array($value['number_arr'])){foreach($value['number_arr'] AS $key1=>$value1) { ?>
                <p><span class="num-<?php echo $value1; ?> k"><?php echo $value1; ?></span></p>
                <?php }}?>

            </div>
            <div class="ssc-opennuma kjh-num-zh" style="display: none;">
                <?php
          $sum=0;
                 ?>
                <?php if(is_array($value['number_arr'])){foreach($value['number_arr'] AS $key1=>$value1) { ?>
                <?php $sum=$sum+$value1;?>
                <p>
                    <span class="num-<?php echo $value1; ?> k"><?php echo $value1; ?></span>
                    <?php if($value1>=5){?><span style="color:#fd0000">大</span><?php } else { ?><span style="color:#0867d1">小</span><?php }?>
                    <?php if($value1%2==1){?><span style="color:#fd0000">单</span><?php } else { ?><span style="color:#0867d1">双</span><?php }?>


                </p>
                <?php }}?>

            </div>

        </td>
        <td data-val="1"><?php echo $sum;?></td>
        <?php if($sum>=23){ ?>
        <td data-val="2" style="color:#fd0000;">大</td>
        <?php }else{ ?>
        <td data-val="2" style="color:#0867d1;">小</td>
        <?php } ?>
        <?php if($sum%2==1){ ?>
        <td data-val="3" style="color:#fd0000;">单</td>
        <?php }else{ ?>
        <td data-val="3" style="color:#0867d1;">双</td>
        <?php } ?>
        <?php if($value['number_arr'][0] > $value['number_arr'][4]){ ?>
        <td data-val="4" style="color:#fd0000;">龙</td>
        <?php }elseif($value['number_arr'][0]<$value['number_arr'][4]){ ?>
        <td data-val="4" style="color:#0867d1;">虎</td>
        <?php }else{ ?>
        <td data-val="4" style="color:green;">和</td>

        <?php } ?>

        <td data-val="5"><?php echo $value['number_xt'][0]; ?></td>
        <td data-val="6"><?php echo $value['number_xt'][1]; ?></td>
        <td data-val="7"><?php echo $value['number_xt'][2]; ?></td>
    </tr>
    <?php }}?>

    </tbody>
</table>