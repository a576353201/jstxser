<?php
include_once '../inc/common.php';
$id=$_REQUEST['id'];
$isgroup=$_REQUEST['isgroup'];
if($isgroup>0){
    $group=GroupInfo($id,$_SESSION['userid']);
}
include_once template('chat/redpacket_send');



?>