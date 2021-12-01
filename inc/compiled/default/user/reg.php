
<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>css/login.css" type="text/css" media="screen" />




<div class="login">

<div style="float:left;width:760px;">
<a href='<?php echo $system['login_imgurl']; ?>' target='_blank'>
<img src='<?php echo $HttpPath; ?><?php echo $system['login_img']; ?>' style='height:500px'>
</a>
</div>
    <!--内容-->
    <div class="loginText">
     <h2  style='margin-bottom:20px;'>账号注册<a href="login.php">已有账号，切换登录</a></h2>



               <form action="reg.php?act=sub" method="post" id="loginForm">


               <p>
                <input type="text" placeholder="请输入11位手机号" name="name" id='mobile'  value="" minlength="11" maxlength="11" autofocus="" required="" autocomplete="off" oninput='check_mobile1(this.value);'>

            </p>

               <p  >
	<input name="code1" id='code1' type="text" maxlength="4" placeholder="请输入左侧图片验证码"  oninput='check_code(this.value);' autofocus="" required="" autocomplete="off"style='float:left;width:220px;'  >

<img src='../inc/checkcode.inc.php' height='48px'  id='img_code'  onclick='change_code();'/>
<img src='../static/images/del.png'  id='code_tip' style='display: none;height:20px;float:right;vertical-align: middle;margin-top:10px; ' >
            </p>

                    <p>

               	<input name="code" id='code' type="text" maxlength="6" placeholder="请输入短信验证码"  autofocus="" required="" autocomplete="off">
						<input type="button" id='send_sms' class="sendSMS tel" onclick="sendsms();" disabled="" value='获取验证码' />

            </p>
                    <p><input type="text" placeholder="请输入密码" name="pwd" id='pwd' minlength="6" onfocus="this.type='password'" required="" autocomplete="off"></p>
      <p  style='margin-bottom:10px;height:40px;'>
注册类型：
      <select name='group' id='group'>
<option value=''>请选择</option>
      <?php if(is_array($user_group)){foreach($user_group AS $index=>$value) { ?>
<option value='<?php echo $index; ?>'  ><?php echo $value; ?></option>

<?php }}?>

      </select>

      </p>
                    <i class="error"></i>


                    <p class="loginClick"><input type="submit" class="submitBtn" value="立即注册" onclick='return click_sub();' ></p>

                     <div  style='padding-left:40px;margin-top:0px;margin-bottom:10px;font-size:12px;color:#ccc;'>
                   点击注册表示您已阅读并同意<a href='../news/news.php?id=36' target='_blank' style='color:#ccc;text-decoration:underline'>用户使用协议</a>

                    </div>


                </form>






    </div>



</div>









<div class="clear"></div>

<script language="javascript" type="text/javascript">

function change_code(){
document.getElementById('img_code').src='../inc/checkcode.inc.php?rand='+Math.random();

}


var xmlHttp;
function Sxmlhttprequest(){
	if(window.ActiveXObject){
		xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	else if(window.XMLHttpRequest){
		xmlHttp = new XMLHttpRequest();
	}

}
var countdown=60;

var code_ok=0;
	function check_code(value){

		if(value.length==4){
			Sxmlhttprequest();
	xmlHttp.open('GET','../ajax/check_code.php?code='+value,true);
	xmlHttp.onreadystatechange=function(){


		if(xmlHttp.readyState==4){
		var msg=xmlHttp.responseText;
	    if(msg.indexOf('ok')>-1){

			code_ok=1;
	    document.getElementById('code_tip').src="../static/images/ok.png";
	document.getElementById('code_tip').style.display='';
		 document.getElementById('send_sms').disabled=false;
	    }
	    else{

			code_ok=0;
	    document.getElementById('code_tip').src="../static/images/del.png";
document.getElementById('code_tip').style.display='';
 document.getElementById('send_sms').disabled=true;

	    }

		}


	};
	xmlHttp.send(null);


		}
		else{
		code_ok=0;
			$('#code_tip').hide();
		 document.getElementById('send_sms').disabled=true;
		}

	}
















function check_mobile1(value){



	 if((/^1[34578]\d{9}$/.test(value)))
{

		// document.getElementById('send_sms').disabled=false;
	      return  true;
	 }

	 else{

		 document.getElementById('send_sms').disabled=true;

	 }




}





function sendsms(){
	if(check_mobile()==false) return false;
if(document.getElementById('code1').value==''){
change_code();
	 window.wxc.xcConfirm('请输入图形验证码',window.wxc.xcConfirm.typeEnum.warning);
		     return false;

}

if(code_ok==0){
change_code();
	 window.wxc.xcConfirm('图形验证码不正确',window.wxc.xcConfirm.typeEnum.warning);
		     return false;

}



	document.getElementById('send_sms').value="发送中";
	Sxmlhttprequest();
	xmlHttp.open('GET','../ajax/check_reg.php?type=reg&action=send_sms&name='+document.getElementById('mobile').value+'&code1='+document.getElementById('code1').value,true);
	xmlHttp.onreadystatechange=function(){


		if(xmlHttp.readyState==1){
			document.getElementById('send_sms').value="发送中";
		}
		if(xmlHttp.readyState==4){
		var msg=xmlHttp.responseText;
	    if(msg.indexOf('ok')>-1){
	    	settime('send_sms');

	    }
	    else{
	    change_code();
document.getElementById('send_sms').value="获取验证码";
	    	 window.wxc.xcConfirm(msg,window.wxc.xcConfirm.typeEnum.warning);

		     return false;



	    }

		}


	};
	xmlHttp.send(null);

}



function check_mobile(){
	if(document.getElementById('mobile').value==''){


change_code();
		  window.wxc.xcConfirm('请输入手机号码！',window.wxc.xcConfirm.typeEnum.warning);
		return  false;

	}

	 if((/^1[34578]\d{9}$/.test(document.getElementById('mobile').value)))
	 {


	 	      return  true;
	 	 }

	 	 else{
change_code();

	 		  window.wxc.xcConfirm('手机号码格式不正确！',window.wxc.xcConfirm.typeEnum.warning);
	 		 return  false;
	 	 }



}


function click_sub(){

	if(check_mobile()==false) return false;

if(document.getElementById('code1').value==''){

change_code();
		window.wxc.xcConfirm('请输入验证码！',window.wxc.xcConfirm.typeEnum.warning);


		return  false;

	}

if(document.getElementById('pwd').value==''){

change_code();
	window.wxc.xcConfirm('请输入密码！',window.wxc.xcConfirm.typeEnum.warning);


	return  false;

}



if(document.getElementById('pwd').value.length<6){

change_code();
	window.wxc.xcConfirm('密码长度不能少于6位',window.wxc.xcConfirm.typeEnum.warning);


	return  false;

}
		if(document.getElementById('group').value==''){


	window.wxc.xcConfirm('请选择用户类型！',window.wxc.xcConfirm.typeEnum.warning);


	return  false;

}

}




function set_display(div){
	if(document.getElementById(div).style.display=='none'){


		document.getElementById(div).style.display='block';

	}
	else
		document.getElementById(div).style.display='none';

}



</script>

<?php include_once template("footer");?>