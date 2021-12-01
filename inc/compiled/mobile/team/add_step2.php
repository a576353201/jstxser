<div class='line'  style='clear:both;text-align:center;'>
<input type='button' class='btn00' value='新增抵达时间'  onclick="arrive_add();">
<input type='button' class='btn01' value='新增离会时间'  onclick="level_add();" >
</div>
<div class='line' id='arrive_div'  style='clear:both;'>

<?php

$temp=0;
?>
<?php if(is_array($arrive)){foreach($arrive AS $index=>$value) { ?>
<?php

$index=$temp;
$temp++;

?>

<div class='info00' id='arrive_<?php echo $index; ?>'><div class='title00'>抵达时间<?php echo $num_arr[$index]; ?>


<span class='icon_add1' onclick='arrive_add();'></span>

<span class='icon_add2' onclick='arrive_remove("arrive_<?php echo $index; ?>");'></span>


</div>


<div>
<span class='title'>抵达时间：</span><input type='text' class='Wdate input1'  name='arrive[<?php echo $index; ?>][time]' value='<?php echo $value['time']; ?>'  style='width:200px !important;' minlength='18' maxlength='20' autofocus='' required='' autocomplete='off'  onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false})">（格式：yyyy-mm-dd HH:ii:ss）<br>
<span class='title'>航班号(车次)：</span><input type='text' style='width:200px !important;'   name='arrive[<?php echo $index; ?>][hangban]' value='<?php echo $value['hangban']; ?>' required=''><br>
<span class='title'>备注：</span><input type='text' style='width:200px !important;'   name='arrive[<?php echo $index; ?>][mark]' value='<?php echo $value['mark']; ?>' ><br>
<span class='title'>人数：</span><input type='number'  class='input1'  name='arrive[<?php echo $index; ?>][num]' value='<?php echo $value['num']; ?>' min='1' max='1000'  autofocus='' required='' autocomplete='off' >人<br>
<span class='title'>联系人：</span><input type='text'  style='width:200px !important;'  name='arrive[<?php echo $index; ?>][contact]' value='<?php echo $value['contact']; ?>' minlength='2' maxlength='20' autofocus='' required='' autocomplete='off' ><br>
<span class='title'>联系电话：</span><input type='text' style='width:200px !important;'   name='arrive[<?php echo $index; ?>][tel]' value='<?php echo $value['tel']; ?>' >
</div>

</div>
<?php }}?>
</div>




<div class='line' id='level_div'  style='clear:both;margin-top:15px;'>
<?php

$temp=0;
?>
<?php if(is_array($level)){foreach($level AS $index=>$value) { ?>
<?php

$index=$temp;
$temp++;

?>

<div class='info00' id='level_<?php echo $index; ?>'><div class='title00'>离会时间<?php echo $num_arr[$index]; ?>


<span class='icon_add1' onclick='level_add();'></span>

<span class='icon_add2' onclick='level_remove("level_<?php echo $index; ?>");'></span>

</div>


<div>
<span class='title'>离会时间：</span><input type='text' class='Wdate input1'  name='level[<?php echo $index; ?>][time]' value='<?php echo $value['time']; ?>'  style='width:200px !important;' minlength='18' maxlength='20' autofocus='' required='' autocomplete='off'  onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false})">（格式：yyyy-mm-dd  HH:ii:ss）<br>
<span class='title'>航班号(车次)：</span><input type='text' style='width:200px !important;'   name='level[<?php echo $index; ?>][hangban]' value='<?php echo $value['hangban']; ?>' required=''><br>
<span class='title'>备注：</span><input type='text' style='width:200px !important;'   name='level[<?php echo $index; ?>][mark]' value='<?php echo $value['mark']; ?>' ><br>
<span class='title'>人数：</span><input type='number'  class='input1'  name='level[<?php echo $index; ?>][num]' value='<?php echo $value['num']; ?>' min='1' max='1000'  autofocus='' required='' autocomplete='off' >人<br>
<span class='title'>联系人：</span><input type='text'  style='width:200px !important;'  name='level[<?php echo $index; ?>][contact]' value='<?php echo $value['contact']; ?>' minlength='2' maxlength='20' autofocus='' required='' autocomplete='off' >
    <br>
<span class='title'>联系电话：</span><input type='text' style='width:200px !important;'   name='level[<?php echo $index; ?>][tel]' value='<?php echo $value['tel']; ?>' >
</div>

</div>
<?php }}?>
</div>



<div class='line'>

<div style='padding-left:100px;padding-top:10px;'>
<input type='button' class='btn00' value='上一步'  onclick="location.href='add.php?type=<?php echo $_GET['type']; ?>&step=1&id=<?php echo $_GET['id']; ?>&tid=<?php echo $_GET['tid']; ?>'"; >
<input type='submit' class='btn01' value='下一步'  onclick="return click_sub(<?php echo $step; ?>)"; >
    <?php if($_GET[id]>0){?>
 <a href='add.php?type=<?php echo $_GET['type']; ?>&step=3&id=<?php echo $_GET['id']; ?>&tid=<?php echo $_GET['tid']; ?>' style='color:#00aaee;margin-left: 10px; ' >跳过</a>

<?php }?>
</div>
</div>