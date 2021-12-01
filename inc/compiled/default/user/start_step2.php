<?php if($user['group']==1 || $user['group']==2){?>
<script>
var player_group = new Array();
<?php
foreach($player_group as $key=>$value){
?>
player_group[<?php echo $key;?>]='<?php echo $system['player_group_'.$key];?>';

<?php
}
?>
</script>
<div class='line'>
<span  class='title'>昵称：</span>
<input type='text' class='input' id='nickname' name='nickname' value='<?php echo $user['nickname']; ?>'  >

</div>

<div class='line'>
<span  class='title'>常驻球馆：</span>
<input type='text' class='input' id='qiuguan' name='player[qiuguan]' value='<?php echo $player['qiuguan']; ?>'  >

</div>

<div class='line'>
<span  class='title'>身高：</span>
<input type='number' class='input' id='height' name='player[height]' value='<?php echo $player['height']; ?>'  min="100" max="250" step='0.1'  oninput="if(this.checkValidity()==false)check_ok(); " >cm
</div>

<div class='line'>
<span  class='title'>体重：</span>
<input type='number' class='input' id='weight' name='player[weight]' value='<?php echo $player['weight']; ?>'  min="20" max="150" step='0.1'  oninput="if(this.checkValidity()==false)check_ok(); ">kg
</div>

<div class='line'>
<span  class='title'>球重：</span>
<input type='number' class='input' id='ballweight' name='player[ballweight]' value='<?php echo $player['ballweight']; ?>'  min="1" max="16" step='0.1'  oninput="if(this.checkValidity()==false)check_ok(); " >磅
</div>


<div class='line'>
<span  class='title'>等级：</span>
<select name='player[group]' onchange='change_group(this.value);'>
<option value=''>请选择</option>
<?php
if($user['group']==1) unset($player_group[3]);
foreach($player_group as $key=>$value){
?>
<option value='<?php echo $key;?>' <?php if($key==$player['group']) echo "selected";?> ><?php echo $value;?></option>

<?php
}
?>


</select>
<span   id='group2'>
<?php

if($player['group2']){

$arr= explode('|',$system['player_group_'.$player['group']]);
?>

<select name='player[group2]'>
<?php
foreach($arr as $value) {

?>
<option value='<?php echo $value;?>' <?php if($value==$player['group2']) echo "selected";?> ><?php echo $value;?></option>
<?php
}
?>

</select>
<?php }?>
</span>

</div>

<div class='line'>
<span  class='title'><span class='must'>*</span>开始打球时间：</span>

<select id='fromtime' name='player[fromtime]' required="">
<option value=''>请选择</option>
<?php
for($i=date('Y');$i>1970;$i--){
?>
<option value='<?php echo $i;?>' <?php if($i==$player['fromtime']) echo "selected"; ?>><?php echo $i;?></option>


<?php } ?>
</select>
年
</div>
<div class='line'>
<span  class='title'><span class='must'>*</span>技术打法：</span>


<input  name="player[playkinds]" type="radio" value="F" <?php if($player['playkinds']=='F'){?>checked<?php }?>>飞碟&nbsp;&nbsp;
<input  name="player[playkinds]" type="radio" value="H" <?php if($player['playkinds']=='H'){?>checked<?php }?>>弧线&nbsp;&nbsp;
<input  name="player[playkinds]" type="radio" value="Z" <?php if($player['playkinds']=='Z'){?>checked<?php }?>>直线  &nbsp;&nbsp;


</div>

<div class='line'>
<span  class='title'><span class='must'>*</span>惯用手：</span>

<input name="player[hand]" type="radio" value="左手" <?php if($player['hand']=='左手'){?>checked<?php }?>>左手&nbsp;&nbsp;
<input name="player[hand]" type="radio" value="右手" <?php if($player['hand']=='右手'){?>checked<?php }?>>右手&nbsp;&nbsp;
<input name="player[hand]" type="radio" value="双手(左)" <?php if($player['hand']=='双手(左)'){?>checked<?php }?>>双手(左)&nbsp;&nbsp;
<input name="player[hand]" type="radio" value="双手(右)" <?php if($player['hand']=='双手(右)'){?>checked<?php }?>>双手(右)

</div>
<div class='line'>
<span  class='title'>单局最高分：</span>
<input type='number' class='input' id='score1' name='player[score1]' value='<?php echo $player['score1']; ?>'  min="0" max="300" step='1'  oninput="if(this.checkValidity()==false)check_ok(); " >
</div>

<div class='line'>
<span  class='title'>三局最高分：</span>
<input type='number' class='input' id='score3' name='player[score3]' value='<?php echo $player['score3']; ?>'  min="0" max="900" step='1'   oninput="if(this.checkValidity()==false)check_ok(); " >
</div>

<div class='line'>
<span  class='title'>六局最高分：</span>
<input type='number' class='input' id='score6' name='player[score6]' value='<?php echo $player['score6']; ?>'  min="0" max="1800" step='1'   oninput="if(this.checkValidity()==false)check_ok(); "  >
</div>

<?php }?>


