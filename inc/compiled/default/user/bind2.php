<?php include_once template("header");?>
<script type="text/javascript" src="<?php echo $HttpPath; ?>static/js/user.js"></script>
 <div class="main">

 <div class='process'  style='height:50px;'>
 <div class="title"><?php echo $web_title; ?></div>


 </div>




<div class="info">
<form  action='bind2.php' method='post'>

<div class='line'>

<span class="title"><span class='must'>*</span>用户类型:</span>


      <select name='group'>

      <?php if(is_array($user_group)){foreach($user_group AS $index=>$value) { ?>
<option value='<?php echo $index; ?>'  ><?php echo $value; ?></option>

<?php }}?>

      </select>


</div>


<div class='line'>

<div style='padding-left:253px;'>
<input type="submit" class='btn01' value='下一步'>
</div></div>
</form>
</div>



</div>



</div>






<?php include_once template("footer");?>