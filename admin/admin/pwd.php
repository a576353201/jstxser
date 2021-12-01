<?php
include_once '../inc/header.php';

?>




  <form name='myform' enctype="multipart/form-data" action="action.php?action=pwd" method="post">
         <table width="100%"  class="table_add" cellpadding="1" cellspacing="1">

          <tr>
            <td align="right">旧密码</td>
            <td> <input name="pwd" id='pwd' type="password" size="40" maxlength="40" autocomplete="off" value=''>
     </td>
          </tr>

          <tr>
            <td align="right">新密码</td>
            <td> <input name="pwd1" id='pwd1' type="password" size="40" maxlength="40" autocomplete="off" value=''>
       </td>
          </tr>
          <tr>
            <td align="right">密码确认</td>
            <td> <input name="pwd2" id='pwd2' type="password" size="40" maxlength="40" autocomplete="off" value='' >
     </td>
          </tr>

          <tr>
          <td></td>
            <td height="30" align="left" colspan="1">
              <input class="button" type="submit" name="Submit" value="提 交" onclick="return check_pwd11();" >&nbsp;&nbsp;&nbsp;&nbsp;
              <input class="button" type="reset" name="Submit" value="重 置" >
            </td>
          </tr>
        </table>
      </form>
<script type="text/javascript">

function   check_pwd11(){




	var pwd=document.getElementById('pwd');
	var pwd1=document.getElementById('pwd1');
	var pwd2=document.getElementById('pwd2');

	if(pwd.value==''){
		alert('请输入旧密码');
		return false;
	}



	if(pwd1.value==''){
		alert('请输入新密码');
		return false;
	}

		if(checkpassword(pwd1.value)!==true){
  alert(checkpassword(pwd1.value));
		return false;


	}
	if(pwd1.value!=pwd2.value){
	alert('两次密码输入不一致');
		return false;
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





<?php include_once '../inc/footer.php';?>

