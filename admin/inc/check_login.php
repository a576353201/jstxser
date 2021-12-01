<?php
include_once 'common.php';

if(!$_SESSION['adminid']){

	echo "<script>parent.window.location='".$AdminHttpPath."login.php';</script>";
exit();
		//promptMessage($AdminHttpPath.'login.php', '您还没有登录，请先登录');
}
else{

	if(strpos($_SERVER['PHP_SELF'],'mobile.php')===false){
		$admin=get_admin_info($_SESSION['adminid']);
		if($admin['id']!=$_SESSION['adminid']){

            echo "<script>parent.window.location='".$AdminHttpPath."login.php';</script>";
            exit();
        }
//		if(!$admin['tel'])
//promptMessage($AdminHttpPath.'admin/mobile.php?step=1', '请先绑定手机号码');
	}


}


?>