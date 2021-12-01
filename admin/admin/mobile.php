<?php
include_once '../inc/header.php';



$admin=get_admin_info($_SESSION['adminid']);

if($_GET['step']) $step=$_GET['step'];
else $step=1;
if(!$admin['tel']) $step=2;
else{

	  $mobile=substr($admin['tel'],0,3).'******'.substr($admin['tel'],strlen($admin['tel'])-3,3);
}

if($_GET['ref']) {
$ref=$_GET['ref'];

}


if($_POST){



	if($step==1){

		if($_POST['ref']){

			$url1="mobile.php?ref=".$_POST['ref'];

$url2=$_POST['ref'].'?sms_ok=1';
		}
		else{
					$url1="mobile.php";
					$url2="mobile.php?step=2";

		}

			if($_SESSION['sms_number']!=$admin['tel']){

		promptMessage($url1, '手机号码错误');

				exit();

	}
	if($_SESSION['sms_code']==$_POST['code']){
unset($_SESSION['sms_code']);
		echo "<script>window.location='{$url2}';</script>";
exit();
	}
	else{


promptMessage($url1, '短信验证码错误');


	}


	}



if($step==2){



	if($_SESSION['sms_number']!=$_POST['mobile']){

		promptMessage($_SERVER['HTTP_REFERER'], '手机号码错误');		exit();

	}
	if($_SESSION['sms_code']==$_POST['code']){
unset($_SESSION['sms_code']);

		$db->query("update ".tname('admin')." set tel='{$_POST['mobile']}'  where id='{$_SESSION['adminid']}'");


			promptMessage('../index.php', '修改成功');



	}
	else{


promptMessage($_SERVER['HTTP_REFERER'], '短信验证码错误');


	}

}
exit();

}

?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="titlebg">

      <tr>

        <td width="12" height="30"><img src="../style/images/content/tab_03.gif" width="12" height="30" /></td>

        <td>


         <div style='float:left' ><img src="../style/images/content/tb.gif" width="16" height="16" /></div>

         <div style='float:left'  class="STYLE1"><span class="STYLE3">当前位置:</span><?php if($ref) echo "短信验证";else {if($step==1) echo "修改手机号码";else  echo "绑定手机号码";} ?></div>


      <div style='float:right;padding-right:5px;'><a href='#' onclick="window.history.go(-1);">返回</a></div>
        </td>

        <td width="16"><img src="../style/images/content/tab_07.gif" width="16" height="30" /></td>

      </tr>

  </table>


  <?php
  if($step==1){



  ?>

  <div class='info' >

<form action="mobile.php?step=<?php echo $step; ?>"  method="post">

  <input type="hidden" name="ref" value="<?php echo $ref; ?>" />


<div class='line'>

<span class="title">当前手机号：</span><?php echo $mobile;?>

</div>
<div class='line'>
<span  class='title'><span class='must'>*</span>图片验证码：</span>
<input name="code1" id='code1' type="text" maxlength="4" placeholder="请输入验证码" style='width:150px;'  >

<img src='../../inc/checkcode.inc.php' height='35px'  id='img_code'  onclick='change_code();'  style='vertical-align:middle;'/>
</div>
<div class='line' >
     <span class="title"><span class='must'>*</span>短信验证码：</span>
      	   <input type="text" id='code' name='code' class='input' style='width:150px;' value=''>
      	   <input type="button" id='send_sms'  onclick="sendsms();"  value='获取验证码' class='btn00'/>

      	   </div>


<div class='info' >
<div class='line'>
<div style='padding-left:250px;'  id='sub_html'>
<input class='btn00' type='button' name='Submit' value='返回' onclick='window.history.go(-1); '>

<input class='btn01' type='Submit' name='Submit' value='下一步' onclick='order_sub(); '>
</div>
</form>
</div>




<script>

function change_code(){
document.getElementById('img_code').src='../../inc/checkcode.inc.php?rand='+Math.random();

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

    function sendsms(){

    if ( document.getElementById('code1').value=='') {
                 window.wxc.xcConfirm('图片验证码不能为空！',window.wxc.xcConfirm.typeEnum.warning);
                 document.getElementById('code1').focus();
                 return false;
             }

         	document.getElementById('send_sms').value="发送中";
         	Sxmlhttprequest();
         	xmlHttp.open('GET','../../ajax/admin.php?type=send_sms&mobile=<?php echo $admin['tel'];?>'+'&code1='+document.getElementById('code1').value,true);
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

         	    	 window.wxc.xcConfirm(msg,window.wxc.xcConfirm.typeEnum.warning);
         		     return false;



         	    }

         		}


         	};
         	xmlHttp.send(null);

         }

