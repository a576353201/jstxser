<?php
include_once '../inc/common.php';
$ids=explode(',',$_GET['ids']);

$sql="select * from ".tname('user')." where (`group`=1 or `group`=2) and `agree`=1 ";

if($_GET['playersex']) $sql.=" and sex='{$_GET['playersex']}' ";
if($_GET['playerid']) $sql.=" and playerid='{$_GET['playerid']}' ";
if($_GET['realname']) $sql.=" and realname like '%{$_GET['realname']}%' ";

$list=$db->fetch_all($sql);
if(count($list)>0){
?>
<table style='width:100%;text-align:center;'>

<tr>
<td>
  <input type="checkbox" value="1"   onclick="click_all(this);"/>
  </td>
  <td>运动员编号</td>
<td>姓名</td>
<?php
if (!isMobile()){
	?>


<td>性别</td>
<td>居住地</td>
<td>年龄</td>
<td>是否外援</td>
<td>上年度锦标赛参赛单位</td>

<?php }else
{?>
<td style='line-height:25px;'>是否<br>外援</td>
<td style='line-height:25px;'>上年度锦标<br>赛参赛单位</td>


	<?php
}
?>


</tr>

<?php
foreach($list as $key =>$value){

	$idcard=desession($value['idcard']);
	if($value['birth']){

	$age=date('Y')-substr($value['birth'],0,4);

}

else $age='';

$address=unserialize($value['address']);
	?>

<tr>
<td>
  <input type="checkbox" name="playerid[]" value="<?php echo $value['id']?>" onclick="player_num();"/>
 <input type="hidden" id="name_<?php echo $value['id']?>" value="<?php echo $value['realname']?>"/>
    <input type="hidden" id="sex_<?php echo $value['id']?>" value="<?php echo $value['sex']?>"/>
  </td>
  <td><?php echo $value['playerid'];?></td>
<td><a href='<?php echo $HttpPath;?>user/space.php?uid=<?php echo $value['id']; ?>' target='_blank'><?php echo $value['realname'];?></a></td>
<?php
if (!isMobile()){
	?>
<td><?php echo $sex_arr[$value['sex']];?></td>
<td><?php if($address['resideprovince'] and !strpos($address['resideprovince'],'选择')) echo $address['resideprovince'].' '.$address['residecity'];else echo '-';?></td>
<td><?php echo $age;?></td>
<td><input type='radio' id='waiyuan_1_<?php echo $value['id'];?>'  value='1'  name='player[<?php echo $value['id'];?>][waiyuan]' >是&nbsp;&nbsp;
<input type='radio'id='waiyuan_2_<?php echo $value['id'];?>'  value='2' name='player[<?php echo $value['id'];?>][waiyuan]'>否</td>
<td style='position: relative;'>
<input type='text' style='width:120px;' id='player_danwei1_<?php echo $value['id'];?>' name='player[<?php echo $value['id'];?>][danwei]'  value=''  onclick="set_danwei(this.value,<?php echo $value['id'];?>,'player',0);" oninput="set_danwei(this.value,<?php echo $value['id'];?>,'player',1);"  >
<div class='player_danwei'  id='player_danwei_<?php echo $value['id'];?>'></div>

</td>
<?php }else
{?>

<td style='line-height:25px;'><input type='radio'  id='waiyuan_1_<?php echo $value['id'];?>' value='1' name='player[<?php echo $value['id'];?>][waiyuan]'  >是<br>
<input type='radio' id='waiyuan_2_<?php echo $value['id'];?>' value='2' name='player[<?php echo $value['id'];?>][waiyuan]' >否</td>
<td style='position: relative;'>
<input type='text' style='width:60px;' id='player_danwei1_<?php echo $value['id'];?>' value='' onclick="set_danwei(this.value,<?php echo $value['id'];?>,'player',0);" oninput="set_danwei(this.value,<?php echo $value['id'];?>,'player',1);" >
<div class='player_danwei'  id='player_danwei_<?php echo $value['id'];?>' name='player[<?php echo $value['id'];?>][waiyuan]'></div>
</td>



	<?php
}
?>


</tr>
	<?php
}
?>

</table>


<?php
}
else{


	echo "没找到对应的运动员";
}

?>
