<?php
include_once '../inc/header.php';

if(!$_GET['action']) $action='add';
else $action=$_GET['action'];

if($_GET['id'])  {
	$web_title='修改队伍';
	$team=$db->exec("select * from ".tname('team')." where id='{$_GET['id']}'");
$player=unserialize($team['player']);
$player_ids='';
if(count($player)>0){

	foreach($player as $key=>$value){
if($player_ids=='') $player_ids=$key;
else $player_ids.=','.$key;
		$u=get_user_byid($key);
			$player[$key]['idcard']=desession($u['idcard']);
	if($u['birth']){

	$player[$key]['age']=date('Y')-substr($u['birth'],0,4);

	}
$player[$key]['playerid']=$u['playerid'];

$player[$key]['sex']=$u['sex'];
$player[$key]['realname']=$u['realname'];
$player[$key]['address']=$u['address'];
}

}
$contact=unserialize($team['contact']);
$lingdui=unserialize($team['lingdui']);
$fulingdui=unserialize($team['fulingdui']);
$jiaolian=unserialize($team['jiaolian']);
$arrive=unserialize($team['arrive']);
$file=unserialize($team['file']);
$level=unserialize($team['level']);

$hotal=$db->fetch_all("select * from ".tname('hotal')." where `status`='1' order by sortnum asc,id asc");

$hotal_html='';
if(count($hotal)>0){
	foreach($hotal as $value){

		$hotal_html.="<option value='{$value['id']}'>{$value['name']}</option>";
	}


}


$room=$db->fetch_all("select * from ".tname('room')." where `tid`='{$_GET['id']}' order by id asc ");
}


if($_POST){

		$data=array();


     $data['name']=$_POST['name'];

$data['file']=serialize($_POST['file']);


if($_GET['id']){
	$id=$_GET['id'];
	add_adminlog("修改队伍信息：".$data['name']);
	$db->update(tname('team'),$data,$id);
}






	promptMessage('../task/active.php?id='.$team['tid'],'操作成功');





}


$danwei=$db->fetch_all("select * from ".tname('user')." where `group`='4' and `agree`=1 ");


?>
<script>
var danwei_list = new Array();
<?php

foreach($danwei as $index=>$value){
?>
	danwei_list[<?php echo $index;?>]='<?php echo $value['realname'];?>';

	<?php
}
?>
var lingdui_num=<?php echo count($lingdui);?>;
var fulingdui_num=<?php echo count($fulingdui);?>;
var jiaolian_num=<?php echo count($jiaolian);?>;

</script>
<script type="text/javascript" src="<?php echo $HttpPath;?>static/js/team.js?v=123"></script>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="titlebg">

      <tr>

        <td width="12" height="30"><img src="../style/images/content/tab_03.gif" width="12" height="30" /></td>

        <td>


         <div style='float:left' ><img src="../style/images/content/tb.gif" width="16" height="16" /></div>

         <div style='float:left'  class="STYLE1"><span class="STYLE3">当前位置:</span>编辑队伍</div>


      <div style='float:right;padding-right:5px;'><a href='#' onclick="window.history.go(-1);">返回</a></div>
        </td>

        <td width="16"><img src="../style/images/content/tab_07.gif" width="16" height="30" /></td>

      </tr>

  </table>



  <form name='myform' enctype="multipart/form-data" action="team_add.php?id=<?php echo $_GET['id'];?>" method="post">







<div class='info' id='info_0' >




<div class='line'>
<span  class='title'>队伍名称：</span>
<input type='text' class='input' id='name' name='name' value='<?php echo $team['name'];?>' minlength="2" maxlength="30" autofocus="" required="" autocomplete="off">

</div>

<div class='line'>
<span  class='title'><span class='must'>*</span>单位名称：</span>


  <?php
  $dw=$db->exec("select * from ".tname('user')." where id='{$team['uid']}'");

echo $dw['realname'];
  ?>




</div>













<div class='line'  style='height:auto;padding-left:100px'>

