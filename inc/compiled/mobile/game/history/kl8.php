

<table class="history_kl8">
    <thead>
    <tr>
        <td  style="width:50px">期号</td>



        <td >
号码
        </td>
        <td  style="width:50px;">时间</td>
    </tr>
    </thead>
    <tbody>

    <?php if(is_array($number_list)){foreach($number_list AS $key=>$value) { ?>
    <tr>
        <td>
    <?php echo substr($value['period'],strlen($value['period'])-3,3); ?>

        </td>


        <td>

            <div class="kl8-num">
                <?php
          $sum=0;
                 ?>
                <?php if(is_array($value['number_arr'])){foreach($value['number_arr'] AS $key1=>$value1) { ?>
                <?php $sum=$sum+$value1;?>

                    <span class="num"><?php echo $value1; ?></span>

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