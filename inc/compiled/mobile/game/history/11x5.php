

<table class="history_11x5">
    <thead>
    <tr>
        <td  style="width: 40px;">期号</td>

        <td >
            <div class="kjh-title">
                <span class="td-1">第一球</span>
                <span class="td-2">第二球</span>
                <span class="td-3">第三球</span>
                <span class="td-4">第四球</span>
                <span class="td-5">第五球</span>



            </div>

        </td>
        <td style="width: 50px;">时间</td>
    </tr>
    </thead>
    <tbody>

    <?php if(is_array($number_list)){foreach($number_list AS $key=>$value) { ?>
    <tr>
        <td>
    <span style="color:red;"><?php echo substr($value['period'],strlen($value['period'])-3,3); ?></span>

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
                    <?php if($value1>5){?><span style="color:#fd0000">大</span><?php } else { ?><span style="color:#0867d1">小</span><?php }?>
                    <?php if($value1%2==1){?><span style="color:#fd0000">单</span><?php } else { ?><span style="color:#0867d1">双</span><?php }?>


                </p>
                <?php }}?>

            </div>

        </td>
        <td>
            <span><?php echo date('Y-m-d',$value['lottime']); ?></span>
        </td>

    </tr>
    <?php }}?>

    </tbody>
</table>