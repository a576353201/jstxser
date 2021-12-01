<?php
include_once '../inc/common.php';



if($_GET['type']=='send_sms'){
   if(strtoupper($_GET['code1'])==$_SESSION['code']){
	if($db->exec("select * from ".tname('admin')." where tel='{$_GET['mobile']}'")){

			$_SESSION['sms_code']=rand(10000, 999999);
		$_SESSION['sms_number']=$_GET['mobile'];
	    send_sms($_GET['mobile'], $_SESSION['sms_code'])	;

		echo 'ok';
	}
	else echo "该手机号尚未绑定管理员";
   }
  else{

  	echo '您输入的图形验证码不正确';
  }


	exit();
}




if($_GET['type']=='bind'){


   if(strtoupper($_GET['code1'])==$_SESSION['code']){



		if($db->exec("select * from ".tname('admin')." where tel='$_GET[name]' ")){
		echo '该手机号已经被绑定';//已经被注册
	}
	else{
		$_SESSION['sms_code']=rand(10000, 999999);
		$_SESSION['sms_number']=$_GET['name'];
	    send_sms($_GET['name'], $_SESSION['sms_code'])	;

	echo 'ok';
	}




		exit();
	}

else{

echo '您输入的图形验证码不正确';



}

exit();
}

?>
