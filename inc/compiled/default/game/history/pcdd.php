

<table class="history_pcdd">
    <thead>
    <tr>
        <td  style="width:120px">期号</td>

        <td  style="width:200px;">时间</td>

        <td style="width:300px;">

        </td>



        <td data-val="2">大小</td>
        <td data-val="3" >单双</td>


        <td data-val="4"><span class="common-wh zbwh">中边</span></td>
        <td data-val="5"><span class="common-wh bswh">波色</span></td>
        <td data-val="6"><span class="common-wh jzwh">极值</span></td>
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

            <div class="pcdd-num">

                <span class="num"><?php echo $value['number_arr'][0]; ?></span>
               <a>+</a>
                <span class="num"><?php echo $value['number_arr'][1]; ?></span>
                <a>+</a>
                <span class="num"><?php echo $value['number_arr'][2]; ?></span>
                <a>=</a>
                <span class="sum" style="background-color: <?php echo lot_typepcdd($value['number_arr']);?>"><?php $sum= $value['number_arr'][0]+$value['number_arr'][1]+$value['number_arr'][2];echo $sum;?></span>


            </div>

        </td>

        <?php if($sum>14){ ?>
        <td data-val="2" style="color:#fd0000;">大</td>

        <?php }else{ ?>
        <td data-val="2" style="color:#0867d1;">小</td>
        <?php } ?>
        <?php if($sum%2==1){ ?>
        <td data-val="3" style="color:#fd0000;">单</td>
        <?php }else{ ?>
        <td data-val="3" style="color:#0867d1;">双</td>
        <?php } ?>
        <?php if($sum>=10 and $sum<=17){ ?>
        <td data-val="4" style="color:#fd0000;">中</td>

        <?php }else{ ?>
        <td data-val="4" >边</td>
        <?php } ?>


        <td data-val="5"><?php echo $value['number_bs']; ?></td>

        <td data-val="6" >
            <?php if($sum<=5) echo "极小";elseif($sum>=22) echo "极大";else echo '无'; ?>

        </td>




    </tr>
    <?php }}?>

    </tbody>
</table>