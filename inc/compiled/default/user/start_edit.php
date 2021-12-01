<?php include_once template("header");?>
 <div class="user_center">
 <div class='u_left'>

<?php include_once template("user/left");?>
 </div>



 <div class='u_right'>
 <div class='user_nav'>

当前位置：<a href='index.php'>个人中心</a> &gt;
<?php if($_GET['act']=='update'){?>
<a href='start.php?type=edit&step=2&act=update'>升级为职业球员</a>

<?php } else { ?>
<a href='start.php?type=edit&step=1'>个人信息修改</a>

<?php }?>
 </div>
 <?php if($_GET['act']!='update'){?>
<div class='process1'>


<?php if($user['group']==4){?>


<div class='step <?php if($step==1){?>cur<?php }?>'  style='width:50%;' onclick="location.href='start.php?type=edit&step=1'" >

<div class='info'>基本信息</div>
</div>

<div class='step <?php if($step==4){?>cur<?php }?>' style='width:50%;' onclick="location.href='start.php?type=edit&step=4'" >

<div class='info'>附件</div>
</div>

<?php } else { ?>

<div class='step <?php if($step==1){?>cur<?php }?>' onclick="location.href='start.php?type=edit&step=1'" >

<div class='info'>基本信息</div>
</div>
<div class='step <?php if($step==2){?>cur<?php }?>' onclick="location.href='start.php?type=edit&step=2'" >

<div class='info'><?php if($user['group']==3){?>职业信息<?php } else { ?>球员信息<?php }?></div>
</div>
<div class='step <?php if($step==3){?>cur<?php }?>' onclick="location.href='start.php?type=edit&step=3'" >

<div class='info'>联系方式</div>
</div>
<div class='step <?php if($step==4){?>cur<?php }?>' onclick="location.href='start.php?type=edit&step=4'" >

<div class='info'>附件</div>
</div>

<?php }?>
 </div>

<?php }?>
<script type="text/javascript" src="<?php echo $HttpPath; ?>static/js/user.js?v=<?php echo time(); ?>"></script>
<div class="info"  style='padding:0 5%;'>
<form  action='start.php?step=<?php echo $step; ?>&type=<?php echo $type; ?>' method='post'>
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
</div>
















<?php include_once template("footer");?>