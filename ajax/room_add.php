<?php
include_once '../inc/common.php';

if($_GET['hid'] and $_GET['tid']){
	$hid=$_GET['hid'];
	$tid=$_GET['tid'];
	$begintime=strtotime($_GET['begintime'].' 00:00:00');
	$temp=explode('|',$_GET['room']);
	$room=array();
	foreach($temp as $key=>$value){

		$tt=explode('^',$value);

		$room[]=array('name'=>$tt[0],'num'=>$tt[1]);


	}
	$room=serialize($room);


	$row=$db->exec("select * from ".tname('room')." where hid='{$hid}' and tid='{$tid}'");

	if($row['id']>0){
$db->query("update ".tname('room')." set room='{$room}',mark='{$_GET['mark']}',begintime='{$begintime}' where id='{$row['id']}'");

	}
	else{
     $db->query("insert into ".tname('room')."(hid,tid,room,mark,begintime) values('{$hid}','{$tid}','{$room}','{$_GET['mark']}','{$begintime}')");

	}

}


?>
