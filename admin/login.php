<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台登陆</title>
<style type="text/css">
<!--
*{overflow:hidden; font-size:9pt;}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-image: url(style/images/bg.gif);
	background-repeat: repeat-x;
}
-->
</style></head>

<body>
<table width="100%"  height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="561" style="background:url(style/images/lbg.gif)">
        <table width="940" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td height="238" style="background:url(style/images/login01.jpg)">&nbsp;</td>
          </tr>
          <tr>
            <td height="190">
            <form action="inc/login.inc.php?action=login" method="post">

            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="208" height="190" style="background:url(style/images/login02.jpg)">&nbsp;</td>
                <td width="518" style="background:url(style/images/login03.jpg)">
                <table width="320" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="40" height="40"><img src="style/images/user.gif" width="30" height="30"></td>
                    <td width="38" height="40">用户</td>
                    <td width="242" height="40">
                    <input type="text" name="username" id="username" autocomplete="off"  style="width:164px; height:32px; line-height:34px;  border:solid 1px #d1d1d1; font-size:9pt; font-family:Verdana, Geneva, sans-serif;"></td>
                  </tr>
                  <tr>
                    <td height="40"><img src="style/images/password.gif" width="28" height="32"></td>
                    <td height="40">密码</td>
                    <td height="40"><input type="password" name="password" id="password" autocomplete="off"  style="width:164px; height:32px; line-height:34pxborder:solid 1px #d1d1d1; font-size:9pt; "></td>
                  </tr>
                         <tr>
                    <td height="40"></td>
                    <td height="40">验证码</td>
                    <td height="40">
                    		<input type="text" autocomplete="off"  style="width:74px; height:32px; line-height:34px;  border:solid 1px #d1d1d1; font-size:9pt; font-family:Verdana, Geneva, sans-serif;"id="code" name='code' maxlength="4" size="10">
                    		<img id="validateCodeImg" onClick="changeValidateImg()" title="看不清？换一张" src="../inc/checkcode.inc.php" style="cursor:pointer; height:24px; margin-top:8px;" alt="免费网站注册"/>
		<a onClick="changeValidateImg()" style="margin-left:5px;text-decoration:underline;color:gray;" href="javascript:;">看不清</a>
                    </td>
                  </tr>
                  <tr>
                    <td height="40">&nbsp;</td>
                    <td height="40">&nbsp;</td>
                    <td height="60"><input type="image" src="style/images/login.gif" width="95" onclick="return check_login();" height="34"></td>
                  </tr>
                </table></td>
                <td width="214" style="background:url(style/images/login04.jpg)" >&nbsp; </td>
              </tr>
            </table>
            </form>

            </td>
          </tr>
          <tr>
            <td height="133" style="background:url(style/images/login05.jpg)">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<script type="text/javascript">
function changeToCapital(obj)//字母变大写
{
  obj.value = obj.value.toUpperCase();
}
function changeValidateImg(){
	document.getElementById("validateCodeImg").src="../inc/checkcode.inc.php?rand" + parseInt(Math.random() * 1000);
}
function check_login(){
if(document.getElementById('username').value==''){

alert('请输入手机号');
return false;

}

if(document.getElementById('password').value==''){

	alert('请输入密码');
	return false;

	}

if(document.getElementById('code').value==''){

	alert('请输入验证码');
	return false;

	}

}

</script>

</body>
</html>
