<?php
include_once '../../inc/common.php';
if($_GET['title']){
if($db->exec("select * from ".tname('client')." where title='$_GET[title]'")){
	echo '1';
	
}
	else echo "0";
}
?>