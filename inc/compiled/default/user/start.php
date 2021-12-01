<?php include_once template("header");?>
<script type="text/javascript" src="<?php echo $HttpPath; ?>static/js/user.js"></script>
 <div class="main">

 <div class='process'>
 <div class="title"><?php echo $web_title; ?></div>

<?php if($user['group']==4){?>


<div class='step <?php if($step==1){?>cur<?php }?>'  style='width:50%;'>
<div class='num'>1</div>
<div class='info'>基本信息</div>
</div>

<div class='step <?php if($step==4){?>cur<?php }?>' style='width:50%;'>
<div class='num'>2</div>
<div class='info'>附件</div>
</div>

<?php } else { ?>

<div class='step <?php if($step==1){?>cur<?php }?>'>
<div class='num'>1</div>
<div class='info'>基本信息</div>
</div>
<div class='step <?php if($step==2){?>cur<?php }?>'>
<div class='num'>2</div>
<div class='info'><?php if($user['group']==3){?>职业信息<?php } else { ?>球员信息<?php }?></div>
</div>
<div class='step <?php if($step==3){?>cur<?php }?>'>
<div class='num'>3</div>
<div class='info'>联系方式</div>
</div>
<div class='step <?php if($step==4){?>cur<?php }?>'>
<div class='num'>4</div>
<div class='info'>附件</div>
</div>

<?php }?>
 </div>




<div class="info">
<form  action='start.php?step=<?php echo $step; ?>' method='post'>
<?php if($step==1){?>
<?php include_once template("user/start_step1");?>
<?php }?>


<?php if($step==2){?>
<?php include_once template("user/start_step2");?>
<?php }?>

<?php if($step==3){?>
<?php include_once template("user/start_step3");?>
<?php }?>

<?php if($step==4){?>
<?php include_once template("user/start_step4");?>
<?php }?>
</form>

</div>



</div>






<?php include_once template("footer");?>