<?php if($user['group']==1 && $_GET['act']!='update'){?>


<div class='line'>
<span  class='title'>注册单位：</span>
<input type='text' class='input' id='danwei' name='player[danwei]' value='<?php echo $player['danwei']; ?>'  >

</div>

<div class='line'>
<span  class='title'>主要运动战绩：</span>
<textarea id='zhanji' name='player[zhanji]' ><?php echo $player['zhanji']; ?></textarea>
</div>
<?php }?>



<?php if($user['group']==2  || $_GET['act']=='update'){?>
<div class='line'>
<span  class='title'>注册为职业球员时间：</span>

<select name='player[fromyear]'>
<?php
for($i=date('Y');$i>1950;$i--){
if($i==$player['fromyear']) $select="selected";
else $select='';
echo "<option value='".$i."' ".$select." >".$i."年</option>";
}

 ?>

</select>

</div>

<div class='line'>
<span  class='title'>所属协会或俱乐部：</span>
<input type='text' class='input' id='xiehui' name='player[xiehui]' value='<?php echo $player['xiehui']; ?>'  >
</div>

<div class='line'>
<span  class='title'>赞助商：</span>
<input type='text' class='input' id='zanzhu' name='player[zanzhu]' value='<?php echo $player['zanzhu']; ?>'  >
</div>

<div class='line'>
<span  class='title'>职业积分：</span>
<input type='text' class='input' id='zyscore' name='player[zyscore]' value='<?php echo $player['zyscore']; ?>'  >

</div>
<div class='line'>
<span  class='title'>职业战绩：</span>
<textarea id='zhanji' name='player[zhanji]' ><?php echo $player['zhanji']; ?></textarea>

</div>
<?php }?>

<?php if($user['group']==3){?>


<div class='line'>
<span  class='title'>注册单位：</span>
<input type='text' class='input' id='danwei' name='player[danwei]' value='<?php echo $player['danwei']; ?>'  >
</div>

<div class='line'>
<span  class='title'>裁判员等级：</span>
<input type='text' class='input' id='dengji' name='player[dengji]' value='<?php echo $player['dengji']; ?>'  >

</div>

<div class='line'>
<span  class='title'>主要执裁经历：</span>
<textarea id='jingli' name='player[jingli]' ><?php echo $player['jingli']; ?></textarea>
</div>
<?php }?>



<div class='line'>

<div style='padding-left:270px;'>
 <?php if($_GET['act']=='update'){?>
<input type='hidden'  name='act' value='update'  >
<input type='submit' class='btn00' value='确认升级'  onclick="return click_sub(<?php echo $step; ?>,<?php echo $user['group']; ?>)"; >
<?php } else { ?>
<?php if($type=='edit'){?>
<input type='button' class='btn00' value='上一步'  onclick="location.href='start.php?step=1&type=<?php echo $type; ?>';"; >
<input type='submit' class='btn01' value='保存并进入下一步' id='click_next' onclick="return click_sub(<?php echo $step; ?>,<?php echo $user['group']; ?>);" >
<?php } else { ?>

<input type='button' class='btn00' value='上一步'  onclick="location.href='start.php?step=1&type=<?php echo $type; ?>';"; >
<input type='submit' class='btn01' value='下一步'  id='click_next'  onclick="return click_sub(<?php echo $step; ?>,<?php echo $user['group']; ?>);" >
<?php }?>
<?php }?>

</div>
</div>