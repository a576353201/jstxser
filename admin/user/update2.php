<?php
include_once '../inc/header.php';

if($_POST){
$id=$_GET['id'];
$user=get_user_byid($id);
$date=array();

$agree=$_POST['agree'];
unset($_POST['agree']);
$data=array();
if($agree=='1'){

    $data['update']=0;
     $data['agree']=1;
     $data['group']=3;
$data['playerid']=set_playerid(3);
add_adminlog("同意{$user['realname']}成为{$user_group[3]}");
add_msg($id,"您的[{$user_group[3]}]申请已通过");

}
else{
 $data['update']=2;
$data['mark']=$_POST['mark'];
   $data['agree']=0;
    add_adminlog("拒绝{$user['realname']}成为{$user_group[3]}");
add_msg($id,"您的[{$user_group[3]}]申请已被管理员拒绝，理由：".$_POST['mark']);
}
	$db->update(tname('user'), $data, $id);
$user=get_user_byid($id);
	promptMessage('index2.php', '恭喜您！审核成功');


exit();
}




$user=$admin=get_table(tname('user'), $_GET['id']);

$company_type=explode('|',$system['company_type']);
$user['idcard']=desession($user['idcard']);
$user['idcard1']=substr($user['idcard'],0,4).'********'.substr($user['idcard'],strlen($user['idcard'])-3,3);
$address=unserialize($user['address']);
$player=unserialize($user['player']);
$contact=unserialize($user['contact']);
$company=unserialize($user['company']);
$file=unserialize($user['file']);

if(count($contact)>0){
	foreach($contact as $key=>$value){

		$contact[$key]=desession($value);

	}



}

if($user['update']==1){
$subinfo='审核';

}else{
	if($user['group']==1) $subinfo='升级';
else  $subinfo='降级';

}


?>

<script type="text/javascript" src="<?php echo $HttpPath;?>static/js/script_area.js"></script>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="titlebg">

      <tr>

        <td width="12" height="30"><img src="../style/images/content/tab_03.gif" width="12" height="30" /></td>

        <td>


         <div style='float:left' ><img src="../style/images/content/tb.gif" width="16" height="16" /></div>

         <div style='float:left'  class="STYLE1"><span class="STYLE3">当前位置:</span>
        裁判<?php

         if($user['update']==1) echo "审核";
         else echo $subinfo;
         ?>

         </div>


      <div style='float:right;padding-right:5px;'><a href='#' onclick="window.history.go(-1);">返回</a></div>
        </td>

        <td width="16"><img src="../style/images/content/tab_07.gif" width="16" height="30" /></td>

      </tr>

  </table>

<style type="text/css">

  .info .line{height:40px;line-height:40px;}

</style>


  <form name='myform' enctype="multipart/form-data" action="update2.php?action=up&id=<?php echo $_GET['id'];?>" method="post">



<div class='info'  >


<div class='line'>
<span  class='title'>手机号码：</span>



                              <?php echo $admin['name'];?>

</div>




<div class='line'>
<span  class='title'>账户状态：</span>
<?php if($admin['status']==1 ) echo "正常";else echo "锁定";?>

</div>

<div class='line'>
<span  class='title'>用户类型：</span>
  <?php echo $user_group[$user['group']];?>
</div>
<?php

      	if( $user['playerid']){
      		?>

<div class='line'>
<span  class='title'>编号：</span>
<?php echo $user['playerid'];?>

</div>

      		<?php
      	}
      	?>


<?php if ($user['realname']){ ?>
<div class='line'>
<span  class='title'>姓名：</span>
<?php echo $user['realname'];?>

</div>
<?php } ?>
<?php if ($user['idcard']){ ?>
<div class='line'>
<span  class='title'>身份证号：</span>
<?php echo $user['idcard'];?>

</div>
<?php } ?>
<?php if ($user['sex']){ ?>
<div class='line'>
<span  class='title'>性别：</span>
<?php if ($user['sex']==1)echo "男";else echo '女';?>

</div>

<?php } ?>
<?php if ($user['birth']){ ?>
<div class='line'>
<span  class='title'>出生年月日：</span>
<?php echo $user['birth'];?>

</div>
<?php } ?>
<?php if ($user['birthprovince']){ ?>
<div class='line'>
<span  class='title'>家乡：</span>
<?php echo $address['birthprovince'];?> <?php echo $address['birthcity'];?> <?php echo $address['birthcountry'];?>


</div>
<?php } ?>
<?php if ($user['resideprovince']){ ?>
<div class='line'>
<span  class='title'>居住地：</span>
<?php echo $address['resideprovince'];?> <?php echo $address['residecity'];?> <?php echo $address['residecountry'];?>
</div>

<?php } ?>




