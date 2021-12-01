<?php
include_once '../inc/header.php';
if($_GET['type']=='index'){ $title='首页Flash设置'; $index=1;$open='open_flash_index';}
else {
    $title='子页Flash设置';$index=0;$open='open_flash';
}

if($_POST){
	if(!$_POST['open_flash']) $_POST['open_flash']=0;

		foreach ($_POST as $key=>$value) {
			if(strpos($key, 'flash_')!==FALSE or strpos($key, '_flash')!==FALSE){
				if($_POST['index']=='1')$key=$key."_index";
		if($db->exec("select * from ".tname('system')." where `key`='$key' and index='{$index}'")){

			$db->query("update ".tname('system')." set `value`='$value' where `key`='$key' and index='{$index}'");

		}
		else{
			$db->query("insert into ".tname('system')." (`key`,`value`,`index`) values('$key','$value','$index')");


		}

	}
}

for($i=1;$i<=6;$i++){
	$_POST['edittime']=time();
		if($row=$db->exec("select * from ".tname('flash')." where `index`='{$index}' and uid='0' and num='$i'")){
			$id=$row['id'];

					foreach ($_POST as $key=>$value){
				if(strpos($key, "_".$i)!==false){

					$key=str_replace("_".$i, "", $key);
					$db->query("update ".tname('flash')." set `$key`='$value' where `id`='$id'");

				}



			}

		}
	else{
		$now=time();
		$db->query("insert into ".tname('flash')."(`num`,`addtime`,`index`,`uid`) values('$i','$now','1','$userid')");
		if($db->affected_rows()>0){
			$id=$db->insert_id();
			foreach ($_POST as $key=>$value){
				if(strpos($key, "_".$i)!==false){

					$key=str_replace("_".$i, "", $key);
					$db->query("update ".tname('flash')." set `$key`='$value' where `id`='$id'");

				}

			}

		}

	}

}
           	$all=$db->fetch_all("select * from ".tname('flash')." where `index`='{$index}' order by `num` asc");
           	$xml="<?xml version='1.0' encoding='utf-8'?>
<root imageWidth='364' imageHeight='206'>
";
           	foreach ($all as $value) {
           		if($value['src'])
           		$xml.="<menu url='{$value['url']}' frame='_blank' imageUrl='{$value['src']}'/>
           		";
           	}
           	$xml.="</root>";

           	$filename="../../xml/images.xml";
	$handle = fopen($filename,"w");/*根据需要更改这里的参数*/
$contents = fwrite($handle,$xml);
fclose($handle);
}

$system=get_system();


?>



  <form name='myform' enctype="multipart/form-data" action="flash.php?type=<?php echo $_GET['type'];?>" method="post">
  <input type="hidden" name='index' value="<?php echo $index;?>">

                <table width="100%" height="100%"  cellpadding="1" cellspacing="1">
                <?php
                for ($i=1;$i<=6;$i++){
                	$flash=$db->exec("select * from ".tname('flash')." where `index`='{$index}' and num='$i'");

                ?>
                  <tr>
                    <td rowspan="2" width="10%" align="right"><b>图片<?php echo $i;?></b></td>
                    <td height="25" width="10%" align="right">图片地址</td>
                    <td width="70%" align='left'><input name="src_<?php echo $i;?>" type="text"  size="30" maxlength="200"   value="<?php echo $flash['src'];?>">
                <iframe style="padding:0; margin:0;vertical-align: middle" src="../inc/upload.php?returnid=src_<?php echo $i?>&path=ico&image=1" frameborder=0 scrolling=no width="350" height="25" ></iframe>


         </td>
                  </tr>
                  <tr>
                    <td  height="25" align="right" >链接地址</td>
                    <td align='left'><input name="url_<?php echo $i;?>" type="text"  size="70" maxlength="200" value="<?php echo $flash['url'];?>"></td>
                  </tr>






       <?php }?>

          <tr>
          <td ></td>
            <td height="30" align="left" colspan="4" style="padding-left: 20px;">
              <input class="button" type="submit" name="Submit" value="提 交"  >&nbsp;&nbsp;&nbsp;&nbsp;
              <input class="button" type="reset" name="Submit" value="重 置" >
            </td>
          </tr>
        </table>
      </form>




<?php include_once '../inc/footer.php';?>

