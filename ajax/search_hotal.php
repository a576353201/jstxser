<?php
include_once '../inc/common.php';
$begintime=strtotime($_GET['begintime'].' 00:00:00');
$tid=$_GET['tid'];
$sql="select * from ".tname('room')." where hid='{$_GET['room_id']}' ";

$room_list=$db->fetch_all($sql);

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

$sql="select * from ".tname('hotal')." where tid='{$tid}' and begintime>='{$begintime}'";
if($_GET['hotal_name']) $sql.=" and name like '%{$_GET['hotal_name']}%'";
$list=$db->fetch_all($sql);
if(count($list)>0){

	foreach($list as $key1=>$value1){
?>
<div  style='text-align:left;border-bottom:1px dashed #ccc;padding:7px 0px;'>
<div >
<input type='checkbox' name='hotal[]'  value="<?php echo $value1['id']?>"    onclick="show_room(this,<?php echo $value1['id']?>);">

<?php  echo $value1['name']; ?>
</div>
<div  id='roomhtml_<?php echo $value1['id']?>'  style='display:none;'>
<?php
$room=unserialize($value1['room']);

if(count($room)>0){

$html='';


	foreach($room as $key=>$value){



		$value['num']=$value['num']-get_room_num1($value1['id'],$value['name']);

	if($value['num']>0){

    $html.=$value['name'].":";

    $html.="<select class='room_{$value1['id']}' name='{$value['name']}'  onchange='room_num11();'  ><option value=''>--</option>";
    for($i=1;$i<=$value['num'];$i++){
    	$html.="<option value='{$i}'>{$i}</option>";

    }

    $html.="</select>间  &nbsp; &nbsp; ";

	}

	}


echo $html;

}
else {

	echo "没有可预订的房间";

}

echo "<br><div style='padding-top:5px;'><input type='text'  id='mark_{$value1['id']}' value='' placeholder='请输入其他要求' ></div>";

 ?>


</div>

</div>
<?php

	}

}
else{
	?>

	<div style='text-align:center;'>
	没发现相关的酒店

	</div>


	<?php
}


?>
