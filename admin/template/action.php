<?php
include_once '../inc/common.php';
if($_GET['type']=='add' and $_POST){
	$dir="../../template/".$_POST['dir'];
	if(!is_dir($dir))
		mkdir($dir);
	
	$now=time();
	$db->query("insert into ".tname('template')."(`addtime`,`edittime`) values('$now','$now')");
	if($db->affected_rows()>0){
		$id=$db->insert_id();
		if (!$_POST['url']) $_POST['url']="http://".$id.".".$http_short_url;
		
		$db->update(tname('template'), $_POST, $id);
		if($_POST['default']=='1'){
			$db->query("update ".tname('template')." set `default`='0' where id!='$id'");
			
		}
		
		
		promptMessage('manage.php', '恭喜您添加成功');
		
		
	}
	
	
}

if($_GET['type']=='edit' and $_POST){
		$dir="../../template/".$_POST['dir'];
	if(!is_dir($dir)){
		
		promptMessage('manage.php', '对不起，您添加的模版目录不存在');
		
	}
	else{
	$_POST['edittime']=time();

		$id=$_POST['id'];
		$db->update(tname('template'), $_POST, $id);
if($_POST['default']=='1'){
			$db->query("update ".tname('template')." set `default`='0' where id!='$id'");
			
		}
		promptMessage('manage.php', '恭喜您编辑成功');
		
		
	
	}
	
}


	if($_GET['action']=='delete' and $_GET['id']){
		
	
			$db->query("delete from ".tname('template')." where id='$_GET[id]'");
							promptMessage($_SERVER['HTTP_REFERER'], '恭喜您，删除成功');
		
	}
	
		if($_GET['action']=='sort' and $_POST){
		foreach ($_POST['sortnum'] as $key=>$value) {
			$db->query("update ".tname('template')." set sortnum='$value' where id='$key'");
		}
		promptMessage('manage.php', '排序成功');
		
	}
	
	if($_GET['action']=='updateurl'){
   $all=$db->fetch_all("select * from ".tname('template')." where `status`='1'");
   $i=0;
		foreach ($all as $value) {
			$url='http://'.$value['id'].".".$http_short_url;
			$db->query("update ".tname('template')." set `url`='$url' where id='$value[id]'");
			if($db->affected_rows()>0) $i++;
		}
		
		promptMessage('manage.php', "恭喜您，成功更新".$i."个演示地址");
	}
	
?>