

<table class="history_kl8">
    <thead>
    <tr>
        <td  style="width:120px">期号</td>

        <td  style="width:150px;">时间</td>

        <td style="width:450px;">

        </td>


        <td data-val="1">和值</td>
        <td data-val="2">大/小</td>
        <td data-val="3" >单/双</td>


        <td data-val="4">上/下</td>
        <td data-val="5">五行</td>

    </tr>
    </thead>
    <tbody>

    <?php if(is_array($number_list)){foreach($number_list AS $key=>$value) { ?>
    <tr>
        <td>
            <?php echo substr($value['period'],0,strlen($value['period'])-3); ?><span style="color:red;"><?php echo substr($value['period'],strlen($value['period'])-3,3); ?></span>

        </td>
        <td>
            <span><?php echo date('Y-m-d H:i',$value['lottime']); ?></span>
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
        <td data-val="1"><?php echo $sum;?></td>
        <?php if($sum>811){ ?>
        <td data-val="2" style="color:#fd0000;">大</td>

        <?php }else{ ?>
        <td data-val="2" style="color:#0867d1;">小</td>
        <?php } ?>
        <?php if($sum%2==1){ ?>
        <td data-val="3" style="color:#fd0000;">单</td>
        <?php }else{ ?>
        <td data-val="3" style="color:#0867d1;">双</td>
        <?php } ?>

        <?php if($value['number_sx']=='上'){ ?>
        <td data-val="4" style="color:#fd0000;"><?php echo $value['number_sx']; ?></td>
        <?php }else if($value['number_sx']=='下'){ ?>
        <td data-val="4" style="color:#0867d1;"><?php echo $value['number_sx']; ?></td>
        <?php }else{ ?>
        <td data-val="4" style="color:green;"><?php echo $value['number_sx']; ?></td>
        <?php } ?>


        <td data-val="5">
            <?php
            if($sum<=695) echo '金';else if($sum<=763) echo '木';else if($sum<=855) echo '水';else if($sum<=923) echo '木';
            else echo '土';
            ?>

        </td>




    </tr>
    <?php }}?>

    </tbody>
</table>