<?php
include_once '../../inc/common.php';
if($_GET['action']=='login'){
$name=$_POST['username'];
$pwd=$_POST['password'];
if($_POST['code']){
	if(strtoupper($_POST['code'])!=strtoupper($_SESSION['code'])){

			promptMessage('../login.php', '验证码错误');
	}
	else{
if($name and $pwd){
	$pwd=md5($pwd);
	$sql="select * from ".tname('admin')." where `name`='$name' and `pwd`='$pwd' ";


if($row=$db->exec($sql)){
	$_SESSION['adminid']=$row['id'];
	$_SESSION['adminname']=$row['name'];
	$_SESSION['admingroup']=$row['group'];

$db->exec("update ".tname('admin')." set logintime='".time()."' where id='{$row['id']}'");
add_adminlog("登录后台");
	promptMessage('../index.php', "恭喜您！登录成功");


}else{

	promptMessage('../login.php', '用户名或密码错误');

}

}
}
}
}

if($_GET['action']=='quit'){

session_destroy();

		promptMessage('../login.php', '退出成功');

}

?>