<?php
include_once '../inc/common.php';
$type=trim($_GET['type']);
if($type=='getmenu'){
	echo "<select name='type3'> <option value='0'>三级栏目</option>";
	
	echo get_secondmenu($_GET[id],$_GET['type3']);
	
	echo "</select>";
	
}



?>