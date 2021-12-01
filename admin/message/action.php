<?php
include_once '../inc/common.php';
if($_GET['type']=='add' and $_POST){
	$now=time();
	$db->query("insert into ".tname('message')."(`addtime`) values('$now')");
	if($db->affected_rows()>0){
		$id=$db->insert_id();
		$db->update(tname('message'), $_POST, $id);
		promptMessage('manage.php?menuid='.$_POST['type1'], '恭喜您添加成功');
		
		
	}
	
	
}

if($_GET['type']=='edit' and $_POST){

if($_POST['replaycontent']){
	$_POST['replay']=1;
	$_POST['replaytime']=time();
	
}
		$id=$_POST['id'];
		$db->update(tname('message'), $_POST, $id);
		promptMessage('manage.php?menuid='.$_POST['type1'], '恭喜您编辑成功');
		
		
	
	
	
}


	if($_GET['action']=='delete' and $_GET['id']){
		
	
			$db->query("delete from ".tname('message')." where id='$_GET[id]'");
							promptMessage($_SERVER['HTTP_REFERER'],'恭喜您，删除成功');
		
	}
?>