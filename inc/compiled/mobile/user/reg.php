<?php include_once template("header");?>
<link rel="stylesheet" href="<?php echo $HttpTemplatePath; ?>css/login.css" type="text/css" media="screen" />



<div class="login-register has-topbar">

				<form class="clearfix" action='reg.php?act=sub' method="post">
										<input type="hidden" name="puserid" value="">

					<div class="input-item must tel">
						<input name="name" id='mobile' type="text" maxlength="11" placeholder="请输入手机号"    oninput='check_mobile1(this.value);'>
					</div>
<div class="input-item must code">
						<input name="code1" id='code1' type="text" maxlength="4"  oninput='check_code(this.value);' placeholder="请输入验证码" style='float:left;width:100px;'  >

<img src='../inc/checkcode.inc.php' height='30px'  id='img_code'  onclick='change_code();'/>
<img src='../static/images/del.png'  id='code_tip' style='display: none;height:20px;' >
					</div>
					<div class="input-item must code">
						<input name="code" id='code1' type="text" maxlength="6" placeholder="请输入短信验证码" autocomplete="off" >
						<input type="button" id='send_sms' class="get-code disabled" onclick="sendsms();"  value='获取验证码' />
					</div>

					<div class="input-item must password1">
						<input name="pwd" id='pwd' type="password" placeholder="请设置密码" autocomplete="off" >
					</div>


					<div class="input-item must tel">
					注册类型：
       <select name='group' id='group'>
<option value=''>请选择</option>

      <?php if(is_array($user_group)){foreach($user_group AS $index=>$value) { ?>
<option value='<?php echo $index; ?>'  ><?php echo $value; ?></option>

<?php }}?>

      </select>
					</div>
   <div  style='padding-left:5px;margin-top:5px;margin-bottom:5px;font-size:14px;color:#ccc;'>
                   点击注册表示您已阅读并同意<a href='../news/news.php?id=36' target='_blank' style='color:#ccc;text-decoration:underline；'>用户使用协议</a>

                    </div>


					<button class="login-page-btn disabled" type="submit" id="register-btn"   onclick='return click_sub();'>注册</button>
					<div class="to-login" style='margin-top:10px;'>已有账号？<a href="login.php">直接登录</a></div>
				</form>
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

		 document.getElementById('send_sms').className='get-code';
	      return  true;
	 }

	 else{

		 document.getElementById('send_sms').className='get-code disabled';

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

	 		 document.getElementById('send_sms').className='get-code';
	 	      return  true;
	 	 }

	 	 else{
change_code();
	 		 document.getElementById('send_sms').className='get-code disabled';
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