<?php if ($player['danwei']){ ?>
<div class='line'>
<span  class='title'>注册单位：</span>
<?php echo $player['danwei'];?>
</div>
<?php } ?>
<?php if ($player['dengji']){ ?>
<div class='line'>
<span  class='title'>裁判员等级：</span>
<?php echo $player['dengji'];?>

</div>
<?php } ?>
<?php if ($player['jingli']){ ?>
<div class='line'>
<span  class='title'>主要执裁经历：</span>
<?php echo $player['jingli'];?>
</div>
<?php } ?>

<?php if ($contact['email']){ ?>

<div class='line'>
<span  class='title'>常用邮箱：</span>
<?php echo $contact['email'];?>

</div>
<?php } ?>
<?php if ($contact['qq']){ ?>

<div class='line'>
<span  class='title'>QQ号码：</span>
<?php echo $contact['qq'];?>

</div>
<?php } ?>
<?php if ($contact['weixin']){ ?>

<div class='line'>
<span  class='title'>微信：</span>
<?php echo $contact['weixin'];?>

</div>

<?php } ?>

<?php if ($file['file1']){ ?>
<div class='line'  style='height:auto;padding-left:80px;'>
<span style='font-size:20px;'>个人照片/证件照片</span>





    <input type="hidden" name='file[file1]' id='file_add1' value='<?php echo $file['file1'];?>'>

<iframe src='../../upload_pc.php?fileid=file_add1&img=<?php echo $file['file1'];?>&iframeid=upload_src1&pc=1&read=1'  id='upload_src1'  style='width:100%;height:100px;'marginwidth="0px" frameborder="0" scrolling="no" ></iframe>
</div>

<?php } ?>

<?php if ($file['file2']){ ?>
<div class='line'  style='height:auto;padding-left:80px;'>

<span style='font-size:20px;'>生活照片</span>


    <input type="hidden" name='file[file2]' id='file_add2' value='<?php echo $file['file2'];?>'>
<input type="hidden" name='file[info]' id='file_add2_info' value='<?php echo $file['info'];?>'>
<iframe src='../../upload_pc1.php?fileid=file_add2&img=<?php echo $file['file2'];?>&info=<?php echo $file['info'];?>&iframeid=upload_src2&pc=1&read=1'  id='upload_src2'  style='width:100%;height:100px;'marginwidth="0px" frameborder="0" scrolling="no" ></iframe>

</div>


<?php } ?>

<?php if ($file['file3']){ ?>
<div class='line'  style='height:auto;padding-left:80px;'>

<span style='font-size:20px;'><?php echo $filename3?></span>


    <input type="hidden" name='file[file3]' id='file_add3' value='<?php echo $file['file3'];?>'>

<iframe src='../../upload_pc.php?fileid=file_add3&img=<?php echo $file['file3'];?>&iframeid=upload_src3&pc=1'  id='upload_src2'  style='width:100%;height:100px;'marginwidth="0px" frameborder="0" scrolling="no" ></iframe>

</div>


<?php } ?>












<?php

if($admin['update']==1){

	?>
<input type='hidden' name='update' value='1'/>
	<div class='line'>
<span  class='title'>申请类型：</span>

               <?php
if($admin['group']==1)

$group=2;
else $group=$admin['group'];
               echo $user_group[$group];

               ?>

</div>

<input type='hidden' name='group' value='<?php echo $group;?>'/>
	<?php

if($admin['reqtime']){?>
<div class='line'>
<span  class='title'>申请时间：</span>

<?php echo date('Y-m-d H:i:s',$admin['reqtime']) ?>

</div>


<?php
}
?>

<div class='line'>
<span  class='title'><span class='must'>*</span>审核状态：</span>

           <input name="agree" type="radio" value="1" onclick='set_agree(1);' >通过 &nbsp;
              <input name="agree" type="radio" value="0" onclick='set_agree(0);' >不通过

</div>


<div class='line' id='area_html' style='display:none;'>
<span  class='title'><span class='must'>*</span>不通过理由：</span>
<?php
$user_area=explode('|',$system['user_area']);
?>


  <select id="user_area"  onchange='set_area(this.value);' >
  <option value=''>请选择</option>
<?php
foreach($user_area as $key=>$value){


?>
<option  value='<?php echo $value;?>'><?php echo $value; ?></option>
<?php }?>

  <option value='-1'>其他理由</option>
  </select>



</div>
<div class='line'  id='other_area'  style='display:none;'>
<span  class='title'><span class='must'>*</span>其他理由：</span>

  <textarea name="mark" id='mark' rows="8" cols="50" placeholder="请输入不通过的理由" ></textarea>



</div>

	<?php
}

?>





<div class='line'>
<div style='padding-left:250px;'  id='sub_html'>
<input class='btn00' type='button' name='Submit' value='返回' onclick='window.history.go(-1); '>

<input class='btn01' type='submit' name='Submit' value='确认审核'  onclick="return check_add();">
</div>

</div>

</div>
      </form>

<script language="JavaScript" type="text/javascript" >

function set_agree(value){

	if(value=='1'){

		document.getElementById('area_html').style.display='none';

	}
	else
	document.getElementById('area_html').style.display='block';

}

