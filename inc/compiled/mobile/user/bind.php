<?php include_once template("header");?>






 <div class="user_center">




<div class="info">


<form action="bind.php?type=<?php echo $_GET['type']; ?>"  method="post">



<div class='line'>

<span class="title"><span class='must'>*</span>手机号码:</span><input name="mobile" type="text" class="input" id="mobile" value=""   style='width:160px;'/>

</div>
<div class='line'>
<span  class='title'><span class='must'>*</span>图片验证码：</span>
<input name="code1" id='code1' type="text" maxlength="4" placeholder="请输入验证码" style='width:80px;'  >

<img src='../inc/checkcode.inc.php' height='35px'  id='img_code'  onclick='change_code();'  style='vertical-align:middle;'/>
</div>
<div class='line' >
     <span class="title"><span class='must'>*</span>短信验证码：</span>
      	   <input type="text" id='code' name='code' class='input' style='width:80px;' value=''>
      	   <input type="button" id='send_sms'  onclick="sendsms();"  value='获取验证码' class='btn00'/>

      	   </div>





<div class='line'>

<div style='padding-left:123px;'>
<input type="submit" class='btn01' value='下一步' onClick="return order_sub();">
</div></div>
</form>
</div>



<script>

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
function check_mobile(){
	if(document.getElementById('mobile').value==''){



		  window.wxc.xcConfirm('请输入手机号码！',window.wxc.xcConfirm.typeEnum.warning);
		return  false;

	}

	 if((/^1[34578]\d{9}$/.test(document.getElementById('mobile').value)))
	 {

	 		 document.getElementById('send_sms').className='btn00';
	 	      return  true;
	 	 }

	 	 else{

	 		 document.getElementById('send_sms').className='btn01';
	 		  window.wxc.xcConfirm('手机号码格式不正确！',window.wxc.xcConfirm.typeEnum.warning);
	 		 return  false;
	 	 }



}

    function sendsms(){
	if(check_mobile()==false) return false;

	document.getElementById('send_sms').value="发送中";
	Sxmlhttprequest();
	xmlHttp.open('GET','../ajax/check_reg.php?type=bind&act=<?php echo $_GET['type']; ?>&action=send_sms&name='+document.getElementById('mobile').value+'&code1='+document.getElementById('code1').value,true);
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

if(check_mobile()==false) return false;

             if ( document.getElementById('code').value=='') {
                 window.wxc.xcConfirm('短信验证码不能为空！',window.wxc.xcConfirm.typeEnum.warning);
                 document.getElementById('code').focus();
                 return false;
             }

  return true;


}


</script>

</div>
</div>




















<?php include_once template("footer");?>