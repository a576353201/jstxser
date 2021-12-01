<?php
include_once '../inc/common.php';
$ids=explode(',',$_GET['ids']);

$sql="select * from ".tname('user')." where 1";
if($_GET['group']) $sql.=" and `group`='{$_GET['group']}' ";
if($_GET['agree']==1) $sql.=" and agree='1' ";
if($_GET['agree']==-1) $sql.=" and agree='0' ";
if($_GET['name']) $sql.=" and name='{$_GET['name']}' ";
if($_GET['playerid']) $sql.=" and playerid='{$_GET['playerid']}' ";
if($_GET['realname']) $sql.=" and realname like '%{$_GET['realname']}%' ";

$list=$db->fetch_all($sql);
if(count($list)>0){
?>
<table style='width:100%;text-align:center;'>

<tr>
<td>
  <input type="checkbox" value="1" checked  onclick="click_all(this);"/>
  </td>

  <td>手机号码</td>
  <td>姓名</td>
  <td>编号</td>
<td>用户类型</td>
<td>是否认证</td>

<td>注册时间</td>

</tr>

<?php
foreach($list as $key =>$value){


	?>

<tr>
<td>
  <input type="checkbox" name="playerid[]" checked value="<?php echo $value['id']?>" onclick="player_num();" <?php if(in_array($value['id'],$ids)) echo "checked"; ?>/>


  </td>
    <td><?php echo $value['name'];?></td>
  <td><a href='<?php echo $HttpPath;?>user/space.php?uid=<?php echo $value['id']; ?>' target='_blank'><?php echo $value['realname'];?></a></td>
  <td><?php echo $value['playerid'];?></td>


<td><?php echo $user_group[$value['group']];?></td>
<td><?php if($value['agree']==1) echo '已认证';else echo '未认证';?></td>
<td><?php echo date('Y-m-d H:i:s',$value['regtime']);?></td>


</tr>
	<?php
}
?>

</table>


<?php
}
else{


	echo "没找到对应的用户";
}

?>
