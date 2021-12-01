<?php include_once template("header");?>


<script type="text/javascript" src="<?php echo $HttpPath; ?>static/js/team.js"></script>

<style>

.info .line  .title{width:120px;}
</style>

 <div class="user_center">

<div class='process1'>




<div class='step <?php if($step==1){?>cur<?php }?>' <?php if($_GET['id']){?>onclick="location.href='add.php?type=edit&step=1&id=<?php echo $_GET['id']; ?>&tid=<?php echo $_GET['tid']; ?>'" <?php }?>>

<div class='info'>基本信息</div>
</div>
<div class='step <?php if($step==2){?>cur<?php }?>' <?php if($_GET['id']){?>onclick="location.href='add.php?type=edit&step=2&id=<?php echo $_GET['id']; ?>&tid=<?php echo $_GET['tid']; ?>'" <?php }?> >

<div class='info'>抵离信息</div>
</div>
<div class='step <?php if($step==3){?>cur<?php }?>' <?php if($_GET['id']){?>onclick="location.href='add.php?type=edit&step=3&id=<?php echo $_GET['id']; ?>&tid=<?php echo $_GET['tid']; ?>'" <?php }?> >

<div class='info'>住宿信息</div>
</div>
<div class='step <?php if($step==4){?>cur<?php }?>'  <?php if($_GET['id']){?>onclick="location.href='add.php?type=edit&step=4&id=<?php echo $_GET['id']; ?>&tid=<?php echo $_GET['tid']; ?>'" <?php }?> >

<div class='info'>附件</div>
</div>


 </div>

<div class="info"  >

<form  action='add.php?step=<?php echo $step; ?>&tid=<?php echo $_GET['tid']; ?>' method='post'>
<?php if($_GET['id']){?>
<input type='hidden' name='id' value='<?php echo $_GET['id']; ?>'>

<?php }?>
<?php if($step==1){?>
<?php include_once template("team/add_step1");?>
<?php }?>

<?php if($step==2){?>
<?php include_once template("team/add_step2");?>
<?php }?>

<?php if($step==3){?>
<?php include_once template("team/add_step3");?>
<?php }?>

<?php if($step==4){?>
<?php include_once template("team/add_step4");?>
<?php }?>

</form>

</div>




</div>
</div>




















<script>
var team_num1='<?php echo $team_con['num1']; ?>';
var team_num2='<?php echo $team_con['num2']; ?>';
var team_num3='<?php echo $team_con['num3']; ?>';
var team_num4='<?php echo $team_con['num4']; ?>';
var team_num5='<?php echo $team_con['num5']; ?>';
var  task_id=<?php echo $_GET['tid']; ?>;

var player_ids='<?php echo $player_ids; ?>';
<?php if($step==1){?>
player_num();
<?php }?>
var is_admin=0;

var arrive_num=<?php echo count($arrive); ?>;
var level_num=<?php echo count($level); ?>;
var room_num=<?php echo count($room); ?>;
if(arrive_num==0) arrive_add();
if(level_num==0) level_add();
//if(room_num==0) room_add();
</script>


<?php include_once template("footer");?>