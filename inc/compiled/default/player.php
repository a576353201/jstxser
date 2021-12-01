   <?php include_once template("header");?>












<div class='player_list'>

<div style='height:50px;line-height:50px;padding-top:10px;'>

<form action='player.php'  method='get'>
类型：<select name='group'>
<option value=''>不限</option>

<?php  foreach($user_group as $key=>$value){

if($key<3){

	?>
	<option value='<?php echo $key;?>'  <?php if ($key==$_GET['group']) echo "selected";?>><?php echo $value; ?></option>

	<?php
	}
}?>

</select>
&nbsp;&nbsp;
注册年份：<select name='year'>
<option value=''>不限</option>

<?php  for($i=date('Y');$i>=2016;$i-- ){



	?>
	<option value='<?php echo $i;?>'  <?php if ($i==$_GET['year']) echo "selected";?>><?php echo $i; ?></option>

	<?php

}?>

</select>
&nbsp;&nbsp;

性别：<select name='sex'>
<option value=''>不限</option>

<?php  foreach($sex_arr as $key=>$value){



	?>
	<option value='<?php echo $key;?>'  <?php if ($key==$_GET['sex']) echo "selected";?>><?php echo $value; ?></option>

	<?php

}?>

</select>


&nbsp;&nbsp;
姓名：<input type="text" name="realname" value="<?php echo $_GET['realname']; ?>" >&nbsp;&nbsp;
运动员编号：<input type="text" name="playerid" value="<?php echo $_GET['playerid']; ?>" >&nbsp;&nbsp;

<input type='submit' value='搜索' class='btn01'>
</form>






</div>




<?php if(count($list)>0){?>


<ul >
 	<?php if(is_array($list)){foreach($list AS $index=>$value) { ?>
<li >
<a href='user/space.php?uid=<?php echo $value['id']; ?>' target='_blank' title='<?php echo show_username($value['id']); ?>&nbsp;运动员编号：<?php echo $value['playerid']; ?>'>


<img src='<?php echo avatar($value['id']); ?>' />


<div>


<?php echo show_username($value['id']); ?>&nbsp;
<?php echo show_usergroup($value['id'],0); ?>
</div>



</a>


</li>

           <?php }}?>

</ul>


                    <div class="page" style='clear:both;'><?php echo $page_html; ?></div>




<?php } else { ?>
<div  style='height:40px;line-height:40px;text-align:center;'>没有找到符合条件运动员</div>

<?php }?>

</div>
<?php include_once template("footer");?>
