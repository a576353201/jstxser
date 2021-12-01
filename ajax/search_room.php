<?php
include_once '../inc/common.php';
$begintime=strtotime($_GET['begintime']);
$endtime=strtotime($_GET['endtime']);

$room_list=$db->fetch_all("select * from ".tname('room')." where hid='{$_GET['room_id']}' and begintime<='{$endtime}' and endtime>='{$begintime}'");

if(count($room_list)>0){

	foreach($room_list as $key=>$value){
     $r=unserialize($value['room']);

      if(count($r)>0){

      	foreach($r as $key1=>$value1){
      	if($room_arr[$value1['name']]){

      		$room_arr[$value1['name']]+=$value1['num'];
      	}
      	else
      	$room_arr[$value1['name']]=$value1['num'];

      	}


      }



	}



}


$html='';

$hotal=$db->exec("select * from ".tname('hotal')." where id='{$_GET['room_id']}'");
$room=unserialize($hotal['room']);
if(count($room)>0){




	foreach($room as $key=>$value){

		$value['num']=$value['num']-$room_arr[$value['name']];

	if($value['num']>0){

    $html.=$value['name'].":";

    $html.="<select class='room' name='room[{$_GET['num']}][room][{$value['name']}]'><option value=''>--</option>";
    for($i=1;$i<=$value['num'];$i++){
    	$html.="<option value='{$i}'>{$i}</option>";

    }

    $html.="</select>间  &nbsp; &nbsp; ";

	}

	}




}
if (!isMobile()){

	?>

		<span class='title' style='float:left;'>户型：</span><span style='float:left;' >
	<?php
}
	?>


	<?php
	if($html) echo $html;else echo "没有可以预定的房间";
	?>

<?php
if (!isMobile()){

	?>

</span>
<?php
}
?>