function settime(id) {
	var val=document.getElementById(id);



if (countdown == 0) {
val.removeAttribute("disabled");
val.value="获取验证码";
countdown=60;
return false;
} else {
val.setAttribute("disabled", true);
val.value="重新发送(" + countdown + ")";
countdown--;

}
var tt=setTimeout(function() {
settime(id) ;
},1000)
}

function order_sub(){

    if (document.getElementById('code1').value=='') {
                 window.wxc.xcConfirm('图片验证码不能为空！',window.wxc.xcConfirm.typeEnum.warning);
                 document.getElementById('code1').focus();
                 return false;
             }

             if (document.getElementById('code').value=='') {
                 window.wxc.xcConfirm('短信验证码不能为空！',window.wxc.xcConfirm.typeEnum.warning);
                 document.getElementById('code').focus();
                 return false;
             }

  return true;


}


</script>

  <?php } ?>




























  <?php
  if($step==2){



  ?>

  <div class='info' >

<form action="mobile.php?step=<?php echo $step; ?>"  method="post">

<div class='line'>

<span class="title"><span class='must'>*</span>新手机号码:</span><input name="mobile" type="text" class="input" id="mobile" value=""   style='width:160px;'/>

</div>
<div class='line'>
<span  class='title'><span class='must'>*</span>图片验证码：</span>
<input name="code1" id='code1' type="text" maxlength="4" placeholder="请输入验证码" style='width:150px;'  >

<img src='../../inc/checkcode.inc.php' height='35px'  id='img_code'  onclick='change_code();'  style='vertical-align:middle;'/>
</div>
<div class='line' >
     <span class="title"><span class='must'>*</span>短信验证码：</span>
      	   <input type="text" id='code' name='code' class='input' style='width:150px;' value=''>
      	   <input type="button" id='send_sms'  onclick="sendsms();"  value='获取验证码' class='btn00'/>

      	   </div>





<div class='line'>

<div style='padding-left:253px;'>
<input type="submit" class='btn01' value='下一步' onClick="return order_sub();">
</div></div>
</form>
</div>




<script>

function change_code(){
document.getElementById('img_code').src='../../inc/checkcode.inc.php?rand='+Math.random();

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

    function sendsms(){

    if ( document.getElementById('code1').value=='') {
                 window.wxc.xcConfirm('图片验证码不能为空！',window.wxc.xcConfirm.typeEnum.warning);
                 document.getElementById('code1').focus();
                 return false;
             }

         	document.getElementById('send_sms').value="发送中";
         	Sxmlhttprequest();
         	xmlHttp.open('GET','../../ajax/admin.php?type=bind&name='+document.getElementById('mobile').value+'&code1='+document.getElementById('code1').value,true);
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

         	    	 window.wxc.xcConfirm(msg,window.wxc.xcConfirm.typeEnum.warning);
         		     return false;



         	    }

         		}


         	};
         	xmlHttp.send(null);

         }

         function settime(id) {
         	var val=document.getElementById(id);



         if (countdown == 0) {
         val.removeAttribute("disabled");
         val.value="免费获取验证码";
         countdown = 60;
         } else {
         val.setAttribute("disabled", true);
         val.value="重新发送(" + countdown + ")";
         countdown--;
         }
         setTimeout(function() {
         settime(id) ;
         },1000)
         }
function order_sub(){

    if (document.getElementById('code1').value=='') {
                 window.wxc.xcConfirm('图片验证码不能为空！',window.wxc.xcConfirm.typeEnum.warning);
                 document.getElementById('code1').focus();
                 return false;
             }

             if (document.getElementById('code').value=='') {
                 window.wxc.xcConfirm('短信验证码不能为空！',window.wxc.xcConfirm.typeEnum.warning);
                 document.getElementById('code').focus();
                 return false;
             }

  return true;


}


</script>

  <?php } ?>