<?php
include_once '../inc/header.php';

if($_GET['action']=='delete'){

	$db->query("delete from ".tname('hotal')." where id='{$_GET['id']}'");

	add_adminlog('删除酒店数据');

	exit();
}

$tid=$_GET['tid'];

$task=get_table(tname('task'),$tid);

if(!$_GET['type']) include_once 'hotal_index.php';

else include_once "hotal_{$_GET['type']}.php";





?>


<?php include_once '../inc/footer.php';?>

