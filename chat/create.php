<?php
include_once '../inc/common.php';
checkstatus();

$system=get_system();
$tags=explode('|',$system['tags']);


include_once template('chat/create');
?>