<?php
include_once '../inc/header.php';

$title=array('系统基本参数');

$system=get_system();

?>




<form name='myform' enctype="multipart/form-data" action="action.php?from=index&type=<?php echo $_GET['type'] ?>&id=<?php echo $_GET['id'];?>" method="post">
    <table width="98%"  class="tableList" cellpadding="1" cellspacing="1">


        <tr>
            <td align="right">充值渠道</td>
            <td>
                <?php
                $method=unserialize($system['recharge_method']);
                foreach ($recharge_arr as $key=>  $value){
                    ?>
                    <input type="checkbox" name="recharge_method[]" value="<?php echo $key;?>" <?php if(in_array($key,$method)) echo  "checked";?> ><?php echo $value;?>
                <?php
                }
                ?>
            </td>
        </tr>


        <?php
        $setting=unserialize($system['recharge_setting']);
        foreach ($recharge_arr as $key=>  $value){
            ?>
            <tr>
                <td align="right"><?php echo $value;?>充值设置</td>
                <td>
                   最低:<input name="recharge_setting[<?php echo $key;?>][min]" type="text" size="5"  value="<?php echo $setting[$key]['min'];?>">元

                    最高：<input name="recharge_setting[<?php echo $key;?>][max]" type="text" size="5"  value="<?php echo $setting[$key]['max'];?>">元
                    手续费：<input name="recharge_setting[<?php echo $key;?>][fee]" type="text" size="5"  value="<?php echo $setting[$key]['fee'];?>">%

                </td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td align="right">IOS充值方式</td>
            <td>
                 <input type="radio" name="iospay" value="1" <?php if($system['iospay']==1) echo 'checked';?>>ios内付 &nbsp;&nbsp;

                <input type="radio" name="iospay" value="0" <?php if($system['iospay']!=1) echo 'checked';?>>其他支付方式
            </td>
        </tr>


        <tr>
            <td align="right">IOS端VIP购买方式</td>
            <td>
                <input type="radio" name="iosvip" value="1" <?php if($system['iosvip']==1) echo 'checked';?>>ios内付 &nbsp;&nbsp;

                <input type="radio" name="iosvip" value="0" <?php if($system['iosvip']!=1) echo 'checked';?>>余额支付
            </td>
        </tr>
        <tr>
            <td align="right">ios内付手续费</td>
            <td>
                <input name="iospay_fee" type="text" style="width: 50px"  value="<?php echo $system['iospay_fee'];?>">%
            </td>
        </tr>
        <tr>
            <td align="right">ios内付充值金额</td>
            <td>
                <input name="iospay_money" type="text" style="width: 300px"  value="<?php echo $system['iospay_money'];?>">（用“|”分隔）
            </td>
        </tr>
        <tr>
            <td align="right">ios内付渠道(充值)</td>
            <td>
                <input name="iospay_recharge" type="text" style="width: 300px"  value="<?php echo $system['iospay_recharge'];?>">（用“|”分隔）
            </td>
        </tr>
        <tr>
            <td align="right">ios内付渠道(VIP)</td>
            <td>
                <input name="iospay_vip" type="text" style="width: 300px"  value="<?php echo $system['iospay_vip'];?>">（用“|”分隔）
            </td>
        </tr>



        <tr>
            <td align="right">最多绑定银行卡数量</td>
            <td>
                <input name="bank_num" type="text" size="5"  value="<?php echo $system['bank_num'];?>">张
            </td>
        </tr>

        <tr>
            <td align="right">每天最多提现次数</td>
            <td>
                <input name="plat_times" type="text" size="5"  value="<?php echo $system['plat_times'];?>">次
            </td>
        </tr>
        <tr>
            <td align="right">提现设置</td>
            <td>
                最低:<input name="plat_min" type="text" size="5"  value="<?php echo $system['plat_min'];?>">元

                最高：<input name="plat_max" type="text" size="5"  value="<?php echo $system['plat_max'];?>">元
                手续费：<input name="plat_fee" type="text" size="5"  value="<?php echo $system['plat_fee'];?>">%

            </td>
        </tr>
        <tr>
            <td align="right">拒绝提现提示</td>
            <td>
               <textarea name="platdeny_tips"  rows="4" cols="80" ><?php echo $system['platdeny_tips']?></textarea>(用“|”分隔)

            </td>
        </tr>

        <tr>
            <td></td>
            <td height="30" align="left" colspan="1">
                <input class="button" type="submit" name="Submit" value="提 交"  >&nbsp;&nbsp;&nbsp;&nbsp;
                <input class="button" type="reset" name="Submit" value="重 置" >
            </td>
        </tr>
    </table>
</form>





<?php include_once '../inc/footer.php';?>

