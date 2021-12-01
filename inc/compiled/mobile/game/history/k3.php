

<table class="history_k3">
    <thead>
    <tr>
        <td style="width:40px">期号</td>


        <td style="width:50px;">开奖号</td>
        <td>
            <div class="kjh-title">
                <span class="td-1">万</span>
                <span class="td-2">千</span>
                <span class="td-3">百</span>

            </div>
        </td>
        <td style="width:40px;">总和</td>

        <td style="width:50px;">形态</td>
        <td style="width:50px;">时间</td>
    </tr>

    </thead>
    <tbody>

    <?php if(is_array($number_list)){foreach($number_list AS $key=>$value) { ?>
    <tr>
        <td>
     <?php echo substr($value['period'],strlen($value['period'])-3,3); ?>

        </td>


        <td>
            <span><?php echo $value['number']; ?></span>
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
                    <?php if($value1>3){?><span style="color:#fd0000">大</span><?php } else { ?><span style="color:#0867d1">小</span><?php }?>
                    <?php if($value1%2==1){?><span style="color:#fd0000">单</span><?php } else { ?><span style="color:#0867d1">双</span><?php }?>


                </p>
                <?php }}?>

            </div>

        </td>
        <td data-val="1"><?php echo $sum;?></td>



        <td data-val="7"><?php echo $value['number_xt'][0]; ?></td>

        <td>
            <span><?php echo date('H:i',$value['lottime']); ?></span>
        </td>

    </tr>
    <?php }}?>

    </tbody>
</table>