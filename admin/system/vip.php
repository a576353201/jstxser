<?php
include_once '../inc/header.php';

$title=array('系统基本参数');

$system=get_system();
$vip_arr=array('普通用户','代理','VIP','团队VIP');
?>




<form name='myform' enctype="multipart/form-data" action="action.php?from=index&type=<?php echo $_GET['type'] ?>&id=<?php echo $_GET['id'];?>" method="post">
    <table width="98%"  class="tableList" cellpadding="1" cellspacing="1">



        <tr>
            <td align="right">VIP金额</td>
            <td>
                <input name="vip_month" type="text"  style="width: 35px"  value="<?php echo $system['vip_month'];?>">元/月  &nbsp;
                <input name="vip_year" type="text" style="width: 35px" value="<?php echo $system['vip_year'];?>">元/年
            </td>
        </tr>
        <tr>
            <td align="right">团队VIP金额</td>
            <td>
                <input name="vip1_month" type="text"  style="width: 35px"  value="<?php echo $system['vip1_month'];?>">元/月  &nbsp;
                <input name="vip1_year" type="text" style="width: 35px" value="<?php echo $system['vip1_year'];?>">元/年


            </td>
        </tr>

        <tr>
            <td align="right">团队VIP最大支持人数</td>
            <td>
                <input name="vip1_max" type="text"  style="width: 50px"  value="<?php echo $system['vip1_max'];?>">人
            </td>
        </tr>



        <tr>
            <td align="right">最多可以创建多少群</td>
            <td>
                <?php
                foreach ($vip_arr as $key=>$value){
                    ?>
                <?php echo $value ?> : <input   style="width: 35px" name="group_sum<?php echo $key ?>" type="text" size="20" maxlength="20" value="<?php echo $system['group_sum'.$key];?>">
                   &nbsp;&nbsp;

                    <?php
                }
                ?>

            </td>
        </tr>
        <tr>
            <td align="right">每个群组最多人数</td>
            <td>
                <?php
                foreach ($vip_arr as $key=>$value){
                    ?>
                    <?php echo $value ?> : <input   style="width: 35px" name="people_sum<?php echo $key ?>" type="text" size="20" maxlength="20" value="<?php echo $system['people_sum'.$key];?>">
                    &nbsp;&nbsp;

                    <?php
                }
                ?>

            </td>
        </tr>
        <tr>
            <td align="right">最多可以加入多少群</td>
            <td>
                <?php
                foreach ($vip_arr as $key=>$value){
                    ?>
                    <?php echo $value ?> : <input   style="width: 35px" name="group_join<?php echo $key ?>" type="text" size="20" maxlength="20" value="<?php echo $system['group_join'.$key];?>">
                    &nbsp;&nbsp;

                    <?php
                }
                ?>

            </td>
        </tr>

        <tr>
            <td align="right">最多可以添加多少个好友</td>
            <td>
                <?php
                foreach ($vip_arr as $key=>$value){
                    ?>
                    <?php echo $value ?> : <input   style="width: 35px" name="friend_num<?php echo $key ?>" type="text" size="20" maxlength="20" value="<?php echo $system['friend_num'.$key];?>">
                    &nbsp;&nbsp;

                    <?php
                }
                ?>

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

