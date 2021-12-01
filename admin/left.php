

	<style>

	.msg_num{display:none;background-color:#ff0000;color:#fff;font-size:12px;font-weight:600;display:none;margin-left:3px;width:18px;height:18px;line-height:18px;text-align:center;border-radius:50%;}

	li{cursor: pointer;}
	</style>



<?php
$row=$db->exec("select * from ".tname('role')." where id='{$_SESSION['admingroup']}'");

$role='|'.$row['content'].'|';

foreach($admin_menu1  as $key=>$value){

foreach($admin_menu2[$key] as $key2=>$value2){

if(strpos($role,$value2['url'])!==false  and $value2['nav']==1){



}
else{
	unset($admin_menu2[$key][$key2]);

}


}

}

?>







	<div class="left">
		<ul class="bigbtu">
			<li id="now02"><a href="index.php" title="网站后台" target="_self">网站后台</a></li>
			<li id="now01"><a href="../"  target="_blank" title="网站前台">网站前台</a></li>

		</ul>
		<div class="menu_top"></div>
		<div class="menu" id="TabPage3">
			<ul id="TabPage2">


		<?php
		$num=0;
		foreach($admin_menu1 as $key=>$value){

			if(count($admin_menu2[$key])>0){

$num++;
			?>

	<li id="left_tab<?php echo $num;?>" <?php if($num==1) echo 'class="Selected"';?> onClick="javascript:border_left('TabPage2','left_tab<?php echo $num;?>');" ><?php echo $value;?></li>


			<?php
			}
		}?>



			</ul>
			<div id="left_menu_cnt">


					<?php
		$num=0;
		foreach($admin_menu1 as $key=>$value){

			if(count($admin_menu2[$key])>0  ){

$num++;
			?>

	<ul id="dleft_tab<?php echo $num;?>" style="display:<?php if($num==1) echo 'block';else echo "none";?>;"	>

<?php

foreach($admin_menu2[$key] as $key2=>$value2){


	if(strpos($value2['title'],'<')!==false){
		$title=explode('<',$value2['title']);
		$title=$title[0];

	}
	else $title=$value2['title'];
	?>

	<li ><a  onClick="go_cmdurl('<?php echo $title;?>',this,'<?php echo $value2['url']?>');" target="content3" ><?php echo $value2['title']?></a></li>

	<?php
}
?>




				</ul>



			<?php
			}
		}?>







			</div>
			<div class="clear"></div>
		</div>
		<div class="menu_end"></div>
	</div>
<script>
var xmlHttp;
function Sxmlhttprequest(){
	if(window.ActiveXObject){
		xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	else if(window.XMLHttpRequest){
		xmlHttp = new XMLHttpRequest();
	}

}
var realname=true;
function check_num(){
var arr=Array('2','3','4');

	Sxmlhttprequest();
	xmlHttp.open('GET','ajax.php');
	xmlHttp.onreadystatechange=function(){



		if(xmlHttp.readyState==4){
		var msg=xmlHttp.responseText;
	  	msg=  JSON.parse(msg);

       for(var i=0;i<arr.length;i++){
       	var id=arr[i];
       	document.getElementById('msg_'+id).innerHTML=msg[id];
      if(msg[id]>0){

      	 	document.getElementById('msg_'+id).style.display='inline-block';

      }
else{

	document.getElementById('msg_'+id).style.display='none';
}

       }


		}


	};
	xmlHttp.send(null);


}
check_num();

setInterval(function(){check_num();},5000) ;


</script>



