<?php if($user['group']==4){?>


<?php if($user['realname']=='' && $user['agree']==1   ){?>
<div class='line'>
<span  class='title'><span class='must'>*</span>单位名称：</span>
<input type='text' class='input' id='realname' name='realname' value='<?php echo $user['realname']; ?>' minlength="2" maxlength="30" autofocus="" required="" autocomplete="off">

</div>
<?php } else { ?>
<div class='line'>
<span  class='title'>单位名称：</span>
<input type='hidden'  name='realname' value='<?php echo $user['realname']; ?>'>
<?php echo $user['realname']; ?>
</div>
<?php }?>


<?php if($company['ids']=='' && $user['agree']==1){?>
<div class='line'>
<span  class='title'>组织机构代码：</span>
<input type='text' class='input' id='ids' name='company[ids]' value='<?php echo $company['ids']; ?>'>

</div>
<?php } else { ?>
<div class='line'>
<span  class='title'>组织机构代码：</span>
<input type='hidden'  name='company[ids]' value='<?php echo $company['ids']; ?>'>
<?php echo $company['ids']; ?>
</div>
<?php }?>


<?php if($company['type']=='' && $user['agree']==1){?>

<div class='line'>
<span  class='title'>机构类型：</span>
<select name='company[type]'>
<?php if(is_array($company_type)){foreach($company_type AS $index=>$value) { ?>
<option value='<?php echo $value; ?>' <?php if($value==$company['type']){?>selected<?php }?>><?php echo $value; ?></option>
<?php }}?>
</select>

</div>

<?php } else { ?>
<div class='line'>
<span  class='title'>机构类型：</span>
<?php echo $company['type']; ?>
<input type='hidden'  name='company[type]' value='<?php echo $company['type']; ?>'>

</div>
<?php }?>



<?php } else { ?>


<?php if(($type=='edit' && ($user['group']==1  || $user['group']==2 ) ) || ($user['group']==3 && $user['agree']==1) ){?>


<div class='line'>
<span  class='title'>姓名：</span>
<?php echo $user['realname']; ?>

</div>

<div class='line'>
<span  class='title'>身份证号：</span>
<?php echo $user['idcard1']; ?>

</div>

<div class='line'>
<span  class='title'>性别：</span>
 <?php if($user['sex']==1){?>男<?php } else { ?>女<?php }?>
</div>


<div class='line'>
<span  class='title'>出生年月日：</span>
<?php echo $user['birth']; ?>

</div>




<?php } else { ?>
<input type='hidden' name='sex' id='sex' value='<?php echo $user['sex']; ?>'>
<input type='hidden' name='birth' id='birth' value='<?php echo $user['birth']; ?>'>
<div class='line'>
<span  class='title'><span class='must'>*</span>姓名：</span>
<input type='text' class='input' id='realname' name='realname' value='<?php echo $user['realname']; ?>' minlength="2" maxlength="10" autofocus="" required="" autocomplete="off">

</div>

<div class='line'>
<span  class='title'><span class='must'>*</span>身份证号：</span>
<input type='text' class='input' id='idcard' name='idcard' value='<?php echo $user['idcard']; ?>' minlength="18" maxlength="18" autofocus="" required="" onblur='setidcard(this.value);' >
(如果尾号是'X'，必须大写)
</div>

<div class='line'>
<span  class='title'><span class='must'>*</span>性别：</span>
<span id='sex_html'>
<?php if($user['sex']==1){?>
男
<?php } else if($user['sex']==2) { ?>
女
<?php } else { ?>
-
<?php }?>

</span>

</div>


<div class='line'>
<span  class='title'><span class='must'>*</span>出生年月日：</span>
<span id='birth_html'>
<?php if($user['birth']){?>
<?php echo $user['birth']; ?>
<?php } else { ?>
-
<?php }?>

</span>
<br>
<span style='margin-left:250px;color:#ccc;font-size:12px;'>以上四项一旦提交不能修改，请谨慎填写</span>
</div>
<?php }?>
<div class='line'>
<span  class='title'>家乡：</span>
<select id="birthprovince" name='address[birthprovince]'></select>
<select id="birthcity"  name='address[birthcity]'></select>
<select id="birthcountry"  name='address[birthcountry]'></select>
<script type="text/javascript">
addressInit('birthprovince', 'birthcity', 'birthcountry','<?php echo $address['birthprovince']; ?>','<?php echo $address['birthcity']; ?>','<?php echo $address['birthcountry']; ?>');
</script>

</div>

<div class='line'>
<span  class='title'>居住地：</span>
<select id="resideprovince" name='address[resideprovince]'></select>
<select id="residecity"  name='address[residecity]'></select>
<select id="residecountry"  name='address[residecountry]'></select>
<script type="text/javascript">
addressInit('resideprovince', 'residecity', 'residecountry','<?php echo $address['resideprovince']; ?>','<?php echo $address['residecity']; ?>','<?php echo $address['residecountry']; ?>');
</script>


</div>

<?php }?>
<div class='line'>

<div style='padding-left:270px;'>
<?php if($type=='edit'){?>

<input type='submit' class='btn01' value='保存并进入下一步'  onclick="return click_sub(<?php echo $step; ?>,<?php echo $user['group']; ?>)"; >
<?php } else { ?>


<input type='submit' class='btn01' value='下一步'  onclick="return click_sub(<?php echo $step; ?>,<?php echo $user['group']; ?>)"; >
<?php }?>

</div>
</div>



