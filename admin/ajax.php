<?php

require_once('../inc/common.php');

$arr=array();
$row= $db->exec("select count(*) as num from ".tname('chat')." where groupid='0' and userid>0 and touid='{$system['admin_id']}' and isread=0 ");
$arr['message']=$row['num'];

$row=$db->exec("select count(*) as num from ".tname('recharge')." where status<1");
$arr['recharge']=$row['num'];
$row=$db->exec("select count(*) as num from ".tname('plat')." where status='0'");
$arr['plat']=$row['num'];
$row=$db->exec("select count(*) as num from ".tname('user_report')." where status='0'");
$arr['report']=$row['num'];
echo json_encode($arr);
exit();

?>
