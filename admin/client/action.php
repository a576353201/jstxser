<?php
include_once '../../inc/common.php';

$action=trim($_GET['action']);
$now=time();
if($action=='add'){

   $db->query("insert into ".tname('client')." (`addtime`) values ('$now')");
	if($db->affected_rows()>0){
		$id=$db->insert_id();
		$_POST['adminid']=$_SESSION['adminid'];
		$db->update(tname('client'), $_POST, $id);
		promptMessage('index.php', '恭喜您！客户信息添加成功');
	}
	

}
if($action=='delete'){
	
	if(delete(tname('client'), $_GET['id']))
		promptMessage('index.php', '恭喜您！客户信息删除成功');
	
	
}
if($action=='edit'){
	$id=$_GET['id'];

			$db->update(tname('client'), $_POST, $id);
		promptMessage('index.php', '恭喜您！客户信息编辑成功');
	
}	


?>