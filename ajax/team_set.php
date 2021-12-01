<?php
include_once '../inc/common.php';

$menu=$db->exec("select * from ".tname('task_menu')." where id='{$_GET[id]}'");
$team=unserialize($menu['team']);
?>
  领队最大人数：<input name="team[num1]" type="text" class="input1" maxlength="10" value="<?php echo $team['num1'];?>">
            &nbsp;&nbsp;副领队最大人数：<input name="team[num2]" type="text" class="input1" maxlength="10" value="<?php echo $team['num2'];?>"><br>
               教练最大人数：<input name="team[num3]" type="text" class="input1" maxlength="10" value="<?php echo $team['num3'];?>"><br>
                   男运动员最大人数：<input name="team[num4]" type="text" class="input1" maxlength="10" value="<?php echo $team['num4'];?>">
            &nbsp;&nbsp;女运动员最大人数：<input name="team[num5]" type="text" class="input1" maxlength="10" value="<?php echo $team['num5'];?>">