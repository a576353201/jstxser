<?php
include_once '../inc/common.php';

needlogin();

if($_GET['type']) $type=$_GET['type'];else $type='0';


include_once template('chat/mygroup');
?>