<?php
include_once '../inc/header.php';

$title=array('系统基本参数');

$system=get_system();

?>




<form name='myform' enctype="multipart/form-data" action="action.php?from=index&type=<?php echo $_GET['type'] ?>&id=<?php echo $_GET['id'];?>" method="post">
    <table width="98%"  class="tableList" cellpadding="1" cellspacing="1">
        <?php

        foreach ($plan_grade_arr  as $key=>$value) {


                ?>
                <tr>
                    <td align="right"><?php echo $value;?>计划员Logo</td>
                    <td>
                        <input type="text" name="plan_logo_<?php echo $key;?>" value="<?php echo $system['plan_logo_'.$key]?>" size="40"/>
                        &nbsp;<iframe style=" padding:0; margin:0;" src="../inc/upload.php?returnid=plan_logo_<?php echo $key;?>&image=1&path=ico" frameborder=0 scrolling=no width="350" height="25"></iframe>
                    </td>
                </tr>
                <?php

        }
        ?>

        <tr  style="display: none" >
            <td align="right">在线计划地址</td>
            <td> <input name="planurl" type="text" size="40"  value="<?php echo $system['planurl'];?>">


            </td>
        </tr>
        <tr>
            <td align="right">计划欢迎语</td>
            <td>
                <input name="plan_welcome" type="text" size="50"  value="<?php echo $system['plan_welcome'];?>">
            </td>
        </tr>

        <tr>
            <td align="right">计划提示语</td>
            <td>
                <input name="plan_tips" type="text" size="50"  value="<?php echo $system['plan_tips'];?>">
            </td>
        </tr>

        <tr>
            <td align="right">计划声明</td>
            <td>
                <textarea rows="4"style="width: 90%" name="task_note"><?php echo $system['task_note'];?></textarea>

            </td>
        </tr>

        <?php
        $plan_task=unserialize($system['plan_task']);
        foreach ($plan_grade_arr  as $key=>$value) {

            if ($key > 0) {
                ?>
                <tr>
                    <td align="right"><?php echo $value;?>任务</td>
                    <td>
                       连续<input name="plan_task[<?php echo $key;?>][day]" type="text"  style="width: 35px"  value="<?php echo $plan_task[$key]['day'];?>">天，
                        每天发布<input name="plan_task[<?php echo $key;?>][expect]" type="text" style="width: 35px" value="<?php echo $plan_task[$key]['expect'];?>">期，
                        中奖率<input name="plan_task[<?php echo $key;?>][rate]" type="text" style="width: 35px" value="<?php echo $plan_task[$key]['rate'];?>">%，
                        完成1天奖励<input name="plan_task[<?php echo $key;?>][reward]" type="text" style="width: 35px" value="<?php echo $plan_task[$key]['reward'];?>">元，
                        完成任务奖励<input name="plan_task[<?php echo $key;?>][rewardsum]" type="text" style="width: 35px" value="<?php echo $plan_task[$key]['rewardsum'];?>">元,

                    </td>
                </tr>
                <?php
            }
        }
        ?>
        <tr>
            <td align="right">任务个数限制</td>
            <td>
                <?php

                foreach ($plan_grade_arr  as $key=>$value) {


                ?>

                    <?php echo $value;?>：<input name="plan_task[<?php echo $key;?>][addnum]" type="text"  style="width: 35px"  value="<?php echo $plan_task[$key]['addnum'];?>">个

                   &nbsp;
                    最高<input  name="plan_task[<?php echo $key;?>][addmax]" type="text"  style="width: 35px"  value="<?php echo $plan_task[$key]['addmax'];?>">期\个

                    <input type="radio" name="plan_task[<?php echo $key;?>][isdelete]" value="1" <?php if($plan_task[$key]['isdelete']==1) echo "checked";?> >可删除   &nbsp; &nbsp;
                    <input type="radio" name="plan_task[<?php echo $key;?>][isdelete]" value="0" <?php if($plan_task[$key]['isdelete']!=1) echo "checked";?> >禁止删除
                    <br>



    <?php

    }
    ?>

            </td>
        </tr>

        <tr>
            <td align="right">打赏榜</td>
            <td>
                <textarea rows="4" style="width: 90%" name="plan_notes"><?php echo $system['plan_notes'];?></textarea>

            </td>
        </tr>
        <tr>
            <td align="right">打赏限制</td>
            <td>

                   期数>=<input name="reward_expect" type="text"  style="width: 35px"  value="<?php echo $system['reward_expect'];?>">期

                中奖率>=<input name="reward_rate" type="text"  style="width: 35px"  value="<?php echo $system['reward_rate'];?>">%


            </td>
        </tr>
        <tr>
            <td align="right">计划员申请拒绝提示</td>
            <td>
                <textarea name="planerdeny_tips"  rows="4" cols="80" ><?php echo $system['planerdeny_tips']?></textarea>(用“|”分隔)

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

