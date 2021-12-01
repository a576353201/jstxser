<?php
include_once '../inc/header.php';

if(!$_GET['action']) $action='add';
else $action=$_GET['action'];
$admin=get_table(tname('admin'), $_GET['id']);

$role=$db->fetch_all("select * from ".tname('role')." order by id desc");
if(count($role)<1){

		promptMessage('role.php', '请先添加角色');

}
if($_GET['sms_ok']!=1){

//	$ref=urlencode('//'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
//echo "<script>window.location='mobile.php?ref={$ref}';</script>";
//
//exit();



}



?>



  <form name='myform' enctype="multipart/form-data" action="action.php?action=<?php echo $action ?>&id=<?php echo $_GET['id'];?>" method="post">
         <table width="100%"  class="table_add" cellpadding="1" cellspacing="1">
          <tr>
            <td  align="right">用户名</td>
            <td >
              <div style="float:left; margin-right:10px">
                <input name="name" type="text" size="40" maxlength="40" onblur="check_name();" value="<?php echo $admin['name'];?>">
                <span id="name_msg"></span>
              </div>
              <div id="showMessageId" style="display:none; float:left; line-height:16px; margin-top:5px;"></div>
            </td>
          </tr>
          <tr>
            <td align="right">登陆密码</td>
            <td> <input id='pwd' name="pwd" type="password" size="40" maxlength="40">
              <font color="#FF0000" id='pwd_msg'>*</font></td>
          </tr>
          <tr>
            <td align="right">密码确认</td>
            <td> <input id='pwdcheck' name="pwdcheck" type="password" size="40" maxlength="40">
             <font color="#FF0000" id="pwdcheck_msg">*</font></td>
          </tr>
          <tr>
            <td align="right">姓名</td>
            <td> <input name="realname" type="text" size="40" maxlength="40" value="<?php echo $admin['realname']?>"></td>
          </tr>
                     <tr>
            <td align="right">管理员类别</td>
            <td> <select name='group'>
              <?php

               foreach ($role as  $key=>$value) {
              	if($value){
    ?>
           <option value="<?php echo $value['id']?>" <?php if($value['id']==$admin['group']) echo "selected";?>><?php echo $value['name'];?></option>

      <?php
              	}}?>

              </select></td>
          </tr>
          <tr>
            <td align="right">性别</td>
            <td>
              <input name="sex" type="radio" value="1"  <?php if($admin['sex']==1){?>  checked="checked" <?php }?>>男 &nbsp;
              <input name="sex" type="radio" value="2" <?php if($admin['sex']==2){?>  checked="checked" <?php }?>>女
            </td>
          </tr>
          <?php
          if($admin['tel']){
          	?>

          	   <tr>
            <td align="right">手机</td>
            <td> <?php echo $admin['tel'];?></td>
          </tr>

          	<?php
          }
          ?>

          <tr>
            <td align="right">邮箱</td>
            <td> <input name="email" type="text" size="40" maxlength="40" value="<?php echo $admin['email']?>" > </td>
          </tr>

          <tr>
              <td>

              </td>
            <td >
              <input class="button" type="submit" name="Submit" value="提 交"  onclick="return check_add();" >&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="hidden" value="关闭"  class="btn00" onclick="parent.layer.close(parent.layer.getFrameIndex(window.name));" />
            </td>
          </tr>
        </table>
      </form>
<script type="text/javascript">
var name=document.getElementById('name');
function check_name() {
		Sxmlhttprequest();


		xmlHttp.open('GET','check_admin.php?name='+name.value,true);
		xmlHttp.onreadystatechange=byphp;
		xmlHttp.send(null);
	}
function byphp(){

	if(xmlHttp.readyState==1){
		document.getElementById('name_msg').innerHTML="loading....";
	}
	if(xmlHttp.readyState==4){
	var msg=xmlHttp.responseText;

	if(msg.indexOf("1")>0)
	{document.getElementById('name_msg').innerHTML='<img src="../../style/images/error.jpg"><font color=red >会员已存在</font>';
	return false;
	}

		 else
			 document.getElementById('name_msg').innerHTML='<img src="../../style/images/right.jpg">';

	}
}

function   check_add(){

	var pwd=document.getElementById('pwd');
	var pwdcheck=document.getElementById('pwdcheck');
	<?php if($action=='add'){?>
	check_name();
	if(pwd.value==''){
		document.getElementById('pwd_msg').innerHTML='<img src="../../style/images/error.jpg">请输入密码';
		return false;
	}

		 else{
			 document.getElementById('pwd_msg').innerHTML='<img src="../../style/images/right.jpg">';
		 }
	<?php }?>
if(pwd.value.length>0){

if(pwd.value.length<8 ){
		document.getElementById('pwd_msg').innerHTML='<img src="../../style/images/error.jpg">密码长度至少为8位';
		return false;
	}

	if(checkpassword(pwd.value)!==true){
		document.getElementById('pwd_msg').innerHTML='<img src="../../style/images/error.jpg">'+checkpassword(pwd.value);
		return false;


	}



}

	if(pwd.value!=pwdcheck.value){
		document.getElementById('pwdcheck_msg').innerHTML='<img src="../../style/images/error.jpg">两次密码输入不一致';
		return false;
	}

		 else{
			 document.getElementById('pwdcheck_msg').innerHTML='<img src="../../style/images/right.jpg">';
		 }


}



 function checkpassword(v){
    var numasc = 0;
        var charasc = 0;
        var otherasc = 0;
        if(0==v.length){
            return "密码不能为空";
        }else if(v.length<8||v.length>12){
            return "密码至少8个字符,最多12个字符";
        }else{

                return true;

        }

        }
</script>




