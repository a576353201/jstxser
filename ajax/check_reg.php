<?php
include_once '../inc/common.php';

if($_GET['type']=='reg'){


   if(strtoupper($_GET['code1'])==$_SESSION['code']){

   		if($_GET['action']=='send_sms'){
		if($db->exec("select * from ".tname('user')." where name='$_GET[name]'")){
		echo '该手机号已经被注册';//已经被注册
	}
	else{
		$_SESSION['sms_code']=rand(10000, 999999);
		$_SESSION['sms_number']=$_GET['name'];
	  echo   send_sms($_GET['name'], $_SESSION['sms_code'])	;

	echo 'ok';
	}






   }






		exit();
	}

else{

echo '您输入的图形验证码不正确';



}

exit();
}


if($_GET['type']=='bind'){


   if(strtoupper($_GET['code1'])==$_SESSION['code']){

   		if($_GET['action']=='send_sms'){
   			$act=$_GET['act'];

		if($db->exec("select * from ".tname('user')." where name='$_GET[name]' and `{$act}`!='' and  `{$act}` is not null ")){
		echo '该手机号已经被绑定';//已经被注册
	}
	else{
		$_SESSION['sms_code']=rand(10000, 999999);
		$_SESSION['sms_number']=$_GET['name'];
	    send_sms($_GET['name'], $_SESSION['sms_code'])	;

	echo 'ok';
	}






   }






		exit();
	}

else{

echo '您输入的图形验证码不正确';



}

exit();
}

if($_GET['type']=='pwd'){


   if(strtoupper($_GET['code1'])==$_SESSION['code']){

   		if($_GET['action']=='send_sms'){
   			$row=$db->exec("select * from ".tname('user')." where name='$_GET[name]'");
		if(!$row){
		echo '该手机号还没有注册';
	}
	else{

		if($row['status']==1){
$_SESSION['sms_code']=rand(10000, 999999);
		$_SESSION['sms_number']=$_GET['name'];
	    send_sms($_GET['name'], $_SESSION['sms_code'])	;

	echo 'ok';


		}
		else{


	echo '该账户已经被锁定';

		}


	}






   }


		exit();
	}

else{

echo '您输入的图形验证码不正确';



}

exit();
}




if($_GET['type']=='send_sms'){
   if(strtoupper($_GET['code1'])==$_SESSION['code']){
	if($db->exec("select * from ".tname('user')." where name='{$_GET['mobile']}'")){

			$_SESSION['sms_code']=rand(10000, 999999);
		$_SESSION['sms_number']=$_GET['mobile'];
	    send_sms($_GET['mobile'], $_SESSION['sms_code'])	;

		echo 'ok';
	}
	else echo "该手机号尚未注册";
   }
  else{

  	echo '您输入的图形验证码不正确';
  }


	exit();
}


if($_GET['type']=='check_realname'){

	if($db->exec("select * from ".tname('user')." where realname='{$_GET['realname']}' and id!='{$_SESSION['userid']}'")){
echo "用户名已经被其他人使用";

	}
	else 	echo 'ok';

	exit();
}



$cmd=$_GET['cmd'];
if($cmd=='checkname'){

	if($db->exec("select * from ".tname('user')." where name='$_POST[name]'")){
		echo '1';
	}
else {

	echo "0";
}

}





if($cmd=='reg'){


	if($_SESSION['code']==$_POST['validateCode'] and $_POST['name']){
	$now=time();
	$_POST['regip']=$_SERVER['REMOTE_ADDR'];
	$db->query("insert into ".tname('user')." (`regtime`,`edittime`) values ('$now','$now')");
	if($db->affected_rows()>0){

		$id=$db->insert_id();

	$template=$db->exec("select * from ".tname('template')." where `default`=1");
		$_POST['template']=$template['dir'];
		$url="http://".$_POST['name'].".".$http_short_url;
		$db->query("insert into ".tname('url')."(`uid`,`url`) values('$id','$url')");
   $_POST['endtime']=time()+7*24*3600;

		$db->update(tname('user'), $_POST, $id);
		$db->query("insert into ".tname('system')." (`key`,`value`,`uid`) values('web_title','$_POST[cname]','$id')");

		 $subject="【$system[web_title]】注册激活邮件";
            $hash=md5($_POST['name'].$_POST['pwd']);
            $url=$HttpPath."user/emailcheck.php?id=$id&hash={$hash}";
            $now=date("Y-m-d H:i:s");
			$message="<table cellspacing='0' cellpadding='20'>
<tr><td>
<table width='500' cellspacing='0' cellpadding='1'>
<tr><td bgcolor='#FF8E00' align='left' style=\"font-family:'lucida grande',tahoma,'bitstream vera sans',helvetica,sans-serif;line-height:150%;color:#FFF;font-size:24px;font-weight:bold;padding:4px\">
&nbsp;{$system[web_title]}</td></tr>
<tr><td bgcolor=\"#FF8E00\">
<table width='100%' cellspacing=\"0\" bgcolor=\"#FFFFFF\" cellpadding=\"20\">
<tr><td style=\"font-family:'lucida grande',tahoma,'bitstream vera sans',helvetica,sans-serif;line-height:150%;color:#000;font-size:14px;\">
亲爱的朋友：
<blockquote><br><strong>您的邮箱激活邮件</strong><br>请复制下面的激活链接到浏览器进行访问，以便激活你的邮箱。<br>邮箱激活链接:<br>
<a href=\"{$url}\" target=\"_blank\">{$url}</a><br><br></blockquote>
<br>
<br>{$system[web_title]}<br><a href=\"{$HttpPath}\" target=\"_blank\">{$HttpPath}/</a>
<br>{$now}<br>
<br>此邮件为系统自动发出的邮件，请勿直接回复。
</td></tr></table>
</td></tr></table>
</td></tr>
</table> ";
		sendmail($_POST['email'], $subject, $message);
		copy_all($id);
		echo '1';
	}

	}
	else{


		echo '-401';
	}

}



?>