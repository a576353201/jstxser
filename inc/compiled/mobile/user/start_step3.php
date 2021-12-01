
<div class='line'>
<span  class='title'>常用邮箱：</span>
<input type='text' class='input' id='email' name='contact[email]' value='<?php echo $contact['email']; ?>'   minlength="4" maxlength="30"  >
(名片页面可见)
</div>


<div class='line'>
<span  class='title'>QQ号码：</span>
<input type='text' class='input' id='qq' name='contact[qq]' value='<?php echo $contact['qq']; ?>'   minlength="5" maxlength="11"  >

</div>


<div class='line'>
<span  class='title'>微信：</span>
<input type='text' class='input' id='weixin' name='contact[weixin]' value='<?php echo $contact['weixin']; ?>'   minlength="3" maxlength="30" >

</div>

<div class='line'>

<div style='padding-left:40px;'>

<?php if($type=='edit'){?>
<input type='button' class='btn00' value='上一步'  onclick="location.href='start.php?step=2&type=<?php echo $type; ?>';"; >
<input type='submit' class='btn01' value='保存并进入下一步'  onclick="return click_sub(<?php echo $step; ?>,<?php echo $user['group']; ?>)"; >
<?php } else { ?>

<input type='button' class='btn00' value='上一步'  onclick="location.href='start.php?step=2&type=<?php echo $type; ?>';"; >
<input type='submit' class='btn01' value='下一步'  onclick="return click_sub(<?php echo $step; ?>,<?php echo $user['group']; ?>)"; >
<?php }?>


</div>
</div>