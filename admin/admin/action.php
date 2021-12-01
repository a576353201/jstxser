<?php
include_once '../../inc/common.php';
$action=trim($_GET['action']);

if($action=='add'){

   $db->query("insert into ".tname('admin')." (`addtime`) values ('$now')");
	if($db->affected_rows()>0){
		$id=$db->insert_id();
		$_POST['pwd']=md5($_POST['pwd']);
		$db->update(tname('admin'), $_POST, $id);
		add_adminlog("新增管理员：".$_POST['name']);

        ?>
        <script>


            parent.location.href=parent.location.href;


        </script>
        <?php

    }


}
if($action=='delete'){
	$user=get_table(tname('admin'), $_GET['id']);
	if(delete(tname('admin'), $_GET['id'])){
add_adminlog("删除管理员：".$user['name']);
		promptMessage('index.php', '恭喜您！管理员删除成功');
	}



}
if($action=='edit'){
	$id=$_GET['id'];
	$admin=get_table(tname('admin'), $id);
	if($_POST['pwd']){

		$_POST['pwd']=md5($_POST['pwd']);

	}
	else
	$_POST['pwd']=$admin['pwd'];
			$db->update(tname('admin'), $_POST, $id);
			add_adminlog("修改管理员：".$admin['name']);

    ?>
    <script>


        parent.location.href=parent.location.href;


    </script>
    <?php


}

if($action=='pwd'){

	$admin=get_table(tname('admin'), $_SESSION['adminid']);

	if(md5($_POST['pwd'])==$admin['pwd']){
		$array=array('pwd'=>md5($_POST['pwd1']));
	$db->update(tname('admin'), $array, $_SESSION['adminid']);


	echo "<script>alert('恭喜你密码修改成功');parent.window.location='../inc/login.inc.php?action=quit';</script>";
	//promptMessage('../inc/login.inc.php?action=quit', '恭喜您！密码修改成功');

	}
	else {

		promptMessage('pwd.php', '旧密码错误');

	}


}

?>