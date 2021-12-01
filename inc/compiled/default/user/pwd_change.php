<?php include_once template("header");?>


 <div class="user_center">
 <div class='u_left'>

<?php include_once template("user/left");?>
 </div>



 <div class='u_right'>

 <div class='user_nav'>
当前位置：<a href='index.php'>个人中心</a> &gt;<a href='pwd_change.php'>修改密码</a>

 </div>

<form action='pwd_change.php' method="post" onsubmit='return check_pwd();' class='info'>




<?php if($pwd==1){?>

<div class="line">
<span class="title"><span class="must">*</span>旧登录密码：</span>
<input name="oldpwd" type="password" class="input" id="oldpwd" value=""  autocomplete="off" />

</div>

<?php }?>


<div class="line">
<span class="title"><span class="must">*</span>新登录密码：</span>
<input id="pwd1" name="pwd1"  type="password" class="input"  value="" autocomplete="off"  />

</div>



<div class="line">
<span class="title"><span class="must">*</span>确认新密码：</span>
<input name="pwd2" type="password" class="input" id="pwd2" value="" autocomplete="off"  />

</div>

<div class='line'>

<div style='padding-left:253px;'>

<input type='submit' class='btn01' value='确认修改' id="button"  onclick="check_pwd();"  >
</div>
</div>

    </form>
</div>
</div>













<script>
function check_pwd(){


<?php if($pwd==1){?>


    if(document.getElementById('oldpwd').value==''){

    	window.wxc.xcConfirm('请输入登录密码',window.wxc.xcConfirm.typeEnum.warning);
    			return false;
    	        }

<?php }?>




    if(document.getElementById('pwd1').value==''){

    	window.wxc.xcConfirm('请输入新登录密码',window.wxc.xcConfirm.typeEnum.warning);
    			return false;
    	        }
    if(document.getElementById('pwd2').value==''){

    	window.wxc.xcConfirm('请确认登录密码',window.wxc.xcConfirm.typeEnum.warning);
    			return false;
    	  }

    if(document.getElementById('pwd1').value!=document.getElementById('pwd2').value){

    	window.wxc.xcConfirm('两次登录密码输入不一致',window.wxc.xcConfirm.typeEnum.warning);
    			return false;
    	        }


}
</script>

<?php include_once template("footer");?>