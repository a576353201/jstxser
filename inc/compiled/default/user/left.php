
	<script charset="utf-8" src="<?php echo $HttpTemplatePath; ?>js/main.js"></script>


       <div class="left_list">
      <div class='title'>参赛信息</div>

<ul>

<li onclick="location.href='<?php echo $HttpPath; ?>user/index.php'" <?php echo nav_cur('index.php'); ?>>
<span class='icon'>
<img src="<?php echo $HttpPath; ?>static/images/mobile/icon_team1.png" >
</span>
<span class='info11'>个人中心</span>
<span class='next'>&gt; </span>
</li>

<li onclick="location.href='<?php echo $HttpPath; ?>user/msg.php'" <?php echo nav_cur('msg.php'); ?>>
<span class='icon'>
<img src="<?php echo $HttpPath; ?>static/images/mobile/icon_note.png" height="25px">
</span>
<span class='info11'>我的消息(<span style='color:#ff0000;font-weight:600;' name='msg_num'><?php echo $msg_num; ?></span>)</span>
<span class='next'>&gt; </span>
</li>


<li onclick="location.href='<?php echo $HttpPath; ?>user/task.php'" <?php echo nav_cur('task.php'); ?>>
<span class='icon'>
<img src="<?php echo $HttpPath; ?>static/images/mobile/icon_team.png" height="25px">
</span>
<span class='info11'>我参加的比赛</span>
<span class='next'>&gt; </span>
</li>





</ul>
</div>
<div class="left_list">
    <div class='title'>个人信息</div>
<ul>

<li onclick="location.href='<?php echo $HttpPath; ?>user/start.php?type=edit&step=1'"  <?php echo nav_cur('start.php'); ?>>
<span class='icon' >
<img src="<?php echo $HttpPath; ?>static/images/mobile/icon_useradd.png" height="25px">
</span>
<span class='info11'>个人信息修改</span>
<span class='next'> &gt; </span>
</li>


<li onclick="location.href='<?php echo $HttpPath; ?>user/pwd_change.php'" <?php echo nav_cur('pwd_change.php'); ?>>
<span class='icon'>
<img src="<?php echo $HttpPath; ?>static/images/mobile/icon_pwd.png" height="25px">
</span>
<span class='info11'>修改密码</span>
<span class='next'>&gt;</span>
</li>






<li onclick="location.href='<?php echo $HttpPath; ?>user/mobile.php'" <?php echo nav_cur('mobile.php'); ?>>
<span class='icon'>
<img src="<?php echo $HttpPath; ?>static/images/mobile/icon_pwd2.png" height="25px">
</span>
<span class='info11'>修改手机号</span>
<span class='next'>&gt; </span>
</li>


<li onclick="location.href='<?php echo $HttpPath; ?>user/quit.php'" <?php echo nav_cur('quit.php'); ?>>
<span class='icon'>
<img src="<?php echo $HttpPath; ?>static/images/mobile/icon_update.png" height="25px">
</span>
<span class='info11'>退出登录</span>
<span class='next'>&gt;</span>
</li>

</ul>
</div>


<script>
function set_menu(id){

	  var menu =document.getElementById(id);
	  var menu_title =document.getElementById(id+'_title');

	  if(menu.style.display=='block'){
		  menu.style.display='none' ;
		  menu_title.src='<?php echo $HttpTemplatePath; ?>images/xia.gif';
	  }
	  else{
		  menu.style.display='block' ;
		  menu_title.src='<?php echo $HttpTemplatePath; ?>images/shang.gif';

	  }
}


</script>