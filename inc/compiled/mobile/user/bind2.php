<?php include_once template("header");?>






 <div class="user_center">




<div class="info">


<form action="bind2.php"  method="post">


<div class='line'>

<span class="title"><span class='must'>*</span>用户类型:</span>


      <select name='group'>

      <?php if(is_array($user_group)){foreach($user_group AS $index=>$value) { ?>
<option value='<?php echo $index; ?>'  ><?php echo $value; ?></option>

<?php }}?>

      </select>


</div>





<div class='line'>

<div style='padding-left:123px;'>
<input type="submit" class='btn01' value='下一步' onClick="return order_sub();">
</div></div>
</form>
</div>




</div>
</div>




















<?php include_once template("footer");?>