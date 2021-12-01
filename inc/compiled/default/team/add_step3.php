
<div class='line'  style='clear:both;text-align:center;'>

<?php if(count($hotal)>0 && $task['room_status']==1){?>
<input type='button' class='btn00' value='新增入住信息'  onclick="room_add();">

<?php } else { ?>
目前该赛事暂时未提供酒店预定服务


<?php }?>
</div>
<div class='line' id='room_div'  style='clear:both;'>

<?php

$temp=0;
?>
<?php if(is_array($room)){foreach($room AS $index=>$value) { ?>
<?php

$index=$temp;
$temp++;

?>
<div class='info00' id='room_<?php echo $index; ?>'><div class='title00'>入住需求<?php echo $num_arr[$index]; ?>



<span class='icon_add2' onclick='room_remove("room_<?php echo $index; ?>");'></span>


</div>



<div>
<span class='title'>户型：</span>
<select  name='room[<?php echo $index; ?>][name]'>
<?php if(is_array($hotal)){foreach($hotal AS $index1=>$value1) { ?>
<option value='<?php echo $value1; ?>' <?php if($value1==$value['name']){?>selected<?php }?>><?php echo $value1; ?></option>

<?php }}?>
</select>
<br>
<span class='title'>数量：</span>

<input type="number" class="input" id="height" name="room[<?php echo $index; ?>][num]" value="<?php echo $value['num']; ?>" min="1" max="1000" step="1">
<br>
<span class='title'>入住时间：</span><input type='text' class='Wdate input1' id="room_<?php echo $index; ?>_begintime" name='room[<?php echo $index; ?>][begintime]' value='<?php echo $value['begintime']; ?>'  style='width:200px !important;' minlength='18' maxlength='20' autofocus='' required='' autocomplete='off'  onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false})">（格式：yyyy-mm-dd）<br>
<span class='title'>离开时间：</span><input type='text' class='Wdate input1' id="room_<?php echo $index; ?>_endtime" name='room[<?php echo $index; ?>][endtime]' value='<?php echo $value['endtime']; ?>'  style='width:200px !important;' minlength='18' maxlength='20' autofocus='' required='' autocomplete='off'  onclick="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false})">（格式：yyyy-mm-dd）<br>


<span class='title'>备注：</span>


<input type='text'id="room_<?php echo $index; ?>_mark" name='room[<?php echo $index; ?>][mark]' value='<?php echo $value['mark']; ?>'  style='width:200px !important;' >


</div>

</div>
<?php }}?>
</div>








<div class='line'>

<div style='padding-left:225px;padding-top:10px;'>
<input type='button' class='btn00' value='上一步'  onclick="location.href='add.php?type=<?php echo $_GET['type']; ?>&step=2&id=<?php echo $_GET['id']; ?>&tid=<?php echo $_GET['tid']; ?>';" >
<input type='submit' class='btn01' value='下一步'  onclick="return click_sub(<?php echo $step; ?>)"; >
<span id='text_html'></span>

</div>
</div>



<script>

var hotal_html="<?php echo $hotal_html; ?>";
var  team_id=<?php echo $_GET['id']; ?>;
//get_room_list();
</script>