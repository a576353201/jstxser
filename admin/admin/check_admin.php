<?php
include_once '../../inc/common.php';

if($_GET['name']){

if($db->exec("select * from ".tname('admin')." where name='$_GET[name]'")){
	
	echo '1';
	
}
	
}
?>