<span class='must'>*</span><span style='font-size:20px;'>报名表盖章扫描件</span>

<span style='font-size:14px;'>(请上传小于10MB的照片)</span>


    <input type="hidden" name='file[file1]' id='file_add1' value='<?php echo $file['file1'];?>'>

<iframe src='../../upload_pc.php?fileid=file_add1&img=<?php echo $file['file1'];?>&iframeid=upload_src1&num=1&pc=1'  id='upload_src1'  style='width:100%;height:100px;'marginwidth="0px" frameborder="0" scrolling="no" ></iframe>
</div>



<div class='line'  style='height:auto;padding-left:100px'>

<span class='must'>*</span><span style='font-size:20px;'>外援的协议或有关证明</span>


<span style='font-size:14px;'>(请上传小于10MB的照片)</span>


    <input type="hidden" name='file[file2]' id='file_add2' value='<?php echo $file['file2'];?>'>

<iframe src='../../upload_pc.php?fileid=file_add2&img=<?php echo $file['file2'];?>&iframeid=upload_src2&pc=1'  id='upload_src2'  style='width:100%;height:100px;'marginwidth="0px" frameborder="0" scrolling="no" ></iframe>
</div>

<div class='line'  style='height:auto;padding-left:100px'>

<span class='must'>*</span><span style='font-size:20px;'>团队合影</span>


<span style='font-size:14px;'>(请上传小于10MB的照片)</span>


    <input type="hidden" name='file[file3]' id='file_add3' value='<?php echo $file['file3'];?>'>

<iframe src='../../upload_pc.php?fileid=file_add3&img=<?php echo $file['file3'];?>&iframeid=upload_src3&pc=1'  id='upload_src3'  style='width:100%;height:100px;'marginwidth="0px" frameborder="0" scrolling="no" ></iframe>
</div>



</div>






<div class='info' id='info_4' style='display:none;'>


</div>

<div class='info' >
<div class='line'>
<div style='padding-left:250px;'>

    <input class="btn00" type="reset" name="Submit" value="重 置" >&nbsp;&nbsp;&nbsp;&nbsp;
 <input class="btn01" type="submit" name="Submit" value="提 交"  onclick="return check_add();" >


</div>

</div>

</div>
      </form>




  <table width="100%" border="0" cellspacing="0" cellpadding="0"  background="../style/images/content/tab_19.gif">


      <tr>

        <td width="12" height="35"><img src="../style/images/content/tab_18.gif" width="12" height="35" /></td>



            <td class="STYLE4">&nbsp;&nbsp;</td>

            <td></td>

        <td width="16"><img src="../style/images/content/tab_20.gif" width="16" height="35" /></td>

      </tr>

    </table>
 <style>


    .rebox { position: fixed; width: 100%; height: 100%; top: 0; left: 0;bottom:0px;right:0px; z-index: 10000000;
background-color:#000;
filter:alpha(opacity=100);
-moz-opacity:1;
opacity:1;display:none;
}
.rebox .contents {
background-color:#000;display:block;
}

.rebox .contents img { 	max-width: 100%; max-height: 100%; position: absolute; top: 0; left: 0; right: 0; bottom: 0; margin: auto;
background-color:#000;
}

.rebox .close{
	position: absolute;
    z-index: 99999999999999999999999999;
    min-width: 50px;
    height: 50px;
    line-height: 50px;
    background:#000;
    text-decoration: none;
    font-size: 24px;
    color: #fff;
    text-align: center;
    vertical-align: middle;
    -webkit-border-radius: 32px;
    border-radius: 32px;
    -webkit-transition: all 0.3s;
    transition: all 0.3s;
    left:46%;bottom:20px;

}


    </style>



    <div class='rebox'  id='showbg'>

<div class='contents'>

<img src='#'  id='show_img'>

</div>
<div class='close' onclick="document.getElementById('showbg').style.display='none';">关闭</div>
</div>


<?php include_once '../inc/footer.php';?>

