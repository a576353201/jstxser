<?php include_once template("header");?>
<style>

.wap_list{border:0px;}
.wap_list  .line{width:100%;display:block;clear:both;height:50px;line-height:50px;}
.wap_list  .line ul {padding-top:0px;}
.wap_list  .line  li{float:left;width:100px;}
.wap_list textarea{width:96%;height:100px;margin:0 auto;padding:5px 2%;font-size:16px;border:1px solid #ccc;}
.wap_list  input[type='text']{width:120px;height:35px;line-height:25px;padding:0px 2%;margin:0 auto;font-size:16px;border:1px solid #ccc;}

</style>

<div class="wap_list">
<form action="pay.php?step=sub&id=<?php echo $task['id']; ?>"  method="post">
<input type="hidden" name='id'   value='<?php echo $_GET['id']; ?>'>


<div class='line'>

需求金额：<?php echo $task['money']; ?>元

</div>

<div class='line' >
     短信验证码：
      	   <input type="text" id='code' name='code' class='input' style='width:80px;' value=''>
      	   <input type="button" id='send_sms'  onclick="sendsms();"  value='获取验证码' /></div>



<div>
<input type="submit" class='btn100' value='确认付款' onClick="return order_sub();">
</div>
</form>
</div>



<script>
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


         	document.getElementById('send_sms').value="发送中";
         	Sxmlhttprequest();
         	xmlHttp.open('GET','../ajax/check_reg.php?type=send_sms&mobile=<?php echo $user['name']; ?>',true);
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



             if ( document.getElementById('code').value=='') {
                 window.wxc.xcConfirm('短信验证码不能为空！',window.wxc.xcConfirm.typeEnum.warning);
                 document.getElementById('code').focus();
                 return false;
             }

  return true;


}





</script>



<?php include_once template("footer");?>