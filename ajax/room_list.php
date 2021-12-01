<?php
include_once '../inc/common.php';




if($_GET['type']=='delete'){

	$db->query("delete from ".tname('room')." where id='{$_GET['id']}'");
	exit();

}







$tid=$_GET['tid'];

$list=$db->fetch_all("select * from ".tname('room')." where tid='{$tid}'");

if(count($list)>0){


	foreach($list as $key=>$value){

		$hotal=get_table(tname('hotal'),$value['hid']);
		?>
	<div style='border:1px dashed #ccc;line-height:30px;margin:10px 0px;padding:0 10px;max-width:640px;width:94%;'>
		<?php echo date('Y-m-d',$value['begintime'])?>
		<img src="<?php echo $HttpPath?>static/images/del.png"  onclick="delete_hotal11(<?php echo $value['id'];?>);"
		style='float:right;width:16px;vertical-align:middle;margin-top:5px;' title='删除'/>
	<br>
	<?php echo $hotal['name']?>
<?php
	$html='';
	$room=unserialize($value['room']);


	if(count($room)>0){
$html.="<br>户型：";
		foreach($room as $key2=>$value2){

		$html.=$value2['name'].":".$value2['num'].'间&nbsp;&nbsp;';


		}


	}

	if($value['mark'])  $html.="<br> 备注：".$value['mark'];

echo $html;
	?>


	</div>
		<?php
	}
	?>


<?php
}else{

	echo "暂时没有预订房间";

}

?>
