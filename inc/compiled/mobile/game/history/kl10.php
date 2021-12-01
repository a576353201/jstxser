

<table class="history_kl10">
    <thead>

    <tr>
        <td style="width:50px">期号</td>
        <td>
            <div class="kjh-title">
                <span class="td-1">一</span>
                <span class="td-2">二</span>
                <span class="td-3">三</span>
                <span class="td-4">四</span>
                <span class="td-5">五</span>
                <span class="td-6">六</span>
                <span class="td-7">七</span>
                <span class="td-8">八</span>


            </div>
        </td>
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
                    <?php if($value1>10){?><span style="color:#fd0000">大</span><?php } else { ?><span style="color:#0867d1">小</span><?php }?>
                    <?php if($value1%2==1){?><span style="color:#fd0000">单</span><?php } else { ?><span style="color:#0867d1">双</span><?php }?>


                </p>
                <?php }}?>

            </div>

        </td>
        <td>
            <span><?php echo date('H:i',$value['lottime']); ?></span>
        </td>
    </tr>
    <?php }}?>

    </tbody>
</table>