function set_area(value){

	if(value=='-1'){

		document.getElementById('other_area').style.display='block';
document.getElementById('mark').value='';

	}
	else

	{
		document.getElementById('other_area').style.display='none';
document.getElementById('mark').value=value;
	}


}


var player_group = new Array();
<?php
foreach($player_group as $key=>$value){
?>
player_group[<?php echo $key;?>]='<?php echo $system['player_group_'.$key];?>';

<?php
}
?>

function change_group(value){


     var str=player_group[value];
     var arr=str.split('|');
     var html="<select name='player[group2]'>";

     for(var i=0;i<arr.length;i++){

     html+="<option value='"+arr[i]+"'>"+arr[i]+"</option>";

     }

     html+="</select>";

document.getElementById('group2').innerHTML=html;
}



var step=0;
var exit=0;
var  group_sum=<?php echo count($group_arr);?>;
function click_next(num){
if(num!=0)
	step=step+num;

	var html='';
	if(step==0){
		html+=" <input class='btn00' type='button' name='Submit' value='返回' onclick='window.history.go(-1); '>";
		html+=" <input class='btn01' type='button' name='Submit' value='下一步' onclick='click_next(1); '>";
	}

	else if(step>0 && step<group_sum-1){
      <?php
      if ($user['group']==4){

      ?>

if(step==1){

	html+=" <input class='btn00' type='button' name='Submit' value='上一步' onclick='click_next(-1);'>";
	html+=" <input class='btn01' type='button' name='Submit' value='下一步' onclick='click_next(3); '>";

}

else if(step==4){

	    html+=" <input class='btn00' type='button' name='Submit' value='上一步' onclick='click_next(-3);'>";
		html+=" <input class='btn01' type='button' name='Submit' value='下一步' onclick='click_next(1); '>";

}else{

        html+=" <input class='btn00' type='button' name='Submit' value='上一步' onclick='click_next(-1);'>";
		html+=" <input class='btn01' type='button' name='Submit' value='下一步' onclick='click_next(1); '>";


}

      	<?php
      }else{
      	?>
        html+=" <input class='btn00' type='button' name='Submit' value='上一步' onclick='click_next(-1);'>";
		html+=" <input class='btn01' type='button' name='Submit' value='下一步' onclick='click_next(1); '>";



      	<?php
      }
      ?>

	}
	else{
 <?php
      if ($user['group']==4){

      ?>
      if(step==4){

	html+=" <input class='btn00' type='button' name='Submit' value='上一步' onclick='click_next(-3);'>";
	html+=" <input class='btn01' type='submit' name='Submit' value='<?php if ($admin['update']==1)echo "审核并";?>保存' onclick='return check_add();' >";



      }

      else{
      		html+=" <input class='btn00' type='button' name='Submit' value='上一步' onclick='click_next(-1);'>";
	html+=" <input class='btn01' type='submit' name='Submit' value='<?php if ($admin['update']==1)echo "审核并";?>保存' onclick='return check_add();' >";




      }


      	<?php
      }else{
      	?>
	html+=" <input class='btn00' type='button' name='Submit' value='上一步' onclick='click_next(-1);'>";
	html+=" <input class='btn01' type='submit' name='Submit' value='<?php if ($admin['update']==1)echo "审核并";?>保存' onclick='return check_add();' >";
  	<?php
      }
      ?>
	}

document.getElementById('sub_html').innerHTML=html;

if(num!=0)
set_tabs(step,<?php echo count($group_arr);?>);

}



function check_name() {
		Sxmlhttprequest();

		var name=document.getElementById('name').value;
		//alert(name);
		xmlHttp.open('GET','check_admin.php?name='+name,true);
		xmlHttp.onreadystatechange=byphp;
		xmlHttp.send(null);
	}
function byphp(){

	if(xmlHttp.readyState==1){
		document.getElementById('name_msg').innerHTML="loading....";
	}
	if(xmlHttp.readyState==4){
	var msg=xmlHttp.responseText;

	if(msg.indexOf('1')>0)
	{exit=0;
		alert('手机号已存在');
	return false;
	}
	else{

		exit=1;
	}


	}
}

function   check_add(){


	<?php if($admin['update']==1){?>

  var agree=document.getElementsByName('agree');


  var temp='-1';
  for(var i=0;i<agree.length;i++){

  	if(agree[i].checked) temp=agree[i].value;

  }

   if(temp=='-1'){

   	alert('请先选择审核状态');
		return false;

   }

   if(temp==0){
   	if(document.getElementById('mark').value==''){

   	alert('请填写未通过的原因');
		return false;


   	}


   }




   	<?php } ?>

}


function set_tabs(num,sum){



	for(var i=0;i<sum;i++){


		if(i==num){

			document.getElementById('tit_'+i).className='step cur';

			document.getElementById('info_'+i).style.display='block';
		}
		else{
			document.getElementById('tit_'+i).className='step';

			document.getElementById('info_'+i).style.display='none';


		}

	}
step=num;


click_next(0);

}











</script>




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

