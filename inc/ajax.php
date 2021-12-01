<?php
include_once 'common.php';
$type=trim($_GET['type']);
if($type=='getmenu'){
	echo "<select name='type2'> <option value='0'>二级栏目</option>";

	echo get_secondmenu($_GET[id],$_GET['type3']);

	echo "</select>";

}



?>